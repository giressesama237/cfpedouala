<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *  @author     : ITSolutions
 *  date        : 14 september, 2017
 *  MySchool Management System Pro
 */
class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Barcode_model');
        $this->load->model(array('Ajaxdataload_model' => 'ajaxload'));

        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    function getStudents($class_id)
    {
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $students =  $this->crud_model->get_students($class_id, $running_year);
        echo json_encode($students);
    }
    function getSubjectByClass($class_id)
    {
        $classes = $this->crud_model->get_subjects_by_class($class_id);
        echo json_encode($classes);
    }
    function getTeacher()
    {
        $teachers = $this->crud_model->get_teachers();
        echo json_encode($teachers);
    }
    function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $credential = array('email' => $email, 'password' => sha1($password));
        // Checking login credential for admin
        if(count($query = $this->db->get_where('admin', $credential)->row())){
            $result['admin_login'] = 1;
            $result['admin_id'] = $query->admin_id;
            $result['login_user_id'] = $query->admin_id;
            $result['name'] = $query->name;
            $result['login_type'] = $query->type;
            $result['login_error'] = 0;
            

        }else if(count($query = $this->db->get_where('teacher', $credential)->row())) {
            $result['teacher_login'] = 1;
            $result['teacher_id'] = $query->admin_id;
            $result['teacher_user_id'] = $query->admin_id;
            $result['name'] = $query->name;
            $result['login_error'] = 0;
            $result['login_type'] = $query->type;
        }else{
            $result['login_error'] = 1;
        }
        echo json_encode($result);
    }
}
