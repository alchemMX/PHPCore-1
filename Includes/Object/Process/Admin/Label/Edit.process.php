<?php

namespace Process\Admin\Label;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'label_name'    => [
                'type'      => 'text',
                'required' => true
            ],
            'label_color'   => [
                'type'      => 'text',
                'required'  => true
            ]
        ],
        'data' => [
            'label_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'block' => '\Block\label',
            'method' => 'get',
            'selector' => 'label_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->update(TABLE_LABELS, [
            'label_name'        => $this->data->get('label_name'),
            'label_color'       => $this->data->get('label_color'),
            'label_class_name'  => parse($this->data->get('label_name')),
        ], $this->data->get('label_id'));

        $css = '';
        foreach ($this->db->query('SELECT label_class_name, label_color FROM ' . TABLE_LABELS, [], ROWS) as $label) {
            $css .= '.label.label--' . $label['label_class_name'] . '{background-color:' . $label['label_color'] . '}.label-text.label--' . $label['label_class_name'] . '{color:' . $label['label_color'] . ' !important}.label--' . $label['label_class_name'] . ' input[type="checkbox"] + label .checkbox-icon{border-color:' . $label['label_color'] . '}.label--' . $label['label_class_name'] . ' input[type="checkbox"]:checked + label .checkbox-icon{background-color:' . $label['label_color'] . '}';
        }
        file_put_contents(ROOT . '/Includes/Template/css/Label.min.css', $css);

        // ADD RECORD TO LOG
        $this->log($this->data->get('label_name'));

        $this->updateSession();
    }
}