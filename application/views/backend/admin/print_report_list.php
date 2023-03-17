<style type="text/css">
    td {
        padding: 4px;
        font-size: 10px;
    }
    #print{
        padding: 7px;
    }
    p{
        font-size: 11px;}       
    h5{
        margin: 5px;
    } 
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
    <?php 
        if ($pay==1) {   ?>
            <h3 style="font-weight: 100; background-color: gray"><?php echo 'CLASS LIST '.$class_name;?></h3>
            
        <?php }
        
    ?>

    


    
</center>
<h5> Subject : ..............................................</h5>
<h5>  Teacher : .............................................</h5>
<h5>  Exam : <?= $exam_name ?></h5>
<h5>  Year : <?=$running_year?></h5>
<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
 <thead>
    <tr>
        <td style="text-align: center;">N</td>
        <td style="text-align: center;">Matricule</td>
        <td style="text-align: center;">Name</td>
        <?php 
        if ($exam_name == 'FIRST TERM') {?>
            <td style="text-align: center;">Seq 1 / 20</td>
            <td style="text-align: center;">Seq 2 / 20</td>
       
        
        <?php  }
        else if($exam_name == 'SECOND TERM') {?>
            <td style="text-align: center;">Seq 3 / 20</td>
            <td style="text-align: center;">Seq 4 / 20</td>
            
        
        <?php }
        else if ($exam_name == 'THIRD TERM') { ?>
            
            <td style="text-align: center;">Seq 5 / 20</td>
            <td style="text-align: center;">Seq 6 / 20</td>
        
        <?php }?>
            <td style="text-align: center;">Comment</td>
        
    </tr>

</thead>
<tbody>

    <?php 
     $count = 1;
    foreach ($students as $row): 
        ?>
        <tr>
            <td>
                <?php echo $count++; ?>
            </td>
            <td>
                <?php echo $row['student_code'] ?>
            </td>
            <td>
                <?php echo $row['name'].' '. $row['surname'] ?>
            </td>
            <td>
           
                
            </td>
            <td>
           
                
            </td>
            <td>
           
                
            </td>
            
            
           
        </tr>
        <?php
                        
                       
        endforeach;
        ?>

    </tbody>
</table>