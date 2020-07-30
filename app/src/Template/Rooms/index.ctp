<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room[]|\Cake\Collection\CollectionInterface $rooms
 */
?>

<!-- head of the page -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms | Admin</title>
    <?php $this->assign("title","Rooms | NAIM Admin"); ?>
</head>
<!-- end of header -->

<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<style>

    .inline_field{
        display: inline-block;
    }

    .checkbox{
        padding-right: 30px;
        display:inline-block;
    }

    label.feature {
        /*border:1px solid #ccc;*/
        display:inline-block;
    }

    label.feature:hover {
        background:#eee;
        cursor:pointer;
    }

    #room_card:hover{
        background:#eee;
    }

    p{
        word-break: break-all;
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

    #officeuse{
        background-color: rgba(240, 176, 117, 0.2);
        border-radius: 10px;
    }

</style>

<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->

<!-- page content -->
<div class="wrapper">
    <div class="container">
        <!-- back button -->
        <div class="inline_field">
            <ul class="pull-left" style="padding-right:10px;">
                <?php
                echo $this->Html->link(
                    'Back',
                     $this->request->referer(),
                    ['class' => 'button btn-large btn-inverse']
                );
                // 'confirm' => 'Are you sure to go back?\nThe photos you chose but not submitted will not be saved',
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
                        'Properties List',
                        ['controller' => 'Admins', 'action' => 'property_manage'],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        'Property',
                        ['controller' => 'Properties', 'action' => 'admin_view', $pid],
                        ['class' => '']
                    );
                    ?>
                </li>
                <li>Rooms</li>
            </ul>
        </div>
        <br>
        <!-- header and back button -->
        <div class="inline_field">
            <h1>Room Management</h1>
            <div class="inline_field">
                <p>On property: </p>
            </div>
            <div class="inline_field">
                <?php
                foreach ($property as $p){
                    $country = $p->country;
                    $state = $p->state;
                    $suburb = $p->suburb;
                    $street = $p->street;
                    $postcode = $p->postcode;
                    $unit_num = $p->house_number;
                    $st_location = $unit_num." ".$street.", ".$suburb.", ".$state." ".$postcode;
                    $location = $st_location.", ".$country;
                    $b_n = $p->number_of_bedroom;
                } ?>
                <?php echo "<h4>".$location."</h4>";?>
            </div>
            <div>
                <div class="inline_field">
                    <?php
                    echo $this->Html->link(
                        'Add New Room',
                        ['controller' => 'Rooms', 'action' => 'adminAdd', $pid],
                        ['class' => 'button btn-large btn-success']
                    );
                    ?>
                </div>

            </div>
        </div>
        <!-- end of header and head button -->
        <div class="module">
            <div class="module-head"></div>
            <div class="module-body">
                <br>
                <h1 style="text-align: center;">Existing Rooms</h1>
                <?php
                $counter = 0;
                foreach($rooms as $room){
                    $counter += 1;
                }
                ?>
                <div style="text-align: center;">
                <span >Number of Rooms you created here / Number of Room you assigned for this Property: <?php echo "<p style='color:black;'><b>".$counter."&nbsp;/&nbsp;".$b_n."</b></p>";?></span>
                </div>
                <br>
                <?php
                $counter = 0;
                foreach ($rooms as $room){
                    $counter += 1;
                }
                if ($counter == 0){
                    echo "<p>This property currently has no room.</p>";
                }else{
                    $count = 1;
                    foreach ($rooms as $room){
                        // display room ?>
                        <div id="room_card" class="module">
                            <div class="module-body">
                                <fieldset>
                                    <div class="control-groue" >
                                        <h2><?php echo $count.")&nbsp;".$room->room_name; ?></h2>
                                        <?php $count += 1;?>
                                    </div>

                                    <!-- Office Use -->
                                    <!-- Could add: #people currently statying/total_capacity, #application on this property -->
                                    <div class="control-group" id="officeuse">
                                        <div class="control-group" style="padding-left:5px; margin-bottom: 0;">
                                            <h3 style="margin-bottom: 0;">Office Use</h3>
                                          <!-- --><?php
/*                                            $cd = $property->create_date;
                                            $enquiry_date =  'on '.$this->Time->format(
                                                    $cd, #Your datetime variable
                                                    'dd/MM/Y HH:mm'            #Your custom datetime format
                                                );
                                            echo "<h5 class='inline_field'>Created Date: &nbsp;&nbsp;</h5><h4 class='inline_field'><u>".$enquiry_date."</u></h4>";
                                            */?>
                                        </div>
                                       <!-- <div style="padding-left:5px;margin-bottom:0;">
                                            <h5 style="margin-bottom: 0;">Room Availability:</h5>
                                        </div>
                                        <div style="padding-left: 10px;">
                                            --
                                        </div>-->
                                        <hr style="margin-top:0; margin-bottom:2px;">
                                        <div style="padding-left:5px;margin-bottom:0;">
                                            <h5 style="margin-bottom: 0;">Actions</h5>
                                        </div>
                                        <div style="padding-left: 10px;">
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->postButton(
                                                    'Manage Photos',
                                                    ['controller' => 'PropertiesImages', 'action' => 'adminEdit', $pid],
                                                    ['class' => 'button btn-large btn-info', 'style' => 'top:8px;']
                                                );
                                                ?>
                                            </div>
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Html->link(
                                                    'Edit',
                                                    ['controller' => 'Rooms', 'action' => 'adminEdit', $room->id],
                                                    ['class' => 'button btn-large btn-warning']
                                                );
                                                ?>
                                            </div>
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->postButton(
                                                    'Delete',
                                                    ['controller' => 'Rooms', 'action' => 'delete', $room->id],
                                                    ['confirm' => 'Are you sure to delete this room?\nThe room will be deleted permanently',
                                                        'class' => 'button btn-large btn-danger',
                                                        'style' => 'top:8px;']
                                                );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Office use -->

                                    <!-- Rental Availability Information -->
                                    <?php
                                    if ($room->rental_end_date != null){
                                        ?>
                                        <!--<div class="control-group" style="margin-bottom: 0;">
                                            <div style="padding-top:10px;background-color: #cce5ff; border-radius: 10px; padding-left:10px; margin-bottom: 5px;">-->

                                            <!--<div>
                                                ---
                                            </div>-->
                                            <?php /*$red = $room->rental_end_date; */?><!--
                                            --><?php /*echo "<h5 class='inline_field'>Last Rental End Date: &nbsp;</h5><p class='inline_field'>".$red->i18nFormat('dd-MM-yyyy')."</p>";*/?>

                                            <?php /*$currentDate = \Cake\I18n\Time::now();*/?>
                                            <?php /*$currentDate->setTimezone(new \DateTimeZone('Australia/Melbourne')); */?>

                                            <?php /*$YearToRentEnd = $currentDate->diffInYears($red); */?>
                                            <?php /*//echo "Year to Rent End: ".$YearToRentEnd */?>
                                            <?php /*$currentDate->addYears($YearToRentEnd); */?>

                                            <?php /*$MonthToRentEnd = $currentDate->diffInMonths($red); */?>
                                            <?php /*//echo "Month To Rent End: ".$MonthToRentEnd; */?>
                                            <?php /*$currentDate->addMonths($MonthToRentEnd); */?>

                                            <?php /*$DaysToRentEnd = $currentDate->diffInDays($red); */?>
                                            <?php /*//echo "Days To Rent End: ".$DaysToRentEnd; */?>
                                            <?php /*$currentDate->addDays($DaysToRentEnd); */?>

                                            <?php /*echo "Time To Rental End: ".$YearToRentEnd."Y ".$MonthToRentEnd."M ".$DaysToRentEnd."D"; */?>
                                            <!-- https://book.cakephp.org/3/en/core-libraries/time.html#formatting-relative-times -->
                                            <!-- https://book.cakephp.org/chronos/1/en/index.html -->
                                          <!--  </div>
                                        </div>-->
                                        <?php
                                    }else{
                                        ?>
                                        <!--<div class="control-group" style="margin-bottom: 0; background-color: #cce5ff; border-radius: 10px;">
                                            <div style="padding-top:10px;padding-bottom:3px;background-color: #cce5ff; border-radius: 10px; padding-left:10px; margin-bottom: 5px;">
                                                <h5>No Rental End Date</h5>
                                            </div>
                                        </div>-->
                                        <?php
                                    } ?>

                                    <div class="control-group" style="margin-bottom:0;">
                                        <?php
                                        if ($room->room_type == 0){
                                            $name = "Private";
                                        }else{
                                            $name = "Sharing";
                                        }

                                        if ($room->room_type_desc == null){
                                            echo "<h5 class='inline_field'>Room Type: </h5>&nbsp;<p class='inline_field'>".$name."</p>";
                                        }else{
                                            echo "<h5 class='inline_field'>Room Type: </h5>&nbsp;<p class='inline_field'>".$name."</p>&nbsp;-&nbsp;".$room->room_type_desc;
                                        }
                                        ?>
                                    </div>

                                    <div class="control-group" style="margin-bottom: 0; background-color: #cce5ff; border-radius: 10px;">
                                        <div style="padding-top:10px;padding-bottom:3px;background-color: #ecfaff; border-radius: 10px; padding-left:10px; margin-bottom: 5px;">
                                           <h5>Beds In This Room</h5>
                                            <div style="padding-left:10px;">
                                                <?php
                                                    // for each bed belongs to this room, display its rental
                                                foreach ($brs as $br){
                                                    if ($room->id == $br->room_id){
                                                        foreach ($beds as $bed){
                                                            if ($br->bed_id == $bed->id){
                                                                echo "<p> - ".$bed->bed_name."</p>";
                                                                // display room rental
                                                                $flag = 0;
                                                                foreach ($rentals as $rental){
                                                                    if ($rental->room_id){

                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }

                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Room Information -->

                                    <hr style="margin-top:0; margin-bottom:0;">

                                    <div class="control-group">
                                        <?php echo "<h5>Room Inventory:</h5>&nbsp&nbsp";
                                        if (count($room->items)==0 or $room->items == null){
                                            echo " This room has no record of its inventory";
                                        }else{
                                            $counter = 0;
                                            $first_count = 0;
                                            foreach ($room->items as $item){
                                                $first_count += 1;
                                            }
                                            foreach ($room->items as $item){
                                                if ($first_count - $counter != 1){
                                                    echo "<div class='inline_field'>";
                                                    echo "<p>".$room->items[$counter]->_joinData->quantity." ".$room->items[$counter]->name.",&nbsp  </p>";
                                                    echo "</div>";
                                                }
                                                else{
                                                    echo "<div class='inline_field'>";
                                                    echo "<p>".$room->items[$counter]->_joinData->quantity." ".$room->items[$counter]->name."</p>";
                                                    echo "</div>";
                                                }
                                                $counter += 1;
                                            }
                                        }
                                        ?>
                                    </div>

                                    <hr style="margin-top:0; margin-bottom:0;">

                                    <div class="control-group">
                                        <?php
                                        echo "<h5>Room Description</h5>";
                                        if (strlen($room->room_general_information)==0){
                                            echo "<p>This property doesn't have a House Description.</p>";
                                        }
                                        echo "<p id='general_info' style=\"word-break: break-all;\">".$room->room_general_information."</p>";  ?>
                                     </div>
                                </fieldset>
                                <hr>
                                <div style="padding-top:10px;padding-bottom:3px;background-color: #cce5ff; border-radius: 10px; padding-left:10px; margin-bottom: 5px;">
                                    <h5>Active Rentals On This Room</h5>
                                    <div style="padding-left:10px;">
                                        <?php

                                        $flag = 0;



                                            $counter = 1;
                                            foreach ($rentals as $r){
                                                if ($r->room_id == $room->id){
                                                    $flag = 1;
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

                                            if ($flag == 0){
                                                echo "<p>The room currently has no active rental.</p>";
                                            }

                                        ?>
                                       <!-- --><?php
/*                                        foreach ($rentals as $rental){
                                            if ($rental->room_id == $room->id){
                                                debug($rental);
                                            }
                                        }
                                        */?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>



    </div>
<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
