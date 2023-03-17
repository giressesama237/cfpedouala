<?php  //var_dump($lang);die();
function build_sorter($key)
{
    return function ($a, $b) use ($key) {
        return strnatcmp($b[$key], $a[$key]);
    };
}
//$section = $this->db->get_where('section' , array('class_id' => $class_id,'section_id'=>$section_id))->row()->name;
//var_dump($query_annuelle);die(); 
$class_name         =   $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
$section_name       =   $this->db->get_where('section', array('section_id' => $section_id))->row()->name;
//var_dump($section_name );die()  ;
$exam_name          =   $this->db->get_where('exam', array('exam_id' => $exam_id))->row()->name;
$system_name        =   $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$admin_id = $this->session->userdata('admin_id');
$running_year       =   $this->db->get_where('session', array('admin_id' => $admin_id))->row()->year;
$master_id          =   $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id;
$master_name        =   $this->db->get_where('teacher', array('teacher_id' => $master_id))->row()->name;
$master_surname     =   $this->db->get_where('teacher', array('teacher_id' => $master_id))->row()->surname;

//jours d'absence
$ja =  $this->db->get_where('attendance', array('student_id' => $student_id, 'status' => 2))->num_rows();

$somme_annuelle = 0;
$note_annuelle = 0;
//$effectif = $this->db->get('attendance')->num_rows();
/*$this->db->select('s.*');
$this->db->join('enroll as e','e.student_id = s.student_id');
$this->db->join('payment as p','p.student_id = s.student_id');
$this->db->where(array('e.class_id' => $class_id , 'e.year' => $running_year, 'e.section_id'=>$section_id));
$this->db->group_by('s.name, s.surname');  
$effectif = $this->db->get('student as s')->num_rows();*/
/*$effectif   =   $this->db->get_where('enroll' , array(
    'class_id' => $class_id , 'section_id'=>$section_id, 'year' => $running_year
))->num_rows();*/
$effectif = $this->db->get_where('mark_moy', array('class_id' => $class_id, 'section_id' => $section_id, 'exam_id' => $exam_id, 'year' => $running_year))->num_rows();
//var_dump($effectif);die();
$nbre_moy = 0;

//var_dump($effectif);die();
$subject_test1 = FALSE;
$subject_test2 = FALSE;
$subject_exam = FALSE;
//var_dump($master_name);die();
?>
<script src="assets/js/jquery-1.11.0.min.js"></script>
<style type="text/css">
    td {
        padding: 2px;
        font-size: 8px;
    }

    #print {
        padding: 4px;
    }

    p {
        font-size: 9px;
    }
</style>

