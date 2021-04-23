<?php

namespace Process;

class Database extends Process
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'host'      => [
                'type' => 'text',
                'required' => true
            ],
            'user_name'  => [
                'type' => 'text',
                'required' => true
            ],
            'user_password'  => [
                'type' => 'text'
            ],
            'database'  => [
                'type' => 'text',
                'required' => true
            ],
            'port'      => [
                'type' => 'number'
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
        $port = empty($this->data->get('port')) ? 3306 : $this->data->get('port');

        try {
            // TEST CONNECTION
            $db = new \PDO('mysql:host=' . $this->data->get('host') . ';port=' . $port . ';dbname=' . $this->data->get('database'), $this->data->get('user_name'), $this->data->get('user_password'));

            file_put_contents(ROOT . '/Includes/Settings/.htdata.json', json_encode([
                'host' => $this->data->get('host'),
                'user' => $this->data->get('user_name'),
                'pass' => $this->data->get('user_password'),
                'name' => $this->data->get('database'),
                'port' => $port
            ]));
        
        } catch (\PDOException $e) {
            throw new \Exception\Notice($e->getMessage());
        }

        $this->system->install([
            'db' => true,
            'page' => 3,
        ]);
    }
}