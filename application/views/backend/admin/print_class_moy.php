<style type="text/css">
    

    td {
        padding: 3px;
        font-size: 13px;
    }

    h3 {
        text-align: center;
    }

    #print {
        padding: 0px;
    }

    p {
        font-size: 11px;
    }
</style>
<h3 style="font-weight: 100; background-color: rgba(25,170,245,0.2); "><?php echo
 'Annual Result ' . $class_name.' '.$year; ?></h3>



<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 5px;" border="1">
 <thead>
    <tr>
        <td style="text-align: center;">Rank</td>
        <td style="text-align: center;">Matricule</td>
        <td style="text-align: center;">Name</td>
        <td style="text-align: center;">Date of birth</td>
        <td style="text-align: center;">Sex</td>
        <td style="text-align: center;">Term1</td>
        <td style="text-align: center;">Term2</td>
        <td style="text-align: center;">Term3</td>


        <?php if($exam_id==9){ ?> <td style="text-align: center;">Annual</td> <?php } ?>
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
                <?php echo $row['name'].' '.$row['surname'] ?>
            </td>
            <td>
                <?php if($row['birthday']) echo date('d/m/Y',strtotime($row['birthday'])); ?>
            </td>
            <td>
                <?php if($row["sex"]=='male')
                    echo 'M';
                    else
                    echo 'F'; ?>
            </td>
            <td>
                <?php
                    foreach($moy_firsterm as $row2 ) {
                        if($row2->student_id==$row['student_id']){
                            echo sprintf("%.2f",$row2->moy );
                            break;
                        }
                    }
                
                 ?>
            </td>
            <td>
            <?php
                    foreach($moy_secondterm as $row2 ) {
                        if($row2->student_id==$row['student_id']){
                            echo sprintf("%.2f",$row2->moy );
                            break;
                        }
                    }
                
                 ?>
            </td>
            <td>
                <?php echo sprintf("%.2f",$row['moy'] ) ?>
            </td>
            <?php if($exam_id==9){ ?> 
            <td>
                <?php echo sprintf("%.2f",$row['moy_annuelle'] ) ?>
            </td>
            <?php }?>
        </tr>
        <?php
                        
                       
        endforeach;
        ?>

    </tbody>
</table>