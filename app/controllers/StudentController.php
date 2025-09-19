<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {
    public function __construct()
    {
        parent::__construct();
        
    }

    // Show all students
    public function index()
    {
        $page = 1;
        if(isset($_GET['page']) && ! empty($_GET['page'])) {
            $page = (int) $this->io->get('page');
        }

        $q = '';
        if(isset($_GET['q']) && ! empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 10;
        $offset = ($page - 1) * $records_per_page;

        $result = $this->StudentsModel->get_paginated($q, $records_per_page, $offset);
        $data['students'] = $result['records'];
        $total_rows = $result['total_rows'];

        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('custom');
        $this->pagination->initialize($total_rows, $records_per_page, $page, site_url('students').'?q='.$q);
        $data['pages'] = $this->pagination->paginate();

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