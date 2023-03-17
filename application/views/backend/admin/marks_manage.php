<?php echo form_open(site_url('admin/marks_selector')); ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo get_phrase('marks_manager') ?></h3>
	</div>
	<div class="panel-body">
		<div class="row">


			<div class="col-md-4">
				<div class="form-group">

					<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam'); ?></label>
					<select name="exam_id" class="exam_id form-control selectboxit" id="exam_id">
						<?php
						$exams = $this->db->get_where('exam', array('year' => $running_year))->result_array();
						foreach ($exams as $row) :
						?>
							<option value="<?php echo $row['exam_id']; ?>"><?php echo $row['name']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class'); ?></label>
					<select name="class_id" id="class_id" class="form-control selectboxit class_id" onchange="return get_class_sections(this.value)">
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



		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="loader"></div>

			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section'); ?></label>
					<select name="section_id" id="section_selector_holder" class="section_id form-control" disabled="disabled" onchange="get_class_subject(this.value)">
						<option value=""><?php echo get_phrase('select_class_first'); ?></option>
					</select>
				</div>
			</div>
			<div id="subject_holder">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject'); ?></label>
						<select name="" id="subject_id" class="subject_id form-control selectboxit" disabled="disabled">
							<option value=""><?php echo get_phrase('select_section_first'); ?></option>
						</select>
					</div>
				</div>
				<div class="col-md-2" style="margin-top: 20px;">
					<center>
						<button type="submit" class="btn btn-info" id="submit"><?php echo get_phrase('manage_marks'); ?></button>
					</center>
				</div>

				<div class="col-md-2" style="margin-top: 20px;">
					<center>
						<button type="button" onclick="get_class_list()" class="btn btn-info"><?php echo get_phrase('report_list'); ?></button>
					</center>
				</div>
				<div id="report_list">

				</div>

			</div>

		</div>
	</div>
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#submit").attr('disabled', 'disabled');
		$(".loader").hide();
	});

	function get_class_subject(section_id) {
		var class_id = $('.class_id').val();
		if (section_id !== '') {
			$.ajax({
				url: '<?php echo site_url('admin/marks_get_subject/'); ?>' + class_id + '/' + section_id,
				success: function(response) {
					jQuery('#subject_holder').html(response);
				}
			});
			$('#submit').removeAttr('disabled');
		} else {
			$('#submit').attr('disabled', 'disabled');
		}
	}

	function get_class_sections(class_id) {

		$.ajax({
			url: '<?php echo site_url('admin/get_class_section/'); ?>' + class_id,
			success: function(response) {
				$('#section_selector_holder').removeAttr('disabled');
				jQuery('#section_selector_holder').html(response);
			}
		});

	}

	function get_class_list() {
		var class_id = $('.class_id').val();
		var section_id = $('.section_id').val();
		var exam_id = $('.exam_id').val();
		var subject_id = $('.subject_id').val();
		//alert(section_id);
		$.ajax({
			url: '<?php echo site_url('admin/get_report_list/'); ?>' + class_id + '/' + section_id + '/' + exam_id + '/' + subject_id,
			success: function(response) {
				jQuery('#report_list').html(response);
			}
		});

	}
</script>

<script type="text/javascript">
	$('#print_marks').click(function() {
		class_id = $('#class_id').val();
		exam_id = $('#exam_id').val();
		section_id = $('#section_selector_holder').val();
		subject_id = $('#subject_id').val();


		$('.loader').show();
		if (class_id != '' && exam_id != '' && section_id != '' && subject_id != '') {
			alert(class_id);
			alert(exam_id);
			alert(section_id);
			alert(subject_id);


			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admin/print_marks'); ?>",
				data: {
					class_id: class_id,
					exam_id: exam_id,
					section_id: section_id,
					subject_id: subject_id,

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
	});
</script>