<style type="text/css">
    p{
        font-size: 9px;
        margin-top: 0;
        margin-bottom: 0;
    }
    h5{
        font-size: 10px;
        margin-top: 0;
        margin-bottom: 0;
    }
</style>
<?php
    $edit_data = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
    $admin_id= $this->session->userdata('admin_id');
    $running_year       =   $this->db->get_where('session', array('admin_id'=>$admin_id))->row()->year;
    foreach ($edit_data as $row):
    ?>
    <!--<center>
        <a onClick="PrintElem('#invoice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
            Print Invoice
            <i class="entypo-print"></i>
        </a>
    </center>-->
        <a target="_blank" href="<?php echo site_url('admin/print_invoice/'.$param2);?>" class="btn btn-default btn-icon icon-left hidden-print pull-right">
                Print Invoice
                <i class="entypo-print"></i>
        </a>



    <div id="invoice_print">
        <?php for ($i=0; $i <2 ; $i++) { ?>
            <table width="100%" border="0">
            <tr>
                <td align="left">
                    <p><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></p>
                    <p>BP : 11496 Douala</p>
                    <p>Tel : <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?></p>
                </td>
                <td><center>
                    <img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height : 40px;">
                </center>

            </td>
            <td align="right">
                <p><?php echo get_phrase('creation_date'); ?> : <?php echo date('d M,Y', $row['creation_timestamp']);?></p>
                <p><?php echo get_phrase('academic_year'); ?> : <?php echo $running_year;?></p>
            </td>
            </tr>
        </table>
        <hr>
        <center><p>School Fees Receipt</p></center>
        <table width="100%" border="0">    
            <tr>
                <td align="left" valign="top">
                    <p><?php echo get_phrase('matricule'); ?> : <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->student_code; ?></p>
                    <p><?php echo get_phrase('name'); ?> : <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name; ?> <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->surname; ?></p>
                    <p><?php 
                    $class_id = $this->db->get_where('enroll' , array(
                        'student_id' => $row['student_id'],
                        'year' => $running_year
                    ))->row()->class_id;
                    echo get_phrase('class') . ' ' . $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
                    ?></p>
                </td>
                <td align="right" valign="top">
                    <p><?php echo get_phrase('bank_receipt') ?><p>
                    <p><?php echo $row['bank_receipt'] ?><p>
                    <!--<?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br> -->    
                </td>
                
            </tr>
        </table>
        <hr>

        <table width="100%" border="0">    
            <tr>
                <?php $tranche = array('1' =>'Inscription' , '2' =>'second_instalment', '3' => 'third_instalment'); ?>
                <td align="right" width="80%"><?php echo $tranche[$row['title']]. ' '. get_phrase('total_amount'); ?> :</td>
                <td align="right"><?php echo $row['amount']; ?></td>
            </tr>
            <tr> 
                <td align="right" width="80%"><p><?php echo get_phrase('paid_amount'); ?> :</p></td>
                <td align="right"><p><?php echo $row['amount_paid']; ?></p></td>
            </tr>

            <tr>
                <td align="right" width="80%"><p><?php echo get_phrase('rest'); ?> :</p></td>
                <td align="right"><p><?php echo $row['due']; ?></p></td>
            </tr>

        </table>

        <hr>
        <table width="100%" border="0">  
            <tr>
                <td>
                    <p><?php echo get_phrase('payment_history'); ?></p>
                </td>
                <td>
                    <p><?php echo get_phrase('summary'); ?></p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <table width="100%" border="1" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase('date'); ?></th>
                                <th><?php echo get_phrase('title'); ?></th>
                                <th><?php echo get_phrase('amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $payment_history = $this->db->get_where('payment', array('invoice_id' => $row['invoice_id']))->result_array();
                            foreach ($payment_history as $row2):
                                ?>
                                <tr>
                                    <td><?php echo date("d M, Y", $row2['timestamp']); ?></td>

                                    <td><?php echo $tranche[$row2['title']]; ?></td>
                                    <td><?php echo $row2['amount']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </td>
                <td align="right">
                    <table  width="100%" border="1" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php echo get_phrase('tranche 1'); ?></th>
                                <th><?php echo get_phrase('tranche 2'); ?></th>
                                <th><?php echo get_phrase('tranche 3'); ?></th>
                                <th><?php echo get_phrase('total'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // var_dump($row['student_id']);
                            $cycle_id = $this->db->get_where('class_cycle', array('class_id' => $class_id, 'year'=>$running_year))->row()->cycle;
                            $school_fees = $this->db->get_where('school_fees', array('cycle' => $cycle_id,'year'=>$running_year))->result_array();
                            $tranche1 = $this->db->get_where('payment',  array('student_id' => $row['student_id'], 'title'=>1,'year'=>$running_year ))->result_array();
                            //var_dump($row['student_id']);
                            $tranche2 = $this->db->get_where('payment',  array('student_id' => $row['student_id'], 'title'=>2,'year'=>$running_year ))->result_array();
                            $tranche3 = $this->db->get_where('payment',  array('student_id' => $row['student_id'], 'title'=>3,'year'=>$running_year ))->result_array();
                            $total1 = $total2= $total3= 0;
                            foreach ($tranche1 as $key) {
                               $total1 = $total1 + $key['amount'];
                           }
                           foreach ($tranche2 as $key) {
                               $total2 = $total2 + $key['amount'];
                           }
                           foreach ($tranche3 as $key) {
                               $total3 = $total3 + $key['amount'];
                           }
                           $total_paid = $total1+ $total2 + $total3;
                            //var_dump($total3);
                           foreach ($school_fees as $row3):
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $row3['first']; ?></td>
                                <td><?php echo $row3['second']; ?></td>
                                <td><?php echo $row3['third']; ?></td>
                                <td><?php echo $row3['total']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo get_phrase('paid'); ?></td>
                                <td><?php echo $total1; ?></td>
                                <td><?php echo $total2; ?></td>
                                <td><?php echo $total3; ?></td>
                                <td><?php echo $total_paid; ?></td>
                            </tr>
                            <tr style="font-weight: bold; color: black;">
                                <td><?php echo get_phrase('rest'); ?></td>
                                <td><?php echo $row3['first'] - $total1; ?></td>
                                <td><?php echo $row3['second'] - $total2; ?></td>
                                <td><?php echo $row3['third'] - $total3; ?></td>
                                <td><?php echo $row3['total'] - $total_paid; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%" border="0">
            <tr>
               <td align="left">
                   Signature du parent
               </td> 
               <td align="right">
                   Signature
               </td> 

            </tr>

        </table>
        <hr>

            
        <?php } ?>



    </div>
<?php endforeach; ?>


<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Invoice</title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
       // mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        var is_chrome = Boolean(mywindow.chrome);
        if (is_chrome) {
            setTimeout(function() {
                mywindow.print();
                mywindow.close();

                return true;
            }, 250);
        }
        else {
            mywindow.print();
            mywindow.close();

            return true;
        }

        return true;
    }

</script>