<?php
$nbre_moy = 0;
$somme_moyenne = 0;
$class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
$exam_name = $this->db->get_where('exam', array('exam_id' => $exam_id))->row()->name;
$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$admin_id = $this->session->userdata('admin_id');
$running_year = $this->db->get_where('session', array('admin_id' => $admin_id))->row()->year;
?>
<div id="print">
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        td {
            font-size: 12px;
            padding : 4px;
        }
        p{
            font-size: 14px;
        }
        .entete p{
            font-size : 11px;
            
        }

  
    </style>
    <table style="width:100%;">
        <thead></thead>
        <tbody>
            <tr>
                <td style="text-align:center; font-size: 11px" class="entete" width="30%" >
                    <p style="margin: 0;">Republique du Cameroun</p>
                    <p style="margin: 0;">Paix-Travail-Patrie</p>
                     <p style="margin: 0;">--------------------</p>

                    <p style="margin: 0;">MINISTERE DE L’EMPLOI ET DE LA FORMATION PROFESSIONNELLE</p>
                      <p style="margin: 0;">--------------------</p>

                    <p style="margin: 0;">DELEGATION REGIONALE DU LITTORAL</p>
                      <p style="margin: 0;">--------------------</p>

                    <p style="margin: 0;">CENTRE DE FORMATION PROFESSIONNELLE D’EXCELLENCE DE DOUALA</p>
                    <p style="margin: 0;">--------------------</p>

                    <p style="margin: 0;">BP: 341 DOUALA TEL : 677 65 37 41</p>
                </td>
                <td  width="40%" ><center>

            <img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height : 90px;">
        </center>

        </td>
            <td style="text-align:center; font-size: 11px" class="entete" width="30%" >
                    <p style="margin: 0;">REPUBLIC OF CAMEROON</p>
                    <p style="margin: 0;">Peace-Work-Fatherland</p>
                     <p style="margin: 0;">--------------------</p>

                    <p style="margin: 0;">MINISTRY OF EMPLOYMENT AND VOCATIONAL TRAINING</p>
                      <p style="margin: 0;">--------------------</p>

                    <p style="margin: 0;">REGIONAL DELEGATION OF LITTORAL</p>
                      <p style="margin: 0;">--------------------</p>

                    <p style="margin: 0;">DOUALA ADVANCED VOCATIONAL TRAINING CENTRE</p>
                    <p style="margin: 0;">--------------------</p>

                    <p style="margin: 0;">P.O BOX: 341 DOUALA TEL : 677 65 37 41</p>
                </td>
        </td>
        </tr>
        </tbody>
    </table>

    <center>

        <h1 style="font-weight: 100; background-color: rgba(252,194,59,0.7);"><?php echo 'Procès verbal'; ?></h1>


    </center>
    <table style="width:100%;" style="font-size: 11px">
        <thead></thead>
        <tbody>
            <tr>

                <td style="font-size: 14px">
                    <p style="margin: 0;"><?php echo get_phrase('Metier') . ' ' . $class_name ?></p>

                </td>
                <td style="font-size: 14px">
                    <p style="margin: 0;"><?php echo $exam_name; ?></p>
                    <p style="margin: 0;">Année Académique : <?= $running_year ?></p>
                </td>





            </tr>
        </tbody>
    </table>

    <p style="font-size:11px">Notation : CC = 30 % ; EXAM = 70 % ; NV = Non Validé; V = Validé</p>
    <table style="width:100%; border-collapse:collapse;border: 1px solid black; margin-top: 10px;" border="1">
        <thead>
            <tr>
                <td rowspan="2" style="text-align: center;">
                    N°
                </td>
                <td rowspan="2" style="text-align: center;">
                    <?php echo get_phrase('apprenants'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('modules'); ?> <i class="entypo-right-thin"></i>
                </td>
                <?php
                foreach ($subjects as $row):
                    ?>
            <b><td colspan="4" style="text-align: center;"><?php echo '<b>' . $row['code'] . '<b>'; ?></td><b>
                <?php endforeach; ?>
                <td rowspan="2" style="text-align: center;"><?php echo "Moy"; ?></td>
                <td rowspan="2"  style="text-align: center;"><?php echo "Dec."; ?></td>

                </tr>
                <tr>

                    <?php
                    foreach ($subjects as $row):
                        ?>
                        <td style="text-align: center;">CC</td>
                        <td style="text-align: center;">EXAM</td>
                        <td style="text-align: center;">Moy</td>
                        <td style="text-align: center;">Dec.</td>
                    <?php endforeach; ?>

                </tr>
                </thead>
                <tbody>

                    <?php
                    $count = 1;
                    foreach ($students as $row):
                        ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php echo $count++ ?>
                            </td>
                            <td style="text-align: left;">
                                <?php echo $row['name'] . ' ' . $row['surname'] ?>
                            </td>
                            <?php
                            $total_marks = 0;
                            $total_grade_point = 0;
                            $subject_cc = FALSE;
                            $subject_exam = FALSE;
                            foreach ($subjects as $row2):

                                $mark_cc = null;
                                $mark_exam = null;
                                $moyenne = null;
                                ?>
                                <td style="text-align: center;">
                                    <?php
                                    foreach ($obtained_mark_query as $marks) :
                                        if (($marks['subject_id'] == $row2['subject_id']) && ($marks['student_id'] == $row['student_id'])) {

                                            echo $mark_cc = $marks['mark1'];
                                            if ($mark_cc == null)
                                                $subject_cc = TRUE;
                                            //var_dump($subject_cc);
                                        }
                                    endforeach;
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    foreach ($obtained_mark_query as $marks) :
                                        if (($marks['subject_id'] == $row2['subject_id']) && ($marks['student_id'] == $row['student_id'])) {
                                            echo $mark_exam = $marks['mark2'];
                                            if ($mark_exam == null)
                                                $subject_exam = TRUE;
                                        }
                                    endforeach;
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    if (($mark_cc != null) and ($mark_exam != null))
                                        echo '<b>' . sprintf("%.2f", $moyenne = $mark_cc * 0.3 + $mark_exam * 0.7) . '</b>';
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                                    //var_dump($moyenne);

                                    if ($moyenne < 12 or $moyenne == null)
                                        echo 'NV';
                                    else if ($moyenne >= 12 and $moyenne <= 20)
                                        echo 'V';
                                    ?>
                                </td>
                            <?php endforeach; ?>
                            <td>
                                <?php
                                foreach ($marks_moy as $student_moy):
                                    if (($student_moy['student_id'] == $row['student_id']) and (!$subject_cc and!$subject_exam)) {
                                        echo '<b>'.$moy = sprintf("%.2f", $student_moy['moy']).'</b>';
                                        $somme_moyenne += $moy;
                                        if ($moy >= 12.00) {
                                            $nbre_moy++;
                                        }
                                    }
                                endforeach;
                                ?>

                            </td>
                            <td><?php
                                foreach ($marks_moy as $moy) {

                                    if ($moy['student_id'] == $row['student_id']) {
                                        if ($moy['moy'] < 12 or $moy['moy'] == null or ($subject_cc or $subject_exam))
                                            echo '<b>NV</b>';
                                        else if (($moy['moy'] >= 12 and $moy['moy'] <= 20)) {
                                            echo '<b>V</b>';
                                        }
                                    }
                                }
                                ?></td>

                        </tr>

                    <?php endforeach; ?>
                </tbody>
                </table>
                </div>
                <table style="width:50%; float: left; margin-right: 20px; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
                    <thead> <td colspan="2"style="background-color: rgba(252,194,59,0.7); text-align: center">Statistiques </td> </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php
                                $highest = sprintf("%.2f", $marks_moy[0]['moy']);
                                $effectif = count($marks_moy);
                                $k = $effectif - 1;
                                $lowest = sprintf("%.2f", $marks_moy[$k]['moy']);
                                echo get_phrase('plus_forte_note : ' . $highest);
                                ?> 
                            </td>
                            <td>
                                <?php
                                echo get_phrase('plus_faible_note : ' . $lowest);
                                ?>
                            </td>


                        </tr>
                        <tr>
                            <td>
                                  <?php echo 'Validés : ' .$nbre_moy.' / '.$effectif?>
                            </td>
                            <td>
                                 <?php $nonValides = $effectif-$nbre_moy;
                                 echo get_phrase('non_Validés : ' .$nonValides.' / '.$effectif );
                                 $absents = $effectif_total-$effectif;
                                echo  ';  Absents : '.$absents ;
                                 ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                $reussitePercentage = sprintf("%.2f",$nbre_moy/$effectif*100) ;
                                $echecPercentage = sprintf("%.2f",$nonValides/$effectif*100);
                                echo'% Reussite  :  '.$reussitePercentage.' %';
                                ?>
                            </td>
                            <td>
                                <?php
                                  echo'% Echec  :  '.$echecPercentage.' %';

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php $moyenne_classe = sprintf("%.2f",$somme_moyenne/$effectif) ;
                                echo'Moyenne de la classe : ' . $moyenne_classe ?>
                            </td> 
                        </tr> 
                    </tbody>
                </table>
<table style="width:35%; float: right; margin-right: 5px; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
                    <thead> <td colspan="2"style="background-color: rgba(252,194,59,0.7); text-align: center">Modules </td> </thead>
                    <tbody>
                        <?php
                       for($i=0; $i<count($subjects)-1; $i+=2 ){?>
                           <tr>
                            <td>
                                  <?php echo $subjects[$i]['code'].' '.$subjects[$i]['name']  ?>
                            </td>
                            <td>
                                  <?php echo $subjects[$i+1]['code'].' '.$subjects[$i]['name']  ?>
                            </td>
                        </tr>
                      <?php  } 
                        
                        ?>
                        
                    </tbody>
                </table>


                <script type="text/javascript">

                    jQuery(document).ready(function ($)
                    {
                        var elem = $('#print');
                        PrintElem(elem);
                        Popup(data);

                    });

                    function PrintElem(elem)
                    {
                        Popup($(elem).html());
                    }

                    function Popup(data)
                    {
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
