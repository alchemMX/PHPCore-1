<?php

namespace Process;

use Exception;
use Model\Form;
use Model\Session;
use Process\ProcessCheck;

/**
 * Process
 */
class Process {

    /**
     * @var string $redirectURL Url where will be user redirected after process execution
     */
    private string $redirectURL = '';

    /**
     * @var string $message Success message
     */
    private string $message = '';

    /**
     * @var bool $direct Direct mode
     */
    private bool $direct = false;

    /**
     * @var object $form Refers to Form class
     */
    private $form;

    /**
     * @var array $data Process data
     */
    private array $data = [];
    
    /**
     * @var object $purifier Purifier class
     */
    private object $purifier;
    
    /**
     * @var string $block Block name
     */
    private string $block;
    
    /**
     * @var string $process Name of process
     */
    private string $process;
    
    /**
     * @var object $perm Permission model
     */
    private \Model\Permission $perm;

    /**
     * @var object $system System model
     */
    private \Model\System\System $system;

    /**
     * @var object $check ProcessCheck
     */
    private \Process\ProcessCheck $check;
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct( \Model\System\System $system, \Model\Permission $perm )
    { 
        $this->check = new ProcessCheck();

        $this->perm = $perm;
        $this->system = $system;
    }

    /**
     * Returns last inserted ID
     *
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }
    
    /**
     * Enables direct mode
     *
     * @return void
     */
    public function direct()
    {
        $this->direct = true;
    }

    /**
     * Sets block name
     *
     * @return void
     */
    public function setBlock( string $block )
    {
        $this->block = $block;
    }

    /**
     * Sets default redirect url
     *
     * @return void
     */
    public function url( string $url )
    {
        $this->redirectURL = $url;
    }

    /**
     * Return redirect url
     *
     * @return string
     */
    public function getURL()
    {
        return $this->redirectURL;
    }

    /**
     * Returns success message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Checks form data
     * 
     * @param array $format Process form data
     * 
     * @throws \Exception\Notice If is found some error
     *
     * @return bool
     */
    private function checkData( array $format )
    {
        $formData = $this->form->getData();

        require ROOT . '/Assets/HTMLPurifier/HTMLPurifier.auto.php';
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'em,strong,del');
        $config->set('HTML.AllowedAttributes', 'img.src,a.href,span.data-user');
        $def = $config->getHTMLDefinition(true);
        $def->addAttribute('span', 'data-user', 'Text');

        $this->purifier = new \HTMLPurifier($config);
        foreach ($format as $input => $settings) {

            foreach ($settings as $key => $value) {
                
                switch ($key) {

                    case 'required':
                        $formData[$input] or throw new \Exception\Notice($input);
                    break;

                    case 'function':
                        $value($formData[$input]) === true or throw new \Exception\Notice($input);
                    break;

                    case 'block':
                    case 'custom':
                    
                        if (empty($formData[$input]) and !isset($format[$input]['required'])) break;

                        $array = $value;
                        if ($key === 'block') {

                            $ex = explode('.', $value);
                            $array = (new $ex[0])->{$ex[1]}();
                        }


                        if (count(array_diff((array)$formData[$input], $array)) >= 1) {
                            throw new \Exception\Notice($input);
                        }
                        $this->data[$input] = $formData[$input];
                    
                    break;

                    case 'length_max':
                        $this->check->maxLength($formData[$input], $input, $value);
                    break;

                    case 'length_min':
                        $this->check->minLength($formData[$input], $input, $value);
                    break;

                    case 'type':

                        if (!isset($formData[$input])) {
                            switch ($value) {

                                case 'array':
                                    $formData[$input] = [];
                                break;

                                case 'text':
                                case 'html':
                                case 'email':
                                case 'username':
                                case 'password':
                                    $formData[$input] = '';
                                break;

                                case 'radio':
                                case 'number':
                                case 'checkbox':
                                    $formData[$input] = 0;
                                break;
                            }
                        }

                        switch ($value) {

                            case 'array':
                                $formData[$input] = is_array($formData[$input]) ? $formData[$input] : [];
                            break;

                            case 'text':
                            case 'html':
                            case 'email':
                            case 'username':
                            case 'password':
                                $formData[$input] = is_string($formData[$input]) ? $formData[$input] : '';
                            break;

                            case 'radio':
                            case 'checkbox':
                                $formData[$input] = $formData[$input] == 1 ? 1 : 0;
                            break;

                            case 'number':
                                $formData[$input] = ctype_digit($formData[$input]) ? $formData[$input] : 0;
                            break;
                        }

                        switch ($value) {

                            case 'array':
                                $formData[$input] = array_map('strip_tags', $formData[$input]);
                            break;

                            case 'text':
                            case 'email':
                            case 'username':
                            case 'password':
                                $formData[$input] = strip_tags($formData[$input]);
                            break;

                            case 'html':
                                $formData[$input] =  $this->purifier->purify($formData[$input]);
                            break;
                        }

                        if (!empty($formData[$input])) {
                            switch ($value) {

                                case 'email':
                                    $this->check->email($formData[$input]);
                                break;

                                case 'username':
                                    $this->check->userName($formData[$input]);
                                break;

                                case 'password':
                                    $this->check->password($formData[$input]);
                                break;

                            }
                        }

                        $this->data[$input] = $formData[$input];
                    break;
                }
            }

        }

