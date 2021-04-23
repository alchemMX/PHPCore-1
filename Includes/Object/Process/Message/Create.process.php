<?php

namespace Process\Message;

use Block\Pm;

class Create extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [

            // MESSAGE TEXT
            'text'  => [
                'type' => 'html',
                'required' => true,
                'length_max' => 10000,
            ]
        ],
        'data' => [
            'pm_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'block' => '\Block\Pm',
            'method' => 'get',
            'selector' => 'pm_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        // INSERT MESSAGE
        $this->db->insert(TABLE_MESSAGES, [
            'pm_id'			=> $this->data->get('pm_id'),
            'user_id' 		=> LOGGED_USER_ID,
            'message_text'	=> $this->data->get('text')
        ]);

        $this->id = $this->db->lastInsertId();

        // EDIT PRIVATE MESSAGE
        $this->db->update(TABLE_PRIVATE_MESSAGES, [
            'pm_messages' => [PLUS],
        ], $this->data->get('pm_id'));

        // GET UNREAD USERS
        $unread = array_column($this->db->query('
            SELECT user_id
            FROM ' . TABLE_USERS_UNREAD . '
            WHERE pm_id = ?
        ', [$this->data->get('pm_id')], ROWS), 'user_id');

        $pm = new Pm();

        // SET UNREAD TO RECIPIENTS
        foreach (array_column($pm->getRecipients($this->data->get('pm_id')), 'user_id') as $userID) {

            if ($userID != LOGGED_USER_ID) {

                if (in_array($userID, $unread) === false) {
                    // UPLOADS USER'S NEW MESSAGE NOTIFICATIONS
                    $this->db->insert(TABLE_USERS_UNREAD, [
                        'pm_id' => $this->data->get('pm_id'),
                        'user_id' => $userID
                    ]);
                }
            }
        }
        
        return true;
    }
}