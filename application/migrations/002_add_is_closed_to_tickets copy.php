<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_is_closed_to_tickets extends CI_Migration {
    public function up() {
        if (!$this->db->field_exists('is_closed', 'tickets')) {
            $fields = [
                'is_closed' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0
                ]
            ];
            $this->dbforge->add_column('tickets', $fields);
        }
    }

    public function down() {
        if ($this->db->field_exists('is_closed', 'tickets')) {
            $this->dbforge->drop_column('tickets', 'is_closed');
        }
    }
}