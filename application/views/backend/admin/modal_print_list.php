<?php

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-print"></i>
                    <?php echo get_phrase('Print_list'); ?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(site_url('admin/print_list/' . $param2 . '/' . $param3), 
                array('class' => 'form-horizontal form-groups-bordered validate')); ?>
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('class'); ?></label>

                    <div class="col-sm-9">
                        <select name="class_id" class="form-control selectboxit" onchange="return get_class_sections(this.value)">
                            <option value=""><?php echo get_phrase('select_class'); ?></option>
                            <?php
                            $class = $this->db->get_where('class')->result();
                            foreach ($class as $row2) :
                            ?>
                                <option value="<?php echo $row2->class_id; ?>" <?php if ($param2 == $row2->class_id) echo 'selected'; 
                                ?>><?php echo $row2->name; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <!--<input type="text" class="form-control" name="class" disabled
								value="<?php echo $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name; ?>">-->
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('section'); ?></label>

                    <div class="col-sm-5">
                        <select data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"
                         name="section_id" class="form-control" id="section_selector_holder">
                            <option value=""><?php echo get_phrase('select_section'); ?></option>
                            <?php
                            $sections = $this->db->get_where('section', array('class_id' => $param2))->result();
                            foreach ($sections as $row2) :
                            ?>
                                <option value="<?php echo $row2->section_id; ?>"
                                 <?php if ($param3 == $row2->section_id) echo 'selected'; ?>><?php echo $row2->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="field-3" class="col-sm-3 control-label">
                        <?php echo get_phrase('list'); ?></label>

                    <div class="col-sm-5">
                        <select name="list" class="form-control" >
                                <option value="1"><?php echo get_phrase('all_informations'); ?>
                                 </option>
                                 <option value="2"><?php echo get_phrase('name'); ?>
                                 </option>
                                 <option value="3"><?php echo get_phrase('moy'); ?>
                                 </option>
                        </select>
                    </div>
                </div>






                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('valider'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php
?>

<script type="text/javascript">
    function get_class_sections(class_id) {
        //alert(class_id);
        $.ajax({
            url: '<?php echo site_url('admin/get_class_section/'); ?>' + class_id,
            success: function(response) {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }
</script>