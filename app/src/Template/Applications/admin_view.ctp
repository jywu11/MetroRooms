<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
echo $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i')

?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        View Application | Admin
    </title>
    <?php $this->assign("title","View Application | NAIM Admin"); ?>
</head>
<!-- end of head -->

<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<style>

    #action{
        margin-bottom: 0;
    }

    .inline_field{
        display: inline-block;
    }

    #officeuse{
        background-color: rgba(240, 176, 117, 0.2);
        border-radius: 10px;
    }

    #actiongroup{
        background-color: rgba(240, 176, 117, 0.2);
        border-radius: 10px;
    }

    #mybutton{
        margin-left: 3px;
    }

    #interviewButton{
        color: white;
        background-color: #ed969e;
        text-shadow: 0.3px 0.3px 0.3px black;
        background: -webkit-linear-gradient(top, lightpink, #ed969e);
        background: -moz-linear-gradient(top, lightpink, #ed969e);
        background: -ms-linear-gradient(top, lightpink, #ed969e);
        margin-left: 3px;
    }

    #restoreButton{
        color: white;
        background-color: deepskyblue;
        text-shadow: 0.3px 0.3px 0.3px black;
        background: -webkit-linear-gradient(top, deepskyblue,dodgerblue);
        background: -moz-linear-gradient(top, deepskyblue,dodgerblue);
        background: -ms-linear-gradient(top, deepskyblue, dodgerblue);
        margin-left: 3px;
    }

    #archiveButton{
        color: white;
        background-color: dimgrey;
        text-shadow: 0.3px 0.3px 0.3px black;
        background: -webkit-linear-gradient(top, darkgrey,dimgrey);
        background: -moz-linear-gradient(top, darkgrey,dimgrey);
        background: -ms-linear-gradient(top,darkgrey, dimgrey);
        margin-left: 3px;
    }

    #printButton{
        color: white;
        background-color: dimgrey;
        text-shadow: 0.3px 0.3px 0.3px black;
        background: -webkit-linear-gradient(top, #2dabf9,#5ec5ff);
        background: -moz-linear-gradient(top, #2dabf9,#5ec5ff);
        background: -ms-linear-gradient(top,#2dabf9, #5ec5ff);
        margin-left: 3px;
    }

    .button:hover{
        text-decoration: underline;
    }
    .button{

    }

    ul.breadcrumb {
        padding: 10px;
        list-style: none;
        background-color: white;
    }
    ul.breadcrumb li {
        display: inline;
        font-size: 18px;
    }
    ul.breadcrumb li+li:before {
        padding: 0;
        color: black;
        content: "/\00a0";
    }
    ul.breadcrumb li a {
        color: #0275d8;
        text-decoration: none;
    }
    ul.breadcrumb li a:hover {
        color: #01447e;
        text-decoration: underline;
    }


</style>

<!-- retrieved displayed data -->
<?php
$id = $application->id;
$number_of_people = $application->number_of_people;
$first_name = $application->first_name;
$last_name = $application->last_name;
$preferred_name = $application->preferred_name;
$gender = $application->gender;
$contact_number = $application->contact_number;
$email = $application->email;
$australian_citizen = $application->australian_citizen;
$start_date = $application->start_date;
$end_date = $application->end_date;
$additional_comment = $application->additional_comment;
$enquiry_date = $application->enquiry_date;
$status = $application->status;

$property = $application->property;
$pid = $property->id;
$country = $property->country;
$state = $property->state;
$suburb = $property->suburb;
$street = $property->street;
$postcode = $property->postcode;
$unit_num = $property->house_number;
$br_num = $property->number_of_bedroom;
$ba_num = $property->number_of_bathroom;
$t_num = $property->number_of_toilet;
$info = $property->general_information;
$st_location = $unit_num." ".$street.", ".$suburb.", ".$state." ".$postcode;
$location = $st_location.", ".$country;

$room = $application->room;

if ($room->room_type==0){
    $rt = 'Private';
}else{
    $rt = 'Sharing';
}

if ($room->room_type_desc != null || strlen($room->room_type_desc) != 0){
    $r_n = $room->room_name.' ('.$rt.'-'.$room->room_type_desc.')';
}else{
    $r_n = $room->room_name.'('.$rt.')';
}



$addr = $location." (".$r_n.")";
?>

<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->


<body>
<!-- page content -->
<div class="wrapper">
    <div class="container">
        <div class="inline_field">
            <ul class="pull-left" style="padding-right:10px;">
                <?php
                echo $this->Html->link(
                    'Back',
                    ['controller' => 'Admins', 'action' => 'application_manage'],
                    ['class' => 'button btn-large btn-inverse']
                );
                ?>
            </ul>
            <ul class="breadcrumb inline_field">
                <li>
                    <?php
                    echo $this->Html->link(
                        'Dashboard',
                        ['controller' => 'Admins', 'action' => 'cpanel'],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'Applications',
                        ['controller' => 'Admins', 'action' => 'application_manage'],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>View</li>
            </ul>
        </div>

        <div id="action" class="control-group">

            <div class="inline_field">
                <h2>Application</h2>
            </div>
            <div class="inline_field">
                <p>on </p>
            </div>
            <div class="inline_field">
                <h4><?php echo $addr; ?></h4>
            </div>
            <br>
            <div id="action" class="control-group" >
                <?php
/*
                if ($application->application_status != 'd'){
                    */?><!--
                    <div class="inline_field">
                        <?php
/*                        echo $this->Html->link(
                            ' Edit',
                            ['controller' => 'Applications', 'action' => 'edit', $application->id],
                            ['id' => 'mybutton', 'class' => 'button btn-large span4  btn-warning fas fa-edit', 'style' => 'width:100px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                        );
                        // fas fa-bullhorn
                        */?>
                    </div>
                    --><?php
/*                }
                */?>

                <?php

                if ($application->application_status == 'p'){

                    ?>
                    <div class="inline_field">
                        <?php
                        echo $this->Form->postButton(
                            ' Interview',
                            ['controller' => 'Applications', 'action' => 'setinterview', $application->id],
                            ['class' => 'button btn-large span3 fas fa-comment-alt',
                                'id' => 'interviewButton',
                                'style' => 'width:140px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                        );
                        ?>
                    </div>
                    <?php
                }?>
                <?php
                if ($application->application_status == 'i'){
                    ?>
                    <div class="inline_field">
                        <?php
                       echo $this->Html->Link(
                            ' Accept',
                            ['controller' => 'Rentals', 'action' => 'add', $application->id],
                            ['class' => 'button btn-large span4 btn-success fas fa-check-circle',
                                'confirm' => 'By Accepting this Application, a Rental will be created.\nYou will have a chance to alter the rental information.\nAre you sure to Accept this Application?',
                                'style' => 'width:120px; border-radius: 35px; bottom:3px; margin-bottom: 5px; margin-left:3px;']
                        );
                        ?>
                      <!--  --><?php
/*                        echo $this->Html->Link(
                            ' Accept',
                            ['controller' => 'Applications', 'action' => 'accept', $application->id],
                            ['class' => 'button btn-large span4 btn-success fas fa-check-circle',
                                'confirm' => 'Are you sure to Accept this Application?',
                                'style' => 'width:120px; border-radius: 35px; bottom:3px; margin-bottom: 5px; margin-left:3px;']
                        );
                        */?>
                    </div>

                    <?php
                }
                ?>
                <?php
                if ($application->application_status != 'd'){
                    ?>
                    <div class="inline_field">

                        <?php
                        echo $this->Form->postButton(
                            ' Refuse',
                            ['controller' => 'Applications', 'action' => 'archive', $application->id],
                            ['confirm' => 'Are you sure to archive this application?',
                                'class' => 'button btn-large span3 fas fa-folder',
                                'id' => 'archiveButton',
                                'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px;']
                        );
                        ?>
                    </div>

                    <div class = "inline_field">
                        <button id="printButton" style="width:120px; float:right; bottom:3px; border-radius: 35px; margin-bottom: 5px;" onclick="printFunction()" class="button btn-large span3 fas fa-print">   Print</button>
                    </div>
                    <?php

                }
                ?>

                <?php
                if ($application->application_status == 'd'){
                    ?>
                    <div class="inline_field">
                        <?php
                        echo $this->Html->link(
                            ' Restore',
                            ['controller' => 'Applications', 'action' => 'admin_restore', $application->id],
                            ['class' => 'button btn-large span4 fas fa-folder-open',
                                'confirm' => 'Are you sure to restore this application?',
                                'id' => 'restoreButton',
                                'style' => 'width:120px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                        );
                        ?>
                    </div>

                    <div class="inline_field">
                        <?php
                        echo $this->Form->postButton(
                            ' Delete',
                            ['controller' => 'Applications', 'action' => 'delete', $application->id],
                            ['confirm' => 'Are you sure to delete this application?\nIt will be deleted forever and you CANNOT undo the action',
                                'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                                'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                        );
                        ?>
                    </div>
                    <?php
                }

                ?>

            </div>
        </div>


        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">
                    <div class="control-group" id="officeuse">
                        <div class="control-group" style="padding-left:5px;">
                            <h3>Office Use</h3>
                            <?php
                            if ($application->application_status == 'p'){
                                $status = "<h4 class='inline_field'><u>Pending</u></h4>,&nbsp;&nbsp;&nbsp;&nbsp;";
                            } elseif ($application->application_status == 'i'){
                                $status = "<h4 class='inline_field'><u>Interviewing</u></h4>,&nbsp;&nbsp;&nbsp;&nbsp;";
                            }elseif ($application->application_status == 'a'){
                                $status = "<h4 class='inline_field' style='color:darkgreen;'><u>Accepted</u></h4>,&nbsp;&nbsp;&nbsp;&nbsp;";
                            } else{
                                $status = "<h4 class='inline_field' style='color:red;'><u>Archived</u></h4>,&nbsp;&nbsp;&nbsp;&nbsp;";
                            }
                            echo "<h5 class='inline_field'>Application Status: &nbsp;&nbsp;</h5>".$status."";
                            $cd = $application->create_date;
                            $enquiry_date =  'on '.$this->Time->format(
                                    $cd, #Your datetime variable
                                    'dd/MM/Y HH:mm'            #Your custom datetime format
                                );
                            echo "<h5 class='inline_field'>Created Date: &nbsp;&nbsp;</h5><h4 class='inline_field'><u>".$enquiry_date."</u></h4>";
                            ?>
                        </div>
                    </div>

                    <!-- application detail -->
                    <div class="control-group">
                        <h3>Application Details</h3>
                        <div class="inline_field">
                            <p>on </p>
                        </div>
                        <div class="inline_field">
                            <?php
                            echo $this->Html->link(
                                $location,
                                ['controller' => 'Properties', 'action' => 'admin_view', $application->property_id],
                                ['class'=> 'inline_filed', 'style' => 'font-size:18px; font-weight: bold']
                            );
                            ?> |
                            <?php
                            echo $this->Html->link(
                                $r_n,
                                ['controller' => 'Rooms', 'action' => 'index', $application->property_id],
                                ['class'=> 'inline_filed', 'style' => 'font-size:18px; font-weight: bold']
                            );
                            ?>
                        </div><br>
                        <?php
                        $s_d = $application->start_date;
                        $e_d = $application->end_date;
                        $e_d = $e_d->i18nFormat('dd/MM/yyyy');
                        $s_d = $s_d->i18nFormat('dd/MM/yyyy');
                        $start = "<p class='inline_field'>Expected Staying Period: &nbsp;&nbsp; </p><h4 class='inline_field'><u>".$s_d."</u></h4> to <h4 class='inline_field'><u>".$e_d."</u></h4>"."&nbsp;&nbsp; (<h4 class='inline_field'><u>".$application->duration." months</u></h4>)";
                        echo $start;
                        ?>
                        <div>
                            <p class="inline_field">Number of People Staying:&nbsp;&nbsp; </p><h4 class="inline_field"><?php echo $application->number_of_people;?></h4>
                        </div>
                        <div>
                            <p class="inline_field">Beds Preferred:&nbsp;&nbsp; </p>
                            <h4 class="inline_field">
                                <!-- display beds -->
                                <?php
                                    foreach ($app_room_beds as $arb){
                                       foreach ($room_beds as $rb){
                                            if ($rb->id == $arb->bed_room_id){
                                                foreach ($beds as $b){
                                                    if ($b->id == $rb->bed_id){
                                                        echo "<p class='inline_field'>".$b->bed_name.".&nbsp;</p>";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    //echo $application->number_of_people;
                                ?>
                            </h4>
                        </div>
                        <div>
                            <p class="inline_field">Main Contact Information: &nbsp;&nbsp;</p><h4 class="inline_field">
                                <?php
                                $name = $application->contact_name;
                                echo $name;
                                $contact = " (<i class='fas fa-phone'></i>"." ".$application->contact_number.", ";
                                $contact = $contact." "."<i class='fas fa-envelope'></i>"." ".$application->contact_email.")";
                                echo $contact;
                                ?>
                            </h4>
                        </div>
                    </div>
                    <!-- end application detail -->

                    <!-- applicants -->
                    <div class="control-group">
                        <h3>Applicants Details</h3>
                        <?php
                        $applicants = $application->applicants;
                        $count = 1;
                        foreach ($applicants as $applicant){
                            echo "<div style='padding-bottom: 5px;'>";
                            echo "<p class='inline_field'>Applicant ".$count.":&nbsp;&nbsp;</p>";
                            $count += 1;
                            $name = $applicant->first_name." ".$applicant->last_name;
                            if ($applicant->preferred_name != null){
                                $name = $name." (".$applicant->preferred_name."), ";
                            }
                            if ($applicant->gender == 0){
                                $gender = "Male";
                            }else{
                                $gender = "Female";
                            }
                            if ($applicant->australian_citizen == 0){
                                $ac = ", Australian Citizen";
                            }else{
                                $ac = ", Not Australian Citizen";
                            }
                            $name = $name."  "."(".$gender.")".$ac;
                            if ($applicant->personal_contact_phone != null){
                                $phone = " ("."<i class='fas fa-phone inline_field'></i><h4 class='inline_field'>&nbsp;".$applicant->personal_contact_phone.")</h4>";
                                $name = $name.$phone;
                            }else{
                                $phone = " (<i class='fas fas fa-phone'></i> ----)";
                                $name = $name.$phone;
                            }
                            echo "<h4 class='inline_field'>".$name."</h4>";
                            echo "</div>";
                            ?>

                            <?php
                        }
                        ?>
                    </div>
                    <!-- applicants end -->

                    <!-- additional info -->
                    <div  class="control-group">
                        <h3>Additional Comment</h3>
                        <?php
                        if ($application->additional_comment == null){
                            echo "<p>No additional Comments</p>";
                        }else{
                            echo $application->additional_comment;
                        }
                        ?>
                    </div>
                    <!-- end additional info -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<script>
    function printFunction() {
        window.print();
    }
</script>
<!-- end of footer -->
</body>

