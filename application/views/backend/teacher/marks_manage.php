<hr />
<?php echo form_open(site_url('teacher/marks_selector'));?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo get_phrase('marks_manager') ?></h3>
    </div>
    <div class="panel-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
					<select name="exam_id" class="exam_id form-control selectboxit">
						<?php
							$exams = $this->db->get_where('exam' , array('year' => $running_year))->result_array();
							foreach($exams as $row):
						?>
						<option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
					<select name="class_id" class="form-control selectboxit class_id" onchange="get_class_sections(this.value)" >
						<option value=""><?php echo get_phrase('select_class');?></option>
						<?php
							$classes = $this->db->get('class')->result_array();
							foreach($classes as $row):
						?>
						<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
					<select name="section_id" id="section_selector_holder" class="section_id form-control" disabled="disabled" onchange="get_class_subject(this.value)">
						<option value=""><?php echo get_phrase('select_class_first');?></option>		
					</select>
				</div>
			</div>
			<div id="subject_holder">
				<div class="col-md-4">
					<div class="form-group">
					<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
						<select name="" id="" class="subject_id form-control selectboxit" disabled="disabled">
							<option value=""><?php echo get_phrase('select_section_first');?></option>		
						</select>
					</div>
				</div>
				<div class="col-md-2" style="margin-top: 20px;">
					<center>
						<button type="submit" class="btn btn-info" id = "submit"><?php echo get_phrase('manage_marks');?></button>
					</center>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close();?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#submit").attr('disabled', 'disabled');
	});
	function get_class_subject(section_id) {
		var class_id = $('.class_id').val();
		if (section_id !== '') {
		$.ajax({
            url: '<?php echo site_url('teacher/marks_get_subject/');?>' + class_id +'/'+section_id,
            success: function(response)
            {
                jQuery('#subject_holder').html(response);
            }
        });
        $('#submit').removeAttr('disabled');
	  }
	  else{
	  	$('#submit').attr('disabled', 'disabled');
	  }
	}
	function get_class_sections(class_id) {
		$.ajax({
			url: '<?php echo site_url('teacher/get_class_section/');?>' + class_id ,
			success: function(response)
			{
				$('#section_selector_holder').removeAttr('disabled');
				jQuery('#section_selector_holder').html(response);
			}
		});
	}
</script>