<div id="print">


    <table style="width:100%;">
        <thead></thead>
        <tbody>
            <tr>
                <td width="35%">
                    <p style="margin: 0;">Ministère des Enseignements Secondaires</p>
                    <p style="margin: 0;">Délégation régionale du Littoral</p>
                    <p style="margin: 0;">Délégation Départementale du Wouri</p>
                    <p style="margin: 0;">STEVIN BILINGUAL COLLEGE</p>
                    <p style="margin: 0;">BP : 11496 Douala Tel : 674435316 / 693152933</p>
                </td>
                <td>
                    <center>
                        <img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height : 90px;">
                    </center>

                </td>
                <td width="40%" style="padding-left:50px;">
                    <p style="margin: 0;">Ministry of Secondary Education</p>
                    <p style="margin: 0;">Littoral Regional Delegation</p>
                    <p style="margin: 0;">Divisional Delegation of Wouri</p>
                    <p style="margin: 0;">STEVIN BILINGUAL COLLEGE</p>
                    <p style="margin: 0;">PO BOX : 11496 Douala Tel : 674435316 / 693152933</p>
                </td>
            </tr>
        </tbody>
    </table>

    <center>
        <?php if ($lang == 'en') { ?>

            <h3 style="font-weight: 100; background-color: gray"><?php echo 'Report Card'; ?></h3>
        <?php
        } ?>
        <?php if ($lang == 'fr') { ?>

            <h3 style="font-weight: 100; background-color: gray"><?php echo 'Bulletin de Notes'; ?></h3>
        <?php
        } ?>

        <?php $student = $this->db->get_where('student', array('student_id' => $student_id), 1)->row(); //var_dump($student);die(); 
        ?>
    </center>
    <table style="width:100%;">
        <thead></thead>
        <tbody>
            <tr>
                <?php if ($lang == 'en') { ?>

                    <td>
                        <p style="margin: 0;"><?php echo get_phrase('class') . ' ' . $class_name . ' ' . $section_name; ?></p>
                        <p style="margin: 0;">Matricule : <?= $student->student_code ?></p>
                        <p style="margin: 0;">Name and surname : <?php echo $student->name . ' ' . $student->surname ?></p>
                        <p style="margin: 0;">Date and place of birth : <?php echo $student->birthday . ' at ' . $student->at ?></p>
                        <p style="margin: 0;">Sex : <?php echo $student->sex ?></p>
                    </td>
                    <td>
                        <p style="margin: 0;"><?php echo $exam_name; ?></p>
                        <p style="margin: 0;">Academic year : <?= $running_year ?></p>
                        <p style="margin: 0;">Class master : <?= $master_surname . ' ' . $master_name; ?> </p>
                    </td>
                    <td><img src="<?php echo $this->crud_model->get_image_url('student', $student_id); ?>" class="img-circle" width="70" height="50" /></td>
                <?php

                }
                ?>
                <?php if ($lang == 'fr') { ?>

                    <td>
                        <p style="margin: 0;"><?php echo get_phrase('classe') . ' ' . $class_name . ' ' . $section_name; ?></p>
                        <p style="margin: 0;">Matricule : <?= $student->student_code ?></p>
                        <p style="margin: 0;">Noms et Prénoms : <?php echo $student->name . ' ' . $student->surname ?></p>
                        <p style="margin: 0;">Date et Lieu de Naissance : <?php echo $student->birthday . ' à ' . $student->at ?></p>
                        <p style="margin: 0;">Sexe : <?php echo $student->sex ?></p>
                    </td>
                    <td>
                        <?php if ($exam_name == 'FIRST TERM') { ?>
                            <p style="margin: 0;">PREMIER TRIMESTRE</p>
                        <?php
                        } ?>
                        <?php if ($exam_name == 'SECOND TERM') { ?>
                            <p style="margin: 0;">DEUXIEME TRIMESTRE</p>
                        <?php
                        } ?>
                        <?php if ($exam_name == 'THIRD TERM') { ?>
                            <p style="margin: 0;">TROISIEME TRIMESTRE</p>
                        <?php
                        } ?>

                        <p style="margin: 0;">Année Académique : <?= $running_year ?></p>
                        <p style="margin: 0;">Professeur Titulaire : <?= $master_surname . ' ' . $master_name; ?> </p>
                    </td>
                    <td><img src="<?php echo $this->crud_model->get_image_url('student', $student_id); ?>" class="img-circle" width="70" /></td>
                <?php

                }
                ?>

            </tr>
        </tbody>
    </table>

    <table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
        <thead>
            <tr>
                <td style="text-align: center;" rowspan="2">Disciplines</td>
                <?php if ($exam_name == 'FIRST TERM') { ?>
                    <td style="text-align: center;">Seq 1</td>
                    <td style="text-align: center;">Seq 2</td>
                <?php
                } ?>
                <?php if ($exam_name == 'SECOND TERM') { ?>
                    <td style="text-align: center;">Seq 3</td>
                    <td style="text-align: center;">Seq 4</td>
                <?php
                } ?>
                <?php if ($exam_name == 'THIRD TERM') { ?>
                    <?php if ($lang == 'fr') { ?>
                        <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'colspan="1" rowspan="2"' ?>>Trimestre 1</td>
                        <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'colspan="1" rowspan="2"' ?>>Trimestre 2</td>
                        <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'colspan="4"' ?>>Trimestre 3</td>

                    <?php }
                    if ($lang == 'en') { ?>
                        <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'colspan="1" rowspan="2"' ?>>First Term</td>
                        <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'colspan="1" rowspan="2"' ?>>Second Term</td>
                        <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'colspan="4"' ?>>Third Term</td>

                <?php }
                } ?>
                <!--<td style="text-align: center;">Exam /40</td>-->
                <?php if ($exam_name != 'THIRD TERM') { ?>
                    <td style="text-align: center;">Total</td>
                    <td style="text-align: center;">Moy /20</td>
                <?php } ?>



                <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'rowspan="2"' ?>>Coef</td>
                <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'colspan="3"' ?>>Total</td>
                <!--<td style="text-align: center;">Min</td>-->
                <!-- <td style="text-align: center;">Grade</td>-->
                <td style="text-align: left;" rowspan="2"><?php if ($lang == 'en') {
                                                                echo "Remarks & Signature";
                                                            } else {
                                                                echo "Appréciations & Signature";
                                                            } ?></td>
                <!--<td style="text-align: center;">Subject</td>
            <td style="text-align: center;">Test 1</td>
            <td style="text-align: center;">Coef</td>
            <td style="text-align: center;">Totaux</td>
            <td style="text-align: center;">Max</td>
            <td style="text-align: center;">Min</td>
           
            <td style="text-align: center;">Comment</td>
            <td style="text-align: center;">Appreciations</td>-->
            </tr>
            <?php if ($exam_name == 'THIRD TERM') { ?>
                <tr>

                    <td style="text-align: center;">Seq 5</td>
                    <td style="text-align: center;">Seq 6</td>
                    <td style="text-align: center;">Total</td>
                    <td style="text-align: center;">Moy /20</td>

                    <td style="text-align: center;">1st</td>
                    <td style="text-align: center;">2nd</td>
                    <td style="text-align: center;">3rd</td>
                </tr>
            <?php
            } ?>
        </thead>
        <tbody>
            <tr>
                <!--<td colspan="9" style="background-color: gray;"><b><p>ARTS SUBJECTS</p></td></b>-->
            </tr>
            <?php
            $total_marks = 0;
            $marks_coef = 0;
            $total_coef = 0;
            $total_grade_point = 0;
            $subject_type = $this->db->get('subject_type')->result_array();
            //var_dump($subject_type);die();
            foreach ($subject_type as $key) {
                $sum_test1 = 0;
                $sum_test2 = 0;
                $sum_coef = 0;
                $sum_total = 0;
                $sum_marks = 0;

            ?>

                <tr style="text-align: left; background-color: gray;">
                    <td colspan="15">
                        <?php if ($lang == 'en') { ?>
                            <b><?= $key['libelle'] ?></b>
                        <?php } else {
                            if ($key['libelle'] == 'Arts Subjects')
                                echo "Matières Littéraires";
                            else if ($key['libelle'] == 'Science Subjects')
                                echo "Matières Scientifiques";
                            else echo "Autres";
                        } ?>

                    </td>

                </tr>
                <?php
                $this->db->select('s.*, t.name as teacher_name , t.surname as teacher_surname');
                $this->db->join('teacher as t', 't.teacher_id = s.teacher_id');
                $this->db->where(array('s.class_id' => $class_id, 's.section_id' => $section_id, 's.year' => $running_year, 's.type_id' => $key['type_id']));
                //$this->db->group_by('s.type_id');
                $subjects = $this->db->get('subject as s')->result_array();
                //var_dump($subjects);die();

                foreach ($subjects as $row3) :
                ?>
                    <tr>
                        <td style="text-align: left;"><?php echo $row3['name']; ?><br>
                            <b><?php echo $row3['teacher_name'] . ' ' . $row3['teacher_surname']; ?></b>
                        </td>
                        <?php
                        if ($exam_name == 'THIRD TERM') {
                            $mark_term = $this->db->get_where('mark', array(
                                'subject_id' => $row3['subject_id'],
                                'exam_id' => $exam_id - 2,
                                'class_id' => $class_id,
                                'section_id' => $section_id,
                                'student_id' => $student_id,
                                'year' => $running_year
                            )) ?>
                            <td style="text-align:center">
                                <?php
                                if ($mark_term->num_rows() > 0) {
                                    $marks = $mark_term->result_array();
                                    foreach ($marks as $row4) {
                                        if (!empty($row4['test2']) and !empty($row4['mark_obtained'])) {
                                            echo  $total_term1 = sprintf("%.2f", ($row4['test2']  + $row4['mark_obtained']) / 2);
                                            //var_dump($total);
                                        } elseif (empty($row4['mark_obtained']) and !empty($row4['test2'])) {
                                            echo $total_term1 = sprintf("%.2f", ($row4['test2']));
                                        } elseif (empty($row4['test2']) and !empty($row4['mark_obtained'])) {
                                            echo $total_term1 = sprintf("%.2f", ($row4['mark_obtained']));
                                        } elseif (empty($row4['test2']) and empty($row4['mark_obtained'])) {
                                            $total_term1 = null;
                                        }
                                        /*if(!empty($row4['mark_obtained'])){
                            echo $row4['mark_obtained'];
                        }*/
                                        // $total_marks += $row4['test2'];
                                    }
                                }
                                ?>
                            </td>
                            <!--<td>
                    <?php
                            if ($mark_term->num_rows() > 0) {
                                $marks = $mark_term->result_array();
                                foreach ($marks as $row4) {
                                    if (!empty($row4['test2'])) {
                                        echo $row4['test2'];
                                    }
                                    // $total_marks += $row4['test2'];
                                }
                            }
                    ?>
                    </td>-->
                            <?php
                            $mark_term = $this->db->get_where('mark', array(
                                'subject_id' => $row3['subject_id'],
                                'exam_id' => $exam_id - 1,
                                'class_id' => $class_id,
                                'section_id' => $section_id,
                                'student_id' => $student_id,
                                'year' => $running_year
                            )) ?>
                            <td style="text-align:center">
                                <?php
                                if ($mark_term->num_rows() > 0) {
                                    $marks = $mark_term->result_array();
                                    foreach ($marks as $row4) {
                                        if (!empty($row4['test2']) and !empty($row4['mark_obtained'])) {
                                            echo  $total_term2 = sprintf("%.2f", ($row4['test2']  + $row4['mark_obtained']) / 2);
                                            //var_dump($total);
                                        } elseif (empty($row4['mark_obtained']) and !empty($row4['test2'])) {
                                            echo $total_term2 = sprintf("%.2f", ($row4['test2']));
                                        } elseif (empty($row4['test2']) and !empty($row4['mark_obtained'])) {
                                            echo $total_term2 = sprintf("%.2f", ($row4['mark_obtained']));
                                        } elseif (empty($row4['test2']) and empty($row4['mark_obtained'])) {
                                            $total_term2 = null;
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <!--<td>
                    <?php
                            if ($mark_term->num_rows() > 0) {
                                $marks = $mark_term->result_array();
                                foreach ($marks as $row4) {
                                    if (!empty($row4['test2'])) {
                                        echo $row4['test2'];
                                    }
                                    // $total_marks += $row4['test2'];
                                }
                            }
                    ?>
                    </td>-->
                        <?php } ?>
                        <td style="text-align: center;">
                            <?php
                            $obtained_mark_query = $this->db->get_where('mark', array(
                                'subject_id' => $row3['subject_id'],
                                'exam_id' => $exam_id,
                                'section_id' => $section_id,
                                'class_id' => $class_id,
                                'student_id' => $student_id,
                                'year' => $running_year
                            ));
                            $query = $this->db->get_where('mark_moy', array('class_id' => $class_id, 'section_id' => $section_id, 'exam_id' => $exam_id, 'year' => $running_year))->result_array();

                            // var_dump($query);die();
                            if ($obtained_mark_query->num_rows() > 0) {
                                $marks = $obtained_mark_query->result_array();
                                foreach ($marks as $row4) {
                                    if (!empty($row4['mark_obtained'])) {
                                        echo $row4['mark_obtained'];
                                        $sum_test1 += $row4['mark_obtained'];
                                        $subject_test1 = TRUE;
                                    }
                                    //$marks_coef= $row4['mark_obtained'] * $row3['coef'];
                                    // $total_marks += $marks_coef;
                                    //$total_marks += $row4['mark_obtained'];
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <?php

                            if ($obtained_mark_query->num_rows() > 0) {
                                $marks = $obtained_mark_query->result_array();
                                foreach ($marks as $row4) {
                                    if (!empty($row4['test2'])) {
                                        echo $row4['test2'];
                                        $sum_test2 += $row4['test2'];
                                        $subject_test2 = TRUE;
                                    }
                                    // $total_marks += $row4['test2'];
                                }
                            }
                            ?>
                        </td>
                        <!-- <td style="text-align: center;">
                <?php

                    if ($obtained_mark_query->num_rows() > 0) {
                        $marks = $obtained_mark_query->result_array();
                        foreach ($marks as $row4) {
                            if (!empty($row4['exam'])) {
                                echo $row4['exam'];
                                $subject_exam = TRUE;
                            }
                            // $total_marks += $row4['exam'];
                        }
                    }
                ?>
            </td>-->

                        <td style="text-align: center;">
                            <?php
                            if ($obtained_mark_query->num_rows() > 0) {
                                $marks = $obtained_mark_query->result_array();
                                foreach ($marks as $row4) {
                                    //if(!empty($row4['exam'])){
                                    if (!empty($row4['mark_obtained']) and !empty($row4['test2'])) {
                                        echo $c =  $row4['test2']  + $row4['mark_obtained'];
                                        $sum_c += $c;
                                    }
                                    // $total_marks += $c;
                                }
                            }
                            ?>
                        </td>

                        <td style="text-align: center;">
                            <?php
                            if ($obtained_mark_query->num_rows() > 0) {
                                $marks = $obtained_mark_query->result_array();
                                foreach ($marks as $row4) {
                                    if (!empty($row4['test2']) and !empty($row4['mark_obtained'])) {
                                        echo  $total = sprintf("%.2f", ($row4['test2']  + $row4['mark_obtained']) / 2);
                                        //var_dump($total);
                                    } elseif (empty($row4['mark_obtained']) and !empty($row4['test2'])) {
                                        echo $total = sprintf("%.2f", ($row4['test2']));
                                    } elseif (empty($row4['test2']) and !empty($row4['mark_obtained'])) {
                                        echo $total = sprintf("%.2f", ($row4['mark_obtained']));
                                    } elseif (empty($row4['test2']) and empty($row4['mark_obtained'])) {
                                        $total = null;
                                    }
                                    $sum_total += $total;
                                }
                            }
                            ?>
                        </td>


                        <td style="text-align: center;">
                            <?php
                            if (($subject_test1 == TRUE || $subject_test2 == TRUE)) {
                                echo $row3['coef'];
                                $total_coef += $row3['coef'];
                                $sum_coef += $row3['coef'];
                            }
                            $subject_test1 = FALSE;
                            $subject_test2 = FALSE;
                            $subject_exam = FALSE;

                            ?>
                        </td>
                        <?php
                        if ($exam_name == 'THIRD TERM') { ?>
                            <td style="text-align: center;">
                                <?php
                                if ($total_term1 != null) {
                                    $marks_coef = $total_term1 * $row3['coef'];
                                    echo  $marks_coef;
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if ($total_term2 != null) {
                                    $marks_coef = $total_term2 * $row3['coef'];
                                    echo  $marks_coef;
                                }
                                ?>
                            </td>


                        <?php } ?>
                        <td style="text-align: center;">
                            <?php
                            if ($obtained_mark_query->num_rows() > 0) {
                                $marks = $obtained_mark_query->result_array();
                                foreach ($marks as $row4) {
                                    // if (!empty($row4['exam'])) {

                                    $marks_coef = $total * $row3['coef'];
                                    if (!empty($row4['mark_obtained']) or !empty($row4['test2'])) {
                                        echo  $marks_coef;
                                    }

                                    if (!empty($row4['mark_obtained']) and !empty($row4['test2'])) {
                                        // var_dump($total);

                                        $tot_cof = 20 * $row3['coef'];
                                        $tot += $tot_cof;
                                    }



                                    $total_marks += $marks_coef;
                                    $sum_marks += $marks_coef;
                                    // }

                                }
                            }
                            ?>
                        </td>


                        <td style="text-align: left;">

                            <?php if ($obtained_mark_query->num_rows() > 0)
                                if ($total != null) {
                                    echo $grade = $this->db->get_where('grade', array('mark_from <=' => $total, 'mark_upto >=' => $total, 'lang' => $lang))->row()->grade_point;
                                }

                            ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td style="text-align: left;">
                        <b>Total <?= $key['type_id'] ?></b>
                    </td>
                    <?php
                    if ($exam_name == 'THIRD TERM') { ?>

                        <td></td>
                        <td></td>
                    <?php } ?>
                    <td style="text-align: center;">
                        <?php if ($sum_test1 != 0) { ?>
                            <b><?= $sum_test1 ?></b>
                        <?php } ?>
                    </td>

                    <td style="text-align: center;">
                        <?php if ($sum_test2 != 0) { ?>
                            <b><?= $sum_test2 ?></b>
                        <?php } ?>
                    </td><?php
                            if ($exam_name == 'THIRD TERM') { ?>


                    <?php } ?>
                    <td style="text-align: center;">
                        <?php if ($sum_c != 0) { ?>
                            <b><?= $sum_c ?></b>
                        <?php } ?>
                    </td><?php
                            if ($exam_name == 'THIRD TERM') { ?>


                    <?php } ?>
                    <td style="text-align: center;">
                        <?php if ($sum_total != 0) { ?>
                            <b><?= $sum_total ?></b>
                        <?php } ?>
                    </td>
                    <td style="text-align: center;">
                        <?php if ($sum_coef != 0) { ?>
                            <b><?= $sum_coef ?></b>
                        <?php } ?>
                    </td><?php
                            if ($exam_name == 'THIRD TERM') { ?>
                        <td></td>
                        <td></td>

                    <?php } ?>
                    <td style="text-align: center;">
                        <?php if ($sum_marks != 0) { ?>
                            <b><?= $sum_marks ?></b>
                        <?php } ?>
                    </td>
                    <td>

                    </td>
                </tr>
            <?php }
            ?>





        </tbody>
    </table>

    <br>

    <center>
        <?php // echo //get_phrase('total_marks');
        ?>
        <?php //echo $total_marks;
        ?>

        <?php //echo //get_phrase('Moyenne');
        ?>
        <?php
        $this->db->where('class_id', $class_id);
        $this->db->where('year', $running_year);
        $this->db->where('section_id', $section_id);
        $this->db->from('subject');
        // $number_of_subjects = $this->db->count_all_results();
        // echo ($total_grade_point / $number_of_subjects);
        //echo //$total_marks/$total_coef;
        ?>
    </center>
    <table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
        <thead></thead>
        <tbody>
            <tr>
                <td>
                    <?php if ($lang == 'en') {
                        echo get_phrase('total_marks');
                    } else {
                        echo get_phrase('total_points');
                    } ?> : <?php echo $total_marks . ' / ' . $total_coef * 20; ?>
                </td>
                <td>
                    <?php echo get_phrase('total_coef'); ?> : <?php echo $total_coef; ?>
                </td>
                <td>
                    <?php   ?>
                    <?php if ($lang == 'en') {
                        echo get_phrase('average');
                    } else {
                        echo get_phrase('moyenne');
                    } ?> : <?php if ($student_note > 0) {
                                                                                                                    echo $student_note;
                                                                                                                } //$moyenne = sprintf("%.2f",$total_marks/$total_coef);} 
                                                                                                                ?>
                </td>
                <td>
                    <?php if ($lang == 'en') {
                        echo get_phrase('rank');
                    } else {
                        echo get_phrase('rang');
                    } ?> : <?php

                                                                                                            usort($query, build_sorter('moy'));
                                                                                                            //var_dump(sizeof($query));die();
                                                                                                            for ($i = 0; $i < sizeof($query); $i++) {
                                                                                                                // $note [] = sprintf("%.2f",$query[$i]['moy']);
                                                                                                                if (($query[$i]['student_id'] == $student_id) && ($query[$i]['exam_id'] == $exam_id) && ($query[$i]['year'] == $running_year)) {
                                                                                                                    $j = $i + 1;
                                                                                                                }
                                                                                                                if ($query[$i]['moy'] >= 10) {
                                                                                                                    $nbre_moy = $nbre_moy + 1;
                                                                                                                }
                                                                                                            }
                                                                                                            $e = $j . ' / ' . $effectif;
                                                                                                            echo ($e);
                                                                                                            //$moy_class = sprintf("%.2f", array_sum($note) / count($note));
                                                                                                            // var_dump($query);
                                                                                                            ?>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width:30%; float: left; margin-right: 20px; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
        <thead></thead>
        <tbody>
            <tr>
                <td>
                    <center>
                        <h4 style="text-align: center; background-color: gray;">
                            <?php
                            if ($lang == 'en') {
                                echo get_phrase('class_profile');
                            } else {
                                echo get_phrase('profil_de_la_classe');
                            }
                            // echo get_phrase('disciplinary_report');
                            ?></h4>
                    </center>
                    <?php
                    $highest = sprintf("%.2f", $query[0]['moy']);
                    $k = sizeof($query) - 1;
                    $lowest = sprintf("%.2f", $query[$k]['moy']);
                    if ($lang == 'en') {
                        echo get_phrase('highest_AVG');
                    } else {
                        echo get_phrase('plus_forte_note');
                    } ?> :
                    <?php
                    echo $highest; ?> <br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('lowest_AVG');
                    } else {
                        echo get_phrase('plus_faible_note');
                    } ?> :
                    <?php
                    echo $lowest;
                    ?>
                    <br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('number_of_AVG');
                    } else {
                        echo get_phrase('nombre_de_moyennes');
                    } ?> :
                    <?php
                    echo $nbre_moy;
                    ?>
                    <br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('success_rate');
                    } else {
                        echo get_phrase('pourcentage');
                    } ?> :
                    <?php
                    echo (sprintf("%.2f", $nbre_moy * 100 / $effectif) . '%');
                    ?>
                    <br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('class_AVG');
                    } else {
                        echo get_phrase('moyenne_de_la_classe');
                    } ?> :
                    <?php
                    echo $moy_class;
                    ?>

                </td>

            </tr>
        </tbody>
    </table>
    <table style="width:30%; float: left; margin-right: 20px; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
        <thead></thead>
        <tbody>
            <?php if (($exam_name == 'THIRD TERM') || ($sum == TRUE)) { ?>

                <tr>
                    <td>
                        <center>
                            <h4 style="background-color:gray"><?php if ($lang == 'en') {
                                                                    echo get_phrase('annual_result');
                                                                } else {
                                                                    echo get_phrase('recapitulatif_annuel');
                                                                } ?></h4>
                        </center>
                        <table>
                            <tbody>
                                <tr>
                                    <?php for ($i = 0; $i < sizeof($query_mark); $i++) {
                                        //$somme_annuelle +=$query_mark[$i]['moy'];
                                    ?>
                                        <td> <?php if ($lang == 'en') {
                                                    echo get_phrase('Term');
                                                } else {
                                                    echo get_phrase('Trimestre');
                                                } ?> <?= $i + 1 ?> : <?= sprintf("%.2f", $query_mark[$i]['moy']); ?> </td>
                                    <?php } ?>

                                </tr>
                                <tr>
                                    <td> <?php if ($lang == 'en') {
                                                echo get_phrase('annual_average');
                                            } else {
                                                echo get_phrase('moyenne_annuelle');
                                            } ?> : <?= $moy_annuelle; ?> </td>
                                    <td>
                                        <?php if ($lang == 'en') {
                                            echo get_phrase('annual_rank');
                                        } else {
                                            echo get_phrase('rang_annuel');
                                        } ?> : <?php

                                                                                                                                            usort($query_annuelle, build_sorter('moy_annuelle'));
                                                                                                                                            //var_dump($query_annuelle);die();
                                                                                                                                            for ($i = 0; $i < sizeof($query_annuelle); $i++) {
                                                                                                                                                // $note [] = sprintf("%.2f",$query[$i]['moy']);
                                                                                                                                                if (($query_annuelle[$i]['student_id'] == $student_id) && ($query_annuelle[$i]['year'] == $running_year)) {
                                                                                                                                                    $j = $i + 1;
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            $e = $j . ' / ' . sizeof($query_annuelle);
                                                                                                                                            echo ($e);
                                                                                                                                            //$moy_class = sprintf("%.2f", array_sum($note) / count($note));
                                                                                                                                            // var_dump($query);
                                                                                                                                            ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </td>

                </tr>
            <?php } ?>
            <tr>
                <td>
                    <center>
                        <h4 style="text-align: center; background-color: gray;">
                            <?php
                            if ($lang == 'en') {
                                echo get_phrase('disciplinary_report');
                            } else {
                                echo get_phrase('Rapport Disciplinaire');
                            }
                            // echo get_phrase('disciplinary_report');
                            ?></h4>
                    </center>
                    <?php $absences = $attendance_number[count($attendance_number)-1]->number;
                     if ($lang == 'en') {
                        echo get_phrase('Absent');
                    } else {
                        echo get_phrase('Absences');
                    } ?> : <?= $absences . ' ' ?><?php if ($lang == 'en') {
                                                                                                                                                echo  get_phrase('hours') . ' ;  ';
                                                                                                                                            } else {
                                                                                                                                                echo get_phrase('heures');
                                                                                                                                            } ?>

                </td>

            </tr>


        </tbody>
    </table>
    <table style="width:30%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
        <thead></thead>
        <tbody>
            <?php if (($exam_name == 'THIRD TERM') || ($sum == TRUE)) { ?>


                <tr>
                    <td>

                        <input type="checkbox" <?php if ($moy_annuelle >= 10.00) echo 'checked' ?> name="" value=""> <?php if ($lang == 'en') {
                                                                                                                        echo get_phrase('promoted_to') . ' : ';
                                                                                                                    } else {
                                                                                                                        echo get_phrase('promu_en_classe_de') . ' : ';
                                                                                                                    } ?>
                        <bold><input style="border: 0; width: 60px; font-size: 9px" type="text" name="" value=""></bold>
                        <input type="checkbox" name="" value=""> <?php if ($lang == 'en') {
                                                                        echo get_phrase('repeat');
                                                                    } else {
                                                                        echo get_phrase('Redouble');
                                                                    } ?>

                    </td>


                </tr>
            <?php } ?>
            <tr>
                <td>
                    <center>
                        <h4 style="text-align: center; background-color: gray;"><?php if ($lang == 'en') {
                                                                                    echo get_phrase('dismissed_for');
                                                                                } else {
                                                                                    echo get_phrase('renvoyé_pour');
                                                                                } ?></h4>
                    </center>
                    <table>
                        <tbody>
                            <td><input type="checkbox" name="" value=""> <?php if ($lang == 'en') {
                                                                                echo get_phrase('academic');
                                                                            } else {
                                                                                echo get_phrase('academique');
                                                                            } ?><br></td>
                            <td><input type="checkbox" name="" value=""> <?php if ($lang == 'en') {
                                                                                echo get_phrase('bad_conduct');
                                                                            } else {
                                                                                echo get_phrase('mauvaise_conduite');
                                                                            } ?><br></td>
                            <td><input type="checkbox" name="" value=""> Age<br></td>
                            <td><input type="checkbox" name="" value=""> <?php if ($lang == 'en') {
                                                                                echo get_phrase('absenteeism');
                                                                            } else {
                                                                                echo get_phrase('absentéisme');
                                                                            } ?><br></td>
                        </tbody>
                    </table>
                </td>

            </tr>
        </tbody>
    </table>
    <table width="40%" style=" margin-right: 0px; border-collapse:collapse;border: 1px solid #ccc; margin-top: 0px;" border="1">
        <thead></thead>
        <tbody>
            <tr>
                <td colspan="4">
                    <center>
                        <h4 style="text-align: center; background-color: gray;">
                            <?php
                            if ($lang == 'en') {
                                echo get_phrase('REMARKS');
                            } else {
                                echo get_phrase('REMARQUES');
                            }
                            // echo get_phrase('disciplinary_report');
                            ?></h4>
                    </center>

                </td>
            </tr>
            <?php if ($lang == 'en') { ?>
                <tr>

                    <b>
                        <td style="text-align: center;"><?php echo '<b>Not Acquired</b>'; ?> </td>
                    </b>
                    <b>
                        <td style="text-align: center;"> <?php echo '<b>Being Acquired</b>';  ?> </td>
                    </b>
                    <b>
                        <td style="text-align: center;"> <?php echo '<b>Acquired</b>';  ?> </td>
                    </b>
                    <b>
                        <td style="text-align: center;"> <?php echo '<b>Expert</b>';  ?> </td>
                    </b>
                </tr>
                <tr>
                    <td style="text-align: center;">0 - 9.99 </td>
                    <td style="text-align: center;">10 - 13.99 </td>
                    <td style="text-align: center;"> 14 - 17.99 </td>
                    <td style="text-align: center;"> 18 - 20 </td>
                </tr>
            <?php } ?>
            <?php if ($lang == 'fr') { ?>
                <tr>

                    <b>
                        <td style="text-align: center;"><?php echo '<b>Non Acquis</b>'; ?> </td>
                    </b>
                    <b>
                        <td style="text-align: center;"> <?php echo "<b>En Cours d'Acquisition</b>";  ?> </td>
                    </b>
                    <b>
                        <td style="text-align: center;"> <?php echo '<b>Acquis</b>';  ?> </td>
                    </b>
                    <b>
                        <td style="text-align: center;"> <?php echo '<b>Expert</b>';  ?> </td>
                    </b>
                </tr>
                <tr>
                    <td style="text-align: center;">0 - 9.99 </td>
                    <td style="text-align: center;">10 - 13.99 </td>
                    <td style="text-align: center;"> 14 - 17.99 </td>
                    <td style="text-align: center;"> 18 - 20 </td>
                </tr>
            <?php } ?>
            <tr>
                <?php if ($exam_name != 'THIRD TERM') {
                    // code...
                ?>
                    <td style="height: 20px"><input type="checkbox" name="" <?php if ($student_note < 10) { ?> checked <?php } ?> value=""> </td>
                    </td>
                    <td><input type="checkbox" name="" <?php if ($student_note >= 10 and $student_note < 14) { ?> checked <?php } ?> value=""> </td>
                    <td><input type="checkbox" name="" <?php if ($student_note >= 14 and $student_note < 18) { ?> checked <?php } ?> value=""></td>
                    <td><input type="checkbox" name="" <?php if ($student_note >= 18 and $student_note <= 20) { ?> checked <?php } ?> value=""></td>
                <?php } else { ?>
                    <td style="height: 20px"><input type="checkbox" name="" <?php if ($moy_annuelle < 10) { ?> checked <?php } ?> value=""> </td>
                    </td>
                    <td><input type="checkbox" name="" <?php if ($moy_annuelle >= 10 and $moy_annuelle < 14) { ?> checked <?php } ?> value=""> </td>
                    <td><input type="checkbox" name="" <?php if ($moy_annuelle >= 14 and $moy_annuelle < 18) { ?> checked <?php } ?> value=""></td>
                    <td><input type="checkbox" name="" <?php if ($moy_annuelle >= 18 and $moy_annuelle <= 20) { ?> checked <?php } ?> value=""></td>
                <?php } ?>
            </tr>
        </tbody>
    </table>

    <?php if ($lang == 'en') { ?>
        <p style="margin-left: 80% ; margin-top: -30px;"> Douala , The</p>
        <p style="margin-left: 80%;"> The Principal</p>
    <?php } else { ?>
        <p style="margin-left: 80%; "> Douala , Le</p>
        <p style="margin-left: 80%;"> Le Principal</p>
    <?php } ?>


</div>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        var elem = $('#print');
        PrintElem(elem);
        Popup(data);

    });

    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>