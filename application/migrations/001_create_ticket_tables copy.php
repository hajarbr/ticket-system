<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_createTicket_tables extends CI_Migration {

    public function up() {
        // Table users
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'firstname' => ['type' => 'VARCHAR', 'constraint' => '255'],
            'lastname' => ['type' => 'VARCHAR', 'constraint' => '255'],
            'login' => ['type' => 'VARCHAR', 'constraint' => '255'],
            'password' => ['type' => 'VARCHAR', 'constraint' => '255']
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');

        // Table status
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => ['type' => 'VARCHAR', 'constraint' => '255']
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('status');

        // Table tickets
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'title' => ['type' => 'LONGTEXT'],
            'description' => ['type' => 'LONGTEXT'],
            'is_closed' => ['type' => 'INT', 'constraint' => 1],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'status_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tickets');

        // Table comments
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'comment' => ['type' => 'LONGTEXT'],
            'ticket_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('comments');
    }

    public function down() {
        $this->dbforge->drop_table('users');
        $this->dbforge->drop_table('status');
        $this->dbforge->drop_table('tickets');
        $this->dbforge->drop_table('comments');
    }
}
