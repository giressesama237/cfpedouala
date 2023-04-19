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
    function getStudents($class_id){
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $students =  $this->crud_model->get_students($class_id,$running_year);
        echo json_encode($students);
            
    }
    function getSubjectByClass($class_id){
        $classes = $this->crud_model->get_subjects_by_class($class_id);
        echo json_encode($classes);
    }
    function getTeacher(){
        $teachers = $this->crud_model->get_teachers();
        echo json_encode($teachers);
    }
    
}