<?php

namespace Process\User;

use Model\File;

class Settings extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'user_text' => [
                'type' => 'text',
                'length_max' => 50
            ],
            'user_location'             => [
                'type' => 'text',
                'length_max' => 50
            ],
            'user_age'                  => [
                'type' => 'number'
            ],
            'user_gender'               => [
                'custom' => ['man', 'woman', 'undefined']
            ],
            'delete_user_profile_image' => [
                'type' => 'checkbox'
            ],
            'delete_user_header_image'  => [
                'type' => 'checkbox'
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
        // FILE MODEL
        $file = new File();

        // LOAD PROFILE IMAGES
        $file->load('user_profile_image');
        if ($file->check()) { 

            $file->createFolder('/User/' . LOGGED_USER_ID);

            // UPLOAD IMAGE
            $file->upload('/User/' . LOGGED_USER_ID . '/Profile');

            // RESIZE
            $file->resize('/User/' . LOGGED_USER_ID . '/Profile.' . $file->getFormat(), 200, 200);

            // SET IMAGE
            $this->db->update(TABLE_USERS, [
                'user_profile_image' => $file->getFormat() . '?' . RAND
            ], LOGGED_USER_ID);
        }

        // LOAD HEADER IMAGE
        $file->load('user_header_image');
        if ($file->check()) {

            $file->createFolder('/User/' . LOGGED_USER_ID);

            // UPLOAD IMAGE
            $file->upload('/User/' . LOGGED_USER_ID . '/Header');

            // SET IMAGE
            $this->db->update(TABLE_USERS, [
                'user_header_image' => $file->getFormat() . '?' . RAND
            ], LOGGED_USER_ID);
        }
        
        // IF DELETE PROFILE IMAGE
        if ($this->data->is('delete_user_profile_image')) {

            // DELETE IMAGE
            $file->deleteImage('/User/' . LOGGED_USER_ID . '/Profile');

            // SET IMAGE
            $this->db->update(TABLE_USERS, [
                'user_profile_image' => PROFILE_IMAGES_COLORS[rand(0, 6)]
            ], LOGGED_USER_ID);
        }

        // IF DELETE HEADER IMAGE
        if ($this->data->is('delete_user_header_image')) {

            // DELETE IMAGE
            $file->deleteImage('/User/' . LOGGED_USER_ID . '/Header');

            // SET IMAGE
            $this->db->update(TABLE_USERS, [
                'user_header_image' => ''
            ], LOGGED_USER_ID);
        }
        
        // UPDATE USER INFORMATIONS
        $this->db->update(TABLE_USERS, [
            'user_age' 		        => $this->data->get('user_age'),
            'user_text'             => $this->data->get('user_text'),
            'user_gender' 	        => $this->data->get('user_gender') == 'undefined' ? '' : $this->data->get('user_gender'),
            'user_location'         => $this->data->get('user_location')
        ], LOGGED_USER_ID);
    }
}