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
            width: 282px;
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
            width: 150px;
            margin-top: 5px;
        }

        .id-card h2 {
            font-size: 12px;
            margin: 2px 0;
        }

        .id-card h3 {
            font-size: 12px;
            margin: 2.5px 0;
            font-weight: 300;
        }

        .qr-code img {
            width: 50px;
        }

        .id-card p {
            font-size: 10px;
            margin: 2px;
        }
        .id-card td {
            font-size: 10px;
            
            
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
        .table_head p{
            font-size: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
$teacher = $this->db->get_where('teacher', array('teacher_id' => $id))->row();
$class_id = $this->db->get_where('subject', array('teacher_id' => $id))->result_array();
?>

<div class="id-card-tag-strip"></div>

<div class="id-card-holder">
    <div class="id-card" style="padding: 5px">
        <!--<table class="table_head" style="width:100%;">
            <thead></thead>
            <tbody>
                <tr>
                    <td width="50%">
                        <p style="">REPUBLIQUE DU CAMEROUN</p>
                        
                        <p style="">GROUPE SCOLAIRE BILINGUE "STEVIN INTERNATIONAL" </p>
                        <p style="">Tel : 674435316 / 693152933</p>
                        <p style="">Email : stevininternational@yahoo.fr</p>
                    </td>
                    <td><center>
                        <img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height : 60px;">
                    </center>
                    
                </td>
                <td width="55%" style="">
                    <p style="">REPUBLIC OF CAMEROON</p>
                        
                    <p style="">STEVIN INTERNATIONAL BILINGUAL SCHOOL COMPLEX</p>
                    <p style="">Tel : 674435316 / 693152933</p>
                    <p style="">Email : stevininternational@yahoo.fr</p>
                </td>
            </tr>
        </tbody>
    </table>-->
        <table style="margin-left:20px ;">
            <tr>
                <td><img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height:50px;max-width: 50px"/></td>
                <td><center><h2 style="display: inline; float: right; margin-top: 0%; margin-left: 0px"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></h2></center></td>
            </tr>
        </table>
        <div class="header" style="text-align: left;margin-left: 0px">
            
            
        </div>
        
           <h2 style="background: rgb(29, 169, 244); color: white;"><?php echo  get_phrase("CARTE D'ACCES / ACCES CARD") ?></h2>
        
        
        <div class="photo">
            <img class="img-circle" style="max-height:100px;max-width: 100px"
                 src="<?php echo $this->crud_model->get_image_url('teacher', $teacher->teacher_id); ?>"
                 class="img-circle" width="30"/>
        </div>
        
        
        <hr style="background: rgb(29, 169, 244); height: 5px; color: rgb(29, 169, 244); margin: 0;">
        <div style="text-align: justify;margin-left: 25px;">
            <table class="" >
                <tr>
                   <td style="width:50%">ACADEMIC YEAR</td>
                   <td>:</td>
                   <td ><?php echo $running_year; ?></td>
               </tr>
                <tr>
                   <td>NAME</td>
                   <td>:</td>
                   <td ><?php echo $teacher->name.' '. $teacher->surname; ?></td>
               </tr>
               <tr>
                   <td>SUBJECT</td>
                     <td>:</td>
                   <td ><?php echo $teacher->speciality; ?></td>
               </tr>
               <tr>
                   <td>POST</td>
                    <td>:</td>
                   <td >Teacher   t</td>
               </tr>
                <tr>
                   <td>STATUS</td>
                    <td>:</td>
                   <td ><?php echo $teacher->statut; ?></td>
                 
               </tr>
               <tr>
                    <td>GENDER</td>
                    <td>:</td>
                    <td>
                         <?php echo $teacher->sex; ?>
                    </td>
                </tr>
               
                <tr>
                    <td>CONTACT</td>
                    <td>:</td>
                    <td> <?php echo  $teacher->phone; ?></td>
                </tr>
                <tr>
                    <td>SIGNATURE</td>
                    <td>:</td>
                    <td><img src="<?php echo base_url(); ?>uploads/signature_principal.jpg" style="height:55px;width: 70px"/>                              </td>
                </tr>
                </table>
               
            </table>
        </div>

        

    </div>
</div>


</body>
</html>


