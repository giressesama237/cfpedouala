<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo get_phrase('select_class_exam') ?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(site_url('admin/tabulation_sheet')); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="loader"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('class'); ?></label>
                        <select required name="class_id" class="form-control" data-validate="required" id="class_id" data-message-required="<?php echo get_phrase('value_required'); ?>" onchange="return get_class_sections(this.value)">
                            <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                            <?php
                            $classes = $this->db->get('class')->result_array();
                            foreach ($classes as $row) :
                                ?>
                                <option value="<?php echo $row['class_id']; ?>" <?php if ($class_id == $row['class_id']) echo 'selected'; ?>>
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="field-2" class="control-label"><?php echo get_phrase('section'); ?></label>

                        <select required name="section_id" class="form-control section_id" data-validate="required" id="section_selector_holder" data-message-required="<?php echo get_phrase('value_required'); ?>">
                            <option value=""><?php echo get_phrase('select_class_first'); ?></option>
                            <?php
                            $sections = $this->db->get_where('section', array(
                                        'class_id' => $class_id
                                    ))->result_array();
                            foreach ($sections as $row) :
                                ?>
                                <option value="<?php echo $row['section_id']; ?>" <?php if ($section_id == $row['section_id']) echo 'selected'; ?>>
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"><?php echo get_phrase('exam'); ?></label>
                        <select required name="exam_id" class="form-control" data-validate="required" id="exam_id" data-message-required="<?php echo get_phrase('value_required'); ?>">
                            <option value=""><?php echo get_phrase('select_an_exam'); ?></option>
                            <?php
                            $exams = $this->db->get_where('exam', array('year' => $running_year))->result_array();
                            foreach ($exams as $row) :
                                ?>
                                <option value="<?php echo $row['exam_id']; ?>" <?php if ($exam_id == $row['exam_id']) echo 'selected'; ?>>
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>

                    </div>
                </div>
                <input type="hidden" name="operation" value="selection">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2 col-sm-3 col-6" style="margin-top: 20px;">
                    <button type="submit" id='submit' class="btn btn-info"><?php echo get_phrase('view_tabulation_sheet'); ?></button>
                </div>
                <div class="col-md-2 col-sm-3 col-6" style="margin-top: 20px;">
                    <button type="button" title="Generate Marks" id="generate_marks" class="btn btn-labeled btn-success"><span class="btn-label"><i class="glyphicon glyphicon-refresh"></i></span> <?php echo get_phrase('generate_marks'); ?></button>
                </div>
                <div class="col-md-2 col-6" style="margin-top: 20px;">
                    <a href="<?php echo site_url('admin/generate_top_20/' . $exam_id); ?>" class="btn btn-labeled btn-success" target="_blank"><span class="btn-label"><i class="glyphicon glyphicon-print"></i></span>
                        <?php echo get_phrase('print_top_moy'); ?>
                    </a>

                </div>
                <div class="col-md-2 col-sm-3 col-6" style="margin-top: 20px;">
                    <button type="button" title="<?php echo get_phrase('report_card') ?>" id="print_report_card" class="btn btn-labeled btn-success">
                        <span class="btn-label"><i class="glyphicon glyphicon-print"></i></span>
                        <?php echo get_phrase('report_card'); ?></button>
                </div>
                <div class="col-md-2 col-sm-3 col-6" style="margin-top: 20px;">
                    <div class="form-group">

                        <label class="control-label" for="start">Start</label>
                        <input class="form-control" type="number" min="1" name="start" id="start" placeholder="1">
                        <label class="control-label" for="limit">Limit</label>
                        <input class="form-control" type="number" min="1" name="limit" id="limit" placeholder="10">

                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>
</div>



