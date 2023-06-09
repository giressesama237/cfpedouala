<hr />
<div class="row">
    <div class="col-md-12">

        <!---CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i>
                    <?php echo get_phrase('subject_list');?>
                        </a></li>
            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_subject');?>
                        </a></li>
        </ul>
        <!---CONTROL TABS END------>
        <div class="tab-content">
        <br>
            <!---TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered datatable" id="">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('section');?></div></th>
                            <th><div><?php echo get_phrase('module');?></div></th>
                            

                            <th><div><?php echo get_phrase('code');?></div></th>
                            <th><div><?php echo get_phrase('type');?></div></th>
                            <th><div><?php echo get_phrase('teacher');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;
                                            foreach($subjects as $row):?>
                        <tr>
                            <td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
                            <td><?php echo $this->crud_model->get_type_name_by_id('section',$row['section_id']);?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['code'];?></td>
                            <td><?php if ($row['type_id'] == 1) {
                                echo "TC GENERAUX";
                                }
                                if ($row['type_id'] == 2) {
                                echo "TC TECHNNIQUE";
                                }
                                if ($row['type_id'] == 3) {
                                echo "PROFESSIONNEL";
                                }
                                 ?></td>
                            <td><?php echo $this->crud_model->get_type_name_by_id('teacher',$row['teacher_id']).' '. $this->db->get_where('teacher',array('teacher_id'=>$row['teacher_id']))->row()->surname;?></td>
                            <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_edit_subject/'.$row['subject_id']);?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>

                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo site_url('admin/subject/delete/'.$row['subject_id'].'/'.$class_id);?>');">
                                            <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete');?>
                                            </a>
                                                    </li>
                                </ul>
                            </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->


            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(site_url('admin/subject/create') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    <div class="padded">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('module');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('code');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="code" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('subject_coef');?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="coef" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('subject_type');?></label>
                                <div class="col-sm-9">
                                    <select name="type_id" class="form-control select2" style="width:100%;" required>
                                        <option value=""><?php echo get_phrase('select_type'); ?></option>
                                        <?php
                                        $type = $this->db->get('subject_type')->result_array();
                                        foreach($type as $row):
                                            ?>
                                            <option value="<?php echo $row['type_id'];?>"
                                                <?php if($row['type_id'] == $type_id) echo 'selected';?>>
                                                <?php echo $row['libelle'];?>
                                            </option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            

                        

                             <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                                <div class="col-sm-9">
                                    <select name="class_id" onchange="return get_class_sections(this.value)" class="form-control select2" style="width:100%;" required>
                                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                                        <?php
                                        $classes = $this->db->get('class')->result_array();
                                        foreach($classes as $row):
                                        ?>
                                            <option value="<?php echo $row['class_id'];?>"
                                                <?php if($row['class_id'] == $class_id) echo 'selected';?>>
                                                    <?php echo $row['name'];?>
                                            </option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('section');?></label>
                                <div class="col-sm-9">
                                    <select name="section_id" class="form-control" id="section_selector_holder">
                                        <?php
                                        $section = $this->db->get_where('section',array('class_id'=>$class_id))->result_array();
                                        foreach($section as $row):
                                            ?>
                                            <option value="<?php echo $row['section_id'];?>">
                                                <?php echo $row['name'];?>
                                            </option>
                                            <?php
                                        endforeach;
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('teacher');?></label>
                                <div class="col-sm-9">
                                    <select name="teacher_id" class="form-control select2" style="width:100%;" required>
                                        <option value=""><?php echo get_phrase('select_teacher');?></option>
                                        <?php
                                        $teachers = $this->db->get('teacher')->result_array();
                                        foreach($teachers as $row):
                                        ?>
                                            <option value="<?php echo $row['teacher_id'];?>"
                                                <?php if($row['teacher_id'] == $teacher_id) echo 'selected';?>>
                                                <?php echo $row['name'].' '. $row['surname'];?>
                                                    
                                                </option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                            
                           
                        </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_subject');?></button>
                              </div>
                           </div>
                    </form>
                </div>
            </div>
            <!----CREATION FORM ENDS-->

        </div>
    </div>
</div>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var datatable = $("#table_export").dataTable();
    });

</script>
<script type="text/javascript">

    function get_class_sections(class_id) {

        $.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }

</script>
