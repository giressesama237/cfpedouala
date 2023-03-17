
<div class="col-md-4">
	<div class="form-group">
	<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
		<select name="subject_id" id="subject_id" class="form-control selectboxit">
			<?php
				$subjects = $this->db->get_where('subject' , array(
					'class_id' => $class_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description,
						'teacher_id' => $this->session->userdata('teacher_id'),'section_id'=>$section_id
				))->result_array();
				//var_dump($subjects);die();
				foreach($subjects as $row):
			?>
			<option value="<?php echo $row['subject_id'];?>"><?php echo $row['name'];?></option>
			<?php endforeach;?>
		</select>
	</div>
</div>

<div class="col-md-2" style="margin-top: 20px;">
	<center>
		<button type="submit" class="btn btn-info"><?php echo get_phrase('manage_marks');?></button>
	</center>
</div>




<script type="text/javascript">
	$(document).ready(function() {
        if($.isFunction($.fn.selectBoxIt))
		{
			$("select.selectboxit").each(function(i, el)
			{
				var $this = $(el),
					opts = {
						showFirstOption: attrDefault($this, 'first-option', true),
						'native': attrDefault($this, 'native', false),
						defaultText: attrDefault($this, 'text', ''),
					};

				$this.addClass('visible');
				$this.selectBoxIt(opts);
			});
		}
    });

</script>
<script type="text/javascript">
	function get_session_subject(section) {
		
	if (section !== '') {
	$.ajax({
            url: '<?php echo site_url('teacher/marks_get_session_subject/');?>' + section ,
            success: function(response)
            {
                jQuery('#session_subject_holder').html(response);
            }
        });
	  }
	}
</script>
