<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->assign("title","View Application | NAIM Admin"); ?>
</head>
<!-- end of head -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<style>


    .dataTables_filter {
        width:160px;
    }
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

    .button:hover{
        text-decoration: underline;
    }
    .button{

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
$st_location = $unit_num." ".$street.", ".$suburb.", ".$state.$postcode;
$location = $st_location.", ".$country;

$room = $application->room;
$r_n = $room->room_name;

$addr = $location." (".$r_n.")";
?>
<!-- end retrieved displayed data -->

<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->

<body>
<!-- page content -->
<div class="wrapper">
    <div class="container">

        <!-- back button -->
        <div class="inline_field">
            <ul class="pull-left">
                <?php
                echo $this->Html->link(
                    'Back',
                    $this->request->referer(),
                    ['class' => 'button btn-large btn-inverse']
                );
                ?>
            </ul>
        </div>
        <!-- end back button -->

        <div>
            <div class="inline_field">
                <h2>Editing Application</h2>
            </div>
            <div class="inline_field">
                <p>on </p>
            </div>
            <div class="inline_field">
                <h4><?php echo $addr; ?></h4>
            </div>
        </div>

        <!-- main content -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">

                    <!-- NOT EDITABLE: office section -->
                    <div class="control-group" id="officeuse">
                        <div class="control-group" style="padding-left:5px;">
                            <h3>Office Use</h3>
                            <div>
                                <div class="inline_field">
                                    <p>on </p>
                                </div>
                                <div class="inline_field">
                                    <?php
                                    echo $this->Html->link(
                                        $location,
                                        ['controller' => 'Properties', 'action' => 'admin_view', $application->property_id],
                                        ['confirm' => 'Are you sure to leave this page?\nAll your Unsaved change will be lost.',
                                                'class'=> 'inline_filed', 'style' => '']
                                    );
                                    ?> ,
                                    <?php
                                    echo $this->Html->link(
                                        $r_n,
                                        ['controller' => 'Rooms', 'action' => 'index', $application->property_id],
                                        ['confirm' => 'Are you sure to leave this page?\nAll your Unsaved change will be lost.',
                                            'class'=> 'inline_filed', 'style' => '']
                                    );
                                    ?>
                                </div>
                            </div>
                            <?php
                            $cd = $application->create_date;
                            $enquiry_date =  'on '.$this->Time->format(
                                    $cd, #Your datetime variable
                                    'dd/MM/Y HH:mm'            #Your custom datetime format
                                );
                            echo "<h5 class='inline_field'>Created Date: &nbsp;&nbsp;</h5><h4 class='inline_field'><u>".$enquiry_date."</u></h4>";
                            ?>

                        </div>
                    </div>
                    <!-- end office section -->


                    <!-- EDIT BEGIN -->

                    <!-- application detail -->
                    <div class="control-group">
                        <?= $this->Form->create($application) ?>
                        <h3>Edit Application Details</h3>
                        <?php
                        $status_list = array();
                        $status_list[0] = 'Pending';
                        $status_list[1] = "Interviewing";
                        $status_list[2] = "Accepted";
                        $status_list[3] = "archived";
                        if ($application->application_status == 'p'){
                            $d = 0;
                        } elseif ($application->application_status == 'i'){
                            $d = 1;
                        } elseif ($application->application_status == 'a'){
                            $d = 2;
                        }else{
                            $d=3;
                        }

                        echo $this->Form->control(
                            'application_status',
                            ['label' => 'Application Status',
                                'style' => 'height:120%;',
                                'required' => 'required',
                                'default' => $d,
                                'type'  => 'select',
                                'options' => $status_list
                            ]); ?>
                        <br>

                        <!-- main contact -->
                        <div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('contact_name', ['label' => 'Main Contact Name', 'type' => 'text',
                                    'class' => 'span10'
                                ]);
                                ?>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('contact_number', ['label' => 'Main Contact Phone','type' => 'text',
                                    'class' => 'span10'
                                ]);
                                ?>
                            </div>
                            <div class="inline_field">
                                <?php
                                echo $this->Form->control('contact_email', ['label' => 'Main Contact Email','type' => 'text',
                                    'class' => 'span12'
                                ]);
                                ?>
                            </div>
                        </div>
                        <!-- end main contact -->
                        <br>

                        <!-- time -->
                        <div>
                            <div class="inline_field" style="margin-right:10px; padding-top:1px;">
                                <?php
                                echo
                                $this->Form->control('start_date', [
                                    'label' => 'Expected Starting Date',
                                    'type' => 'date',
                                    'placeholder' => 'Select a Date',
                                   ]);
                                ?>
                            </div>

                            <div class="inline_field" style="padding-top:1px;">
                                <?php
                                echo $this->Form->control('duration',
                                    [
                                        'label' => 'Number of Months staying',
                                        'min' => 3,
                                        'type' => 'number',
                                        'class'=>'span12',])
                                ?>
                            </div>
                        </div>
                        <!-- end time -->
                    </div>
                    <!-- end application detail -->

                    <!-- applicant -->
                    <div class="control-group">
                        <h3>Edit Applicant Details</h3>
                        <?php
                        //debug($application->applicants);
                        $i = 0;
                        foreach ($application->applicants as $applicant){
                            echo $this->Form->control('id');
                            //debug($applicant);
                            ?>

                            <h5><u>Applicant <?php echo $i+1; ?></u></h5>
                            <div>
                                <div class="inline_field">
                                    <?php
                                    echo $this->Form->control('applicants.'.$i.'.first_name', ['label' => 'First Name','type' => 'text',
                                        'class' => 'span11'
                                    ]);
                                    ?>
                                </div>
                                <div class="inline_field">
                                    <?php
                                    echo $this->Form->control('applicants.'.$i.'.last_name', ['label' => 'Last Name','type' => 'text',
                                        'class' => 'span11'
                                    ]);
                                    ?>
                                </div>
                                <div class="inline_field">
                                    <?php
                                    echo $this->Form->control('applicants.'.$i.'.preferred_name', ['label' => 'Preferred Name','type' => 'text',
                                        'class' => 'span11'
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div style="padding-top:10px;">
                                <div class="inline_field" style="padding-right:20px;">
                                <?php
                                $gender_list = array();
                                $gender_list[0] = 'Male';
                                $gender_list[1] = "Female";
                                $gender_list[2] = "Other";
                                echo $this->Form->control(
                                    'applicants.'.$i.'.gender',
                                    ['label' => 'Gender',
                                        'required' => 'required',
                                        'type'  => 'select',
                                        'options' => $gender_list,
                                    ]); ?>
                                </div>
                                <div class="inline_field">
                                    <?php
                                    $my_list = array();
                                    $my_list[0] = 'Yes';
                                    $my_list[1] = "No";
                                    echo $this->Form->control(
                                        'applicants.'.$i.'.australian_citizen',
                                        ['label' => 'Is Australian Citizen',
                                            'required' => 'required',
                                            'type'  => 'select',
                                            'options' => $my_list,
                                        ]); ?>
                                </div>
                            </div>
                            <div style="padding-top:10px;">

                                    <?php   echo $this->Form->control(
                                        'applicants.'.$i.'.personal_contact_phone',
                                        ['label' => 'Personal Contact Phone',
                                            'type'  => 'text',
                                            'placeholder' => 'Personal Contact Phone',
                                            'class' => 'span4'
                                        ]); ?>

                            </div>
                            <br>
                            <br>
                        <?php

                            $i++;
                        }


                        ?>

                    </div>
                    <!-- applicant -->
                    <!-- EDIT END -->
                </div>

            </div>
        </div>

        <?php echo $this->Form->button('Save All',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'style' => 'border-radius: 8px;',
                'confirm' => 'Are you sure you want to save your changes?',
                'disabled' => 'disabled'
            ]); ?>

        <?= $this->Form->end() ?>
        <!-- end main content -->
    </div>
</div>

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
</body>





