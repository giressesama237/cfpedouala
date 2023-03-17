<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajaxdataload_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*----------------------------- BOOKS -------------------------------*/

    function all_books_count()
    {
        $query = $this->db->get('book');
        return $query->num_rows();
    }

    function all_books($limit, $start, $col, $dir)
    {
        $query = $this
            ->db
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('book');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function book_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
            ->db
            ->like('name', $search)
            ->or_like('author', $search)
            ->or_like('book_id', $search)
            ->or_like('price', $search)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('book');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function book_search_count($search)
    {
        $query = $this
            ->db
            ->like('name', $search)
            ->or_like('book_id', $search)
            ->or_like('author', $search)
            ->or_like('price', $search)
            ->get('book');

        return $query->num_rows();
    }

    /*----------------------------- BOOKS -------------------------------*/


    /*----------------------------- TEACHERS -------------------------------*/

    function all_teachers_count()
    {
        $query = $this->db->get('teacher');
        return $query->num_rows();
    }

    function all_teachers($limit, $start, $col, $dir)
    {
        $query = $this
            ->db
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('teacher');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function teacher_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
            ->db
            ->like('teacher_id', $search)
            ->or_like('name', $search)
            ->or_like('surname', $search)
            ->or_like('email', $search)
            ->or_like('phone', $search)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('teacher');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function teacher_search_count($search)
    {
        $query = $this
            ->db
            ->like('teacher_id', $search)
            ->or_like('name', $search)
            ->or_like('surname', $search)
            ->or_like('email', $search)
            ->or_like('phone', $search)
            ->get('teacher');

        return $query->num_rows();
    }

    /*----------------------------- TEACHERS -------------------------------*/


    /*----------------------------- PARENTS -------------------------------*/

    function all_parents_count()
    {
        $query = $this->db->get('parent');
        return $query->num_rows();
    }

    function all_parents($limit, $start, $col, $dir)
    {
        $query = $this
            ->db
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('parent');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function parent_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
            ->db
            ->like('parent_id', $search)
            ->or_like('name', $search)
            ->or_like('email', $search)
            ->or_like('phone', $search)
            ->or_like('profession', $search)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('parent');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function parent_search_count($search)
    {
        $query = $this
            ->db
            ->like('parent_id', $search)
            ->or_like('name', $search)
            ->or_like('email', $search)
            ->or_like('phone', $search)
            ->or_like('profession', $search)
            ->get('parent');

        return $query->num_rows();
    }

    /*----------------------------- PARENTS -------------------------------*/

    /*----------------------------- EXPENSES -------------------------------*/

    function all_expenses_count($year)
    {
        $array = array('payment_type' => 'expense', 'year' => $year);
        $query = $this
            ->db
            ->where($array)
            ->get('payment');
        return $query->num_rows();
    }

    function all_expenses($limit, $start, $col, $dir, $year)
    {
        $array = array('payment_type' => 'expense', 'year' => $year);
        $query = $this
            ->db
            ->where($array)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('payment');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function expense_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
            ->db
            ->like('payment_id', $search)
            ->or_like('title', $search)
            ->or_like('amount', $search)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('payment');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function expense_search_count($search)
    {
        $query = $this
            ->db
            ->like('payment_id', $search)
            ->or_like('title', $search)
            ->or_like('amount', $search)
            ->get('payment');

        return $query->num_rows();
    }

    /*----------------------------- EXPENSES -------------------------------*/


    /*----------------------------- INVOICES -------------------------------*/

    function all_invoices_count($year)
    {
        $array = array('year' => $year);
        $query = $this
            ->db
            ->where($array)
            ->get('invoice');
        return $query->num_rows();
    }

    function all_invoices($limit, $start, $col, $dir, $year)
    {
        $array = array('i.year' => $year, 'e.year' => $year);
        $query = $this
            ->db
            ->select('e.class_id,e.section_id,i.*')
            ->join('enroll as e', 'e.student_id = i.student_id')
            ->where($array)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('invoice as i');
        //var_dump($query->result());die();

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function invoice_search($limit, $start, $search, $col, $dir, $year)
    {
        /*$query = $this
                ->db
                ->like('invoice_id', $search)
                ->or_like('title', $search)
                ->or_like('amount', $search)
                ->or_like('status', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get('invoice');*/
        $query = $this
            ->db
            ->select('e.class_id,e.section_id,i.*')
            ->group_start()
            ->like('i.invoice_id', $search)
            ->or_like(array(
                'i.title' => $search, 'i.bank_receipt' => $search, 'i.amount' => $search, 'i.status' => $search,
                's.name' => $search, 's.surname' => $search, 's.student_code' => $search
            ))
            ->group_end()
            ->join('student as s', 's.student_id = i.student_id')
            ->join('enroll as e', 'e.student_id = i.student_id')
            ->where(array('i.year' => $year, 'e.year' => $year))
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('invoice as i');

        //var_dump($query->result());die();
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function invoice_search_count($search, $year)
    {
        $query = $this
            ->db
            ->group_start()
            ->like('i.invoice_id', $search)
            ->or_like(array(
                'i.title' => $search, 'i.amount' => $search, 'i.status' => $search,
                's.name' => $search, 's.surname' => $search, 's.student_code' => $search
            ))
            ->group_end()
            ->join('student as s', 's.student_id = i.student_id')
            ->where(array('i.year' => $year))
            ->get('invoice as i');

        return $query->num_rows();
    }

    /*----------------------------- INVOICES -------------------------------*/


    /*----------------------------- PAYMENTS -------------------------------*/

    function all_payments_count($year)
    {
        $array = array('payment_type' => 'income', 'year' => $year);
        $query = $this
            ->db
            ->where($array)
            ->get('payment');
        return $query->num_rows();
    }

    function all_payments($limit, $start, $col, $dir, $year)
    {
        $array = array('payment_type' => 'income', 'year' => $year);
        $query = $this
            ->db
            ->where($array)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('payment');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function payment_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
            ->db
            ->like('payment_id', $search)
            ->or_like('title', $search)
            ->or_like('amount', $search)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('payment');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function payment_search_count($search)
    {
        $query = $this
            ->db
            ->like('payment_id', $search)
            ->or_like('title', $search)
            ->or_like('amount', $search)
            ->get('payment');

        return $query->num_rows();
    }

    /*----------------------------- PAYMENTS -------------------------------*/



    /*----------------------------- STUDENTS -------------------------------*/

    function all_student_count($year, $class_id, $section_id = null)
    {
        if (!is_null($section_id))
            $array = array(
                'i.year' => $year, 'e.year' => $year, "e.class_id" => $class_id,
                'e.section_id' => $section_id
            );
        else
            $array = array('i.year' => $year, 'e.year' => $year, "e.class_id" => $class_id);
        $query = $this
            ->db
            ->join('invoice as i', 'i.student_id = e.student_id')
            ->where($array)
            ->group_by('e.student_id')
            ->get('enroll as e');

        return $query->num_rows();
    }

    function all_student($limit, $start, $col, $dir, $year, $class_id, $section_id = null)
    {
        if (!is_null($section_id))
            $array = array(
                'i.year' => $year, 'e.year' => $year, "e.class_id" => $class_id,
                'e.section_id' => $section_id
            );
        else
            $array = array('i.year' => $year, 'e.year' => $year, "e.class_id" => $class_id);
        $query = $this
            ->db
            ->select('e.class_id,e.section_id,s.*')
            ->join('enroll as e', 'e.student_id = s.student_id')
            ->join('invoice as i', 'i.student_id = s.student_id')
            ->where($array)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->group_by('s.student_id')
            ->get('student as s');
        //var_dump($query->result());die();

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function student_search($limit, $start, $search, $col, $dir, $year, $class_id, $section_id = null)
    {
        /*$query = $this
                ->db
                ->like('invoice_id', $search)
                ->or_like('title', $search)
                ->or_like('amount', $search)
                ->or_like('status', $search)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get('invoice');*/
        if (!is_null($section_id))
            $array = array(
                'i.year' => $year, 'e.year' => $year, "e.class_id" => $class_id,
                'e.section_id' => $section_id
            );
        else
            $array = array('i.year' => $year, 'e.year' => $year, "e.class_id" => $class_id);
        $query = $this
            ->db
            ->select('e.class_id,e.section_id,s.*')
            ->group_start()
            ->like('s.student_id', $search)
            ->or_like(array(
                's.name' => $search, 's.surname' => $search, 's.student_code' => $search, 's.num_dossier' => $search
            ))
            ->group_end()
            ->join('invoice as i', 's.student_id = i.student_id')
            ->join('enroll as e', 'e.student_id = i.student_id')
            ->where($array)
            ->limit($limit, $start)
            ->group_by('s.student_id')
            ->order_by($col, $dir)
            ->get('student as s');

        //var_dump($query->result());die();
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return null;
    }

    function student_search_count($search, $year, $class_id, $section_id = null)
    {
        if (!is_null($section_id))
            $array = array('i.year' => $year,'e.year'=>$year, "e.class_id"=>$class_id,
         'e.section_id'=>$section_id);
         else 
            $array = array('i.year' => $year,'e.year'=>$year, "e.class_id"=>$class_id);
        $query = $this
            ->db
            ->group_start()
            ->like('s.student_id', $search)
            ->or_like(array(
                's.name' => $search, 's.surname' => $search, 's.student_code' => $search, 's.num_dossier' => $search
            ))
            ->group_end()
            ->join('invoice as i', 's.student_id = i.student_id')
            ->join('enroll as e', 'e.student_id = i.student_id')
            ->where($array)
            ->where(array('i.year' => $year))
            ->group_by('s.student_id')
            ->get('student as s');

        return $query->num_rows();
    }

    /*----------------------------- STUDENTS -------------------------------*/
}
