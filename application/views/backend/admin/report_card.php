<?php
//var_dump($lang);die();


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
        padding: 3px;
        font-size: 12px;
    }

    h3 {
        text-align: center;
    }

    #print {
        padding: 0px;
    }

    p {
        font-size: 9px;
    }
    .printp{
        font-size: 12px;
        padding: 3px;
    }
</style>

<div >



<?php if ($lang == 'en') { ?>

        <h3 style="font-weight: 100; background-color: rgba(252,194,59,0.7); "><?php echo 'Report Card'; ?></h3>
        <?php }
    ?>
<?php if ($lang == 'fr') { ?>

        <h3 style="font-weight: bold;  background-color: rgba(252,194,59,0.7); "><?php echo 'Relévé de Notes'; ?></h3>
        <?php }
    ?>


    <table style="width:100%;">
        <thead></thead>
        <tbody>
            <tr>

<?php if ($lang == 'fr') { ?>

                    <td>
                        <p  class="printp" ><?php echo get_phrase('metier') . ' ' . $class_name; ?></p>
                        <p class="printp" >Matricule : <?= $student->student_code ?></p>
                        <p class="printp" >Noms et Prénoms : <?php echo $student->name . ' ' . $student->surname ?></p>
                        <p class="printp">Date et Lieu de Naissance : <?php echo date('d/m/Y',strtotime($student->birthday)) . ' à ' . $student->at ?></p>
                        <p class="printp" >Sexe : <?php echo $student->sex ?></p>
                    </td>
                    <td>
                        <p class="printp" style="margin: 0;"><?php echo $exam_name; ?></p>



                        <p class="printp" >Année de formation : <?= $year ?></p>
                        <p class="printp" >Chef d'atelier : <?= $master->name . ' ' . $master->surname; ?> </p>

                    </td>
                    <td><img src="<?php echo $this->crud_model->get_image_url('student', $student->student_id); ?>" class="img-circle" width="70" height="70" /></td>

                    <?php
                }
                ?>

            </tr>
        </tbody>
    </table>

    <table  style="width:100%; border-collapse:collapse;border: 1px solid black; margin-top: 3px;" border="1">
        <thead>
            <tr>
                <td style="text-align: center;" <?php if ($exam_name == 'THIRD TERM') echo 'rowspan="2"' ?>>Modules</td>
                <td style="text-align: center;">CC</td>
                <td style="text-align: center;">EXAM</td>
                <td style="text-align: center;">Moy / 20</td>





                <!--<td style="text-align: center;">Min</td>-->
                <!-- <td style="text-align: center;">Grade</td>-->
                <td style="text-align: left; "  <?php if ($exam_name == 'THIRD TERM') echo 'rowspan="2"' ?>><?php
                    if ($lang == 'en') {
                        echo "Remarks";
                    } else {
                        echo "Décision";
                    }
                    ?></td>
                <!--<td style="text-align: center;">Subject</td>
            <td style="text-align: center;">Test 1</td>
            <td style="text-align: center;">Coef</td>
            <td style="text-align: center;">Totaux</td>
            <td style="text-align: center;">Max</td>
            <td style="text-align: center;">Min</td>
           
            <td style="text-align: center;">Comment</td>
            <td style="text-align: center;">Appreciations</td>-->
            </tr>

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

                <tr  style="text-align: center; font-weight: bold; background-color:rgba(252,194,59,0.7); ">
                    <td  colspan="5" style="font-weight: bold;" >
                        <b><?= strtoupper($key->libelle) ?></b>

                    </td>

                </tr>
                <?php
                $this->db->select('s.*');
                $this->db->where(array('s.class_id' => $class_id, 's.section_id' => $section_id, 's.year' => $year, 's.type_id' => $key->type_id));
                $this->db->order_by('s.name ASC');
                $subjects = $this->db->get('subject as s')->result();

                foreach ($subjects as $row3) {
                    ?>
                    <tr>
                        <td style="text-align: left;"><?php echo $row3->name; ?><br>
                            <b><?php echo ucwords($row3->teacher_name . ' ' . $row3->teacher_surname); ?></b>
                        </td>

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
                                    if (count($row4->test2) and count($row4->mark_obtained)) {
                                        echo $total = sprintf("%.2f", ($row4->test2 * 0.7 + $row4->mark_obtained * 0.3));
                                        //var_dump($total);
                                        $sum_coef++;
                                        $sum_total += $total;
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: left;">

                            <?php
                            if (count($marks) > 0) {
                                if ($total != null) {
                                    echo $grade = $this->db->get_where('grade', array('mark_from <=' => $total, 'mark_upto >=' => $total, 'lang' => $lang))->row()->grade_point;
                                }
                            }
                            ?>
                        </td>
                    </tr>
    <?php } ?>
                <tr>
                    <td colspan="3" style="text-align: left;">
                        <b>Total </b>
                    </td>

                    
                    <td style="text-align: center;">
    <?php if ($sum_coef != 0) { ?>
                        <b><?= sprintf("%.2f",$sum_total/$sum_coef)  ?></b>
                        <?php } ?>
                    </td>


                    <td style="text-align: center;">
    <?php if ($sum_marks != 0) { ?>
                            <b><?= $sum_marks ?></b>
                <?php } ?>
                    </td>


                </tr>
<?php }
?>
        </tbody>
    </table>

    <table  style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
        <thead></thead>
        <tbody>
            <tr>


                <td>
                    <?php
                    echo get_phrase('moyenne');
                    ?> : <?php
                    if ($student_note > 0) {
                        echo '<b>' . $student_note;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    echo get_phrase('rang');
                    ?> : <?php
                    $i = 0;
                    foreach ($note_classe as $row) {
                        $i++;
                        if ($row->student_id == $student_id) {
                            $e = $i . ' / ' . $effectif;
                            echo ($e);
                        }
                        if ($row->moy >= 12) {
                            $nbre_moy++;
                        }
                    }
                    ?>
                </td>
                <td>
                <?php
                $grade = $this->db->get_where('grade', array('mark_from <=' => $student_note,
                    'mark_upto >=' => $student_note, 'lang' => $lang))->row()->grade_point;
                echo get_phrase("decision : ".$grade);
                ?>
                </td>


            </tr>
        </tbody>
    </table>
    <table  style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
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
                }
                ?> :
                <?php echo $highest; ?> <br>
                <?php
                if ($lang == 'en') {
                    echo get_phrase('lowest_AVG');
                } else {
                    echo get_phrase('plus_faible_note');
                }
                ?> :
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
                }
                ?> :
                <?php
                echo $nbre_moy . ' / ' . $effectif;
                ?>
                <br>
                <?php
                if ($lang == 'en') {
                    echo get_phrase('success_rate');
                } else {
                    echo get_phrase('pourcentage');
                }
                ?> :
                <?php
                echo (sprintf("%.2f", $nbre_moy * 100 / $effectif) . '%');
                ?>
                <br>
                <?php
                if ($lang == 'en') {
                    echo get_phrase('class_AVG');
                } else {
                    echo get_phrase('moyenne_de_la_classe');
                }
                ?> :
                    <?php
                    echo $moy_class;
                    ?>
            </td>
                    <?php if (($exam_name == 'THIRD TERM') || ($sum == TRUE)) { ?>
                <td>
                    <h4 style="font-weight: 100; background-color: rgba(252,194,59,0.7); text-align : center">
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('annual_result');
                    } else {
                        echo get_phrase('recapitulatif_annuel');
                    }
                    ?></h4>
                        <?php
                        if ($lang == 'en') {
                            echo get_phrase('Term 1');
                        } else {
                            echo get_phrase('Trimestre 1');
                        }
                        ?> :
                        <?php
                    foreach ($student_moys as $student_moy) {
                        if ($student_moy->exam_id == $exam_id - 2)
                            $term1_moy = $student_moy->moy;
                        elseif ($student_moy->exam_id == $exam_id - 1)
                            $term2_moy = $student_moy->moy;
                        elseif ($student_moy->exam_id == $exam_id)
                            $term3_moy = $student_moy->moy;
                    }
                    echo $term1_moy;
                    ?><br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('Term 2');
                    } else {
                        echo get_phrase('Trimestre 2');
                    }
                    ?> :
                    <?=
                    $term2_moy;
                    ?><br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('Term 3');
                    } else {
                        echo get_phrase('Trimestre 3');
                    }
                    ?> :
                    <?=
                    $term3_moy;
                    ?><br>
                    <?php
                    if ($lang == 'en') {
                        echo get_phrase('annual_AVG');
                    } else {
                        echo get_phrase('Moy_annuelle');
                    }
                    ?> :
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
                        }
                        ?> :
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
            <?php
            if ($lang == 'en') {
                echo get_phrase('Absent');
            } else {
                echo get_phrase('Absences');
            }
            ?> : 
                <?= $attendance_number . ' ' ?>
                <?php
                if ($lang == 'en') {
                    echo get_phrase('hours') . ' ;  ';
                } else {
                    echo get_phrase('heures');
                }
                ?>

            </td>
            <?php if (($exam_name == 'THIRD TERM') || ($sum == TRUE)) { ?>
                <td>

                    <input type="checkbox" name="" <?php if ($moy_annuelle >= 10.00) { ?> checked="checked" <?php } ?> value="">
    <?php
    if ($lang == 'en') {
        echo get_phrase('promoted_to') . ' : ';
    } else {
        echo get_phrase('promu_en_classe_de') . ' : ';
    }
    ?>
                    <input type="checkbox" name="" value="">
    <?php
    if ($lang == 'en') {
        echo get_phrase('repeat');
    } else {
        echo get_phrase('Redouble');
    }
    ?>

                </td>
                <?php } ?>
        </tr>

    </table>



    

<?php if ($lang == 'en') { ?>
        <p class="printp"  style="margin-left: 80% ; margin-top:4px;"> Douala , The <?php echo date("d/m/Y")  ?> </p>
        <p class="printp" style="margin-left: 80%;"> The Principal</p>
<?php } else { ?>
        <p class="printp" style="margin-left: 80%; margin-top:5px;"> Douala , Le <?php echo date("d/m/Y")  ?></p>
        <p class="printp" style="margin-left: 80%;"> Le Directeur</p>
<?php }  ?>


</div>