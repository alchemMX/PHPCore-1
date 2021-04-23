<?php

namespace Process\Pm;

class Create extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'pm_subject'    => [
                'type' => 'text',
                'required' => true,
                'length_max' => 100
            ],
            'to'            => [
                'type' => 'array',
                'required' => true,
                'length_max' => 10,
                'block' => '\Block\User.getAllID'
            ],
            'pm_text'       => [
                'type' => 'html',
                'required' => true,
                'length_max' => 100000
            ],
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        if (in_array(LOGGED_USER_ID, $this->data->get('to'))) {
            return false;
        }

        // INSERT PM TO DATABASE
        $this->db->insert(TABLE_PRIVATE_MESSAGES, [
            'pm_url'        => parse($this->data->get('pm_subject')),
            'pm_text'		=> $this->data->get('pm_text'),
            'user_id'	    => LOGGED_USER_ID,
            'pm_subject'	=> $this->data->get('pm_subject')
        ]);

        $lastInsertId = $this->db->lastInsertId();

        // INSERT PM RICIPEINTS TO DATABASE
        foreach (array_merge([LOGGED_USER_ID], array_unique($this->data->get('to'))) as $userID) {

            // ADDS RECIPIENT
            $this->db->insert(TABLE_PRIVATE_MESSAGES_RECIPIENTS, [
                'pm_id' => $lastInsertId,
                'user_id' => $userID
            ]);

            if ($userID != LOGGED_USER_ID) {
                // UPLOADS USER'S NEW MESSAGE NOTIFICATIONS
                $this->db->insert(TABLE_USERS_UNREAD, [
                    'pm_id' => $lastInsertId,
                    'user_id' => $userID
                ]);
            }
        }

        $this->redirectTo('/user/pm/show/' .$lastInsertId . '.' . parse($this->data->get('pm_subject')));
    }
}