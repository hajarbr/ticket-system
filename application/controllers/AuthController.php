<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model('Ticket');
        $this->load->helper('url');
    }

    public function login() {
        if ($this->input->post()) {
            $login = $this->input->post('login');
            $password = $this->input->post('password');
    
            $user = $this->db->get_where('users', ['login' => $login])->row();
    
            if ($user && password_verify($password, $user->password)) {

                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'user_name' => $user->firstname . ' ' . $user->lastname,
                    'role' => $user->role
                ]);
    
                redirect('tickets');

            } else {
                $this->session->set_flashdata('error', 'Invalid login credentials.');
                redirect('login');
            }
        }
    
        $this->load->view('auth/login');
    }

    public function register() {
        $this->load->helper('auth_helper');
    
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $login = $this->input->post('login');
            $password = $this->input->post('password');
            $firstname = $this->input->post('firstname');   
            $lastname = $this->input->post('lastname');   
    
            $validation_error = validate_register_inputs($login, $password, $firstname, $lastname);
            if ($validation_error) {
                $this->session->set_flashdata('error', $validation_error);
                redirect('auth/register');
            }
    
            $existing_user_error = check_existing_user($login);
            if ($existing_user_error) {
                $this->session->set_flashdata('error', $existing_user_error);
                redirect('auth/register');
            }
    
            $data = [
                'login' => $login,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'firstname' => $firstname,
                'lastname' => $lastname,
                'role' => 'user'
            ];
            $this->db->insert('users', $data);
    
            $this->session->set_flashdata('success', 'Registration successful.');
            redirect('login');
        }
    
        $this->load->view('auth/register');
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->set_flashdata('success', 'You have been logged out.');
        redirect('login');
    }
}
