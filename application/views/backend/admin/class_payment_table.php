<?php
 $cycle = $this->db->get_where('class_cycle', array('class_id' =>$class_id,'year'=>$running_year))->row()->cycle;
$fees = $this->db->get_where('school_fees', array('cycle' =>$cycle,'year'=>$running_year))->row();
?>
<h4 class="text-muted" style="margin-bottom: 20px;">
	<?php echo get_phrase('payment_history_for'); ?> <?php echo $class_id; $pay=1;$order=0; ?><a target="_blank" href="<?php echo site_url('admin/print_class_payment/'.$class_id.'/'.$section_id.'/'.$running_year.'/'.$pay.'/'.$order);?>" class="btn btn-<?php echo $inner == 'class_payment_view' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('print_list_paid_order_name');?></a>
            <a target="_blank" href="<?php $pay=1;$order=1; echo site_url('admin/print_class_payment/'.$class_id.'/'.$section_id.'/'.$running_year.'/'.$pay.'/'.$order);?>" class="btn btn-<?php echo $inner == 'class_payment_view' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('print_list_paid_order_code');?></a>
            <a target="_blank" href="<?php echo site_url('admin/print_class_payment/'.$class_id.'/'.$section_id.'/'.$running_year.'/'.$pay=0);?>" class="btn btn-<?php echo $inner == 'class_payment_view' ? 'primary' : 'default'; ?>">
            <?php echo get_phrase('print_list_unpaid');?></a>
</h4>

<table class="table table-bordered" id="student_payments">
	<thead>
        <tr>
            <th width="40"><div><?php echo get_phrase('N');?></div></th>
            <th><div><?php echo get_phrase('Matricule');?></div></th>
            <th><div><?php echo get_phrase('nom');?></div></th>
            <th><div><?php echo get_phrase('prenom');?></div></th>
            <!--<th><div><?php echo get_phrase('inscription');?></div></th>-->
            <th><div><?php echo get_phrase('tranche1');?></div></th>
            <th><div><?php echo get_phrase('tranche2');?></div></th>
            <th><div><?php echo get_phrase('tranche3');?></div></th>
            <?php
                if( !is_null($fees->tutorials)){?>
                    <th><div><?php echo get_phrase('Travaux_dirigés');?></div></th>
                <?php
                }
            ?>
        </tr>
    </thead>
    <tbody>
    	<?php 
    	$this->db->select('s.name,s.surname,s.student_code,s.student_id');
	    $this->db->join('enroll as e','e.student_id = s.student_id'); 
	    //$this->db->where(array('e.class_id' => $class_id , 'e.year' => $running_year, 'e.section_id'=>$section_id));
	    //$this->db->group_by('s.name, s.surname');

        $this->db->join('payment as p','p.student_id = s.student_id');
        
        

        $this->db->where(array('e.class_id' => $class_id , 'e.year' => $running_year, 'e.section_id'=>$section_id,'p.year'=>$running_year ));
        //$this->db->group_by('s.name, s.surname');
         $this->db->group_by('s.name, s.surname');
   
        $this->db->order_by('s.name ASC');


	    //$this->db->order_by('s.name ASC');
	    $students = $this->db->get('student as s')->result_array();
       // var_dump($students);die();
        $count=1;
        foreach ($students as $row) {
            $tranche1 = 0;$tranche2 = 0;$tranche3 = 0;$inscription=0;$tutorials=0;
            $payment = $this->db->get_where('payment',array('student_id' =>$row['student_id'],'year'=>$running_year ))->result_array();
           // var_dump($payment);
            foreach ($payment as $row2) {
                if ($row2['title']==1) {
                    $tranche1 +=  $row2['amount'];
                } 
                if ($row2['title']==2) {
                    $tranche2 += $row2['amount'];
                }    
                if ($row2['title']==3) {
                    $tranche3 +=  $row2['amount'];
                }
                if ($row2['title']==4) {
                    $tranche1 +=  $row2['amount'];
                } if ($row2['title']==5) {
                    $tutorials +=  $row2['amount'];
                }          
            }?>
             <tr>
                <td><?php echo $count++;?></td>
                
                <td><?php echo $row['student_code'];?></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['surname'];?></td>
                <!--<td><?php echo $inscription;?></td>-->
                <td><?php echo $tranche1;?></td>
                <td><?php echo $tranche2;?></td>
                <td><?php echo $tranche3;?></td>
                <?php
                if( !is_null($fees->tutorials)){?>
                    <td><?php echo $tutorials;?></td>
                <?php
                }
            ?>
            </tr>

            <?php

        }?>
	   
	   
	   
    </tbody>
</table>

<script type="text/javascript">
	$(document).ready(function() {
		//$('#student_payments').dataTable();
	});
</script>