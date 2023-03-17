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
    <h3 style="font-weight: 100; background-color: gray"><?php echo $exam_name . ' RESULTS IN ORDER OF MERITE'.' '.$class_name;?></h3>
    <h4 style="font-weight: 100; background-color: gray"><?php echo 'RESULTATS PAR ORDRE DE MERITE DU '.$exam_name.' '.$class_name;?></h4>

    


    
</center>
<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
 <thead>
    <tr>
        <td style="text-align: center;">N</td>
        <td style="text-align: center;">Matricule</td>
        <td style="text-align: center;">Noms</td>
        <td style="text-align: center;">Prénoms</td>
        <td style="text-align: center;">Class</td>
        <td style="text-align: center;">Term. Avg.</td>
        <?php 
            if($exam_name =="THIRD TERM"){
        ?>
        <td style="text-align: center;">Annual. Avg.</td>
        <?php } ?>
        
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
                <?php echo $row->student_id ?>
            </td>
            <td>
                <?php echo $row->name ?>
            </td>
            <td>
                <?php echo $row->surname ?>
            </td>
            <td>
                <?php echo $row->class_name .' '. $row->section_name ?>
            </td>
            <td>
                <?php echo sprintf("%.2f",$row->moy) ?>
            </td>
            <?php 
            if($exam_name =="THIRD TERM"){
            ?>
            <td ><?= sprintf('%.2f',$row->moy_annuelle)  ?></td>
            <?php } ?>
            
        </tr>
        <?php
                        
                       
        endforeach;
        ?>

    </tbody>
</table>