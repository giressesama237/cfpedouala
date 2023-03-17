
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
							<option value="<?php echo $row['exam_id'];?>"
								<?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
				<!--<div class="col-md-4">
					<div class="form-group">
					<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
						<select name="exam_id" class="form-control selectboxit" required>
							<?php
								$exams = $this->db->get_where('exam' , array('year' => $running_year))->result_array();
								foreach($exams as $row):
							?>
							<option value="<?php echo $row['exam_id'];?>"
								<?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>-->
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
						<select name="class_id" class="form-control selectboxit class_id" onchange="get_class_sections(this.value)" >
							<option value=""><?php echo get_phrase('select_class');?></option>
							<?php
								$classes = $this->db->get('class')->result_array();
								foreach($classes as $row):
							?>
							<option value="<?php echo $row['class_id'];?>"
								<?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
				<!--<div class="col-md-4">
					<div class="form-group">
					<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
						<select name="class_id" class="form-control selectboxit" onchange="get_class_subject(this.value)">
							<option value=""><?php echo get_phrase('select_class');?></option>
							<?php
								$classes = $this->db->get('class')->result_array();
								foreach($classes as $row):
							?>
							<option value="<?php echo $row['class_id'];?>"
								<?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>-->

			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
						<select name="section_id" id="section_selector_holder" class="section_id form-control" required onchange="get_class_subject(this.value)">
							<?php 
									$sections = $this->db->get_where('section' , array(
										'class_id' => $class_id 
									))->result_array();
									foreach($sections as $row):
								?>
								<option value="<?php echo $row['section_id'];?>" 
									<?php if($section_id == $row['section_id']) echo 'selected';?>>
										<?php echo $row['name'];?>
								</option>
							<?php endforeach;?>			
						</select>
					</div>
				</div>
				<div id="subject_holder">
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
							<select name="subject_id" id="" class="subject_id form-control selectboxit">
								<?php 
									$subjects = $this->db->get_where('subject' , array(
										'class_id' => $class_id ,'year'=>$year,'section_id'=>$section_id,'teacher_id'=>$teacher_id
									))->result_array();
									foreach($subjects as $row):
								?>
								<option value="<?php echo $row['subject_id'];?>"
									<?php if($subject_id == $row['subject_id']) echo 'selected';?>>
										<?php echo $row['name'];?>
								</option>
								<?php endforeach;?>		
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
			<!--<div class="row">
				<div id="subject_holder">
					<div class="col-md-3">
						<div class="form-group">
						<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
							<select name="section_id" id="section_id" class="form-control selectboxit"  onchange="get_session_subject(this.value)">
								<?php 
									$sections = $this->db->get_where('section' , array(
										'class_id' => $class_id 
									))->result_array();
									foreach($sections as $row):
								?>
								
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="session_subject_holder">
							<div class="form-group">
								<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
								<select name="subject_id" id="subject_id" class="form-control selectboxit">
									<?php 
									$subjects = $this->db->get_where('subject' , array(
										'class_id' => $class_id ,'section_id'=>$section_id,'teacher_id'=>$this->session->userdata('login_user_id'), 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description,
									))->result_array();
									foreach($subjects as $row):
										?>
										<option value="<?php echo $row['subject_id'];?>"
											<?php if($subject_id == $row['subject_id']) echo 'selected';?>>
											<?php echo $row['name'];?>
										</option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						
					</div>
					<div class="col-md-2" style="margin-top: 20px;">
						<center>
							<button type="submit" class="btn btn-info"><?php echo get_phrase('manage_marks');?></button>
						</center>
					</div>
				</div>
			</div>-->
	    </div>
	</div>
			
<?php echo form_close();?>

<div class="row" style="text-align: center;">
	<div class="col-sm-4"></div>
	<div class="col-sm-4">
		<div class="tile-stats tile-white">
			<div class="icon"><i class="entypo-chart-bar"></i></div>
			
			<h3 style="color: #696969;"><?php echo get_phrase('marks_for');?> <?php echo $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;?></h3>
			<h4 style="color: #696969;">
				<?php echo get_phrase('class');?> <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?> : 
				<?php echo get_phrase('section');?> <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;?> 
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('subject');?> : <?php echo $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;?>
			</h4>
		</div>
	</div>
	<div class="col-sm-4"></div>
