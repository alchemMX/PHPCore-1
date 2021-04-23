<?php

namespace Page;

use Model\Form;
use Model\Session;

/**
 * Page
 */
abstract class Page
{
    /**
     * @var array $listOfOperations List of operations
     */
    private array $listOfOperations = ['add', 'move', 'deleteall', 'new', 'edit', 'delete', 'up', 'down', 'activate', 'lock', 'unlock', 'stick', 'unstick', 'send', 'leave', 'mark', 'back', 'like', 'unlike', 'set', 'refresh'];

    /**
     * @var mixed $id Page id
     */
    private static mixed $id = '';

    /**
     * @var string $definedURL Stored page or folder pre-defined redirect url
     */
    private static string $definedURL = '';

    /**
     * @var string $templateName Name of default template
     */
    protected string $templateName = '';
    
    /**
     * @var string $favicon Favicon
     */
    protected string $favicon = '/Uploads/Site/PHPCore_icon.svg';
    
    /**
     * @var object $page Page class
     */
    protected object $page;

    /**
     * @var object $data Data model
     */
    protected \Model\Data $data;
    
    /**
     * @var object $user User model
     */
    protected \Model\User $user;
    
    /**
     * @var object $build Builder model
     */
    protected \Model\Build\Build $build;
    
    /**
     * @var object $process Process
     */
    protected \Process\Process $process;
    
    /**
     * @var object $language Language model
     */
    protected \Model\Language $language;

    /**
     * @var object $template Template model
     */
    protected \Model\Template $template;

    /**
     * @var object $system System model
     */
    protected \Model\System\System $system;

    /**
     * @var string $navbar Navbar visualization
     */
    protected \Visualization\Navbar\Navbar $navbar;

    /**
     * @var string $url Current page url
     */
    protected static string $url = '/';

    /**
     * @var array $parsedURL Parsed url
     */
    protected static array $parsedURL = [];

    /**
     * @var array $urlData Data from parsed url
     */
    protected static array $urlData = ['page' => 1];

    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {
        // OPTIMALIZE VARIABLE
        if (self::$parsedURL){
            self::$parsedURL = array_values(array_filter(self::$parsedURL));
        }
    }
    
    /**
     * Initialise page
     *
     * @return void
     */
    protected function initialise()
    {
        // LOADS URL
        $pageClass = array_values(array_filter(explode('\\', get_class($this))));
        
        foreach (['Page', 'Index', 'Router'] as $item) {

            if (in_array($item, $pageClass)) {
                unset($pageClass[array_search($item, $pageClass)]);
            }
        }
        
        if (in_array(strtolower($pageClass[array_key_last($pageClass)] ?? ''), $this->listOfOperations)) {
            array_pop($pageClass);
        }

        $this->style->URL = $this->urlExc = $this->system->url->build(mb_strtolower(implode('/', array_filter($pageClass))));
        
        // LOADS ID
        if (isset($this->settings['id'])) {

            self::$parsedURL[0] ?? [] or $this->error();

            $this->style->ID = self::$id = explode('.', self::$parsedURL[0])[0];
            
            if ($this->settings['id'] == int) {
                if (!ctype_digit(self::$id)) {
                    $this->error();
                }
            }

            $this->style->URL = $this->urlExc .= self::$parsedURL[0] . '/';
        }
        
        // LOADS TITLE
        $this->data->head['title'] = $this->language->get('L_TITLE')[get_class($this)] ?? $this->data->head['title'];
        
        $this->process->url($this->getURL());

        if (isset($this->settings)) {
            foreach (array_keys($this->settings) as $option) {
                switch ($option) {

                    case 'permission':
                        if ($this->user->perm->has($this->settings['permission']) === false) $this->error();
                    break;

                    case 'redirect':
                        $this->process->url(self::$definedURL = $this->settings['redirect']);
                    break;

                    case 'loggedOut':
                        if ($this->user->isLogged() === true) $this->error();
                    break;

                    case 'loggedIn':
                        if ($this->user->isLogged() === false) $this->error();
                    break;

                    case 'header':
                        $this->data->data([
                            'bigHeader' => true
                        ]);
                    break;

                    case 'editor':
                        $this->data->data([
                            'editor' => $this->settings['editor']
                        ]);
                    break;

                    case 'template':
                        $this->templateName = $this->settings['template'];
                        $this->style->setTemplate($this->settings['template']);
                    break;

                    case 'notification':
                        if ($this->settings['notification'] === true) {
                            $this->data->data([
                                'globalNotification' => (new \Block\Notification())->getAll()
                            ]);
                        }
                    break;
                }
            }
        }
    }
    
