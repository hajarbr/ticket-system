<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Model {
    public function getAllTickets() {
        $this->db->select('tickets.*, users.firstname, users.lastname, status.name as status_name');
        $this->db->from('tickets');
        $this->db->join('users', 'user_id = users.id', 'left');
        $this->db->join('status', 'status_id = status.id', 'left');
        return $this->db->get()->result();
    }

    public function createTicket($data) {
        return $this->db->insert('tickets', $data);
    }
    
    public function updateTicket($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tickets', $data);
    }
    
    public function updateStatus($id, $status_id) {
        $this->db->where('id', $id);
        return $this->db->update('tickets', ['status_id' => $status_id]);
    }

    public function getTicketById($id) {
        $this->db->select('tickets.*, users.firstname, users.lastname, status.name as status_name');
        $this->db->from('tickets');
        $this->db->join('users', 'user_id = users.id', 'left');
        $this->db->join('status', 'status_id = status.id', 'left');
        $this->db->where('tickets.id', $id);
        return $this->db->get()->row();
    }

    public function addComment($data) {
        return $this->db->insert('comments', $data);
    }

    public function getCommentsByTicketId($ticket_id) {
        $this->db->select('comments.*, users.firstname, users.lastname');
        $this->db->from('comments');
        $this->db->join('users', 'comments.user_id = users.id', 'left');
        $this->db->where('comments.ticket_id', $ticket_id);

        return $this->db->get()->result();
    }

    public function getTicketsByStatus($status_id) {
        $this->db->select('tickets.*, users.firstname, users.lastname, status.name as status_name');
        $this->db->from('tickets');
        $this->db->join('users', 'tickets.user_id = users.id', 'left');
        $this->db->join('status', 'tickets.status_id = status.id', 'left');
        $this->db->where('tickets.status_id', $status_id);
        return $this->db->get()->result();
    }

    public function searchTickets() {
        checkAdmin();

        $title = $this->input->get('title');
        $data['title'] = 'Search Tickets by Title';
        $data['tickets'] = $this->Ticket->searchTicketsByTitle($title);
        $this->load->view('admin/tickets', $data);
    }

    public function searchTicketsByTitle($title) {
        $this->db->select('tickets.*, users.firstname, users.lastname, status.name as status_name');
        $this->db->from('tickets');
        $this->db->join('users', 'tickets.user_id = users.id', 'left');
        $this->db->join('status', 'tickets.status_id = status.id', 'left');
        $this->db->like('tickets.title', $title);
        return $this->db->get()->result();
    }

    public function getTicketsByUser($user_id) {
        $this->db->select('tickets.*, users.firstname, users.lastname, status.name as status_name');
        $this->db->from('tickets');
        $this->db->join('users', 'tickets.user_id = users.id', 'left');
        $this->db->join('status', 'tickets.status_id = status.id', 'left');
        $this->db->where('tickets.user_id', $user_id);
        return $this->db->get()->result();
    }

    public function filterTickets($title = null, $status_id = null, $user_id = null) {
        $this->db->select('tickets.*, users.firstname, users.lastname, status.name as status_name');
        $this->db->from('tickets');
        $this->db->join('users', 'tickets.user_id = users.id', 'left');
        $this->db->join('status', 'tickets.status_id = status.id', 'left');

        if (!empty($title)) {
            $this->db->like('tickets.title', $title);
        }
        if (!empty($status_id)) {
            $this->db->where('tickets.status_id', $status_id);
        }
        if (!empty($user_id)) {
            $this->db->where('tickets.user_id', $user_id);
        }

        return $this->db->get()->result();
    }
}