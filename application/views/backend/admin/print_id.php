<?php $admin_id= $this->session->userdata('admin_id');
    $running_year       =   $this->db->get_where('session', array('admin_id'=>$admin_id))->row()->year;?>
<html>
<head>

    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/neon-core.css">
    <link rel="stylesheet" href="assets/css/neon-theme.css">
    <link rel="stylesheet" href="assets/css/neon-forms.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <style>

        .id-card-holder {
            width: 325px;
            padding: 4px;
            margin: 0 auto;

            border-radius: 5px;
            position: relative;
        }

        .id-card-holder:after {
            content: '';
            width: 7px;
            display: block;
            height: 100px;
            position: absolute;
            top: 105px;
            border-radius: 0 5px 5px 0;
        }

        .id-card-holder:before {
            content: '';
            width: 7px;
            display: block;
            height: 100px;
            position: absolute;
            top: 105px;
            left: 222px;
            border-radius: 5px 0 0 5px;
        }

        .id-card {

            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 1.5px 0px #b9b9b9;
        }

        .id-card img {
            margin: 0 auto;
        }

        .header img {
            width: 100px;
            margin-top: 5px;
        }

        .photo img {
            width: 80px;
            margin-top: 5px;
        }

        .id-card h2 {
            font-size: 10px;
            margin: 0px 0;
        }

        .id-card h3 {
            font-size: 8px;
            margin: 2.5px 0;
            font-weight: 300;
        }

        .qr-code img {
            width: 50px;
        }

        .id-card p {
            font-size: 3px;
            margin: 0px;
        }
        .id-card td {
            font-size: 10.5px;
            padding-top: 0px;
            
        }

        .id-card-hook {
            background-color: #000;
            width: 70px;
            margin: 0 auto;
            height: 12px;
            border-radius: 5px 5px 0 0;
        }

        .id-card-hook:after {
            content: '';
            background-color: #d7d6d3;
            width: 47px;
            height: 6px;
            display: block;
            margin: 0px auto;
            position: relative;
            top: 6px;
            border-radius: 4px;
        }

        .id-card-tag-strip {
            display: none;
            width: 45px;
            height: 40px;
            background-color: #0950ef;
            margin: 0 auto;
            border-radius: 5px;
            position: relative;
            top: 9px;
            z-index: 1;
            border: 1px solid #0041ad;
        }

        .id-card-tag-strip:after {
            content: '';
            display: block;
            width: 100%;
            height: 1px;
            background-color: #c1c1c1;
            position: relative;
            top: 10px;
        }

        .id-card-tag {
            width: 0;
            height: 0;
            border-left: 100px solid transparent;
            border-right: 100px solid transparent;
            border-top: 100px solid #0958db;
            margin: -10px auto -30px auto;
        }

        .id-card-tag:after {
            content: '';
            display: block;
            width: 0;
            height: 0;
            border-left: 50px solid transparent;
            border-right: 50px solid transparent;
            border-top: 100px solid #d7d6d3;
            margin: -10px auto -30px auto;
            position: relative;
            top: -130px;
            left: -50px;
        }
        
    </style>
</head>
<body>
<?php

$student = $this->db->get_where('student', array('student_id' => $id))->row();
$class_id = $this->db->get_where('enroll', array('student_id' => $id,'year'=>$running_year))->row()->class_id;
?>

<div class="id-card-tag-strip"></div>

<div class="id-card-holder">
    <div class="id-card" style="padding: 10px;padding-top: 5px;padding-bottom: 2px">
        <table style="margin-right: 0">
            <tr>
                <td><img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height:50px;max-width: 50px"/></td>
                <td><center><h2 style="display: inline; float: right; margin-top: 0%; margin-left: 0px; font-size:12px"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></h2></center></td>
            </tr>
        </table>
        
        <?php if ($card_type==1) {?>
           <h2><?php echo get_phrase('first_instalment_card') ?></h2>
        <?php
        } ?>
        <?php if ($card_type==2) {?>
           <h2><?php echo get_phrase('second_instalment_card') ?></h2>
        <?php
        } ?>
        <?php if ($card_type==3) {?>
           <h2><?php echo get_phrase('third_instalment_card') ?></h2>
        <?php
        } ?>
        <?php if ($card_type==null) {?>
           <h2 style="margin-top:-10px"><?php echo get_phrase('STUDENT_IDENTITY_CARD') ?></h2>
        <?php
        } ?>
        
        <div class="photo" style="">
            <img class="img-circle" style="max-height:90px;max-width: 90px;float: left;margin-right: 10px"
                 src="<?php echo $this->crud_model->get_image_url('student', $student->student_id); ?>"
                 class="img-circle" width="30"/>
                 
            <table class="" style="font-size: 10px">
                <tr>
                   <td>Name</td>
                   <td>:</td>
                   <td ><?php echo $student->name.' '. $student->surname; ?></td>
               </tr>
                
                
               <tr>
                   <td>Date of birth</td>
                     <td>:</td>
                   <td ><?php if($student->birthday!=null) echo date('d/m/Y',strtotime($student->birthday)) ; ?></td>
               </tr>
                <tr>
                   <td>At</td>
                    <td>:</td>
                   <td ><?php echo $student->at; ?></td>
               </tr>
               <!-- <tr>
                    <td>Parent</td>
                    <td>:</td>
                    <td><?php echo $this->db->get_where('parent', array('parent_id' => $student->parent_id))->row()->name; ?></td>
                </tr>-->
                <tr>
                    <td>Class</td>
                    <td>:</td>
                    <td><?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name; ?> </td>
                </tr>
               
                <tr>
                    <td>Contact</td>
                    <td>:</td>
                    <td> <?php echo "674435316 / 693152933"; //$student->phone; ?></td>
                </tr>
                <tr>
                   <td>Academic Year</td>
                   <td>:</td>
                   <td ><?php echo $running_year; ?></td>
               </tr>
                <tr>
                    <td>Principal's Signature</td>
                    
                   <td>:</td>
                    <td><img src="<?php echo base_url(); ?>uploads/signature_principal.jpg" style="height:35px;width: 50px"/>                              </td>
                </tr>
            </table>
        </div>
        <h2 style="float: left;margin-top:-30px;margin-left:15px;font-size: 12px" ><?php echo $student->student_code; ?></h2>
        
        
        

        

    </div>
</div>


</body>
</html>