        return true;
    }

    /**
     * Starts process on form submitting
     *
     * @param  string $type Path to process
     * @param  string $on Name of submit button
     * @param  string $url URL where user will be redirected after successfully execution a process
     * @param  array $data Additional process data
     *
     * @return bool|void If is enabled "Direct mode", returns boolean otherwise user will be automatically redirected to set URL. To enable direct mode call method ->direct().
     */
    public function form( string $type, string $on = 'submit', string $url = null, array $data = [] )
    {
        // LOAD FORM
        $this->form = new Form($this->direct);
        
        // IF SUBMIT BUTTON WAS PRESSED
        if ($this->form->isSend($on)) {

            $this->redirectURL = $url ?? $this->redirectURL;
            $this->data = $data;

            $process = $this->explode($type);

            foreach ($data['options']['input'] ?? [] as $inputName => $value) {
                $process->require['form'][$inputName]['custom'] = $value;
            }
    
            if (!isset($process->require['form']) or $this->checkData($process->require['form'] ?? [])) {

                // CHECK INPUTS
                return $this->_process($process);
            }

            return false;
        }
    }
    
    /**
     * Calls a process without submitting a form
     *
     * @param  string $type Path to process
     * @param  string $url URL where user will be redirected after successfully execution a process
     * @param  array $data Additional process data
     * 
     * @return bool|void If is enabled "Direct mode", returns boolean otherwise user will be automatically redirected to set URL. To enable direct mode call method ->direct().
     */
    public function call( string $type, string $url = null, array $data = [] )
    {
        if (isset($data['options']['on'])) {
            foreach ((array)$data['options']['on'] as $key => $value) {
                if ((string)$key !== (string)$value) return false;
            }
        }

        $this->redirectURL = $url ?? $this->redirectURL;
        $this->data = $data;
        $this->form = null;

        return $this->_process($this->explode($type));
    }

    /**
     * Explodes process
     *
     * @param  string $processName
     * 
     * @return object
     */
    private function explode( string $processName )
    {
        // EXPLODE PROCESS NAME
        $ex = explode('/', $processName);

        // SET VARIABLES
        $this->process = $processName;

        $this->id = $this->data[array_key_first($this->data)] ?? 0;

        unset($this->data['options']);

        $process = 'Process\\' . implode('\\', $ex);
        $process = new $process($this->process, $this->system, $this->perm);

        switch ($process->options['login'] ?? REQUIRE_LOGIN) {
            case REQUIRE_LOGOUT:
                if (LOGGED_USER_ID != 0) $this->redirect();
            break;
            case REQUIRE_LOGIN:
                if (LOGGED_USER_ID == 0) $this->redirect();
            break;
        }

        return $process;
    }

    /**
     * Redirects users
     *
     * @return void
     */
    private function redirect()
    {
        redirect($this->system->url->build($this->redirectURL));
    }

    /**
     * Ends process
     *
     * @param  object $process
     * @return void
     */
    private function _process( object $process )
    {
        if (isset($process->options['verify'])) {

            $block = $this->block ?? $process->options['verify']['block'];
            $method = $process->options['verify']['method'];
            $selector = $process->options['verify']['selector'];

            $block = new $block;

            if (!$blockData = $block->{$method}($this->data[$selector])) {
                if ($this->direct === true) {
                    return false;
                }
                $this->end(false);
            }

            foreach ($process->require['block'] ?? [] as $column) {
                $this->data[$column] = $blockData[$column] ?? '';
            }

        }

        $allData = array_merge($blockData ?? [], $this->data ?? []);

        $required = array_merge(
                $process->require['block'] ?? [],
                $process->require['data'] ?? []
        );

        foreach (array_filter($required) as $input) {
            if (!isset($allData[$input])) {
                throw new Exception($this->process . ' | Vyžaduje \'' . $input . '\'');
            }
        }

        $process->data($this->data);
        if ($process->process() !== false) {

            $this->id = $process->getID();

            if (AJAX) {
                $this->redirectURL = $process->redirectURL ?: '';
            } else {
                $this->redirectURL = $process->redirectURL ?: $this->redirectURL;
                $this->redirectURL .= PAGE != 1 ? '/page-' . PAGE . '/' : '';
            }

            $this->end(true);
            return true;

        }

        $this->end(false);
        return false;
    }
    
    /**
     * Ends process
     *
     * @param  bool $status
     * 
     * @throws \Exception\Notice If $status is false.
     * 
     * @return void|bool If "Direct mode" is enabled returns given $status otherwise it will redirect user to pre-defined URL.
     */
    private function end( bool $status = false )
    {
        // SHOW NOTICE
        if ($status === true) {
            if (AJAX and empty($this->redirectURL)) {
                $this->message = $this->process;
            } else {
                Session::put('success', $this->process);
            }
        } else {
            throw new \Exception\Notice($this->process);
        }

        if ($this->direct === false) {

            // REDIRECTS USER
            $this->redirect();
        }
        return $status;
    }
}