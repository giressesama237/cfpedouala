<?php
$nbre_moy =0;
$somme_moyenne =0;
$class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
$exam_name  		= 	$this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
$admin_id= $this->session->userdata('admin_id');
$running_year       =   $this->db->get_where('session', array('admin_id'=>$admin_id))->row()->year;
?>
<div id="print">
	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<style type="text/css">
		td {
			padding: 5px;
		}
	</style>

	<center>
		<img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height : 60px;"><br>
		<h3 style="font-weight: 100;"><?php echo $system_name;?></h3>
		<?php echo get_phrase('tabulation_sheet');
			$section_name       =   $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
		?><br>
		<?php echo get_phrase('class') . ' ' . $class_name . ' '.$section_name ;?><br>
		<?php echo $exam_name;
		
		?>



	</center>


	<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
		<thead>
			<tr>
				<td rowspan="2" style="text-align: center;">
					N°
				</td>
				<td rowspan="2" style="text-align: center;">
					<?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects');?> <i class="entypo-right-thin"></i>
				</td>
				<?php 
				
				foreach($subjects as $row):
					?>
					<td colspan="2" style="text-align: center;"><?php echo $row['name'];?></td>
				<?php endforeach;?>
				<td rowspan="2" style="text-align: center;"><?php echo "moy";?></td>

			</tr>
			<tr>

				<?php
				foreach($subjects as $row):
					?>
					<?php if ($exam_name == 'FIRST TERM') {?>
						<td style="text-align: center;">Seq 1</td>
						<td style="text-align: center;">Seq 2</td>
						<?php
					}?>
					<?php if ($exam_name == 'SECOND TERM') {?>
						<td style="text-align: center;">Seq 3</td>
						<td style="text-align: center;">Seq 4</td>
						<?php
					}?>
					<?php if ($exam_name == 'THIRD TERM') {?>
						<td style="text-align: center;">Seq 5</td>
						<td style="text-align: center;">Seq 6</td>
						<?php
					}?>
				<?php endforeach;?>
				
			</tr>
		</thead>
		<tbody>
			
			<?php
			$count = 1;
			foreach($students as $row):
				?>
				<tr>
					<td style="text-align: center;">
						<?php echo $count++ ?>
					</td>
					<td style="text-align: left;">
						<?php echo $row['name'].' '. $row['surname']?>
					</td>
					<?php
					$total_marks = 0;
					$total_grade_point = 0;  
					foreach($subjects as $row2):
						?>
						<td style="text-align: center;">
							<?php 
							foreach ($obtained_mark_query as $marks) :
								if ( ($marks['subject_id'] == $row2['subject_id'])&&($marks['student_id'] == $row['student_id'])) {

									echo $marks['mark1'];
								}
							endforeach;
							?>
						</td>
						<td style="text-align: center;">
							<?php 
							foreach ($obtained_mark_query as $marks) :
								if ( ($marks['subject_id'] == $row2['subject_id'])&&($marks['student_id'] == $row['student_id'])) {
									echo $marks['mark2'];
								}
							endforeach;
							?>
						</td>
					<?php endforeach;?>
					<td>
						<?php 
							foreach ($marks_moy as $student_moy):
								if($student_moy['student_id'] == $row['student_id']){
									echo $moy = sprintf("%.2f",$student_moy['moy']);
									$somme_moyenne += $moy;
									if ($moy>=10.00) {
										$nbre_moy++;
									}
								}
							endforeach;
						?>

					</td>

				</tr>

			<?php endforeach;?>
		</tbody>
	</table>
