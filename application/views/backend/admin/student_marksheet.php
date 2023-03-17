<style>
    .exam_chart {
        width           : 100%;
        height      : 265px;
        font-size   : 11px;
    }
    
</style>

<?php 
$student_info = $this->crud_model->get_student_info($student_id);
$exams         = $this->crud_model->get_exams();
$subject_test1 = FALSE;
$subject_test2 = FALSE;
$subject_exam = FALSE;
foreach ($student_info as $row1):
    foreach ($exams as $row2):
        //$query = $this->db->get_where('mark_moy' , array('class_id' => $class_id, 'student_id'=>$student_id, 'exam_id'=>$row2['exam_id'],'year'=>$running_year));

        $marks = $this->db->get_where('mark' , array(
            'exam_id' => $row2['exam_id'],
            'class_id' => $class_id,
            'section_id' => $section_id,
            'student_id' => $student_id , 
            'year' => $running_year))->result_array();
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary panel-shadow" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo $row2['name'];?></div>
                        </div>
                        <div class="panel-body">


                           <div class="col-md-6">
                               <table class="table table-bordered">
                                   <thead>

                                    <tr>
                            <td style="text-align: center;">Disciplines</td>
                            <td style="text-align: center;">Seq 1 /20</td>
                            <td style="text-align: center;">Seq 2 /20</td>
                            <td style="text-align: center;">Total</td>
                            <td style="text-align: center;">Moy /20</td>
                            <td style="text-align: center;">Coef</td>                            
                            <td style="text-align: center;">Total</td>
                            <td style="text-align: center;">Comment</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                           
                                $total_marks = 0;
                                $marks_coef = 0;
                                $total_coef = 0;
                                $total_grade_point = 0;
                                
                                foreach ($subjects as $row3):
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $row3['name'];?></td>
                                        <td style="text-align: center;">
                                            <?php
                                            foreach ($marks as $row4) {
                                                if ($row4['subject_id']==$row3['subject_id']) { 
                                                    if(!empty($row4['mark_obtained'])){
                                                        echo $row4['mark_obtained'];
                                                        $subject_test1 = TRUE;
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php
                                            foreach ($marks as $row4) {
                                                if ($row4['subject_id']==$row3['subject_id']) { 
                                                    if(!empty($row4['test2'])){
                                                        echo $row4['test2'];
                                                        $subject_test2 = TRUE;
                                                    }
                                               
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php 
                                            
                                                foreach ($marks as $row4) {
                                                    if ($row4['subject_id']==$row3['subject_id']) { 
                                                        echo $c= $row4['test2']  + $row4['mark_obtained'];
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php 
                                                foreach ($marks as $row4) {
                                                    if ($row4['subject_id']==$row3['subject_id']) { 
                                                    if ( !empty($row4['test2']) AND !empty($row4['mark_obtained'])) {      
                                                        echo  $total = ( $row4['test2']  + $row4['mark_obtained'])/2;
                                                    }
                                                    elseif (empty($row4['mark_obtained']) AND !empty($row4['test2'])) {
                                                        echo $total = ($row4['test2'] );
                                                    }
                                                    elseif (empty($row4['test2']) AND !empty($row4['mark_obtained'])) {
                                                        echo $total = ($row4['mark_obtained'] );
                                                    }elseif (empty($row4['test2']) AND empty($row4['mark_obtained'])) {
                                                        $total=null;
                                                    }
                                                    
                                                }
                                            }
                                            
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php
                                            if (($subject_test1==TRUE || $subject_test2==TRUE)) {
                                               echo $row3['coef'];
                                               $total_coef += $row3['coef'];
                                           }
                                           $subject_test1=FALSE;
                                           $subject_test2=FALSE;
                                           $subject_exam=FALSE;
                                           ?>
                                       </td>
                                       <td style="text-align: center;">
                                        <?php 
                                        
                                            foreach ($marks as $row4) {
                                                if ($row4['subject_id']==$row3['subject_id']) { 
                                                $marks_coef = $total*$row3['coef'];
                                                echo  $marks_coef;
                                                $total_marks += $marks_coef;
                                            }

                                        }
                                        ?>
                                    </td>
                                
                                <td style="text-align: center;">
                                    <?php if($marks) 
                                    echo $row4['comment'];
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <hr />

                <?php echo get_phrase('total_marks');?> : <?php echo $total_marks;?>
                <br>
                <?php echo get_phrase('average_grade_point');?> : 
                <?php 
                
                if ($total_coef!=0) {
                  echo $moy= sprintf("%.2f", $total_marks/$total_coef)+0.001;
                /*if($query->num_rows() < 1) {
                  $moy_info = array('class_id' => $class_id,'section_id'=>$section_id, 'student_id'=>$student_id, 'exam_id'=>$row2['exam_id'],'moy'=>$moy,'year'=>$running_year);
                  $this->db->insert('mark_moy', $moy_info);
              }else{
                $query2 = $query->result_array();
                $mark_id = $query2[0]['mark_id'];
                $this->db->where('mark_id' , $mark_id);
                $this->db->update('mark_moy' , array('class_id' => $class_id, 'section_id'=>$section_id,'student_id'=>$student_id, 'exam_id'=>$row2['exam_id'],'moy'=>$moy,'year'=>$running_year));
            }*/
        }

        ?>

        <br> <br>
        <form  action="<?php echo site_url('admin/student_marksheet_print_view/'.$row2['exam_id'].'/'.$student_id.'/');?>" method="post">
                    <!--<a href="<?php echo site_url('admin/student_marksheet_print_view/'.$student_id.'/'.$row2['exam_id'].'/'.'en');?>" 
                        class="btn btn-primary" target="_blank">
                        <?php echo get_phrase('print_marksheet');?>
                    </a>
                    <a href="<?php echo site_url('admin/student_marksheet_print_view/'.$student_id.'/'.$row2['exam_id'].'/'.'fr');?>" 
                        class="btn btn-primary" target="_blank">
                        <?php echo get_phrase('print_marksheet_fr');?>
                    </a>-->
                    <input type="checkbox"  name="sum">
                    <label for="sum"> Add Summary</label><br>
                    <input type="checkbox" id="lang" name="lang" >
                    <label for="lang"> French</label><br>
                    <button type="submit" id="" class="btn btn-primary" target="_blank">  <?php echo get_phrase('print_marksheet');?></button>
                </form>
            </div>

            <div class="col-md-6">
               <div id="chartdiv<?php echo $row2['exam_id'];?>" class="exam_chart"></div>
               <script type="text/javascript">
                var chart<?php echo $row2['exam_id'];?> = AmCharts.makeChart("chartdiv<?php echo $row2['exam_id'];?>", {
                    "theme": "none",
                    "type": "serial",
                    "dataProvider": [
                    <?php 
                    foreach ($subjects as $subject) :
                        ?>
                        {
                            "subject": "<?php echo $subject['name'];?>",
                            "mark_obtained": 
                            <?php
                            $obtained_mark = $this->crud_model->get_obtained_marks( $row2['exam_id'] , $class_id , $subject['subject_id'] , $row1['student_id']);
                            echo $obtained_mark;
                            ?>,
                            "mark_highest": 
                            <?php
                            $highest_mark = $this->crud_model->get_highest_marks( $row2['exam_id'] , $class_id , $subject['subject_id'] );
                            echo $highest_mark;
                            ?>
                        },
                        <?php 
                    endforeach;

                    ?>

                    ],
                    "valueAxes": [{
                        "stackType": "3d",
                        "unit": "%",
                        "position": "left",
                        "title": "Obtained Mark vs Highest Mark"
                    }],
                    "startDuration": 1,
                    "graphs": [{
                        "balloonText": "Obtained Mark in [[category]]: <b>[[value]]</b>",
                        "fillAlphas": 0.9,
                        "lineAlpha": 0.2,
                        "title": "2004",
                        "type": "column",
                        "fillColors":"#7f8c8d",
                        "valueField": "mark_obtained"
                    }, {
                        "balloonText": "Highest Mark in [[category]]: <b>[[value]]</b>",
                        "fillAlphas": 0.9,
                        "lineAlpha": 0.2,
                        "title": "2005",
                        "type": "column",
                        "fillColors":"#34495e",
                        "valueField": "mark_highest"
                    }],
                    "plotAreaFillAlphas": 0.1,
                    "depth3D": 20,
                    "angle": 45,
                    "categoryField": "subject",
                    "categoryAxis": {
                        "gridPosition": "start"
                    },
                    "exportConfig":{
                        "menuTop":"20px",
                        "menuRight":"20px",
                        "menuItems": [{
                            "format": 'png'   
                        }]  
                    }
                });
            </script>
        </div>

    </div>
</div>  
</div>
</div>
<?php
endforeach;
endforeach;
?>