<script type="text/javascript">
    var cycle_value;
</script>
<div class="row">
    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#unpaid" data-toggle="tab">
                    <span class="hidden-xs"><?php echo get_phrase('create_single_invoice'); ?></span>
                </a>
            </li>
            <li>
                <a href="#paid" data-toggle="tab">
                    <span class="hidden-xs"><?php echo get_phrase('create_mass_invoice'); ?></span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <br>
            <div class="tab-pane active" id="unpaid">

                <!-- creation of single invoice -->
                <?php echo form_open(site_url('admin/invoice/create'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo get_phrase('invoice_informations'); ?></div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('cycle'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="cycle" id="cycle" class="form-control selectboxit cycle" onchange="cycle_value = this.value; return get_class_list(this.value);">
                                            <option value=""><?php echo get_phrase('select_cycle'); ?></option>
                                            <?php
                                            $cycles = $this->db->get_where('school_fees', array(
                                                'year' => $running_year
                                            ))->result_array();
                                            //$cycles = $this->db->get_where('school_fees'array('year'=>$running_year))->result_array();
                                            foreach ($cycles as $row) :
                                            ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('class'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="class_id" class="form-control class_id" id="class_list" onchange="return get_class_students(this.value)">
                                            <option value=""><?php echo get_phrase('select_class'); ?></option>


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('student'); ?></label>
                                    <div class="col-sm-9" id="student_holder">
                                        <select class="" name="student_id" id="student_id" disabled>
                                            <option value=""><?php echo get_phrase('select_a_class_first'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('payment'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="number" min="1" class="form-control" name="amount_paid" placeholder="<?php echo get_phrase('enter_payment_amount'); ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" />
                                    </div>
                                </div>

                                <!-- <div class="form-group">
		                                <label class="col-sm-3 control-label"><?php echo get_phrase('student'); ?></label>
		                                <div class="col-sm-9">
		                                    <select name="student_id" class="form-control" style="width:100%;" id="student_selection_holder" required>
		                                        <option value=""><?php echo get_phrase('select_student_first'); ?></option>
		                                    </select>
		                                </div>
		                            </div>-->

                                <!--<div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="title" class="form-control title" onchange="return get_class_fees(this.value)" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>">
                                            <option value=""><?php echo get_phrase('select_instalment'); ?></option>
                                            <option value="1"><?php echo get_phrase('first_instalment'); ?></option>
                                            <option value="2"><?php echo get_phrase('second_instalment'); ?></option>
                                            <option value="3"><?php echo get_phrase('third_instalment'); ?></option>
                                            <option value="5"><?php echo get_phrase('tutorials'); ?></option>
                                        </select>
                                    </div>
                                </div>-->
                                <!--<div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>
	                                    <div class="col-sm-9">
	                                        <input type="text" class="form-control" name="description"/>
	                                    </div>
	                                </div>-->

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="datepicker form-control" name="date" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-primary panel-shadow" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo get_phrase('payment_informations'); ?></div>
                            </div>
                            <div class="panel-body">
                                <!--<div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('total'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="amount" class="form-control" style="width:100%;" id="amount" disabled="" required>
                                            <option value=""><?php echo get_phrase('select_amount_first'); ?></option>
                                        </select>
                                    </div>
                                </div>-->





                                <!--<div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('status'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control selectboxit">
                                            <option value="paid"><?php echo get_phrase('paid'); ?></option>
                                            <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
                                        </select>
                                    </div>
                                </div>-->

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('method'); ?></label>
                                    <div class="col-sm-9">
                                        <select name="method" class="form-control selectboxit">
                                            <option value="1" disabled><?php echo get_phrase('cash'); ?></option>
                                            <option value="2" selected><?php echo get_phrase('bank'); ?></option>
                                            <option value="3" disabled><?php echo get_phrase('card'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('recu'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="bank_receipt" placeholder="<?php echo get_phrase('enter_bank_receipt'); ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-info submit"><?php echo get_phrase('add_invoice'); ?></button>
                            </div>
                        </div>
                    </div>


                </div>
                <?php echo form_close(); ?>

                <!-- creation of single invoice -->

            </div>
            <div class="tab-pane" id="paid">
                <?php echo form_open(
                    site_url('admin/bulk_student_payment_using_csv/import'),
                    array('class' => 'form-inline validate',   'enctype' => 'multipart/form-data')
                ); ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-primary " data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="fa fa-calendar"></i>
                                    <?php echo get_phrase('create_multiple_students_payments'); ?>
                                </div>
                            </div>
                            <div class="panel-body">
                                
                                <div class="row">
                                    
                                    <div class="col-md-offset-4 col-md-4" style="padding-bottom:15px;">
                                        <input type="file" name="userfile" class="form-control file2 inline btn btn-info" data-label="<i class='entypo-tag'></i> Select CSV File" data-validate="required" data-message-required="<?php echo get_phrase('required'); ?>" accept="text/csv, .csv" />
                                    </div>
                                    <div class="col-md-offset-4 col-md-4">
                                        <button type="submit" class="btn btn-success" name="import_csv" id="import_csv"><?php echo get_phrase('import_CSV'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <?php echo form_close(); ?>

                <!-- creation of mass invoice -->
                <!--<?php echo form_open(site_url('admin/invoice/create_mass_invoice'), array('class' => 'form-horizontal form-groups-bordered validate', 'id' => 'mass', 'target' => '_top')); ?>
                <br>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('class'); ?></label>
                            <div class="col-sm-9">
                                <select name="class_id" class="form-control class_id2" onchange="return get_class_students_mass(this.value)" required="">
                                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                                    <?php
                                    $classes = $this->db->get('class')->result_array();
                                    foreach ($classes as $row) :
                                    ?>
                                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="description" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('total'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="amount" placeholder="<?php echo get_phrase('enter_total_amount'); ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('payment'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="amount_paid" placeholder="<?php echo get_phrase('enter_payment_amount'); ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('status'); ?></label>
                            <div class="col-sm-9">
                                <select name="status" class="form-control selectboxit">
                                    <option value="paid"><?php echo get_phrase('paid'); ?></option>
                                    <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('method'); ?></label>
                            <div class="col-sm-9">
                                <select name="method" class="form-control selectboxit">
                                    <option value="1"><?php echo get_phrase('cash'); ?></option>
                                    <option value="2"><?php echo get_phrase('check'); ?></option>
                                    <option value="3"><?php echo get_phrase('card'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="datepicker form-control" name="date" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-5 col-sm-offset-3">
                                <button type="submit" class="btn btn-info submit2"><?php echo get_phrase('add_invoice'); ?></button>
                            </div>
                        </div>



                    </div>
                    <div class="col-md-6">
                        <div id="student_selection_holder_mass"></div>
                    </div>
                </div>
                <?php echo form_close(); ?>-->

                <!-- creation of mass invoice -->

            </div>

        </div>


    </div>
</div>

<script type="text/javascript">
    function select() {
        var chk = $('.check');
        for (i = 0; i < chk.length; i++) {
            chk[i].checked = true;
        }

        //alert('asasas');
    }

    function unselect() {
        var chk = $('.check');
        for (i = 0; i < chk.length; i++) {
            chk[i].checked = false;
        }
    }
</script>

<script type="text/javascript">
    function get_class_students(class_id) {
        if (class_id !== '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_class_students/'); ?>' + class_id,
                success: function(response) {
                    $('#student_holder').html(response);
                    $('#student_id').select2();
                    jQuery('#student_selection_holder').html(response);
                }
            });
        }
    }
</script>
<script type="text/javascript">
    function get_class_list(cycle) {
        //alert(cycle);
        if (cycle !== '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_class_list/'); ?>' + cycle,
                success: function(response) {
                    jQuery('#class_list').html(response);
                    //$('.submit').removeAttr('disabled');
                }
            });
        }
    }
</script>
<script type="text/javascript">
    function get_class_fees(tranche) {
        //alert('sdfsd');
        //jQuery('#amount').value('dffgfgf');
        var student_id = $('#student_id').val();
        //alert(student_id);
        if (tranche !== '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_class_fees/'); ?>' + tranche + '/' + cycle_value + '/' + student_id,
                success: function(response) {
                    jQuery('#amount').html(response);
                }
            });
        }
    }
</script>

<script type="text/javascript">
    var class_id = '';
    jQuery(document).ready(function($) {
        $('.submit').attr('disabled', 'disabled');
        $('#student_id').select2();
    });

    function get_class_students_mass(class_id) {
        if (class_id !== '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_class_students_mass/'); ?>' + class_id,
                success: function(response) {
                    jQuery('#student_selection_holder_mass').html(response);
                }
            });
        }
    }

    function check_validation() {
        if (class_id !== '') {
            $('.submit').removeAttr('disabled');
        } else {
            $('.submit').attr('disabled', 'disabled');
        }
    }
    $('.class_id').change(function() {
        class_id = $('.class_id').val();
        check_validation();
    });
</script>