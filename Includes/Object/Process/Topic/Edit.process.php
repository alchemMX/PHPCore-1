<?php

namespace Process\Topic;

use Model\File;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'topic_name'            => [
                'type' => 'text',
                'required' => true,
                'length_max' => 100
            ],
            'topic_text'            => [
                'type' => 'html',
                'required' => true,
                'length_max' => 100000
            ],
            'delete_topic_image'    => [
                'type' => 'checkbox'
            ]
        ],
        'data' => [
            'topic_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        // FILE
        $file = new File();
        
        // IF LOGGED USER HAS PERMISSION TO UPLOAD TOPIC IMAGE
        if ($this->perm->has('topic.image')) {

            // IF DELETE TOPIC IMAGE BUTTON WAS PRESSED
            if ($this->data->is('delete_topic_image')) {

                // DELETE IMAGE
                $file->deleteImage('/topics/' . $this->data->get('topic_id'));

                // DELETE TOPIC IMAGE
                $this->db->update(TABLE_TOPICS, [
                    'topic_image' => ''
                ], $this->data->get('topic_id'));

            } else {

                // UPLOAD TOPIC IMAGE
                $file->load('topic_image');
                if ($file->check()) {

                    // UPLOAD IMAGE
                    $file->upload('/Topics/' . $this->data->get('topic_id'));

                    // SET TOPIC IMAGE
                    $this->db->update(TABLE_TOPICS, [
                        'topic_image' => $file->getFormat() . '?' . RAND
                    ], $this->data->get('topic_id'));
                }
            }
        }

        // UPDATE TOPIC
        $this->db->update(TABLE_TOPICS, [
            'topic_url'     => parse($this->data->get('topic_name')),
            'is_edited'     => '1',
            'topic_text'    => $this->data->get('topic_text'),
            'topic_name'    => $this->data->get('topic_name'),
            'topic_edited'  => DATE_DATABASE
        ], $this->data->get('topic_id'));
    }
}