<?php if ($class_id != '' && $exam_id != '') : ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4" style="text-align: center;">
            <div class="tile-stats tile-white">
                <div class="icon"><i class="entypo-docs"></i></div>
                <h3 style="color: #696969;">
                    <?php
                    $exam_name = $this->db->get_where('exam', array('exam_id' => $exam_id))->row()->name;
                    $class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
                    echo get_phrase('tabulation_sheet');
                    ?>
                </h3>
                <h4 style="color: #696969;">
                    <?php echo get_phrase('class') . ' ' . $class_name; ?> : <?php echo $exam_name; ?>
                </h4>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>


    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo get_phrase('tabulation_sheet') ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td rowspan="2" style="text-align: center;">
                                    <?php echo get_phrase('students'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects'); ?> <i class="entypo-right-thin"></i>
                                </td>
                                <?php
                                foreach ($subjects as $row) :
                                    ?>
                                    <td colspan="4" style="text-align: center;"><?php echo $row['name']; ?></td>

                                <?php endforeach; ?>
                                <td rowspan="2" style="text-align: center;"><?php echo 'Moy'; ?></td>
                                <td rowspan="2" style="text-align: center;"><?php echo 'Decision'; ?></td>


                            </tr>
                            <tr>

                                <?php
                                foreach ($subjects as $row) :
                                    ?>
                                    <td style="text-align: center;">CC</td>
                                    <td style="text-align: center;">EXAM</td>
                                    <td style="text-align: center;">Moy</td>
                                    <td style="text-align: center;">Decision</td>

                                <?php endforeach; ?>




                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //var_dump($obtained_mark_query);die();
                            ?>
                            <?php
                            //var_dump($students);die();
                            foreach ($students as $row) :
                                ?>
                                <tr>
                                    <td style="text-align: center;">
                                <?php echo $row['name'] . ' ' . $row['surname'] ?>
                                    </td>
                                        <?php
                                        $total_marks = 0;
                                        $total_grade_point = 0;
                                        $subject_cc = FALSE;
                                        $subject_exam = FALSE;
                                        foreach ($subjects as $row2) :
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
                                    <td><?php
                                        foreach ($mark_moy as $moy) {
                                            if ($moy->student_id == $row['student_id'] and !$subject_cc and !$subject_exam)
                                                echo $moy->moy;
                                        }
                                        ?></td>
                                    <td><?php
                                        foreach ($mark_moy as $moy) {

                                            if ($moy->student_id == $row['student_id']) {
                                                if ($moy->moy < 12 or $moy->moy == null or $subject_cc or $subject_exam)
                                                    echo '<b>NV</b>';
                                                else if ($moy->moy >= 12 and $moy->moy <= 20)
                                                    echo '<b>V</b>';
                                            }
                                        }
                                        ?></td>

                                </tr>

                                    <?php endforeach; ?>

                        </tbody>
                    </table>
                    <center>
                        <a href="<?php echo site_url('admin/tabulation_sheet_print_view/' . $class_id . '/' . $exam_id . '/' . $section_id); ?>" class="btn btn-primary" target="_blank">
    <?php echo get_phrase('print_tabulation_sheet'); ?>
                        </a>
                    </center>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<script type="text/javascript">
    function get_class_sections(class_id) {

        $.ajax({
            url: '<?php echo site_url('admin/get_class_section/'); ?>' + class_id,
            success: function (response) {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }
</script>
<script>
    /*$('#generate_marks').click(function() {
     class_id = $('#class_id').val();
     section_id = $('.section_id').val();
     exam_id = $('#exam_id').val();
     if (class_id != '' && section_id != '' && exam_id != '') {
     alert(class_id);
     alert(section_id);
     alert(exam_id);
     $.ajax({
     type: "POST",
     url: "<?php echo site_url('admin/generate_marks'); ?>",
     data: {
     class_id: class_id,
     exam_id: exam_id,
     section_id: section_id
     },
     success: function(data) {
     var response = JSON.parse(data);
     console.log(response);
     if (response.success) {
     window.location.reload(true);
     } else {
     alert("selectionner tous les champs");
     }
     
     }
     });
     } else {
     alert("selectionner tous les champs");
     
     }
     
     });*/
    $('#print_top_20').click(function () {
        class_id = $('#class_id').val();
        section_id = $('.section_id').val();
        exam_id = $('#exam_id').val();
        if (class_id != '' && section_id != '' && exam_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/generate_top_20'); ?>",
                data: {
                    class_id: class_id,
                    exam_id: exam_id,
                    section_id: section_id
                },
                success: function (data) {
                    var response = JSON.parse(data);
                    console.log(response);
                    if (response.success) {
                        window.location.reload(true);
                    } else {
                        alert("une erreur est survenue");
                    }

                }
            });
        }
    });
</script>
<script type="text/javascript">
    var class_id = '';
    var exam_id = '';
    var section_id = '';
    jQuery(document).ready(function ($) {
        $('#submit').attr('disabled', 'disabled');
        $('#print_report_card').attr('disabled', 'disabled');
        $('#generate_marks').attr('disabled', 'disabled');

        $('.loader').hide();
    });

    function check_validation() {

        if (section_id !== '') {
            $('#submit').removeAttr('disabled');
            $('#print_report_card').removeAttr('disabled');
            $('#generate_marks').removeAttr('disabled');
        } else {
            $('#submit').attr('disabled', 'disabled');
            $('#print_report_card').attr('disabled', 'disabled');
            $('#generate_marks').attr('disabled', 'disabled');
        }
    }
    $('#class_id').change(function () {
        class_id = $('#class_id').val();
        check_validation();
    });
    $('#exam_id').change(function () {
        exam_id = $('#exam_id').val();
        check_validation();
    });
    $('#section_selector_holder').change(function () {
        section_id = $('#section_selector_holder').val();
        check_validation();
    });
</script>
<script>
    /*$('#print_report_card').click(function() {
     class_id = $('#class_id').val();
     exam_id = $('#exam_id').val();
     section_id = $('#section_selector_holder').val();
     
     $('#print_report_card').attr('disabled', 'disabled');
     $('.loader').show();
     if (class_id != '' && exam_id != '') {
     alert(class_id);
     alert(exam_id);
     alert(section_id);
     
     
     $.ajax({
     type: "POST",
     url: "<?php echo site_url('admin/print_report_card'); ?>",
     data: {
     class_id: class_id,
     exam_id: exam_id,
     section_id: section_id,
     
     },
     success: function(data) {
     var response = JSON.parse(data);
     console.log(response);
     if (response.success) {
     //window.location.reload(true);
     $('.loader').hide();
     $('#print_report_card').removeAttr('disabled');
     
     
     } else {
     $('.loader').hide();
     $('#print_report_card').removeAttr('disabled');
     
     alert("erreur survenue");
     }
     
     }
     });
     } else {
     $('.loader').hide();
     alert("selectionner tous les champs");
     
     }
     });*/
</script>

<script>
    $('#generate_marks').click(function () {
        class_id = $('#class_id').val();
        section_id = $('.section_id').val();
        exam_id = $('#exam_id').val();
        $('#generate_marks').attr('disabled', 'disabled');
        $('.loader').show();

        if (class_id != '' && section_id != '' && exam_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/generate_marks'); ?>",
                data: {
                    class_id: class_id,
                    exam_id: exam_id,
                    section_id: section_id
                },
                success: function (data) {
                    var response = JSON.parse(data);
                    console.log(response);
                    if (response.success) {
                        $('.loader').hide();
                        $('#generate_marks').removeAttr('disabled');
                        toastr.success('<?php echo "success process" ?>');
                    } else {
                        $('#generate_marks').removeAttr('disabled');
                        toastr.error('<?php echo "An error has occured" ?>');

                    }

                }
            });
        } else {
            $('.loader').hide();
            toastr.error('<?php echo "Select all fields" ?>');
        }

    });
</script>

<script>
    $('#print_report_card').click(function () {
        class_id = $('#class_id').val();
        exam_id = $('#exam_id').val();
        section_id = $('.section_id').val();
        start = $('#start').val();
        limit = $('#limit').val();
        $('#print_report_card').attr('disabled', 'disabled');
        $('.loader').show();
        if (class_id != '' && exam_id != '' && section_id != '') {

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/print_report_card'); ?>",
                data: {
                    class_id: class_id,
                    exam_id: exam_id,
                    section_id: section_id,
                    start: start,
                    limit: limit

                },
                success: function (data) {
                    var response = JSON.parse(data);
                    console.log(response);
                    if (response.success) {
                        //window.location.reload(true);
                        $('.loader').hide();
                        $('#print_report_card').removeAttr('disabled');
                        toastr.success('<?php echo "success process" ?>');


                    } else {
                        $('.loader').hide();
                        $('#print_report_card').removeAttr('disabled');
                        toastr.error('<?php echo "An error has occured" ?>');
                    }

                }
            });
        } else {
            $('.loader').hide();
            toastr.error('<?php echo "Select all fields" ?>');

        }
    });
</script>