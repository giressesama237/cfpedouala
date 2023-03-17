
<div class="row">
	<div class="col-md-3">
		<label><?php echo get_phrase('From');?></label>
		<input type="text" class="form-control datepicker" name="date_from" id="date_from" value="" data-start-view="0">
	</div>
	<div class="col-md-3">
		<label><?php echo get_phrase('To');?></label>
		<input type="text" class="form-control datepicker" name="date_to" id="date_to" value="" data-start-view="0">
	</div>
	<div class="col-md-2">
		<label></label>
		<button type="button" class="btn btn-info btn-block" id="find">
			<?php echo get_phrase('find_payments');?>
		</button>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<div id="data">
			<?php include 'student_specific_payment_history_table.php'; ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {


		

		$('#find').on('click', function(e) {
			e.preventDefault();
			var date_from = $('input[name=date_from]').val();
			var date_to = $('input[name=date_to]').val();
			console.log(date_from);
			//console.log(class_id);
			$.post(
				'<?php echo site_url('admin/get_payment_stats');?>',
				{
					date_from : date_from,
					date_to : date_to
				},
				function (response){
					
						$('#data').html(response);
				},
				'html'
				
			);
		});

	});
</script>
<script >
	 function invoice_delete_confirm(invoice_id) {
        confirm_modal('<?php echo site_url('admin/invoice/delete/');?>' + invoice_id);
    }
</script>