<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('validate_register_inputs')) {
    function validate_register_inputs($login, $password, $firstname, $lastname) {
        if (empty($login) || empty($password) || empty($firstname) || empty($lastname)) {
            return 'All fields are required.';
        }
        return null;
    }
}

if (!function_exists('check_existing_user')) {
    function check_existing_user($login) {
        $CI =& get_instance();
        $existing_user = $CI->db->get_where('users', ['login' => $login])->row();
        if ($existing_user) {
            return 'Login already exists.';
        }
        return null;
    }
    
    if (!function_exists('checkAdmin')) {
        function checkAdmin() {
            $CI =& get_instance();
            if ($CI->session->userdata('role') !== 'admin') {
                $CI->session->set_flashdata('error', 'Access denied.');
                redirect('tickets');
            }
        }
    }
}