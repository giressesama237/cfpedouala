<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

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
    //manage attendance

    function manage_attendance(){
        $data = $this->input->post();
        $attendance = $data[0];
        $class_id = $data[1]['class_id'];
        $section_id = $data[1]['section_id'];
        $date = $data[1]['date'];
        $students_attendance=array();
        foreach($attendance as $key=> $value){
            $item['student_id'] = $key;
            $item['class_id'] = $class_id;
            $item['section_id'] = $section_id;
            $item['status'] = $value;
            $item['year'] = '2022-2023';
            date_default_timezone_set('Africa/Ndjamena');
            $item['timestamp'] = strtotime($date);
            $students_attendance []= $item;

        }
        $this->crud_model->save_attendance($students_attendance);

        echo json_encode($students_attendance);

    }


    function get_all_students() {
        $students = $this->crud_model->get_all_students();
        echo json_encode($students);
    }
    function get_students_by_sex() {
        $students = $this->crud_model->get_all_students_bySex();
        echo json_encode(count($students));
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
    
    function getStudents($class_id, $limit = 0){
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $students =  $this->crud_model->get_students($class_id, $running_year ,$limit);
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
    
    function generateToken ()  {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $tokenLength = 35;
       $token = '';
       for ($i = 0; $i < $tokenLength; $i++) {
        $randomIndex = rand(0,strlen($characters)); 
        $token .= $characters[$randomIndex];
       }
       return $token;
     }


    function login($username,$password)
    {
        //var_dump($email,$password);
        $credential = array('username' => $username, 'password' => sha1($password));
        $table = 'admin';
        $query = $this->crud_model->login($table,$credential);
        $token = $this->generateToken();
        $data = array('authentication_key' => $token);
        
        if(count($query)){
          
            $result['admin_id'] = $query->admin_id;
            $result['name'] = $query->name;
            $result['email'] = $query->email;
            $result['username'] = $query->username;
            $result['password'] = $query->password;
            $result['phone'] = $query->phone;
            $result['address'] = $query->address;
            $result['type'] = $query->type;
            $result['login_error'] = 0;
             $this->db->where(array('admin_id'=> $query->admin_id));
                $auth = $this->db->update('admin' , $data);
                if($auth)
                {
                    $result['autentication_key'] = $token;
                }
        }else if(count($query = $this->crud_model->login('teacher',$credential))) {
            $result['teacher_id'] = $query->teacher_id;
            $result['name'] = $query->name;
            $result['email'] = $query->email;
            $result['password'] = $query->password;
            $result['username'] = $query->username;
            $result['phone'] = $query->phone;
            $result['address'] = $query->address;
            $result['surname'] = $query->surname;
            $result['speciality'] = $query->speciality;
            $result['higher_diploma'] = $query->higher_diploma;
            $result['type'] = $query->type;
            $result['login_error'] = 0;
            $this->db->where(array('teacher_id'=> $query->teacher_id));
            $auth = $this->db->update('teacher' , $data);
            if($auth)
            {
                $result['autentication_key'] = $token;
            }
        }
        else if(count($query = $this->crud_model->login('student',$credential))) {
            $result['student_id'] = $query->student_id;
            $result['name'] = $query->name;
            $result['email'] = $query->email;
            $result['password'] = $query->password;
            $result['username'] = $query->username;
            $result['phone'] = $query->phone;
            $result['address'] = $query->address;
            $result['surname'] = $query->surname;
            $result['type'] = $query->type;
            $result['login_error'] = 0;
            $this->db->where(array('student_id'=> $query->student_id));
            $auth = $this->db->update('student' , $data);
            if($auth)
            {
                $result['autentication_key'] = $token;
            }
        }
        else if(count($query = $this->crud_model->login('parent',$credential))) {
            $result['parent_id'] = $query->parent_id;
            $result['name'] = $query->name;
            $result['email'] = $query->email;
            $result['password'] = $query->password;
            $result['username'] = $query->username;
            $result['phone'] = $query->phone;
            $result['address'] = $query->address;
            $result['surname'] = $query->surname;
            $result['type'] = $query->type;
            $result['login_error'] = 0;
            $this->db->where(array('student_id'=> $query->student_id));
            $auth = $this->db->update('student' , $data);
            if($auth)
            {
                $result['autentication_key'] = $token;
            }
        }
        else{
            $result['login_error'] = 1;
            // $result['email'] = $username;
            // $result['password'] = sha1($password);
        }
        echo json_encode($result);
    }

    function getTeacher_count()
    {
        $teachers = $this->crud_model->get_teachers();
        echo json_encode(count($teachers));
    }
    function getParent_count()
    {
        $parents = $this->crud_model->get_parents();
        echo json_encode(count($parents));
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
    function getClasse ($class_id) {
        $classe = $this->crud_model->get_classe($class_id);
        echo json_encode($classe);
    }

    function getRowMessage () {
        $message = $this->crud_model->get_message();
        echo json_encode($message);
    }

    function getSection () {
        $section = $this->crud_model->get_section();
        echo json_encode($section);
    }

   
    function getExams ($running_year) {
        $exams = $this->crud_model->get_exams($running_year);
        echo json_encode($exams);
    }
    
    function get_mark ($running_year) {
        $mark = $this->crud_model->get_mark($running_year);
        echo json_encode($mark);
    }

    function getExamInfos($exam_id)
    {
        $examInfos = $this->crud_model->get_exam_info($exam_id);
        echo json_encode($examInfos);
    }

    function delete_student($student_id) {
        $this->crud_model->deleteStudent($student_id);
    }

    function delete_notification($id) {
        $this->crud_model->delete_notification($id);
    }
    function delete_teacher($teacher_id) {
        $this->crud_model->deleteTeacher($teacher_id);
    }
    

    //juste  une exemple de la fonction add teacher

    
    function get_section($class_id)
    {
        $section = $this->crud_model->get_sectionby($class_id);
        echo json_encode($section->name);
    }
    
    function get_message_thread () 
    {
        $message = $this->crud_model->get_message();
        echo json_encode($message);
    }

    function get_message () 
    {
        $message = $this->crud_model->get_message_infos();
        echo json_encode($message);
    }
    
    function add_student () {
        $data = $this->input->post();
        $student_data['name'] = $data['name'];
        $student_data['surname'] = $data['surname'];
        $student_data['birthday'] = $data['birthday'];
        $student_data['sex'] = $data['sex'];
        $student_data['at'] = $data['at'];
        $student_data['name'] = $data['name'];
        $student_data['address'] = $data['address'];
        $student_data['phone'] = $data['phone'];
        $this->crud_model->add_student($student_data);
        $student_id = $this->db->insert_id();
        if ($student_id) {
            # code...
            $data2['student_id']     = $student_id;
            $data2['enroll_code']    = substr(md5(rand(0, 1000000)), 0, 7);
            $data2['class_id']       = $data['class_id'];
            $data2['section_id'] = $data['class_id'];
            $data2['date_added'] = strtotime(date("Y-m-d H:i:s"));
            $data2['year'] = "2022-2023";
            //$data2['roll']           = html_escape($this->input->post('roll'));
            $this->db->insert('enroll', $data2);
        }
    }

    function add_teacher() {
        $data = $this->input->post();
        $data['username'] = $data['surname'].$data['name'];
        $this->crud_model->add_teacher($data);

        echo json_encode($data);
    }
    
    // juste un exemple de la fonction update teacher , sachant que les donnees sont fixes
    function update_teacher($teacher_id, $data) {
         $teacher_data = array();
        foreach ($data as $key => $value) {
            $teacher_data[$key] = $value;
        }
    
        $this->crud_model->update_teacher($teacher_id, $teacher_data);
        echo "Teacher update succesfully";
    }

    function update_admin($admin_id, $data) {
         $admin_data = array();
        foreach ($data as $key => $value) {
            $admin_data[$key] = $value;
        }
    
        $this->crud_model->update_admin($admin_id, $admin_data);
        echo "Teacher update succesfully";
    }


    function update_student($data) {
        $student_data = array($data);
        // foreach (json_decode($data) as $key => $value) {
        //     $student_data[$key] = $value + 1;
        // }

        //$this->crud_model->update_student($student_id, $student_data);
        echo json_encode($student_data);
}

public function generate_marks($class_id,$section_id,$exam_id)
{
    $response = [
        'success' => false,
        'data' => [],
        'errors' => []

    ];
    //STUDENTS
    // $class_id = $this->input->post('class_id');
    // $section_id = $this->input->post('section_id');
    // $exam_id = $this->input->post('exam_id');
    $exam_name          =   $this->db->get_where('exam', array('exam_id' => $exam_id))->row()->name;
    //$admin_id = $this->session->userdata('admin_id');
    //$running_year       =   $this->db->get_where('session', array('admin_id' => $admin_id))->row()->year;
    $running_year ="2022-2023";

    $this->db->select('s.name,s.surname,s.student_id');
    $this->db->join('enroll as e', 'e.student_id = s.student_id');
    //$this->db->join('payment as p', 'p.student_id = s.student_id');
    $this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id));
    //$this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id, 'p.year' => $running_year));
    $this->db->group_by('s.student_id');
    $this->db->order_by('s.name ASC');
    $students = $this->db->get('student as s')->result();
    //var_dump($students);die();
    $subject_test1 = FALSE;
    $subject_test2 = FALSE;

    //subjects

    $subjects = $this->db->get_where('subject', array(
        'class_id' => $class_id, 'year' => $running_year, 'section_id' => $section_id
    ))->result();

    
    //marks 

    $marks = $this->db->get_where('mark', array(
        'exam_id' => $exam_id,
        'class_id' => $class_id,
        'section_id' => $section_id,
        'year' => $running_year
    ))->result();
    //var_dump($marks);die();



    foreach ($students as $row1) {
        //MARKS MOY
        $student_moy = array();
        $total_marks = 0;
        $marks_coef = 0;
        $total_coef = 0;
        $mark_moy = $this->db->get_where(
            'mark_moy',
            array('class_id' => $class_id, 'student_id' => $row1->student_id, 'section_id' => $section_id,  'exam_id' => $exam_id, 'year' => $running_year)
        )->result();

        foreach ($subjects as  $row2) {
            foreach ($marks as $row3) {
                if (($row3->student_id == $row1->student_id) &&
                    ($row3->subject_id == $row2->subject_id)
                ) {
                    if (count($row3->mark_obtained)) {
                        $subject_test1 = TRUE;
                    }
                    if (count($row3->test2)) {
                        $subject_test2 = TRUE;
                    }
                    if (count($row3->test2) and count($row3->mark_obtained)) 
                        $total = ($row3->test2*0.7  + $row3->mark_obtained*0.3) ;
                    else 
                        $total = null;

                     
                    if (($subject_test1 == TRUE and $subject_test2 == TRUE)) {
                        $total_coef += $row2->coef;
                    }
                    $subject_test1 = FALSE;
                    $subject_test2 = FALSE;
                    $subject_exam = FALSE;
                    $marks_coef = $total * $row2->coef;
                    $total_marks += $marks_coef;
                }
            }
        }
        //var_dump($mark_moy);

        if ($total_coef != 0) {
            $moy = sprintf("%.2f", $total_marks / $total_coef);

            if (sizeof($mark_moy) == 0) {
                $moy_info = array(
                    'class_id' => $class_id, 'section_id' => $section_id,
                    'student_id' => $row1->student_id, 'exam_id' => $exam_id, 'moy' => $moy,
                    'year' => $running_year
                );
                $this->db->insert('mark_moy', $moy_info);
            } else {
                $this->db->where(array('student_id' => $row1->student_id, 'exam_id' => $exam_id, 'year' => $running_year));
                $this->db->update('mark_moy', array(
                    'class_id' => $class_id, 'section_id' => $section_id,
                    'student_id' => $row1->student_id, 'exam_id' => $exam_id, 'moy' => $moy, 'year' => $running_year
                ));
            }
        }
 
    }

}


    function getClassMarks($class_id,$section_id,$subject_id,$exam_id,$exam_type){
        $marks = $this->crud_model->getClassMarks($class_id,$section_id,
        $subject_id,$exam_id,$exam_type);
        echo json_encode( $marks);
    }
     function insert_mark() {
        $data = $this->input->post();
        //echo json_encode($data);
        $mark = array();
                foreach ($data[1] as $key => $value) {
                    # code...
                    if($data[0]['exam_selected'] == "CC")
                        $mark_data['mark_obtained']=$value;
                    else 
                        $mark_data['test2']=$value;
                    $mark_data['student_id']=$key;
                    $mark_data["class_id"] = $data[0]['class_id'];
                    $mark_data["subject_id"] = $data[0]['subject_id'];
                    $mark_data["section_id"] = $data[0]['section_id'];
                    $mark_data["exam_id"] = $data[0]['exam_id'];
                    $mark[]= $mark_data;
                    $mark_data = array();
                }
                //$mark_data['mark_obtained'] = 
           //echo json_encode($mark);
           $this->crud_model->insertMark($mark);

    }
    function getMarks($class_id,$section_id, $exam_id){
        $this->generate_marks($class_id,$section_id,$exam_id);
        $data['marks'] = $this->crud_model->getMarks($class_id,$section_id,$exam_id);
        $data['student_info'] = $this->crud_model->getStudentsMarks($class_id,$section_id,$exam_id);
        $data['head'] = $this->crud_model->getHeadTeacher($class_id);

        echo json_encode($data);
    }
    
    function getHeadTeacher($class_id)
    {
        $head = $this->crud_model->getHeadTeacher($class_id);
        echo json_encode($head);
    }

 
    function getStudentInfosbYId ($student_id)
    {
        $info = $this->crud_model->getStudentInfosbYId($student_id);
        echo json_encode($info);
    }

    function getTeacherSubject ($teacher_id,$class_id)
    {
        $info = $this->crud_model->get_teacher_subject($teacher_id,$class_id);
        echo json_encode($info);
    }
    function getTopMoyPerClass ($class_id,$section_id,$exam_id)
    {
        $info = $this->crud_model->getTopMoyPerClass($class_id,$section_id,$exam_id);
        echo json_encode($info);
    }

    function get_cycle(){
        $cylce = $this->crud_model->get_cycle()->result();
        echo json_encode($cylce);
    }

    

    function addClasse() {
            $data = $this->input->post();
            $this->crud_model->addClasses($data);
        }
        
        
        function get_notification() {
            $notification = $this->crud_model->get_notification()->result();
            echo json_encode($notification);
        }


        function get_chat() {
            $chat = $this->crud_model->get_chat()->result();
            echo json_encode($chat);
        }
        function get_teachername($id) {
            $chat = $this->crud_model->get_teachername($id);
            echo json_encode($chat);
        }
        
    function addNotification() {
            $data = $this->input->post();
            $this->crud_model->addNotification($data);
    }

    function add_chat() {
            $data = $this->input->post();
            $this->crud_model->add_chat($data);
    }

    function tabulation_sheet_print_view($class_id, $exam_id, $section_id,$admin_id)
    {
       
        $running_year       =   $this->db->get_where('session', array('admin_id' => $admin_id))->row()->year;

        //STUDENTS
        $this->db->select('s.name,s.surname,s.student_id,mm.moy, s.sex');
        $this->db->join('enroll as e', 'e.student_id = s.student_id');
        $this->db->join('payment as p', 'p.student_id = s.student_id');
        $this->db->join('mark_moy as mm', 'mm.student_id = s.student_id');
        //$this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id, 'mm.exam_id' => $exam_id, 'mm.year' => $running_year));
        $this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id, 'p.year' => $running_year, 'mm.exam_id' => $exam_id, 'mm.year' => $running_year));
        $this->db->group_by('s.name, s.surname');
        $this->db->order_by('mm.moy DESC');
        $students = $this->db->get('student as s')->result_array();
        
        //GARCONS
        /*$this->db->select('s.name,s.surname,s.student_id,s.sex, mm.moy');
        $this->db->join('enroll as e', 'e.student_id = s.student_id');
        //$this->db->join('payment as p', 'p.student_id = s.student_id');
        $this->db->join('mark_moy as mm', 'mm.student_id = s.student_id');
        $this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id, 'mm.exam_id' => $exam_id, 'mm.year' => $running_year, 's.sex' => 'male'));
        //$this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id, 'p.year' => $running_year, 'mm.exam_id' => $exam_id, 'mm.year' => $running_year, 's.sex' => 'male'));
        $this->db->group_by('s.name, s.surname');
        $this->db->order_by('mm.moy DESC');
        $garcons = $this->db->get('student as s')->result();*/


        //FILLES
        /*$this->db->select('s.name,s.surname,s.student_id,s.sex, mm.moy');
        $this->db->join('enroll as e', 'e.student_id = s.student_id');
        //$this->db->join('payment as p', 'p.student_id = s.student_id');
        $this->db->join('mark_moy as mm', 'mm.student_id = s.student_id');
        $this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id,'mm.exam_id' => $exam_id, 'mm.year' => $running_year, 's.sex' => 'female'));
        //$this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id, 'p.year' => $running_year, 'mm.exam_id' => $exam_id, 'mm.year' => $running_year, 's.sex' => 'female'));
        $this->db->group_by('s.name, s.surname');
        $this->db->order_by('mm.moy DESC');
        $filles = $this->db->get('student as s')->result();*/
        
        //effectif total
        $this->db->select('s.student_id');
        $this->db->join('enroll as e', 'e.student_id = s.student_id');
        //$this->db->join('payment as p', 'p.student_id = s.student_id');
        $this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id));
        //$this->db->where(array('e.class_id' => $class_id, 'e.year' => $running_year, 'e.section_id' => $section_id, 'p.year' => $running_year, 'mm.exam_id' => $exam_id, 'mm.year' => $running_year, 's.sex' => 'female'));
        $this->db->group_by('s.student_id');
        $effectif_total = count( $this->db->get('student as s')->result());
       // var_dump($effectif_total);die();

        //STUDENTS MARKS
        $this->db->select('m.mark_obtained as mark1 , m.test2 as mark2, m.subject_id, m.student_id');
        $this->db->where(array('m.class_id' => $class_id, 'm.year' => $running_year, 'm.section_id' => $section_id, 'm.exam_id' => $exam_id));
        $obtained_mark_query = $this->db->get('mark as m')->result_array();

        //MARKS MOY
        $this->db->select('*');
        $this->db->where(array('class_id' => $class_id, 'section_id' => $section_id, 'exam_id' => $exam_id, 'year' => $running_year));
        $this->db->order_by('moy DESC');
        $marks = $this->db->get('mark_moy')->result_array();

        //subjects
        $subjects = $this->db->get_where('subject', array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year))->result_array();

        //$page_data['garcons'] = $garcons;
        //$page_data['filles'] = $filles;
        $page_data['lang'] = "en";        
        $page_data['effectif_total'] = $effectif_total ;

        $page_data['subjects'] = $subjects;
        $page_data['obtained_mark_query'] = $obtained_mark_query;
        $page_data['students'] = $students;
        $page_data['marks_moy'] = $marks;
        $page_data['class_id'] = $class_id;
        $page_data['exam_id']  = $exam_id;
        $page_data['section_id'] = $section_id;
        $page_data['admin_id'] = $admin_id;
        $page_data['running_year'] = $running_year;
        $this->load->view('backend/admin/tabulation_sheet_print_view', $page_data);
    }



    



}
