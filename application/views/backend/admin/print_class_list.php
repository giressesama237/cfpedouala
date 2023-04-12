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
        font-size: 9px;
    }
</style>
<h3 style="font-weight: 100; background-color: rgba(252,194,59,0.7);"><?php echo
 'Metier ' . $class_name; ?></h3>

<h6>Année de Formation : <?php echo $year?> </h6>
<table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 5px;" border="1">
    <thead>
        <tr>
            <td style="text-align: center;">N</td>
            <td style="text-align: center;">Matricule</td>

            <td style="text-align: center;">Noms et Prenoms </td>

            <?php if ($list == "2") { ?>
                <td style="text-align: center;">Observations</td>

            <?php } elseif ($list == "1") { ?>
                <td style="text-align: center;">Date de Naissance</td>
                <td style="text-align: center;">Lieu</td>
                <td style="text-align: center;">Sexe</td>
                <td style="text-align: center;">Contact</td>
                <td style="text-align: center;">Status</td>
            <?php } ?>
        </tr>

    </thead>
    <tbody>

        <?php
        $count = 1;

        foreach ($students as $row) :
        ?>
            <tr>
                <td>
                    <?php echo $count++; ?>
                </td>
                <td>
                    <?php echo $row->student_code ?>
                </td>
                
                <td>
                    <?php echo $row->name . ' ' . $row->surname  ?>
                </td>
                
                <?php if ($list == "2") { ?>
                    <td>

                    </td>
                <?php } elseif ($list == "1") { ?>
                    <td>
                        <?php  if(isset($row->birthday)) echo date('d/m/Y', strtotime($row->birthday)) ?>
                    </td>
                    <td>
                        <?php echo $row->at?>
                    </td>
                    <td>
                        <?php if ($row->sex == 'male') echo 'M';
                        else echo 'F'; ?>
                    </td>
                    
                    <td>
                        <?php echo $row->address . ' ' . $row->phone ?>
                    </td>
                    <td>
                        <?php 
                        if ($year == $row->year)
                            echo 'N';
                        else
                            echo 'O'; ?>
                    </td>
                <?php } ?>
            </tr>
        <?php


        endforeach;
        ?>

    </tbody>
</table>