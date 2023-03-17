
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs bordered">
		  	<li class="active">
		    	<a href="#tab1" data-toggle="tab">
			      <span>
			      	<?php echo get_phrase('students_of_class');?> <?php echo $this->db->get_where('class' , array('class_id' => $class_id_from))->row()->name;?>
			      </span>
		    </a>
		  </li>
		</ul>
		<div class="tab-content">
		  	<div class="tab-pane active" id="tab1" style="margin-top: 20px;">

		  		<table class="table table-bordered">
					<thead align="center">
						<tr>
							<td align="center"><?php echo get_phrase('N°');?></td >
							<td align="center"><?php echo get_phrase('name');?></td >
							<td align="center"><?php echo get_phrase('section');?></td >
							<td align="center"><?php echo get_phrase('id_no');?></td >
							<td align="center"><?php echo get_phrase('info');?></td >
							<td align="center"><?php echo get_phrase('options');?></td >
						</tr>
					</thead>
					<tbody>
					<?php 
					$count =1;
						/*$students = $this->db->get_where('enroll' , array(
							'class_id' => $class_id_from , 'year' => $running_year
						))->result_array();*/
							$this->db->select('s.*, e.year as running_year , e.class_id, e.section_id');
                            $this->db->join('enroll as e','e.student_id = s.student_id');

                            $this->db->select('p.title');
                            $this->db->join('payment as p','p.student_id = s.student_id');
                            


                            $this->db->where(array('e.class_id' => $class_id_from ,'e.section_id' => $section_id_from , 'e.year' => $running_year,'p.year' => $running_year));


                            $this->db->group_by('s.name, s.surname');
                            $this->db->order_by('s.name ASC');
                       		// $this->db->limit(50);
                            $students = $this->db->get('student as s')->result_array();
                            //var_dump($students);die();
							foreach($students as $row):
							$query = $this->db->get_where('enroll' , array(
								'student_id' => $row['student_id'],
									'year' => $promotion_year
								));
					?>
						<tr>
							<td align="left">
								<?php echo $count++?>
							</td>
							
							<td align="left">
								<?php echo $row['name'].' '.$row['surname']  ;?>
							</td>
							<td align="center">
								<?php if($row['section_id'] != '' && $row['section_id'] != 0)
										echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
								?>
							</td>
		                    <td align="center"><?php echo $this->db->get_where('student' , array(
		                            'student_id' => $row['student_id']
		                        ))->row()->student_code;?></td>
							<td align="center">
							<!--<button type="button" class="btn btn-default"
								onclick="showAjaxModal('<?php echo site_url('modal/popup/student_promotion_performance/'.$row['student_id'].'/'.$class_id_from);?>');">
								<i class="entypo-eye"></i> <?php echo get_phrase('view_academic_performance');?>
							</button>-->	
							</td>
							<td width="40%">
								<?php if($query->num_rows() < 1):?>
									<select class="form-control selectboxit" name="promotion_status_<?php echo $row['student_id'];?>" style="width: 50px;" id="promotion_status">
										<option value="<?php echo $class_id_to;?>">
											<?php echo get_phrase('enroll_to_class') ." - ". $this->crud_model->get_class_name($class_id_to);?>
										</option>
										<option value="<?php echo $class_id_from;?>">
											<?php echo get_phrase('enroll_to_class') ." - ". $this->crud_model->get_class_name($class_id_from);?>
									</select>
									<select  class="form-control hidden selectboxit" name="promotion_section_status_<?php echo $row['student_id'];?>" style="width: 40px;" id="promotion_section_status">
										<option value="<?php echo $section_id_to;?>">
										</option>
									</select>
								<?php endif;?>
								<?php if($query->num_rows() > 0):?>
									<button class="btn btn-success">
										<i class="entypo-check"></i> <?php echo get_phrase('student_already_enrolled');?>
									</button>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
				<center>
					<button type="submit" class="btn btn-success">
						<i class="entypo-check"></i> <?php echo get_phrase('promote_slelected_students');?>
					</button>
				</center>

		  	</div>
		</div>
				
	</div>
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