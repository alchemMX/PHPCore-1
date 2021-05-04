<?php

namespace Process;

class Admin extends Process
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'user_name'      => [
                'type' => 'username',
                'required' => true
            ],
            'user_email'  => [
                'type' => 'email',
                'required' => true
            ],
            'user_password'  => [
                'type' => 'password',
                'required' => true
            ]
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->query('INSERT INTO `phpcore_users` (`user_name`, `user_email`, `user_password`, `user_profile_image`, `group_id`, `is_admin`, `user_topics`) VALUES (?, ?, ?, ?, ?, ?, ?)', [
            $this->data->get('user_name'),
            $this->data->get('user_email'),
            password_hash($this->data->get('user_password'), PASSWORD_DEFAULT),
            PROFILE_IMAGES_COLORS[mt_rand(0, 6)],
            '2',
            '1',
            '1'
        ]);

        $this->system->install([
            'db' => true,
            'page' => 5,
        ]);
    }
}