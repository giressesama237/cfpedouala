
<a  href="<?php echo site_url('admin/student_add'); ?>" class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('add_new_student'); ?>
</a>

<input type="text" value="<?=$class_id?>" id="class_id" hidden>
<input type="text" value="<?=$section_id?>" id="section_id" hidden>
<a href="<?php echo site_url('admin/student_add'); ?>" class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('view_student'); ?>
</a>
<a href="#" onclick="class_print_list(<?=$class_id?>,<?=$section_id?>)" class="btn btn-primary pull-right">
    <i class="glyphicon glyphicon-print"></i>
    <?php echo get_phrase('print'); ?>
</a>
<br><br><br>
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo site_url('admin/student_information/' . $class_id ); ?>" class="btn btn-<?php echo $section_id == '' ? 'primary' : 'default'; ?>">
                <?php echo 'All students'; ?>
            </a>
        <?php
        foreach ($section as $row) :
        ?>
            <a href="<?php echo site_url('admin/student_information/' . $class_id . '/' . $row->section_id); ?>" class="btn btn-<?php echo $section_id == $row->section_id ? 'primary' : 'default'; ?>">
                <?php echo 'Section ' . $row->name; ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" id="student_information">
			<thead>
        		<tr>
        			<th width="40"><div><?php echo get_phrase('id');?></div></th>
            		<th><div><?php echo get_phrase('student_code');?></div></th>
            		<th><div><?php echo get_phrase('folder');?></div></th>
                    <th><div><?php echo get_phrase('photo');?></div></th>
                    <th><div><?php echo get_phrase('Name');?></div></th>
                    <th><div><?php echo get_phrase('class');?></div></th>
                    <th><div><?php echo get_phrase('contact');?></div></th>
            		<th><div><?php echo get_phrase('options');?></div></th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$.fn.dataTable.ext.errMode = 'throw';
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        
        $('#student_information').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "<?php echo site_url('admin/get_students/') ?>"+class_id+"/"+section_id,
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                { "data": "student_id" },
                { "data": "student_id" },
                { "data": "student_id" },
                { "data": "photo" },
                { "data": "student" },
                { "data": "class" },
                { "data": "contact" },
                { "data": "options" },
            ],
            "columnDefs": [
            	{
					"targets": [1,3,4,6,7],
					"orderable": false
				},
			]
        });
	});

	
	function student_edit_modal(student_id) {
        showAjaxModal('<?php echo site_url('modal/popup/modal_student_edit/');?>' + student_id);
    }

    function student_delete_confirm(student_id,class_id) {
        confirm_modal('<?php echo site_url('admin/delete_student/');?>' + student_id+'/'+class_id);
    }
    function class_print_list(class_id,section_id) {
        showAjaxModal('<?php echo site_url('modal/popup/modal_print_list/');?>' + class_id+'/'+section_id);
    }
</script>