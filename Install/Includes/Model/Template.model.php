<?php

namespace Model;

class Template {

    private $template;
    public $language;
    private $favicon = '/Uploads/Site/PHPCore_icon.svg?' . RAND;

    public $data = ['hideNavbar' => false];

    public function load( string $templateName )
    {
        $this->template = $templateName;
    }

    public function show( string $noticeMessage = null )
    {
        global $form;

        if (empty($form)) $form = new Form();

        if (empty($this->data['favicon'])) $this->data['favicon'] = $this->favicon;

        $this->data['templateName'] = $this->template;

        if (!is_null($noticeMessage)) {
            $this->data['noticeMessage'] = $noticeMessage;
        }

        extract($this->data);
        extract((array)$this->language);
        require ROOT . '/Install/Style/Templates/body.phtml';
        exit(0);
    }

}