 <?php
 $cycle = $this->db->get_where('class_cycle', array('class_id' =>$class_id,'year'=>$running_year))->row()->cycle;
$fees = $this->db->get_where('school_fees', array('cycle' =>$cycle,'year'=>$running_year))->row();
?>
<style type="text/css">
    td {
        padding: 2px;
        font-size: 10px;
    }
    #print{
        padding: 7px;
    }
    p{
        font-size: 11px;}        
    </style>
<table style="width:100%;">
    <thead></thead>
    <tbody>
        <tr>
            <td width="40%">
                <p style="margin: 0;">Ministère des Enseignements Secondaires</p>
                <p style="margin: 0;">Délégation régionale du Littoral</p>
                <p style="margin: 0;">Délégation Départementale du Wouri</p>
                <p style="margin: 0;">STEVIN BILINGUAL COLLEGE</p>
                <p style="margin: 0;">BP : 11496 Douala Tel : 674435316 / 693152933</p>
            </td>
            <td><center>
                <img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height : 90px;">
            </center>

        </td>
        <td width="40%" style="padding-left:50px;">
            <p style="margin: 0;">Ministry of Secondary Education</p>
            <p style="margin: 0;">Littoral Regional Delegation</p>
            <p style="margin: 0;">Divisional Delegation of Wouri</p>
            <p style="margin: 0;">STEVIN BILINGUAL COLLEGE</p>
            <p style="margin: 0;">PO BOX : 11496 Douala Tel : 674435316 / 693152933</p>
        </td>
    </tr>
</tbody>
</table>
<center>
  
    <h3 style="font-weight: 100; background-color: gray"><?php echo 'Liste des paiements '.$class_name;?></h3>
    <p> year : <?=$running_year ?>  </p>
</center>
<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
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
        if ($pay==1) {

        $this->db->select('s.name,s.surname,s.student_code,s.student_id');
       // $this->db->select('p.title');
        $this->db->join('enroll as e','e.student_id = s.student_id'); 
        //$this->db->join('payment as p','p.student_id = s.student_id');
                $this->db->select('p.title');
        $this->db->join('payment as p','p.student_id = s.student_id');
        
        

        $this->db->where(array('e.class_id' => $class_id , 'e.year' => $running_year, 'e.section_id'=>$section_id,'p.year'=>$running_year ));
        //$this->db->group_by('s.name, s.surname');
         $this->db->group_by('s.name, s.surname');
   
        if($order == 0){
            $this->db->order_by('s.name  ASC');
        }else{
            $this->db->order_by('s.student_code ASC');
        }
        $students = $this->db->get('student as s')->result_array();
        //var_dump($students);die();
        }
        if ($pay==0) {
            $this->db->select('student_id');
            $this->db->where(array('year' =>$running_year));

            $payments = $this->db->get('payment')->result_array();
            foreach ($payments as $key ) {
                $paid[]=$key['student_id'];
            }
            //var_dump($paid);die();
            $this->db->select('s.name,s.surname,s.student_code,s.student_id');
       // $this->db->select('p.title');
        $this->db->join('enroll as e','e.student_id = s.student_id'); 
        //$this->db->join('payment as p','p.student_id = s.student_id');

        $this->db->where(array('e.class_id' => $class_id , 'e.year' => $running_year, 'e.section_id'=>$section_id));
        $this->db->where_not_in('s.student_id',$paid);
        //$this->db->group_by('s.name, s.surname');
         $this->db->group_by('s.name, s.surname');
   
        $this->db->order_by('s.student_code ASC');
        $students = $this->db->get('student as s')->result_array();
        //var_dump($students);die();
        }
       // var_dump($students);die();
        $count=1;
        foreach ($students as $row) {
            $fees_paid_1 = 0;
            $fees_paid_2 = 0;
            $fees_paid_3 = 0;
            $fees_paid_tutorials = 0;
            $tranche1 = 0;$tranche2 = 0;$tranche3 = 0; $inscription=0;$tutorials=0;
            $payment = $this->db->get_where('payment',array('student_id' =>$row['student_id'],'year'=>$running_year ))->result_array();
           // var_dump($payment);
            foreach ($payment as $row2) {
                if ($row2['title']==1) {
                    $tranche1 = $tranche1 + $row2['amount'];
                } 
                if ($row2['title']==2) {
                    $tranche2 = $tranche2 + $row2['amount'];
                }    
                if ($row2['title']==3) {
                    $tranche3 = $tranche3 + $row2['amount'];
                } 
                if ($row2['title']==4) {
                    $tranche1 = $tranche1 + $row2['amount'];
                }   
                if ($row2['title']==5) {
                    $tutorials += $row2['amount'];
                }        
            }
           
            if($tranche1     == $fees->first    ){
                $fees_paid_1     = 1;
            }
            if($tranche2     == $fees->second       ){
                $fees_paid_2     = 1;
            }
            if($tranche3     == $fees->third ){
                $fees_paid_3     = 1;
            }
            if($tutorials     == $fees->tutorials ){
                $fees_paid_tutorials     = 1;
            }
            

            ?>
             <tr>
                <td><?php echo $count++;?></td>
                <td><?php echo $row['student_code'];?></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['surname'];?></td>
                <!--<td><?php echo $inscription;?></td>-->
                <td <?php if($fees_paid_1 ==0 ) { ?> style ="background-color:rgb(212, 212, 212)  ;color:  black   ;" <?php } ?> ><?php echo $tranche1;?></td>
                <td <?php if($fees_paid_2 ==0 ) { ?> style ="background-color:rgb(212, 212, 212)  ;color:  black   ;" <?php } ?>><?php echo $tranche2;?></td>
                <td <?php if($fees_paid_3 ==0 ) { ?> style ="background-color:rgb(212, 212, 212)  ;color:  black   ;" <?php } ?>><?php echo $tranche3;?></td>
                <?php
                if( !is_null($fees->tutorials)){?>
                    <td <?php if($fees_paid_tutorials ==0 ) { ?> style ="background-color:rgb(212, 212, 212)  ;color:  black   ;" <?php } ?>><?php echo $tutorials;?></td>
                <?php
                }
            ?>

            </tr>

            <?php

        }?>
       
       
       
    </tbody>
</table>