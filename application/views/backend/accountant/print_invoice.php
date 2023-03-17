<style type="text/css">
    p{
        font-size: 9px;
        margin-top: 0;
        margin-bottom: 0;
    }
    h5{
        font-size: 9px;
        margin-top: 0;
        margin-bottom: 0;
    }
    tr{
        font-size: 10px;
        margin-top: 0;
        margin-bottom: 0;
    }
    hr{
        margin : 0;
    }
</style>
<?php

foreach ($edit_data as $row):
    ?>




    <div id="invoice_print">
        <?php for ($i=0; $i <2 ; $i++) { ?>
            <table width="100%" border="0">
                <tr>
                    <td align="left">
                        <p><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></p>
                        <p>BP : <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?></p>
                        <p>Tel : <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?></p>
                    </td>
                    <td><center>
                            <img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height : 40px;">
                        </center>

                    </td>
                    <td align="right">
                        <p><?php echo get_phrase('date'); ?> : <?php echo date('d M,Y', $row['creation_timestamp']);?></p>
                        <p><?php echo get_phrase('annee_academique'); ?> : <?php echo $running_year;?></p>
                    </td>
                </tr>
            </table>
            <hr>
            <center><h5>Recu de scolarité</h5><h5>School Fees Receipt</h5></center>
            <table width="100%" border="0">
                <tr>
                    <td align="left" valign="top">
                        <p><?php echo get_phrase('matricule'); ?> : <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->student_code; ?></p>
                        <p>Matricule</p>
                        <p><?php echo get_phrase('noms et prenom'); ?> : <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name; ?> <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->surname; ?></p>
                        <p>Name</p>
                        <p><?php
                            $class_id = $this->db->get_where('enroll' , array(
                                'student_id' => $row['student_id'],
                                'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                            ))->row()->class_id;
                            echo get_phrase('classe') . ' : ' . $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
                            ?></p>
                        <p>class</p>
                    </td>
                    <td align="right" valign="top">
                        <p>Recu Bancaire : <p>
                        <p>Bank Receipt<p>
                        <p style="font-weight: bold; color: black;"><?php echo $row['bank_receipt'] ?><p>
                            <!--<?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br> -->
                    </td>

                </tr>
            </table>
            <hr>

            <table width="100%" border="0">
                <tr>
                    <?php $tranche = array('1' =>'Tranche 1 ' , '2' =>'Tranche 2 ', '3' => 'Tranche 3'); ?>
                    <?php $tranche2 = array('1' =>'First Instalment' , '2' =>'Second Instalment', '3' => 'Third Instalment'); ?>
                    <td align="right" width="80%"><?php echo $tranche[$row['title']]; ?> :</td>

                    <td align="right"><?php echo $row['amount']; ?></td>
                </tr>
                <tr>
                    <td align="right" width="80%"><p><?php echo $tranche2[$row['title']]; ?></p></td>

                </tr>
                <tr>
                    <td align="right" width="80%"><?php echo "Payé"; ?> : </td>
                    <td align="right"><?php echo $row['amount_paid']; ?></td>
                </tr>
                <tr>
                    <td align="right" width="80%"><p><?php echo "Paid"; ?></p> </td>
                </tr>

                <!--<tr>
                    <td align="right" width="80%"><p><?php echo get_phrase('rest'); ?> :</p></td>
                    <td align="right"><p><?php echo $row['due']; ?></p></td>
                </tr>-->

            </table>

            <hr>
            <table width="100%" border="0">
                <tr align="center">
                    <td>
                        <?php echo 'Historique De Paiement'; ?>
                    </td>
                    <td>
                        <?php echo 'Récapitulatif'; ?>
                    </td>
                </tr>
                <tr align="center">
                    <td>
                        <p><?php echo 'Payment History'; ?></p>
                    </td>
                    <td>
                        <p><?php echo 'Summary'; ?></p>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="100%" border="1" style="border-collapse:collapse;">
                            <thead>
                            <tr>
                                <th><?php echo 'Date' ?><p>Date</p></th>
                                <th><?php echo 'Titre'; ?><p>Title</p></th>
                                <th><?php echo "Montant"; ?><p>Amount</p></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $payment_history = $this->db->get_where('payment', array('student_id' => $row['student_id'], 'year' => $running_year))->result_array();
                            foreach ($payment_history as $row2):
                                ?>
                                <tr>
                                    <td><?php echo date("d M, Y", $row2['timestamp']); ?></td>

                                    <td><?php echo $tranche[$row2['title']]; ?><p><?php echo $tranche2[$row2['title']]; ?></p></td>
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
                                <th><?php echo get_phrase('Tranche 1'); ?><p>First Instalment</p></th>
                                <th><?php echo get_phrase('Tranche 2'); ?><p>Second Instalment</p></th>
                                <th><?php echo get_phrase('Tranche 3'); ?><p>Third Instalment</p></th>
                                <th><?php echo get_phrase('Total'); ?> <p>Total</p></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // var_dump($row['student_id']);
                            $cycle_id = $this->db->get_where('class', array('class_id' => $class_id))->row()->cycle;
                            $school_fees = $this->db->get_where('school_fees', array('cycle' => $cycle_id))->result_array();
                            $tranche1 = $this->db->get_where('payment',  array('student_id' => $row['student_id'], 'title'=>1 ))->result_array();
                            //var_dump($row['student_id']);
                            $tranche2 = $this->db->get_where('payment',  array('student_id' => $row['student_id'], 'title'=>2 ))->result_array();
                            $tranche3 = $this->db->get_where('payment',  array('student_id' => $row['student_id'], 'title'=>3 ))->result_array();
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
                                    <td><?php echo 'Montant '?><p>Amount</p></td>
                                    <td><?php echo $row3['first']; ?></td>
                                    <td><?php echo $row3['second']; ?></td>
                                    <td><?php echo $row3['third']; ?></td>
                                    <td><?php echo $row3['total']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo get_phrase('paid'); ?><p>Paid</p></td>
                                    <td><?php echo $total1; ?></td>
                                    <td><?php echo $total2; ?></td>
                                    <td><?php echo $total3; ?></td>
                                    <td><?php echo $total_paid; ?></td>
                                </tr>
                                <tr style="font-weight: bold; color: black;">
                                    <td><?php echo 'Reste'; ?><p>Due</p></td>
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
            <table width="100%" border="0" style="margin-bottom: 25px">
                <tr >
                    <td align="left">
                        Signature du client <p>Client's signature</p>
                    </td>
                    <td align="right">
                        Signature Comptable <p>Accountant's signature</p>
                    </td>

                </tr>

            </table>
            <hr style="margin-bottom: 5px">


        <?php } ?>



    </div>
<?php endforeach; ?>



