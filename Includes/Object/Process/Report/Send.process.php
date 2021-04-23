<?php

namespace Process\Report;

class Send extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'report_reason' => [
                'type' => 'text',
                'required' => true,
                'length_max' => 1000,
            ]
        ],
        'data' => [
            'report_type',
            'report_type_id'
        ],
        'block' => [
            'user_id',
            'report_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'method' => 'get',
            'selector' => 'report_type_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        if ($this->data->get('report_id')) {

            $this->db->query('
                UPDATE ' . TABLE_REPORTS . '
                SET report_status = 0
                WHERE report_id = ?
            ', [$this->data->get('report_id')]);

            $this->id = $this->data->get('report_id');
        } else {

            $this->db->insert(TABLE_REPORTS, [
                'report_type' => $this->data->get('report_type'),
                'report_type_id' => $this->data->get('report_type_id'),
                'report_type_user_id' => $this->data->get('user_id')
            ]);
            $this->id = $this->db->lastInsertId();

            switch ($this->data->get('report_type')) {

                case 'Post':
                    $this->db->query('UPDATE ' . TABLE_POSTS . ' SET report_id = ? WHERE p.post_id = ?', [$this->id, $this->data->get('report_type_id')]);
                break;

                case 'Topic':
                    $this->db->query('UPDATE ' . TABLE_TOPICS . ' SET report_id = ? WHERE t.topic_id = ?', [$this->id, $this->data->get('report_type_id')]);
                break;

                case 'ProfilePost':
                    $this->db->query('UPDATE ' . TABLE_PROFILE_POSTS . ' SET report_id = ? WHERE pp.profile_post_id = ?', [$this->id, $this->data->get('report_type_id')]);
                break;

                case 'ProfilePostComment':
                    $this->db->query('UPDATE ' . TABLE_PROFILE_POSTS_COMMENTS . ' SET report_id = ? WHERE ppc.profile_post_comment_id = ?', [$this->id, $this->data->get('report_type_id')]);
                break;
            }
        }

        $this->db->insert(TABLE_REPORTS_REASONS, [
            'user_id' => LOGGED_USER_ID,
            'report_id' => $this->id,
            'reason_text' => $this->data->get('report_reason')
        ]);
    }
}