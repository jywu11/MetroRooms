<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rental $rental
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rental | Admin</title>
    <?php $this->assign("title","Rental Information | NAIM Admin"); ?>
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

    #printButton{
        color: white;
        background-color: dimgrey;
        text-shadow: 0.3px 0.3px 0.3px black;
        background: -webkit-linear-gradient(top, #2dabf9,#5ec5ff);
        background: -moz-linear-gradient(top, #2dabf9,#5ec5ff);
        background: -ms-linear-gradient(top,#2dabf9, #5ec5ff);
        margin-left: 3px;
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
$p = $property;
$r = $rental->room_id;
$unit = $p->house_number;
$country = $p->country;
$state = $p->state;
$suburb = $p->suburb;
$st = $p->street;
$postcode = $p->postcode;
$addr = $unit." ".$st.", ".$suburb.", ".$state." ".$postcode.", ".$country;

if ($room->room_type == 0){
    $r_t = "Private";
}else{
    $r_t = "Sharing";
}
if ($room->room_type_desc == "" || $room->room_type_desc == null){
    $r_n = $room->room_name."&nbsp;(".$r_t.")";
}else {
    $r_n = $room->room_name . "&nbsp;(" . $r_t." - ".$room->room_type_desc.")";
}

?>
<!-- end retrieved displayed data -->




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
                    $this->request->referer(),
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
                        'Rentals',
                        ['controller' => 'Rentals', 'action' => 'index'],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>View</li>
            </ul>
        </div>
        <br>

        <div>
            <div class="inline_field">
                <h2>Rental </h2>
            </div>
            <div class="inline_field">
                <p>on </p>
            </div>
            <div class="inline_field">
                <h4><?php echo $addr; ?></h4>
            </div>
        </div>

        <div id="action" class="control-group" >
            <?php
            if ($rental->rental_status == 0){
                ?>
                <div class="inline_field">
                    <?php
                    echo $this->Html->link(
                        ' Edit',
                        ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                        ['id' => 'mybutton', 'class' => 'button btn-large span4  btn-warning fas fa-edit', 'style' => 'width:100px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                    );
                    ?>
                </div>
                <div class="inline_field">
                    <?php
                    echo $this->Form->postButton(
                        ' Delete',
                        ['controller' => 'Rentals', 'action' => 'delete', $rental->id],
                        ['confirm' => 'Are you sure to delete this rental?\nIt will be deleted forever and you CANNOT undo the action',
                            'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                            'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                    );
                    ?>
                </div>

                <div class = "inline_field">
                    <button id="printButton" style="width:120px; float:right; bottom:3px; border-radius: 35px; margin-bottom: 5px;" onclick="printFunction()" class="button btn-large span3 fas fa-print">   Print</button>
                </div>
                <?php
            }?>
            <?php
            if ($rental->rental_status == 1){
                ?>
                <div class="inline_field">
                    <?php
                    echo $this->Html->link(
                        ' Edit',
                        ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                        ['id' => 'mybutton', 'class' => 'button btn-large span4  btn-warning fas fa-edit', 'style' => 'width:100px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                    );
                    ?>
                </div>
                <div class="inline_field">
                    <?php
                    echo $this->Form->postButton(
                        ' Archive',
                        ['controller' => 'Rentals', 'action' => 'setarchive', $rental->id],
                        ['confirm' => 'If you archive this rental, it will no longer be active, meaning the time and beds occupied will be available for applications. Are you sure to archive this rental? ',
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
            if ($rental->rental_status == 2){
                ?>
                <div class="inline_field">
                    <?php
                    /*echo $this->Html->link(
                        ' Edit',
                        ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                        ['disabled'=>'disabled', 'onclick'=>'return false;', 'id' => 'mybutton', 'class' => 'button btn-large span4  btn-warning fas fa-edit', 'style' => 'width:100px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                    );*/
                    ?>
                </div>
                <div class="inline_field">
                    <?php
                    echo $this->Html->link(
                        ' Restore',
                        ['controller' => 'Rentals', 'action' => 'edit', $rental->id],
                        ['class' => 'button btn-large span4 fas fa-folder-open',
                            'id' => 'restoreButton',
                            'style' => 'width:120px; border-radius: 35px; bottom:3px; margin-bottom: 5px;']
                    );
                    // 'confirm' => 'You will be directed to edit this rental, after ensure all information is correct, please save in the edit mode to restore the rental. Are you sure to restore this rental?',
                    ?>
                </div>

                <div class="inline_field">
                    <?php
                    echo $this->Form->postButton(
                        ' Delete',
                        ['controller' => 'Rentals', 'action' => 'delete', $rental->id],
                        ['confirm' => 'Are you sure to delete this rental?\nIt will be deleted forever and you CANNOT undo the action',
                            'class' => 'button btn-large span3 btn-danger fas fa-trash-alt',
                            'style' => 'width:120px; bottom:3px; border-radius: 35px; margin-bottom: 5px; margin-left: 3px;']
                    );
                    ?>
                </div>

                <?php

            }
            ?>

        </div>

        <!-- main content -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <div class="form-horizontal row-fluid">

                    <!-- NOT EDITABLE: office section -->
                    <div class="control-group" id="officeuse" style="margin-bottom:10px;">
                        <div class="control-group" style="padding-left:5px;">
                            <h3>Office Use</h3>
                            <div class="inline_field" style="padding-left: 10px">
                                <?php
                                if ($rental->rental_status == 0){
                                    $status = "<h4 class='inline_field' style='color:darkred;'><u>Expired</u></h4>&nbsp;&nbsp;&nbsp;&nbsp;";
                                } elseif ($rental->rental_status == 1){
                                    $status = "<h4 class='inline_field' style='color:darkgreen;'><u>Active</u></h4>&nbsp;&nbsp;&nbsp;&nbsp;";
                                }elseif ($rental->rental_status == 2){
                                    $status = "<h4 class='inline_field' style='color:darkblue;'><u>Archived</u></h4>&nbsp;&nbsp;&nbsp;&nbsp;";
                                }
                                echo "<h5 class='inline_field'>Rental Status: &nbsp;&nbsp;</h5>".$status."";
                                ?>
                            </div>

                            <div style="padding-left:10px;">
                                <div class="inline_field">
                                    <span>Rental in</span>
                                </div>
                                <div class="inline_field">
                                    <?php echo "<p><b style='color:black;'>".
                                        $this->Html->link($addr,
                                            ['controller'=>'Properties', 'action'=>'adminView', $property->id])
                                    ." | ".
                                        $this->Html->link($r_n,
                                            ['controller'=>'Rooms', 'action'=>'index', $property->id], ['escape'=>false])
                                        ."</b></p>"; ?>
                                </div>
                            </div>
                            <div style="padding-left:10px;">
                                <div>
                                    <?php
                                    echo $this->Html->Link(
                                        "Go to Bottom of Page for the Details of this rental's Application",
                                        '#app'
                                    );

                                    ?>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <!-- end office section -->

                    <!-- ROOM RENTAL -->
                    <div  id="dis_av_r" onclick="show_info_r();">
                        <div style="background-color: #ecfaff; border-radius: 10px; margin-top:3px; margin-bottom:10px;">
                            <p class="inline_field fas fa-info-circle" style="margin-top:5px; padding: 5px;"></p>&nbsp;Click me to see all this room's rentals.
                        </div>
                    </div>
                    <div id="r_av_r"  onclick="hide_info_r();" style=" display:none;">
                        <div style="color:black; border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #ecfaff; ">
                            <div style="padding: 5px; padding-bottom:0;">
                                <p class="inline_field fas fa-info-circle"></p>&nbsp;Click to close me.
                                <div>
                                    <h5>Room's Active Rentals:</h5>
                                    <?php
                                    if (count($rentals) == 0){
                                        echo "<p>The room currently has no active rental.</p>";
                                    }
                                    else{
                                        $counter = 1;
                                        foreach ($rentals as $r){
                                            $s = new \Cake\I18n\Time($r->start_date);
                                            $s =  $this->Time->format($s,'dd/MM/Y');
                                            $e = new \Cake\I18n\Time($r->end_date);
                                            $e =  $this->Time->format($e,'dd/MM/Y');
                                            echo "<div style='padding:2px;'>";
                                            $rental_name = " - View Rental ".$counter." ";
                                            echo $this->Html->Link(
                                                $rental_name,
                                                ['controller' => 'Rentals', 'action'=>'view', $r->id],
                                                ['class'=> 'inline_field']
                                            );
                                            echo "&nbsp;&nbsp;&nbsp;<p class='fas fa-calendar-alt inline_field'></p>&nbsp;<p style='color:black' class='inline_field'>".$s." ~ ".$e."</p>,&nbsp;&nbsp;";
                                            echo "<p class='fas fa-user inline_field'></p><p class='inline_field'>&nbsp;".$r->number_of_tenant."</p><p class='inline_field' style='color:black;'></p>,&nbsp;&nbsp;";
                                            $bedStr = '';

                                            foreach ($rent_bed_rooms as $rbr){
                                                if ($rbr->rental_id == $r->id){
                                                    $brid = $rbr->bed_room_id;
                                                    foreach($room_beds as $rb){
                                                        if ($rb->id == $brid){
                                                            foreach ($beds as $b){
                                                                if ($b->id == $rb->bed_id){
                                                                    $bedStr = $bedStr.$b->bed_name.".&nbsp";
                                                                    //debug($bedStr);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            echo "<p class='inline_field fas fa-bed'></p><p class='inline_field'>&nbsp;".$bedStr."</p>";
                                            echo "</div>";
                                            //debug($rental);
                                            $counter += 1;
                                        }
                                    }
                                    ?>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END ROOM RENTAL -->
                    <hr>

                    <!-- Rental detail Begin -->
                    <h3>Rental Period</h3>

                    <br>
                    <div class="input-group date">
                        <div style="padding-left:10px;">
                            <?php
                            $start = $rental->start_date->format('d/m/Y');
                            $end = $rental->end_date->format('d/m/Y');
                            echo "<span class='inline_field'>Start date: &nbsp;</span><p class='inline_field'><b class='inline_field' style='color:black'>".$start."</b></p><br>";
                            echo "<span class='inline_field'>End date: &nbsp;</span><p class='inline_field'><b class='inline_field' style='color:black'>".$end."</b></p><br>";
                            echo "<span class='inline_field'>Duration: &nbsp;</span><p class='inline_field'><b class='inline_field' style='color:black'>".$rental->duration."&nbsp;month(s)</b></p>";
                            ?>
                        </div>
                    </div>
                    <!-- end main contact -->
                </div>
                <hr>

                <!-- Confirm Main Contact Information -->
                <h3>Rental's Main Contact</h3>
                <div>
                    <div style="padding-left:10px;"><br>
                        <div>
                            <span class='inline_field'>Main Contact Name: &nbsp;</span>
                            <p class='inline_field'><b class='inline_field' style='color:black; word-break: break-word;'><?php echo $rental->contact_name; ?></b></p><br>
                        </div>
                        <div>
                            <span class='inline_field'>Main Contact Phone: &nbsp;</span>
                            <p class='inline_field'><b class='inline_field' style='color:black'><?php echo $rental->contact_phone; ?></b></p><br>
                        </div>
                        <div>
                            <span class='inline_field'>Main Contact Email: &nbsp;</span>
                            <p class='inline_field'><b class='inline_field' style='color:black'><?php echo $rental->contact_email; ?></b></p><br>
                        </div>
                    </div>
                </div>
                <!--  end Confirm Main Contact Information -->

                <hr>

                <!-- Confirm Beds Staying -->
                <h3>Beds Occupied By This Rental</h3>
                <div style="padding-left:10px;">
                    <?php
                    $flag = 0;
                    foreach ($rent_bed_rooms as $rbr){
                        if ($rbr->rental_id == $rental->id){
                            foreach($room_beds as $rb){
                                if ($rb->id == $rbr->bed_room_id){
                                    foreach ($beds as $b){
                                        if ($b->id == $rb->bed_id){
                                            $flag =1;
                                            echo "<div><p class='inline_field'>&nbsp;-&nbsp;</p><p class='inline_field' style='color:black;'>".$b->bed_name."</p></div>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($flag == 0){
                        echo "<p>No beds being recorded for this rental</p>";
                    }
                    ?>
                </div>

                <!-- end application detail -->
                <hr>


                <!-- Tenants -->
                <input type="hidden" value="0" id="tenantNum">
                <div id="tent" class="control-group">
                    <h3>Tenants Details</h3>
                    <?php
                    $i = 0;
                    foreach ($tenants as $tenant){
                        $tag_id = "tenant".$i;
                        ?>
                        <div style="border-radius: 10px; border: solid 1px #ffc107;" id="<?php echo $tag_id; ?>">
                            <div style="padding-left:10px;">
                                <br>
                                <div>
                                    <div>
                                        <h4><u>Tenant <?php echo $i+1; ?></u></h4>
                                    </div>
                                </div>
                                <div>
                                    <div class="inline_field">
                                        <div>
                                            <span class='inline_field'>Tenant Name: &nbsp;</span>
                                            <p class='inline_field'><b class='inline_field' style='color:black; word-break: break-word;'><?php echo $tenant->first_name."&nbsp;".$tenant->last_name; ?></b></p>
                                            <?php
                                            if ($tenant->preferred_name != "" && $tenant->preferred_name != null){
                                                echo "<p class='inline_field'>(".$tenant->preferred_name.")</p>";
                                            }
                                            ?>
                                            <br>
                                        </div>
                                        <div>
                                            <span class='inline_field'>Gender: &nbsp;</span>
                                            <?php
                                            $g = "--";
                                            if ($tenant->gender == 0){
                                                $g = 'Male';
                                            }elseif($tenant->gender == 1) {
                                                $g = "Female";
                                            }else{
                                                $g = "Other";
                                            }
                                            ?>
                                            <p class='inline_field'><b class='inline_field' style='color:black'><?php echo $g; ?></b></p>
                                        </div>
                                        <div>
                                            <span class='inline_field'>Is Australian Citizen: &nbsp;</span>
                                            <?php
                                            $a = "--";
                                            if ($tenant->is_aus_citizen == 0){
                                                $a = "Yes";
                                            }else{
                                                $a = "No";
                                            }
                                            ?>
                                            <p class='inline_field'><b class='inline_field' style='color:black'><?php echo $a; ?></b></p>
                                            <br>
                                        </div>
                                        <div>
                                            <span class='inline_field'>Personal Contact Phone: &nbsp;</span>
                                            <?php
                                            if ($tenant->personal_contact_phone != "" && $tenant->personal_contact_phone != null){?>
                                                <p class='inline_field'>
                                                    <b class='inline_field' style='color:black'>
                                                        <?php echo $tenant->personal_contact_phone; ?>
                                                    </b>
                                                </p>
                                                <br>
                                            <?php
                                            }else{
                                                echo "<p class='inline_field'><b class='inline_field' style=''>This tenant doesn't provide a personal contact phone</b></p><br>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i++;
                        echo "<br>";
                    } ?>
                </div>
                <!-- end tenants -->


            </div>
        </div>
        <!-- end main content -->

        <hr>
        <?php
        //debug($application);
        ?>
        <div id="app">
            <?php
           // $application = $rental->application;
            if ($application == null){
                echo "<div class='module' style='background-color:white;'><div class='module-body'>Sorry, the application associated with this rental no longer exists</div></div>";
            }else{
                ?>
                <div class="module">
                    <div class="module-body">
                        <?php
                        $c = new \Cake\I18n\Time($application->create_date);
                        $c =  $this->Time->format($c,'dd/MM/Y');
                        ?>
                        <h4>Application Associated With This Rental</h4>
                        <span>This application was created on <?php echo $c; ?></span>
                        <hr>
                        <div>


                        </div>
                        <div>
                            <?php
                            $st = new \Cake\I18n\Time($application->start_date);
                            $st=  $this->Time->format($st,'dd/MM/Y');
                            $ed = new \Cake\I18n\Time($application->end_date);
                            $ed=  $this->Time->format($ed,'dd/MM/Y');
                            ?>
                           <p><b style="color:black;">Application General Information</b></p>
                            <div style="padding-left:10px;">
                                <p style="word-break: break-word;">Main Contact: <?php echo $application->contact_name."&nbsp;&nbsp;(".$application->contact_number.",&nbsp;".$application->contact_email.")" ; ?></p>
                                <p style="word-break: break-word;">Expected Staying: <?php echo "From&nbsp<u>".$st."&nbsp;to&nbsp;".$ed."</u>&nbsp;(".$application->duration."&nbsp;months)"; ?></p>
                            </div>
                            <br></br>
                            <p><b style="color:black;">Applicants Information</b></p>
                            <?php
                            $counter = 1;
                            foreach ($applicants as $a){
                                echo "<div style='padding-left:10px;'>";
                                echo "<u style='color:black; word-break: break-word;'>Applicant&nbsp;".$counter."</u>";
                                $pn = "no preferred name provided";
                                if ($a->preferred_name != '' && $a->preferred_name != ""){
                                    $pn = $a->preferred_name;
                                }
                                $g = '--';
                                if (strval($a->gender)=="0"){
                                    $g = 'Male';
                                }else{ $g = 'Female'; }
                                $ausc = "--";
                                if (strval($a->australian_citizen) == "0"){
                                    $ausc = 'Is Australian Citizen';
                                }else{ $ausc = "Not Australian Citizen"; }
                                $p = "no phone provided";
                                if ($a->personal_contact_phone != null && $a->personal_contact_phone != ""){
                                    $p = $a->personal_contact_phone;
                                }

                                echo "<p style='word-break: break-word;'>".$a->first_name."&nbsp;".$a->last_name."&nbsp;(".$pn."),&nbsp;".$g.",&nbsp;".$ausc."&nbsp;(".$p.")</p>";

                                echo "</div>";
                                $counter += 1;
                            }

                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>


    </div>
</div>



<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
</body>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

<!-- onload validation -->
<script>
    $(function(){
        var timeValid = validateTime();
    });


</script>
<!-- end onload validation -->

<script>
    function validEndBeforeCurrent(){
        alert('validEndBeforeCurrent');
    }
</script>



<!-- update capacity base on start time change -->
<script>
    $(document).ready(function() {
        $('input[name="duration"]').change(function(){
            let du = $('input[name="duration"]').val();
            validation(du);
        });
        function validation(du){
            // if ends before today
            //alert(du);
            /*if ((num_m+parseInt(du))%12 != 0){
                y = parseInt(y)+1;
                m = (num_m+parseInt(du))%12;
            }
            let givenDate = y +"-"+ m + "-"+ d;
            alert(givenDate);
            let currentDate = new Date();
            givenDate = new Date(givenDate);
            if (givenDate < currentDate){
                var ele_1 = document.getElementById("endbeforetoday");
                ele_1.setAttribute("style", "");
            }else{
                var ele_2 = document.getElementById("endbeforetoday");
                ele_2.setAttribute("style", "display:none;");
            }*/
        }
        function cap(){
            //alert("cap");
        }
    });
</script>

<!-- validate date -->
<script>
    $(function(){
        $( ".dateAndDuration" ).change(function() {
            alert('here');
            var startValid = 1;
            $('.dateAndDuration').each(function() {
                if ($(this).val() === '') {
                    startValid = 0;
                }
            });

            if (startValid == 1){
                // all fields entered, start validation
                var validRes = validateDate();
                return validRes;
            }
        });
        function validateDate(){
            let y = $('select[name="start_date[year]"').children("option:selected").val();
            let m = $('select[name="start_date[month]"').children("option:selected").val();
            let d = $('select[name="start_date[day]"').children("option:selected").val();
            let givenDate = y +"-"+ m + "-"+ d;
            //alert(givenDate);
            let currentDate = new Date();
            givenDate = new Date(givenDate);

            // chcek start date
            if (givenDate > currentDate){
                // check if the date satisfies the time slot constraint
            }else{
                alert("Your Select Date is Before Current Date, please ensure this is NOT a mistake.\n\nNote that you are ALLOWED to start a rental from a date before the current date.");
            }
            // check duration
            let du = $('input[name="duration"]').val();
            let e_y = y;
            let e_m = m;
            let e_d = d;
            let num_m = parseInt(m);
            if ((num_m+parseInt(du))%12 != 0){
                y = parseInt(y)+1;
                m = (num_m+parseInt(du))%12;
            }
            let endDate = y +"-"+ m + "-"+ d;
            //alert(endDate);
            endDate = new Date(endDate);
            if (endDate < currentDate){
                var ele_1 = document.getElementById("endbeforetoday");
                ele_1.setAttribute("style", "");
            }else{
                var ele_2 = document.getElementById("endbeforetoday");
                ele_2.setAttribute("style", "display:none;");
            }
        }
    });

</script>

<!-- check if rental ends before today -->
<script>
    $(document).ready(function() {
        /*  $('input[name="duration"]').change(function(){
              alert("here");
              // first validate
              let du = $('input[name="duration"]').val();
              alert(du);
              validation(du);
              // cal cap
              cap();
          });*/
    });
</script>

<!--  tenant generate ADD -->
<script>
    $(document).ready(function(){
        // my jquery methods
        $("#add_t").click(addTenant);
        function addTenant(){
            var ref = document.getElementById('tent');
            //alert("here");
            // create another tenant field, if the max cap isn't exceeded.

            var ele = document.getElementById('cap');
            var new_num = document.getElementById('number-of-people').value;
            // var ref = document.getElementById('ref_child');


            // remove old fields
            $('.added').remove();


            // get new number of people, generate form
            for (let i=0; i < new_num; i++){
                var row = document.createElement("div"); // fieldset
                row.setAttribute('class', 'added');
                var card_div = document.createElement("div");       // card div
                card_div.setAttribute('class', 'card border-warning');
                var card_header = document.createElement("h6");    // card header div
                card_header.setAttribute('class', 'card-header');
                card_header.append('Details of Applicant ', i+1);
                var card_body = document.createElement('div');
                card_body.setAttribute('class', 'card-body');       // card body div
                var row_1 = document.createElement("div");          // ROW 1
                row_1.setAttribute('class', 'row');
                // first name div
                var fn_div_div = document.createElement("div");
                fn_div_div.setAttribute('class', 'col-lg-4');
                var fn_div = document.createElement("div");
                fn_div.setAttribute('class', 'input text required');
                fn_div.innerHTML = "" +
                    "<label for=\"first-name\">First Name</label>" +
                    "<input type=\"text\" " +
                    "name=\"applicants["+i.toString()+"][first_name]\"  " +
                    "placeholder=\"First Name\" " +
                    "required=\"required\" " +
                    "maxlength=\"255\" " +
                    "id=\"applicants-"+i.toString()+"-first-name\" " +
                    "data-validation=\"custom\"" +
                    " data-validation-regexp=\"^([A-Za-z]+)$\"" +
                    " data-validation-error-msg = \"Please enter a valid first name\">";
                fn_div_div.appendChild(fn_div);
                // last name div
                var ln_div_div = document.createElement("div");
                ln_div_div.setAttribute('class', 'col-lg-4');
                var ln_div = document.createElement("div");
                ln_div.setAttribute('class', 'input text required');
                ln_div.innerHTML = "" +
                    "<label for=\"last-name\">Last Name</label>" +
                    "<input type=\"text\" name=\"applicants["+i.toString()+"][last_name]\" " +
                    "placeholder=\"Last Name\" " +
                    "required=\"required\" " +
                    "maxlength=\"255\" " +
                    "id=\"applicants-"+i.toString()+"-last-name\" " +
                    "data-validation=\"custom\" " +
                    "data-validation-regexp=\"^([A-Za-z]+)$\"" +
                    " data-validation-error-msg = \"Please enter a valid last name\">";
                ln_div_div.appendChild(ln_div);
                // preferred name div
                var pn_div_div = document.createElement("div");
                pn_div_div.setAttribute('class', 'col-lg-4');
                var pn_div = document.createElement("div");
                pn_div.setAttribute('class', 'input text');
                pn_div.innerHTML = "" +
                    "<label for=\"preferred-name\">Preferred Name</label>" +
                    "<input type=\"text\" " +
                    "name=\"applicants["+i.toString()+"][preferred_name]\" " +
                    "placeholder=\"Preferred Name\" " +
                    "maxlength=\"255\" " +
                    "id=\"applicants-"+i.toString()+"preferred-name\" " +
                    "data-validation=\"custom\" " +
                    "data-validation-regexp=\"^([A-Za-z ]+)$\"" +
                    " data-validation-error-msg = \"Please enter a valid preferred name if you have one. Please leave it blank if you do not.\" " +
                    "data-validation-optional=\"true\"" +
                    ">";
                pn_div_div.appendChild(pn_div);
                row_1.appendChild(fn_div_div);
                row_1.appendChild(ln_div_div);
                row_1.appendChild(pn_div_div);

                var row_2 = document.createElement("div");          // ROW 2
                row_2.setAttribute('class', 'row');
                var g_div_div = document.createElement("div");     // gender div
                g_div_div.setAttribute('class', 'col-lg-4');
                var g_div = document.createElement("div");
                g_div.setAttribute('class', 'input select required');
                g_div.innerHTML = "" +
                    "<label for=\"gender\">Gender</label>" +
                    "<select name=\"applicants["+i.toString()+"][gender]\" required=\"required\" id=\"applicants-"+i.toString()+"-gender\">" +
                    "<option value=\"0\" selected=\"selected\">Male</option>" +
                    "<option value=\"1\">Female</option>" +
                    "<option value=\"2\">Other</option></select>";
                g_div_div.appendChild(g_div);
                var ac_div_div = document.createElement("div");     // aus citizen div
                ac_div_div.setAttribute('class', 'col-lg-4');
                var ac_div = document.createElement("div");
                ac_div.setAttribute('class', 'input select required');
                ac_div.innerHTML = "" +
                    "<label for=\"australian-citizen\">Is Australian Citizen</label>" +
                    "<select name=\"applicants["+i.toString()+"][australian_citizen]\" required=\"required\" id=\"applicants-"+i.toString()+"-australian-citizen\">" +
                    "<option value=\"0\" selected=\"selected\">Yes</option>" +
                    "<option value=\"1\">No</option></select>";
                ac_div_div.appendChild(ac_div);
                row_2.appendChild(g_div_div);
                row_2.appendChild(ac_div_div);

                var row_3 = document.createElement("div");          // ROW 3
                row_3.setAttribute('class', 'row');
                var pc_div_div = document.createElement("div");     // personal contact div
                pc_div_div.setAttribute('class', 'col-lg-12');
                var pc_div = document.createElement("div");
                pc_div.setAttribute('class', 'input select');
                pc_div.innerHTML = "" +
                    "<label for=\"personal-contact-phone\">Personal Contact Phone</label>" +
                    "<input type=\"text\"   " +
                    "name=\"applicants["+i.toString()+"][personal_contact_phone]\" " +
                    "placeholder=\"04\" " +
                    " "+
                    "id=\"applicants-"+i.toString()+"-personal-contact-phone\" " +
                    "data-validation-optional=\"true\" " +
                    "data-validation=\"number length\" " +
                    "data-validation-length=\"10\"" +
                    " data-validation-error-msg = \"Please enter a valid phone number if you have one, the format should be: 04aabbbccc.Please leave it blank if you do not.\">";
                pc_div_div.appendChild(pc_div);
                row_3.appendChild(pc_div_div);

                // merge
                card_div.appendChild(card_header);
                card_body.appendChild(row_1);
                card_body.appendChild(row_2);
                var next_line = document.createElement("br");
                card_body.appendChild(next_line);
                card_body.appendChild(row_3);
                card_div.appendChild(card_body);

                row.appendChild(card_div);
                var br = document.createElement("br");
                row.appendChild(br);
                ref.parentNode.appendChild(row);
                ref.parentNode.appendChild(row);
                $.validate({});
            }
        }
    });
</script>
<!-- end tenant generate ADD -->

<!-- datepicker -->
<script>
    $( function() {
        $( "#datepicker" ).datepicker({
            showWeek: true,
            firstDay: 1,
            dateFormat: 'dd/mm/yy'
            //maxDate: "+0M +10D"
        });
    } );
</script>
<!-- end datepicker -->
<!-- data validation -->
<script>
    $.validate({});
</script>
<!-- end data validation -->
<!-- help info display and hide -->
<script>
    function hide_info() {
        var x = document.getElementById("r_av");
        x.style.display = "none";
        var y = document.getElementById("dis_av");
        y.setAttribute("style", "");
    }

    function show_info(){
        var x = document.getElementById("dis_av");
        x.style.display = "none";
        var y = document.getElementById("r_av");
        y.setAttribute("style", "");
    }

    function hide_info_r() {
        var x = document.getElementById("r_av_r");
        x.style.display = "none";
        var y = document.getElementById("dis_av_r");
        y.setAttribute("style", "");
    }

    function show_info_r(){
        var x = document.getElementById("dis_av_r");
        x.style.display = "none";
        var y = document.getElementById("r_av_r");
        y.setAttribute("style", "");
    }
</script>

<!--Print function-->
<script>
    function printFunction() {
        window.print();
    }
</script>
<!--Print function-->
<!-- end help info display and hide -->
