<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TicketController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Ticket');
        $this->load->helper('auth_helper');
    
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $role = $this->session->userdata('role');

        if ($role === 'admin') {
            $data['title'] = 'Admin Dashboard';
            $this->load->view('admin/dashboard', $data);
        } elseif ($role === 'user') {
            $data['title'] = 'User Dashboard';
            $this->load->view('user/dashboard', $data);
        } else {
            redirect('login');
        }
    }

    public function view() {
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');

        if ($role === 'admin') {
            $data['title'] = 'Mes tickets';
            $data['tickets'] = $this->Ticket->getAllTickets();
        } elseif ($role === 'user') {
            $data['title'] = 'Gestion des tickets';
            $data['tickets'] = $this->Ticket->getTicketsByUser($user_id);
        } else {
            redirect('login');
        }

        $data['content'] = $this->load->view('ticket/list', ['tickets' => $data['tickets']], TRUE);
        $this->load->view('layouts/adminlte', $data);
    }

    public function edit($id) {
        $ticket = $this->Ticket->getTicketById($id);
        if (!$ticket) {
            show_404(); 
        }
    
        if ($this->input->post()) {
            $data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
            ];
            $this->Ticket->updateTicket($id, $data);
            $this->session->set_flashdata('success', 'Ticket updated successfully.');
            redirect('tickets');
        }
    
        $data['title'] = 'Modifier un ticket';
        $data['content'] = $this->load->view('ticket/edit', ['ticket' => $ticket], TRUE);
        $this->load->view('layouts/adminlte', $data);
    }

    public function add() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $title = $this->input->post('title');
            $description = $this->input->post('description');
    
            if (empty($title) || empty($description)) {
                $this->session->set_flashdata('error', 'Tous les champs sont obligatoires.');
                redirect('add');
            }
    
            $data = [
                'title' => $title,
                'description' => $description,
                'is_closed' => 0,
                'user_id' => $this->session->userdata('user_id'),
                'status_id' => 1
            ];
            $this->db->insert('tickets', $data);
    
            $this->session->set_flashdata('success', 'Ticket ajouté avec succès.');
            redirect('tickets');
        }

        $data['title'] = 'Créer un ticket';
        $data['content'] = $this->load->view('ticket/add', $data, TRUE);

        $this->load->view('layouts/adminlte', $data);
    }

    public function respond($id) {
        $ticket = $this->Ticket->getTicketById($id);
        if (!$ticket) {
            show_404(); 
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $comment = $this->input->post('response');

            if (empty($comment)) {
                $this->session->set_flashdata('error', 'Le commentaire ne peut pas être vide.');
                redirect('respond/' . $id);
            }

            $data = [
                'ticket_id' => $id,
                'user_id' => $this->session->userdata('user_id'),
                'comment' => $comment
            ];
            $this->Ticket->addComment($data);

            $this->session->set_flashdata('success', 'Commentaire ajouté avec succès.');
            redirect('respond/' . $id);
        }

        $data['ticket'] = $ticket;
        $data['comments'] = $this->Ticket->getCommentsByTicketId($id);
        $data['title'] = 'Répondre au Ticket';
        $data['content'] = $this->load->view('ticket/respond', $data, TRUE);

        $this->load->view('layouts/adminlte', $data);
    }

    public function changeStatus($id) {
        checkAdmin(); 

        $ticket = $this->Ticket->getTicketById($id);
        if (!$ticket) {
            show_404(); 
        }
    
        if ($this->input->post()) {
            $status_id = $this->input->post('status_id');
            $this->Ticket->updateStatus($id, $status_id);
            $this->session->set_flashdata('success', 'Ticket status updated successfully.');
            redirect('tickets');
        }
    
        $data['title'] = 'Changer le status d\'un ticket';
        $data['content'] = $this->load->view('ticket/change_status', ['ticket' => $ticket], TRUE);
        $this->load->view('layouts/adminlte', $data);
    }
    public function close($id) {
        checkAdmin();
    
        $ticket = $this->Ticket->getTicketById($id);
        if (!$ticket) {
            show_404();
        }
    
        $this->Ticket->updateTicket($id, ['is_closed' => 1]);
        $this->session->set_flashdata('success', 'Ticket closed successfully.');
        redirect('tickets');
    }

    public function filterTickets() {
        checkAdmin();
    
        $status_id = $this->input->get('status_id');
        $data['title'] = 'Filtrer les Tickets par Statut';
        $data['tickets'] = $this->Ticket->getTicketsByStatus($status_id);
        $data['content'] = $this->load->view('admin/tickets', $data, TRUE);
        $this->load->view('layouts/adminlte', $data);
    }

    public function searchTickets() {
        checkAdmin();

        // Trim spaces from the title input
        $title = trim($this->input->get('title'));
        $data['title'] = 'Chercher les Tickets par Titre';
        $data['tickets'] = $this->Ticket->searchTicketsByTitle($title);
        $data['content'] = $this->load->view('admin/tickets', $data, TRUE);
        $this->load->view('layouts/adminlte', $data);
    }

    public function filter() {
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');
        $title = trim($this->input->get('title'));
        $status_id = $this->input->get('status_id');
    
        if ($role === 'admin') {
            $data['tickets'] = $this->Ticket->filterTickets($title, $status_id);
        } elseif ($role === 'user') {
            $data['tickets'] = $this->Ticket->filterTickets($title, $status_id, $user_id);
        } else {
            redirect('login');
        }
    
        $data['title'] = 'Tickets';
        $data['content'] = $this->load->view('ticket/list', ['tickets' => $data['tickets']], TRUE);
        $this->load->view('layouts/adminlte', $data);
    }
}