<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_role_to_users extends CI_Migration {
    public function up() {
        $fields = [
            'role' => [
                'type' => 'ENUM("user", "admin")',
                'default' => 'user',
                'null' => FALSE
            ]
        ];
        $this->dbforge->add_column('users', $fields);
    }

    public function down() {
        $this->dbforge->drop_column('users', 'role');
    }
}