</div>
<table style="width:50%; float: left; margin-right: 20px; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
    <thead></thead>
    <tbody>
        <tr>
            <td>
                <center><h4 style="text-align: center; background-color: gray;">
                    <?php
                    if($lang=='en') {echo get_phrase('class_profile');} else {echo get_phrase('profil_de_la_classe') ;}
                   // echo get_phrase('disciplinary_report');
                ?></h4>
            </center>
            <?php 
            $highest = sprintf("%.2f",$marks_moy[0]['moy']);
            $k = sizeof($marks_moy)-1;
            $lowest = sprintf("%.2f",$marks_moy[$k]['moy']);
            if($lang=='en') {echo get_phrase('highest_AVG');} 
            else {echo get_phrase('plus_forte_note') ;}?> : 
            <?php 
            echo $highest; ?> <br>
            <?php
            if($lang=='en') {echo get_phrase('lowest_AVG');} 
            else {echo get_phrase('plus_faible_note') ;}?> :
            <?php 
            echo $lowest; 
            ?>
            <br>
            <?php
            if($lang=='en') {echo get_phrase('number_of_AVG');} 
            else {echo get_phrase('nombre_de_moyennes') ;}?> :
            <?php 
            echo ($nbre_moy.'/'.($k+1)); 
            ?>
            <br>
            <?php
            if($lang=='en') {echo get_phrase('success_rate');} 
            else {echo get_phrase('pourcentage') ;}?> :
            <?php 
            echo (sprintf("%.2f",$nbre_moy*100/($k+1)).'%'); 
            ?>
            <br>
            <?php
            if($lang=='en') {echo get_phrase('class_AVG');} 
            else {echo get_phrase('moyenne_de_la_classe') ;}?> :
            <?php 
            echo sprintf("%.2f",$moy_class = $somme_moyenne/($k+1)); 
            ?>

        </td>

    </tr>
</tbody>
</table>
<table style="width:30%;  margin-right: 20px; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
    <thead></thead>
    <tbody>
        <tr>
            <td colspan="2">
                <center><h4 style="text-align: center; background-color: gray;">
                    <?php
                    if($lang=='en') {echo get_phrase('sex_profile');} else {echo get_phrase('profil_de_la_classe') ;}
                   // echo get_phrase('disciplinary_report');
                ?></h4>
            </center>
            
        </td>

    </tr>
    <tr>
    	<td>
    		<?php 
            $garcons_passed = 0;
            foreach ($garcons as $garcon){
            	if ($garcon->moy>=10.00){
            		$garcons_passed++;
            	}
            }
            if($lang=='en') {echo get_phrase('boys');} 
            else {echo get_phrase('garcons') ;}?> : 
            <?php 
            echo count($garcons); ?> <br>
            <?php
            if (count($garcons)>0) {
            	if($lang=='en') {echo get_phrase('passed');} 
            else {echo get_phrase('passés') ;}?> :
            <?php 
            echo ($garcons_passed . ' / '.count($garcons));  
            ?>
            <br>
            <?php
            if($lang=='en') {echo get_phrase('percentage');} 
            else {echo get_phrase('pourcentage') ;}?> :
            <?php 
            
            echo (sprintf("%.2f",$garcons_passed*100/count($garcons)).'%'); 

            }
            
            ?>
            
           

    	</td>
    	<td>
    		<?php 
            $filles_passed = 0;
            foreach ($filles as $fille){
            	if ($fille->moy>=10.00){
            		$filles_passed++;
            	}
            }
            if($lang=='en') {echo get_phrase('girls');} 
            else {echo get_phrase('filles') ;}?> : 
            <?php 
            echo count($filles); ?> <br>
            <?php
            if (count($filles)>0) {
            	if($lang=='en') {echo get_phrase('passed');} 
            else {echo get_phrase('passés') ;}?> :
            <?php 
            echo ($filles_passed . ' / '.count($filles));  
            ?>
            <br>
            <?php
            if($lang=='en') {echo get_phrase('percentage');} 
            else {echo get_phrase('pourcentage') ;}?> :
            <?php 
            
            echo (sprintf("%.2f",$filles_passed*100/count($filles)).'%'); 
            }
            
            ?>
            
           

    	</td>
    </tr>
</tbody>
</table>

<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		var elem = $('#print');
		PrintElem(elem);
		Popup(data);

	});

	function PrintElem(elem)
	{
		Popup($(elem).html());
	}

	function Popup(data)
	{
		var mywindow = window.open('', 'my div', 'height=400,width=600');
		mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
