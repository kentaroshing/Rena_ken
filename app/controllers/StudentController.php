<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {
    public function __construct()
    {
        parent::__construct();
        
    }

    // Show all students with pagination and search
    public function index()
    {
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
            'q' => $q
        ];

        $this->call->view('students_list', $data);
    }

    // Show create form
    public function create_form()
    {
        $this->call->view('student_create');
    }

    // Handle create
    public function create()
    {
        if($this->io->method() == 'post') {
            $first_name = $this->io->post('first_name');
            $last_name  = $this->io->post('last_name');
            $email      = $this->io->post('email');

    
        $data = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email
        ];
        $this->StudentsModel->insert($data);
        redirect('/');
        }else{
         $this->call->view('students/create');   
        }
    
    }

    // Show edit form
    public function edit_form($id)
    {
        $data['students'] = $this->StudentsModel->find($id);
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
        redirect('/');
    }else{
        $this->call->view('students/edit', $data);
    }
        
    }

    // Handle delete
    public function delete($id)
    {
        $this->StudentsModel->delete($id);
        redirect('/');
    }
}
