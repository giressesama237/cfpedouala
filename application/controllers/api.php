<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *  @author     : nickdk
 *  date        : 14 april, 2023
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
    


    function get_all_students() {
        $students = $this->crud_model->get_all_students();
        echo json_encode($students);
    }


    function get_all_parents() {
        $parents = $this->crud_model->get_all_parents();
        echo json_encode($students);
    }

    function parentCount() {
        $parents = $this->crud_model->get_all_parents();
        echo json_encode(count($students));
    }

    function studentCount() {
        $students = $this->crud_model->get_all_students();
        echo json_encode(count($students));
    }
    
    function getStudents($class_id){
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $students =  $this->crud_model->get_students($class_id, $running_year);
        echo json_encode($students);
        $students =  $this->crud_model->get_students($class_id,$running_year);
        echo json_encode($students);    
    }

    function getUser() {
        $teachers = $this->crud_model->get_teachers();
        $admin = $this->crud_model->get_admin();
        $users = array_merge($teachers,$admin);
        
        echo json_encode($users);
    }
    
    
    function getSubjectByClass($class_id){
        $classes = $this->crud_model->get_subjects_by_class($class_id);
        echo json_encode($classes);
    }
    

    function getTeacher(){
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

    function getTeacher_count()
    {
        $teachers = $this->crud_model->get_teachers();
        echo json_encode(count($teachers));
    }


    function getAdmin(){
        $admin = $this->crud_model->get_admin();
        echo json_encode($admin);
    }

    function getTeacherName($teacher_id){
        $teachers = $this->crud_model->get_teacher_name($teacher_id);
        echo json_encode($teachers);
    }

    function getTeachersInfos($teacher_id){
        $teachersInfos = $this->crud_model->get_teacher_info($teacher_id);
        echo json_encode($teachersInfos);
    }
    
    function teachersClassTeach($teacher_id)
    {
      $teacherClasses =  $this->crud_model->get_teacher_class($teacher_id);
       echo json_encode($teacherClasses);
    }

    function getClasses () {
        $classe = $this->crud_model->get_classes();
        echo json_encode($classe);
    }
    function getSection () {
        $section = $this->crud_model->get_section();
        echo json_encode($section);
    }

   
    function getExams ($running_year) {
        $exams = $this->crud_model->get_exams($running_year);
        echo json_encode($exams);
    }

    function getExamInfos($exam_id)
    {
        $examInfos = $this->crud_model->get_exam_info($exam_id);
        echo json_encode($examInfos);
    }

    function delete_student($student_id) {
        $this->crud_model->deleteStudent($student_id);
    }
    

    //juste  une exemple de la fonction add teacher

    function add_teacher($data) {
        $teacher_data = array($data);
    
        $this->crud_model->add_teacher($teacher_data);
        echo "Teacher added successfully";
    }

    function add_student ($data) {
        $student_data = array($data);
        $this->crud_model->add_student($student_data);
        echo "student added successfully";
    }
    
    //juste un exemple de la fonction update teacher , sachant que les donnees sont fixes
    function update_teacher($teacher_id) {
        $teacher_data = array(
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'janedoe@example.com',
            'address' => '456 Elm St',
            'phone' => '987-654-3210',
            'type' => 'teacher'
        );
    
        $this->crud_model->update_teacher($teacher_id, $teacher_data);
        echo "Teacher update succesfully";
    }
    

    



}
