<style type="text/css">
    

    td {
        padding: 3px;
        font-size: 12px;
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

<center>
   
       
    <h3 style="font-weight: 100; background-color: gray"><?php echo 'Teacher List '.$class_name;?></h3>
       
           
</center>
<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
 <thead>
    <tr>
        <td style="text-align: left;">N</td>
        <td style="text-align: left;">Name </td>
        <td style="text-align: left;">login </td>
        <td style="text-align: left;"> Default password </td>
 
    </tr>

</thead>
<tbody>

    <?php 
     $count = 1;

    foreach ($teachers as $row): 
       
        ?>
        <tr>
            <td>
                <?php echo $count++; ?>
            </td>
            <td>
                <?php echo $row->name . ' '.$row->surname ?>
            </td>
            
            <td>
                <?php echo $row->email ?>
            </td>
            <td>
                <?php echo "123456" ?>
            </td>
            
        </tr>
        <?php
                        
                       
        endforeach;
        ?>

    </tbody>
</table>