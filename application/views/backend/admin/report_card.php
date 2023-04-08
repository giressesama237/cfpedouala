<?php  //var_dump($lang);die();


$somme_annuelle = 0;
$note_annuelle = 0;

$effectif = count($note_classe);
$nbre_moy = 0;
$moy_annuelle = null;
$subject_test1 = FALSE;
$subject_test2 = FALSE;
$subject_exam = FALSE;
?>

<style type="text/css">
    *{
        font-family:'Times New Roman', Times, serif;
    }
    td {
        padding-left: 1px;
        font-size: 12px;
    }

    h3 {
        text-align: center;
    }

    #print {
        padding: 0px;
    }

    p {
        font-size: 12px;
    }
    
</style>

<div>



    <?php if ($lang == 'en') { ?>

        <h3 style="font-weight: 100; background-color: rgba(252,194,59,0.7); "><?php echo 'Report Card'; ?></h3>
    <?php
    } ?>
    <?php if ($lang == 'fr') { ?>

        <h3 style="font-weight: 100; background-color: rgba(252,194,59,0.7); "><?php echo 'Relévé de Notes'; ?></h3>
    <?php
    } ?>


    <table style="width:100%;">
        <thead></thead>
        <tbody>
            <tr>
                <?php if ($lang == 'en') { ?>

                    <td>
                        <p style="margin: 0;"><?php echo get_phrase('class') . ' ' . $class_name . ' ' . $section_name; ?></p>
                        <p style="margin: 0;">Matricule : <?= $student->student_code ?></p>
                        <p style="margin: 0;">Name and surname : <?php echo $student->name . ' ' . $student->surname ?></p>
                        <p style="margin: 0;">Date and place of birth : <?php if($student->birthday!=NULL) echo date('d/m/Y', strtotime($student->birthday) ) . ' at ' . $student->at ?></p>
                        <p style="margin: 0;">Sex : <?php echo $student->sex ?></p>
                    </td>
                    <td>
                        <p style="margin: 0;"><?php echo $exam_name; ?></p>
                        <p style="margin: 0;">Academic year : <?= $year ?></p>
                        <p style="margin: 0;">Class master : <?= $master->name . ' ' . $master->surname; ?> </p>
                    </td>
                    <td><img src="<?php echo $this->crud_model->get_image_url('student', $student->student_id); ?>" class="img-circle" width="50" height="50" /></td>
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
                                                <p style="margin: 0;"><?php echo $exam_name; ?></p>

                        

                        <p style="margin: 0;">Année Académique : <?= $year ?></p>
                        <p style="margin: 0;">Professeur Titulaire : <?= $master->name . ' ' . $master->surname; ?> </p>

                    </td>
                    <td><img src="<?php echo $this->crud_model->get_image_url('student', $student->student_id); ?>" class="img-circle" width="70" height="70" /></td>

                <?php

                }
                ?>

            </tr>
        </tbody>
    </table>

    <table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 3px;" border="1">
        <thead>
            <tr>
                <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'rowspan="2"' ?>>Modules</td>
                <td style="text-align: center;">CC</td>
                    <td style="text-align: center;">EXAM</td>
                    
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
                <td style="text-align: left; "  <?php if ($exam_name == 'THIRD TERM') echo 'rowspan="2"' ?>><?php if ($lang == 'en') {
                                                                                                                echo "Remarks";
                                                                                                            } else {
                                                                                                                echo "Appréciations";
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
                <!--<td colspan="9" style="background-color: #28E5FC;"><b><p>ARTS SUBJECTS</p></td></b>-->
            </tr>
            <?php
            $total_marks = 0;
            $marks_coef = 0;
            $total_coef = 0;
            $total_grade_point = 0;
            //var_dump($subject_type);die();
            foreach ($subject_type as $key) {
                $sum_test1 = 0;
                $sum_term1 = null;
                $sum_term2 = null;
                $sum_test2 = 0;
                $sum_coef = 0;
                $sum_total = 0;
                $sum_marks = 0;

            ?>

                <tr style="text-align: left; background-color:rgba(252,194,59,0.7); color : white">
                    <td <?php if ($exam_name == 'THIRD TERM') echo 'colspan="12"';
                        else echo 'colspan="8"' ?>>
                            <b><?= strtoupper($key->libelle) ?></b>

                    </td>

                </tr>
                <?php
                $this->db->select('s.*, t.name as teacher_name , t.surname as teacher_surname');
                $this->db->join('teacher as t', 't.teacher_id = s.teacher_id');
                $this->db->where(array('s.class_id' => $class_id, 's.section_id' => $section_id, 's.year' => $year, 's.type_id' => $key->type_id));
                $this->db->order_by('s.name ASC');
                $subjects = $this->db->get('subject as s')->result();

                foreach ($subjects as $row3) {
                ?>
                    <tr>
                        <td style="text-align: left;"><?php echo $row3->name; ?><br>
                            <b><?php echo ucwords($row3->teacher_name . ' ' . $row3->teacher_surname); ?></b>
                        </td>
                        <?php
                        if ($exam_name == 'THIRD TERM') {
                            $mark_term = $this->db->get_where('mark', array(
                                'subject_id' => $row3->subject_id,
                                'exam_id' => $exam_id - 2,
                                'class_id' => $class_id,
                                'section_id' => $section_id,
                                'student_id' => $student_id,
                                'year' => $year
                            ))->result();
                            //var_dump($mark_term);die();
                        ?>
                            <td style="text-align:center">
                                <?php
                                if (count($mark_term) > 0) {
                                    foreach ($mark_term as $row4) {
                                        if (count($row4->test2) and count($row4->mark_obtained)) {
                                            echo  $total_term1 = sprintf("%.2f", ($row4->test2  + $row4->mark_obtained) / 2);
                                        } elseif (!count($row4->mark_obtained) and count($row4->test2)) {
                                            echo $total_term1 = sprintf("%.2f", ($row4->test2));
                                        } elseif (!count($row4->test2) and count($row4->mark_obtained)) {
                                            echo $total_term1 = sprintf("%.2f", ($row4->mark_obtained));
                                        } elseif (!count($row4->test2) and !count($row4->mark_obtained)) {
                                            $total_term1 = null;
                                        }
                                    }
                                }
                                ?>
                            </td>

                        <?php }
                        if ($exam_name == 'THIRD TERM') {
                            $mark_term = $this->db->get_where('mark', array(
                                'subject_id' => $row3->subject_id,
                                'exam_id' => $exam_id - 1,
                                'class_id' => $class_id,
                                'section_id' => $section_id,
                                'student_id' => $student_id,
                                'year' => $year
                            ))->result(); ?>
                            <td style="text-align:center">
                                <?php
                                if (count($mark_term) > 0) {
                                    foreach ($mark_term as $row4) {
                                        if (count($row4->test2) and count($row4->mark_obtained)) {
                                            echo  $total_term2 = sprintf("%.2f", ($row4->test2  + $row4->mark_obtained) / 2);
                                        } elseif (!count($row4->mark_obtained) and count($row4->test2)) {
                                            echo $total_term2 = sprintf("%.2f", ($row4->test2));
                                        } elseif (!count($row4->test2) and count($row4->mark_obtained)) {
                                            echo $total_term2 = sprintf("%.2f", ($row4->mark_obtained));
                                        } elseif (!count($row4->test2) and !($row4->mark_obtained)) {
                                            $total_term2 = null;
                                        }
                                    }
                                }
                                ?>
                            </td>

                        <?php } ?>
                        <td style="text-align: center;">
                            <?php
                            $marks = $this->db->get_where('mark', array(
                                'subject_id' => $row3->subject_id,
                                'exam_id' => $exam_id,
                                'section_id' => $section_id,
                                'class_id' => $class_id,
                                'student_id' => $student_id,
                                'year' => $year
                            ))->result();
                            //var_dump(count($marks[0]->test2));die();
                            if (count($marks) > 0) {
                                foreach ($marks as $row4) {
                                    if (count($row4->mark_obtained)) {
                                        echo $row4->mark_obtained;
                                        $sum_test1 += $row4->mark_obtained;
                                        $subject_test1 = TRUE;
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            if (count($marks) > 0) {
                                foreach ($marks as $row4) {
                                    if (count($row4->test2)) {
                                        echo $row4->test2;
                                        $sum_test2 += $row4->test2;
                                        $subject_test2 = TRUE;
                                    }
                                }
                            }
                            ?>
                        </td>

                        <td style="text-align: center;">
                            <?php
                            if (count($marks) > 0) {
                                foreach ($marks as $row4) {
                                    if (count($row4->mark_obtained) and count($row4->test2)) {
                                        echo $c =  $row4->test2  + $row4->mark_obtained;
                                        $sum_c += $c;
                                    }
                                }
                            }
                            ?>
                        </td>

                        <td style="text-align: center;">
                            <?php
                            if (count($marks) > 0) {
                                foreach ($marks as $row4) {
                                    if (count($row4->test2) and count($row4->mark_obtained)) {
                                        echo  $total = sprintf("%.2f", ($row4->test2 + $row4->mark_obtained) / 2);
                                        //var_dump($total);
                                    } elseif (!count($row4->mark_obtained) and count($row4->test2)) {
                                        echo $total = sprintf("%.2f", ($row4->test2));
                                    } elseif (!count($row4->test2) and count($row4->mark_obtained)) {
                                        echo $total = sprintf("%.2f", ($row4->mark_obtained));
                                    } elseif (!count($row4->test2) and !count($row4->mark_obtained)) {
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
                                echo $row3->coef;
                                $total_coef += $row3->coef;
                                $sum_coef += $row3->coef;
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
                                    $marks_coef = $total_term1 * $row3->coef;
                                    echo  $marks_coef;
                                    $sum_term1 +=$marks_coef;
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if ($total_term2 != null) {
                                    $marks_coef = $total_term2 * $row3->coef;
                                    echo  $marks_coef;
                                    $sum_term2 +=$marks_coef;

                                }
                                ?>
                            </td>


                        <?php } ?>
                        <td style="text-align: center;">
                            <?php
                            if (count($marks) > 0) {
                                foreach ($marks as $row4) {
                                    $marks_coef = $total * $row3->coef;
                                    if (count($row4->mark_obtained) or count($row4->test2)) {
                                        echo  $marks_coef;
                                    }
                                    if (count($row4->mark_obtained) and count($row4->test2)) {
                                        $tot_cof = 20 * $row3->coef;
                                        $tot += $tot_cof;
                                    }
                                    $total_marks += $marks_coef;
                                    $sum_marks += $marks_coef;
                                }
                            }
                            ?>
                        </td>


                        <td style="text-align: left;">

                            <?php if (count($marks) > 0) {
                                if ($total != null) {
                                    echo $grade = $this->db->get_where('grade', array('mark_from <=' => $total, 'mark_upto >=' => $total, 'lang' => $lang))->row()->grade_point;
                                }
                            }

                            ?>
                        </td>

                    </tr>
                <?php } ?>
                <tr>
                    <td style="text-align: left;">
                        <b>Total <?= $key->type_id ?></b>
                    </td>
                    <?php
                    if ($exam_name == 'THIRD TERM') { ?>

                        <td style="text-align: center;">
                            <?php if  (($sum_coef != 0) and ($sum_term1 != null)) { ?>
                            <b><?= sprintf('%.2f',$sum_term1/$sum_coef)  ?></b>
                            <?php } ?>
                        </td>
                        <td style="text-align: center;">
                            <?php if  (($sum_coef != 0)and ($sum_term1 != null))  { ?>
                            <b><?= sprintf('%.2f',$sum_term2/$sum_coef)  ?></b>
                            <?php } ?>
                        </td>
                    <?php } ?>
                    <td style="text-align: center;">
                        <?php /* if ($sum_test1 != 0) { ?>
                            <b><?= $sum_test1 ?></b>
                        <?php }*/  ?>
                    </td>

                    <td style="text-align: center;">
                        <?php /* if ($sum_test2 != 0) { ?>
                            <b><?= $sum_test2 ?></b>
                        <?php }*/ ?>
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
                    <?php if (($sum_marks != 0) and ($sum_coef != 0))  { ?>
                            <b><?= sprintf('%.2f',$sum_marks/$sum_coef)  ?></b>
                        <?php } ?>
                        
                    </td>
                    <td style="text-align: center;">
                        <?php if ($sum_coef != 0) { ?>
                            <b><?= $sum_coef ?></b>
                        <?php } ?>
                    </td><?php
                            if ($exam_name == 'THIRD TERM') { ?>
                        <td>
                            <?php if ($sum_term1 != null) { ?>
                                <b><?= $sum_term1 ?></b>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($sum_term2 != null) { ?>
                                <b><?= $sum_term2 ?></b>
                            <?php } ?>
                        </td>

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

    <table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 3px;" border="1">
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
                                echo '<b>'. $student_note;
                            }
                            ?>
                </td>
                <td>
                    <?php if ($lang == 'en') {
                        echo get_phrase('rank');
                    } else {
                        echo get_phrase('rang');
                    } ?> : <?php
                            $i = 0;
                            foreach ($note_classe as $row) {
                                $i++;
                                if ($row->student_id == $student_id) {
                                    $e = $i . ' / ' . $effectif;
                                    echo ($e);
                                }
                                if ($row->moy >= 10) {
                                    $nbre_moy++;
                                }
                            }


                            ?>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 3px;" border="1">
        <tr>
            <td>
                <h4 style="font-weight: 100; background-color: rgba(252,194,59,0.7); color :white">
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('class_profile');
                    } else {
                        echo get_phrase('profil_de_la_classe');
                    }
                    // echo get_phrase('disciplinary_report');
                    ?></h4>
                <?php
                $highest = sprintf("%.2f", $note_classe[0]->moy);
                $k = count($note_classe) - 1;
                $lowest = sprintf("%.2f", $note_classe[$k]->moy);
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
            </td>
            <td>
            <?php
                if ($lang == 'en') {
                    echo get_phrase('number_of_AVG');
                } else {
                    echo get_phrase('nombre_de_moyennes');
                } ?> :
                <?php
                echo $nbre_moy.' / '.$effectif;
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
            <?php if (($exam_name == 'THIRD TERM') || ($sum == TRUE)) { ?>
                <td>
                    <h4 style="font-weight: 100; background-color: rgba(252,194,59,0.7); text-align : center">
                        <?php if ($lang == 'en') {
                            echo get_phrase('annual_result');
                        } else {
                            echo get_phrase('recapitulatif_annuel');
                        } ?></h4>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('Term 1');
                    } else {
                        echo get_phrase('Trimestre 1');
                    } ?> :
                    <?php
                    foreach ($student_moys as $student_moy){
                        if ($student_moy->exam_id==$exam_id-2)
                            $term1_moy = $student_moy->moy;
                        elseif ($student_moy->exam_id==$exam_id-1)
                            $term2_moy = $student_moy->moy;
                        elseif ($student_moy->exam_id==$exam_id)
                            $term3_moy = $student_moy->moy;

                    }
                    echo  $term1_moy;
                    ?><br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('Term 2');
                    } else {
                        echo get_phrase('Trimestre 2');
                    } ?> :
                    <?=
                    $term2_moy;
                    ?><br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('Term 3');
                    } else {
                        echo get_phrase('Trimestre 3');
                    } ?> :
                    <?=
                    $term3_moy;
                    ?><br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('annual_AVG');
                    } else {
                        echo get_phrase('Moy_annuelle');
                    } ?> :
                    <?php
                    $i = 0;
                    foreach ($query_annuelle as $row) {
                        $i++;
                        if ($row->student_id == $student_id) {
                            $moy_annuelle = $row->moy_annuelle;
                            $e = $i . ' / ' . count($query_annuelle);
                            echo ($moy_annuelle);
                            //echo ($e);
                        }
                    }
                    ?><br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('annual_rank');
                    } else {
                        echo get_phrase('rank_annuel');
                    } ?> :
                    <?php
                    echo ($e);
                    ?><br>
                </td>
            <?php } ?>
            <td>
                <h4 width="100%" style="text-align: center; font-weight: 100; background-color: rgba(252,194,59,0.7);">
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('disciplinary_report');
                    } else {
                        echo get_phrase('rapport_disciplinaire');
                    }
                    // echo get_phrase('disciplinary_report');
                    ?>
                </h4>
                <?php if ($lang == 'en') {
                    echo get_phrase('Absent');
                } else {
                    echo get_phrase('Absences');
                } ?> : 
                <?= $attendance_number . ' ' ?>
                <?php if ($lang == 'en') {
                    echo  get_phrase('hours') . ' ;  ';
                } else {
                    echo get_phrase('heures');
                } ?>

            </td>
            <?php if (($exam_name == 'THIRD TERM') || ($sum == TRUE)) { ?>
                <td>

                    <input type="checkbox" name="" <?php if ($moy_annuelle >= 10.00) { ?> checked="checked" <?php } ?> value="">
                     <?php if ($lang == 'en') {
                                echo get_phrase('promoted_to') . ' : ';
                            } else {
                                echo get_phrase('promu_en_classe_de') . ' : ';
                            } ?>
                    <input type="checkbox" name="" value="">
                     <?php if ($lang == 'en') {
                                echo get_phrase('repeat');
                            } else {
                                echo get_phrase('Redouble');
                            } ?>

                </td>
            <?php } ?>
        </tr>

    </table>
    
    
    
    <table width="50%" style=" margin-right: 0px; border-collapse:collapse;border: 1px solid #ccc; margin-top: 0px;" border="1">
        <thead></thead>
        <tbody>
            <tr>
                <td style="background-color: rgba(252,194,59,0.7);color : white" colspan="4">
                    <center>
                        <h4 style="text-align: center; ">
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
                    <td style="height: 20px"><input type="checkbox" name="" <?php if ($student_note < 10) { ?> checked="checked" <?php } ?> value=""> </td>
                    </td>
                    <td><input type="checkbox" name="" <?php if ($student_note >= 10 and $student_note < 14) { ?> checked="checked" <?php } ?> value=""> </td>
                    <td><input type="checkbox" name="" <?php if ($student_note >= 14 and $student_note < 18) { ?> checked="checked" <?php } ?> value=""></td>
                    <td><input type="checkbox" name="" <?php if ($student_note >= 18 and $student_note <= 20) { ?> checked="checked" <?php } ?> value=""></td>
                <?php } else { ?>
                    <td style="height: 20px"><input type="checkbox" name="" <?php if ($moy_annuelle < 10) { ?> checked="checked" <?php } ?> value=""> </td>
                    </td>
                    <td><input type="checkbox" name="" <?php if ($moy_annuelle >= 10 and $moy_annuelle < 14) { ?> checked="checked" <?php } ?> value=""> </td>
                    <td><input type="checkbox" name="" <?php if ($moy_annuelle >= 14 and $moy_annuelle < 18) { ?> checked="checked" <?php } ?> value=""></td>
                    <td><input type="checkbox" name="" <?php if ($moy_annuelle >= 18 and $moy_annuelle <= 20) { ?> checked="checked" <?php } ?> value=""></td>
                <?php } ?>
            </tr>
        </tbody>
    </table>

    <?php if ($lang == 'en') { ?>
        <p style="margin-left: 80% ; margin-top: -30px;"> Douala , The</p>
        <p style="margin-left: 80%;"> The Principal</p>
    <?php } else { ?>
        <p style="margin-left: 80%; margin-top: -30px;"> Douala , Le</p>
        <p style="margin-left: 80%;"> Le Principal</p>
    <?php } ?>


</div>