    /**
     * Builds page name according to url
     *
     * @return string
     */
    protected function build()
    {
        $_path = [];

        // DEFAULT PATH
        $path = ROOT . '/Includes/Object/Page/';

        $namespace = explode('\\', get_class($this));
        $namespace = array_slice($namespace, 1, count($namespace) - 2);
        if (empty($namespace) === false) {
            $path .= implode('/', $_path = $namespace) . '/';
        }

        while (true) {
            if (!empty(self::$parsedURL)) {

                // IF EXISTS DIR
                if (is_dir($path . ucfirst(self::$parsedURL[0]) . '/')) {

                    array_push($_path, $shift = ucfirst(array_shift(self::$parsedURL)));
                    $path .= $shift . '/';

                    if (file_exists($path . '/Router.page.php')) {
                        array_push($_path, 'Router');
                    break;
                    }

                    continue;
                }

                // IF EXISTS PAGE
                if (file_exists($path . ucfirst(self::$parsedURL[0]) . '.page.php')) {

                    $shifted = array_shift(self::$parsedURL);
                    array_push($_path, ucfirst($shifted));
                }

            }
            
            if ($this->getOperation()) {
                
                if (file_exists($path . ucfirst($this->getOperation()) . '.page.php')) {
                    array_push($_path, ucfirst($this->getOperation()));

                    break;
                }
            }
            
            if (empty($shifted)) {
                array_push($_path, 'Index');
            }
            break;

        }

        return 'Page\\' . implode('\\', $_path);
    }
    
    /**
     * Returns url parameter
     *
     * @param string $urlParameter
     * 
     * @return mixed
     */
    protected function getParam( string $urlParameter )
    {
        return self::$urlData[$urlParameter] ?? false;
    }
    
    /**
     * Returns name of operation
     *
     * @return string|false
     */
    protected function getOperation()
    {
        foreach (self::$parsedURL as $parameter) {
            if (in_array($_ex = explode('-', $parameter)[0], $this->listOfOperations)) {

                return strtolower($_ex);
            }
        }

        return false;
    }
    
    /**
     * Returns url without names of operations
     *
     * @return string
     */
    protected function getURL()
    {
        return $this->urlExc;
    }

    /**
     * Returns root page url
     *
     * @return mixed
     */
    protected function getID()
    {
        return self::$id;
    }

    /**
     * Redirects user to error page
     *
     * @return void
     */
    protected function error()
    {
        $this->style->load($this->data, $this->build, $this->user);
        $this->style->error();
    }

    /**
     * Redirects user to predefined redirect user if is set otherwise redirects user to current url without operator
     *
     * @return void
     */
    protected function redirect()
    {
        if (self::$definedURL) {
            redirect(self::$definedURL);
        }

        redirect($this->getURL());
    }

    /**
     * Returns content of given path
     *
     * @return string
     */
    protected function file( string $path, array $options = [] )
    {
        ob_start();

        extract($this->language->get());

        if ($options) {
            eval($options['variable'] . ' = $options[\'data\'];');
        }

        require($this->template->require($path));

        return ob_get_clean();
    }
    
    /**
     * Shows page with notice message
     *
     * @param  string $notice Language notice name
     * @param  array $assign Data to assign
     * 
     * @return void
     */
    public function notice( string $notice, array $assign = [] )
    {
        $message = $this->language->get('notice')['failure'][$notice] ?? '';

        if (!$message) {
            $message = 'Vyskytla se chyba: ' . $notice;
        } else {
            foreach ($assign as $variable => $data) {
                $message = strtr($message, ['{' . $variable . '}' => $data]);
            }
        }
        
        if (AJAX === true) {
            echo json_encode([
                'status' => 'error',
                'error' => $message
            ]);
            exit();
        }

        $this->data->navbar = ($this->navbar ?? $this->page->navbar)->getData();
        $this->style->load($this->data, $this->build, $this->user);
        $this->style->notice($message);
        $this->style->show();
    }

    /**
     * Abstract process method for every page
     *
     * @return void
     */
    abstract protected function body();
}