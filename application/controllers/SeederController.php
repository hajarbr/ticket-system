<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeederController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function seed() {
        $this->seed_status();
        $this->seed_users();
        $this->seed_tickets();
        echo "Seeding completed!";
    }

    private function seed_status() {
        $data = [
            ['name' => 'Open'],
            ['name' => 'In Progress'],
            ['name' => 'Closed']
        ];
        $this->db->insert_batch('status', $data);
        echo "Seeded status table.<br>";
    }

    private function seed_users() {
        $data = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'login' => 'johndoe',
                'password' => password_hash('password', PASSWORD_BCRYPT)
            ],
            [
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'login' => 'janesmith',
                'password' => password_hash('password', PASSWORD_BCRYPT)
            ]
        ];
        $this->db->insert_batch('users', $data);
        echo "Seeded users table.<br>";
    }

    private function seed_tickets() {
        $data = [
            [
                'title' => 'Issue with login',
                'description' => 'Unable to log in to the system.',
                'user_id' => 1,
                'status_id' => 1
            ],
            [
                'title' => 'Bug in dashboard',
                'description' => 'Dashboard is not loading properly.',
                'user_id' => 2,
                'status_id' => 2
            ]
        ];
        $this->db->insert_batch('tickets', $data);
        echo "Seeded tickets table.<br>";
    }
}