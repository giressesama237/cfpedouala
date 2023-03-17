
<h4 class="text-muted" style="margin-bottom: 20px;">
	<?php echo get_phrase('payment_history_from').' '. date('d M,Y', strtotime($date_from)).' To '. date('d M,Y', strtotime($date_to)); ?> 
</h4>
<table class="table table-bordered" id="student_payments">
	<thead>
        <tr>
            <th width="40"><div><?php echo get_phrase('N');?></div></th>
            <th><div><?php echo get_phrase('Name & Surname');?></div></th>
            <th><div><?php echo get_phrase('class');?></div></th>
            <th><div><?php echo get_phrase('method');?></div></th>
            <th><div><?php echo get_phrase('amount');?></div></th>
            <th><div><?php echo get_phrase('date');?></div></th>
            <th><div><?php echo get_phrase('options');?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php
        	$title_array = array('1' => 'First instalment', '2'=>'Second Instalment', '3'=>'Third Instalment' ,'4'=>'Inscription' );
    		//$this->db->where('student_id', $student_id);
    		//$this->db->where('payment_type' , 'income');
			
    		$count = 1;
    		$total = 0;
    		foreach ($payments as $row): ?>
	        <tr>
	            <td> <?= $count?>
	            	</td>
	            <td><?php  
	            			echo $row['name'] .' '. $row['surname'];
							
	            	?></td>
				<td><?php  
						$class_name         =   $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;
						$section_name       =   $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;
						echo $class_name.' '.$section_name;
	            	?></td>
	            <td>
	            	<?php
	            		if ($row['payment_method'] == 1)
	            			echo get_phrase('cash');
	            		if ($row['payment_method'] == 2)
	            			echo get_phrase('Bank');
	            		if ($row['payment_method'] == 3)
	            			echo get_phrase('card');
	                    if ($row['payment_method'] == 'Paypal')
	                    	echo 'Paypal';
	                    if ($row['payment_method'] == 'Stripe')
	                    	echo 'Stripe';
	            	?>
	            </td>
	            <td><?php echo $row['amount_paid']; $total += $row['amount_paid']; ?></td>
	            <td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>
	            <td align="center">
	            	<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_view_invoice/'.$row['invoice_id']);?>')">
	            			<i class="entypo-credit-card"></i>&nbsp;<?php echo get_phrase('view_invoice');?>
	            	</a>
	            	<?php $invoice_id = $row['invoice_id'] ?>
	            	<a href="#" onclick="invoice_delete_confirm('<?php echo($invoice_id) ?>')">
	            			<i class="entypo-trash"></i>&nbsp;<?php echo get_phrase('delete');?>
	            	</a>
	            	
	            </td>
	        </tr>

        <?php $count++; endforeach; ?>
        <tr style="background-color: #42A5F5 ">
        	<td colspan="4" style="text-align: center; color: black"> <b>Total</b></td>
        	<td style="color: black"><b><?= $total?></b></td>

        </tr>
    </tbody>
</table>

<script type="text/javascript">
	$(document).ready(function() {
		//$('#student_payments').dataTable();
	});
</script>