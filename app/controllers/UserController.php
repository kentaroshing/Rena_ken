<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    // Show login form
    public function login_form()
    {
        // If already logged in, redirect to appropriate page
        if ($this->session->has_userdata('user_id')) {
            $user = $this->UserModel->get_user_by_id($this->session->userdata('user_id'));
            if (is_array($user) && !empty($user) && $user['role'] == 'admin') {
                redirect('/students/list');
            } else {
                // Check if user has a student record
                if (is_array($user) && !empty($user) && $this->UserModel->has_student_record($user['email'])) {
                    redirect('/students/list');
                } else {
                    redirect('/students/create');
                }
            }
        }
        $this->call->view('login', ['session' => $this->session]);
    }

    // Handle login
    public function login()
    {
        if ($this->io->method() == 'post') {
            $email = $this->io->post('email');
            $password = $this->io->post('password');

            $user = $this->UserModel->get_user_by_email_or_username($email);

            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('user_email', $user['email']);
                $this->session->set_userdata('user_role', $user['role']);

                // Redirect based on role
                if ($user['role'] == 'admin') {
                    redirect('/students/list');
                } else {
                    // Check if user has a student record
                    if ($this->UserModel->has_student_record($user['email'])) {
                        redirect('/students/list');
                    } else {
                        redirect('/students/create');
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid email/username or password.');
                redirect('/login');
            }
        } else {
            redirect('/login');
        }
    }

    // Show register form
    public function register_form()
    {
        $this->call->view('register', ['session' => $this->session]);
    }

    // Handle register
    public function register()
    {
        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $email = $this->io->post('email');
            $password = $this->io->post('password');

            // Check if email or username exists in users table
            if ($this->UserModel->email_exists($email)) {
                $this->session->set_flashdata('error', 'Email already in use.');
                redirect('/register');
            }
            if ($this->UserModel->username_exists($username)) {
                $this->session->set_flashdata('error', 'Username already exists.');
                redirect('/register');
            }

            // Check if email exists in students table
            $existing_student = $this->db->table('students')->where('email', $email)->get();
            if (!empty($existing_student)) {
                $this->session->set_flashdata('error', 'Email already associated with a student record.');
                redirect('/register');
            }

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password,
                'role' => 'user' // Default to user
            ];

            if ($this->UserModel->create_user($data)) {
                $this->session->set_flashdata('success', 'Registration successful! Please log in.');
                redirect('/login');
            } else {
                $this->session->set_flashdata('error', 'Registration failed. Try again.');
                redirect('/register');
            }
        } else {
            redirect('/register');
        }
    }

    // Handle logout
    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'user_email', 'user_role']);
        $this->session->sess_destroy();
        redirect('/login');
    }

    // Handle cancel registration
    public function cancel_registration()
    {
        $user_id = $this->session->userdata('user_id');
        $user_email = $this->session->userdata('user_email');

        // Delete user account
        $this->UserModel->db->table('users')->where('id', $user_id)->delete();

        // Delete associated student record if exists
        $this->UserModel->db->table('students')->where('email', $user_email)->delete();

        // Destroy session
        $this->session->unset_userdata(['user_id', 'user_email', 'user_role']);
        $this->session->sess_destroy();

        redirect('/login');
    }
}
?>