</div>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		        <h3 class="panel-title"><?php echo get_phrase('setup_payment_information') ?></h3>
		    </div>
		    <div class="panel-body">
		    	<?php echo form_open(site_url('teacher/marks_update/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id));?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th><?php echo get_phrase('id');?></th>
							<th><?php echo get_phrase('name');?></th>
							<th><?php echo get_phrase('seq1 / 20');?></th>
							<th><?php echo get_phrase('seq2 / 20');?></th>
							<!--<th><?php echo get_phrase('exam / 40');?></th>-->
							<th><?php echo get_phrase('comment');?></th>
						</tr>
					</thead>
					<tbody>
					<?php
						$count = 1;
						/*$marks_of_students = $this->db->get_where('mark' , array(
							'class_id' => $class_id, 
								'section_id' => $section_id ,
									'year' => $running_year,
										'subject_id' => $subject_id,
											'exam_id' => $exam_id
						))->result_array();*/
						$this->db->select('s.name,s.surname,s.student_code,s.student_id,e.year,p.title,m.*');
					    $this->db->join('enroll as e','e.student_id = s.student_id'); 
					    $this->db->join('mark as m','m.student_id = s.student_id');
					    $this->db->join('payment as p','p.student_id = s.student_id');
					    $this->db->where(array('e.class_id' => $class_id , 'e.year' => $running_year, 'e.section_id'=>$section_id,'m.class_id' => $class_id,'m.section_id' => $section_id ,'p.year'=>$running_year,'m.year' => $running_year,'m.subject_id' => $subject_id,'m.exam_id' => $exam_id));
					    //$this->db->group_by('s.name, s.surname');
					    $this->db->order_by('s.name ASC');
					    $this->db->group_by('s.name, s.surname');
					    $marks_of_students = $this->db->get('student as s')->result_array();
						//var_dump($marks_of_students);die();
						foreach($marks_of_students as $row):
					?>
						<tr>
							<td><?php echo $count++;?></td>

	                        <td><?php echo $row['student_code']?></td>

							<td>
								<?php echo $row['name'].' '.$row['surname'] ;?>
							</td>
							<td>
								<input type="number" step="any" min="0" max="20" <?php if ($row['mark_obtained']!=null) {?>readonly <?php } ?> class="form-control note" name="marks_obtained_<?php echo $row['mark_id'];?>"
									value="<?php if ($row['mark_obtained']!=null) echo sprintf("%.2f", $row['mark_obtained']);?>">	
							</td>
							<td>
								<input type="number" step="any" min="0" max="20"<?php if ($row['test2']!=null) {?>readonly <?php } ?> class="form-control note" name="test2_<?php echo $row['mark_id'];?>"
									value="<?php if ($row['test2']!=null) echo sprintf("%.2f",$row['test2']);?>">	
							</td>
							<!--<td>
								<input type="text" class="form-control" name="exam_<?php echo $row['mark_id'];?>"
									value="<?php echo $row['exam'];?>">	
							</td>-->
							<td>
								<input type="text" class="form-control" name="comment_<?php echo $row['mark_id'];?>"
									value="<?php echo $row['comment'];?>">
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>

				<center>
					<button type="submit" class="btn btn-success" id="submit_button">
						<i class="entypo-check"></i> <?php echo get_phrase('save_changes');?>
					</button>
				</center>
				<?php echo form_close();?>
		    </div>
		</div>
				
		
	</div>
	<div class="col-md-1"></div>
</div>





<script type="text/javascript">
	
	var subject_id = $('.subject_id').val();
	
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
<script>
	if(subject_id!=''){
		
		$('#submit').removeAttr('disabled');
	}
</script>
<script type="text/javascript">
	var error = new Object();
	var name = '';
	$(document).ready(function(){
		$(".note").on('input' ,function(){
		if(this.value >20){
			alert("mark must be inferior.");
			//this.value="";
			name = this.name;
			error[name] = true;
			console.log(error);
			this.style.background='red';
		}else{
			name = this.name;
			error[name] = false;
			console.log(error);
			this.style.background='white';
		}
		var values = Object.values(error);
		if (values.includes(true))
			$('#submit_button').attr('disabled', 'disabled');
		else
			$('#submit_button').removeAttr('disabled');

		});
	});

</script>