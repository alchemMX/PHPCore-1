<?php

namespace Process;

use Model\Form;
use Model\Database;

/**
 * Process
 */
class Process {

    /**
     * @var string $redirectURL Url where will be user redirected after process execution
     */
    private $redirectURL = '/Install/';

    /**
     * @var bool $_options Process options
     */
    private $_options = [];

    /**
     * @var object $form Refers to Form class
     */
    private $form = [];

    /**
     * @var array $_data Process data
     */
    private $_data = [];

    /**
     * @var object $db Database
     */
    protected $db;
    
    /**
     * @var object $check Check class
     */
    protected $check;

    /**
     * @var object $notice Notice class
     */
    protected $notice;

    /**
     * @var object $data ProcessData
     */
    protected $data;

    /**
     * @var object $system Model
     */
    public \Model\System $system;
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    { 
        $this->db = new Database();
        $this->check = new ProcessCheck();
    }

    /**
     * Checks form data
     *
     * @return bool
     */
    private function checkData( array $format )
    {
        $formData = $this->form->getData();

        foreach ($format as $input => $settings) {

            if (isset($settings['required'])) {
                if (empty($formData[$input])) {
                    throw new \Exception\Notice($input);
                }
            }

            foreach ($settings as $key => $value) {
                
                switch ($key) {

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

                            case 'text':
                            case 'email':
                            case 'username':
                            case 'password':
                                $formData[$input] = strip_tags($formData[$input]);
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

                        $this->_data[$input] = $formData[$input];
                    break;
                }
            }

        }

        return true;
    }

    /**
     * Submits form and starts process
     *
     * @param  string $type
     * @param  array $data
     * @return void
     */
    public function form( string $type, string $on = 'submit', array $data = [] )
    {
        // LOAD FORM
        $this->form = new Form();
        
        // IF SUBMIT BUTTON WAS PRESSED
        if ($this->form->isSend($on)) {

            $this->_data = $data;

            // EXPLODE PROCESS NAME
            $ex = explode('/', $type);

            // SET VARIABLES
            $this->process = $type;

            $process = 'Process\\' . implode('\\', $ex);

            $process =  new $process;
    
            if ($this->checkData($process->require['form'] ?? [])) {

                // CHECK INPUTS
                $process->_data = $this->_data;
                $process->system = $this->system;
                $process->data = new ProcessData($this->_data);
                if ($process->process() !== false) {
                    $this->redirect();
                    return true;
                }

                $this->redirect();
                return false;
            }

            return false;
        }
    }

    /**
     * Redirects users
     *
     * @return void
     */
    private function redirect()
    {
        redirect($this->redirectURL);
    }
}