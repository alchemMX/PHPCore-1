<?php

namespace Process\Topic;

class Label extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'topic_label' => [
                'type' => 'array',
                'length_max' => 4,
                'block' => '\Block\Label.getAllID'
            ]
        ],
        'data' => [
            'topic_id'
        ],
        'block' => [
            'user_id',
            'topic_name'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'block' => '\Block\Topic',
            'method' => 'get',
            'selector' => 'topic_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        // DELETE ALL LABELS FROM TOPIC
        $this->db->query('
            DELETE tlb FROM ' . TABLE_TOPICS_LABELS . '
            WHERE topic_id = ?
        ', [$this->data->get('topic_id')]);

        // FOREACH LABELS ID
        if (!empty($this->data->get('topic_label'))) {
            foreach ($this->data->get('topic_label') as $labelID) {

                // INSERT NEW LABELS TO TOPIC
                $this->db->insert(TABLE_TOPICS_LABELS, [
                    'topic_id' => $this->data->get('topic_id'),
                    'label_id' => $labelID
                ]);
            }
        }

        // SEND NOTIFICATION
        $this->notifi(
            id: $this->data->get('topic_id'),
            to: $this->data->get('user_id'),
            replace: true
        );

        // ADD RECORD TO LOG
        $this->log($this->data->get('topic_name'));
    }
}