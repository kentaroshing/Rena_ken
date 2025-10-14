<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();

        // Check if logged in
        if (!$this->session->has_userdata('user_id')) {
            redirect('/login');
        }
    }

    // Show all students with pagination and search
    public function index()
    {
        $user_role = $this->session->userdata('user_role');

        if ($user_role != 'admin') {
            // For regular users, redirect to create form if no student record exists
            $user_email = $this->session->userdata('user_email');
            $existing_student = $this->StudentsModel->db->table('students')->where('email', $user_email)->get();
            if (empty($existing_student)) {
                redirect('/students/create');
            }
        }

        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $records_per_page = 5;

        $result = $this->StudentsModel->page($q, $records_per_page, $page);

        $total_rows = $result['total_rows'];
        $students = $result['records'];

        $last_page = (int) ceil($total_rows / $records_per_page);
        $current_page = max(1, min($page, $last_page));

        $data = [
            'students' => $students,
            'total_rows' => $total_rows,
            'current_page' => $current_page,
            'last_page' => $last_page,
            'q' => $q,
            'user_role' => $user_role,
            'session' => $this->session
        ];

        $this->call->view('students_list', $data);
    }

    // Show create form
    public function create_form()
    {
        $this->call->view('student_create', ['session' => $this->session]);
    }

    // Handle create
    public function create()
    {
        if($this->io->method() == 'post') {
            $first_name = trim($this->io->post('first_name'));
            $last_name  = trim($this->io->post('last_name'));
            $user_role = $this->session->userdata('user_role');
            $user_email = $this->session->userdata('user_email');

            // Check if student with same name already exists
            $stmt = $this->StudentsModel->db->raw("SELECT * FROM students WHERE LOWER(TRIM(first_name)) = LOWER(?) AND LOWER(TRIM(last_name)) = LOWER(?)", [$first_name, $last_name]);
            $existing_name = $stmt->fetchAll();
            if (!empty($existing_name)) {
                $this->session->set_flashdata('error', 'The name you entered is already taken. Please enter a different name.');
                redirect('/students/create');
            }

            if ($user_role != 'admin') {
                // For regular users, use their own email and check if they already have a record
                $existing_student = $this->StudentsModel->db->table('students')->where('email', $user_email)->get();
                if (!empty($existing_student)) {
                    $this->session->set_flashdata('error', 'You already have a student record.');
                    redirect('/students/create');
                }
                $email = $user_email;
            } else {
                $email = $this->io->post('email');
                // Check if email already exists in students table
                $existing_student = $this->StudentsModel->db->table('students')->where('email', $email)->get();
                if (!empty($existing_student)) {
                    $this->session->set_flashdata('error', 'Email already exists in students.');
                    redirect('/students/create');
                }
            }

            $data = [
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email
            ];
            $this->StudentsModel->insert($data);
            $this->session->set_flashdata('success', 'Student added successfully!');
            redirect('/students/list');
        } else {
            $this->call->view('student_create', ['session' => $this->session]);
        }

    }

    // Show edit form
    public function edit_form($id)
    {
        $user_role = $this->session->userdata('user_role');
        $user_email = $this->session->userdata('user_email');

        $student = $this->StudentsModel->find($id);

        // Allow edit only if admin or if the student record belongs to the user
        if ($user_role != 'admin' && $student['email'] != $user_email) {
            redirect('/students/list');
        }

        $data['students'] = $student;
        $this->call->view('student_edit', $data);
    }

    // Handle update
    public function update($id)
    {
         if($this->io->method() == 'post') {
            $first_name = $this->io->post('first_name');
            $last_name  = $this->io->post('last_name');
            $email      = $this->io->post('email');


        $data = [
            'first_name' => $this->io->post('first_name'),
            'last_name'  => $this->io->post('last_name'),
            'email'      => $this->io->post('email'),
        ];
        $this->StudentsModel->update($id, $data);
        redirect('/students/list');
    }else{
        $this->call->view('students/edit', $data);
    }
        
    }

    // Handle delete
    public function delete($id)
    {
        $user_role = $this->session->userdata('user_role');

        // Only admins can delete
        if ($user_role != 'admin') {
            redirect('/');
        }

        $this->StudentsModel->delete($id);
        redirect('/students/list');
    }
}
