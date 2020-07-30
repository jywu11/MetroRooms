<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rental $rental
 */
?>

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
    <title>Add Rental | Admin</title>
    <?php $this->assign("title","Create Rental | NAIM Admin"); ?>
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


</style>

<!-- retrieved displayed data -->
<?php


$aid = $application->id;
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

$r_n = $room->room_name;

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
<!-- end retrieved displayed data -->

<!-- Availability -->
<?php
function getCurrent(){
    $currentDate = \Cake\I18n\Time::now();
    $currentDate->setTimezone(new \DateTimeZone('Australia/Melbourne'));
    $currentDate->hour('00');
    $currentDate->minute('00');
    $currentDate->second('00');
    return $currentDate;
}

function FrozenToDate($FrozenDate){
    $Date = new \Cake\I18n\Time($FrozenDate);
    return $Date;
}

function getRentalRoomBeds($rental_room_beds, $rental){
    /*
     * Return Rental_Room_Bed where RentalID = this Rental (Beds Occupied by this rental)
     */
    $rentalRoomBeds = Array(); $i=0;
    foreach ($rental_room_beds as $rental_room_bed){
        if ($rental_room_bed->rental_id == $rental->id){
            $rentalRoomBeds[$i] = $rental_room_bed;
            $i += 1;
        }
    }
    return $rentalRoomBeds;
}

function getCapacityAndBeds($rentalRoomBeds, $room_beds){
    /*
     *  Return Capacity of this rental and the beds its occupied
     */
    $res = array();
    $res[0] = 0;
    $res[1] = array();
    $i = 0;
    foreach ($rentalRoomBeds as $rentalRoomBed) {
        $this_bed = null;
        $empty_flag = 1;
        foreach ($room_beds as $room_bed){
            if ($room_bed->id == $rentalRoomBed->bed_room_id){
                $this_bed = $room_bed;                                                                               // get the beds info for each bed occupied
                $empty_flag = 0;
            }
        }
        if ($empty_flag == 0){
            $res[0] += $this_bed->capacity;
            $res[1][$i] = $this_bed;
            $i += 1;
        }
    }
    return $res;
}

function debug_slot($slotStart, $gap, $i, $j){
    debug($slotStart);
    debug($gap);
    debug($i);
    debug($j);
}

function generateSlot($i, $j, $slotStart, $currentDate, $resArray){
    $this_res = array();
    $gap = $i - $j;
    array_push($this_res, $gap);

    //debug_slot($slotStart, $gap, $i, $j);

    $slot_end = new \Cake\I18n\Time($slotStart);
    if ($gap == 0){
        $slot_end->addDays($gap+1);
    }else{
        $slot_end->addDays($gap);
    }
    $slot_end->subDays(1);
    array_push($this_res, $slotStart);
    array_push($this_res, $slot_end);
    array_push($this_res, $resArray[$j][1]);

    return $this_res;
}

function getBedName($beds, $id){
    foreach ($beds as $bed){
        if ($bed->id == $id){
            return $bed->bed_name;
        }
    }
    return '-';
}

$room_capacity=0;
foreach ($room_beds as $rb){
    $room_capacity += $rb->capacity;
}
?>
<?php

//debug($rentals);
$matrix = array();
$resArray = array();
$avaArray = array();
// init res array
for ($i=0; $i<365; $i++){ $resArray[$i] = null; }

$currentDate = getCurrent();
if ($room->room_type == 0){                                                                                        // Private Room Ava
    $j = 1;
    $rrr = $rentals;
    $rentals = array();
    foreach ($rrr as $rental){
        array_push($rentals, $rental);
    }
    if (count($rentals)==0){
        $this_res = array();
        $curEnd = getCurrent();
        $this_res[0] = $curEnd;
        $this_res[1] = null;
        array_push($avaArray, $this_res);
    }
    for ($i=0; $i<count($rentals); $i++){
        if ($i == 0 && $i == count($rentals)-1){
            //debug($i);

            // only one rental exists

            // check this rental's start and end
            $curStart = FrozenToDate($rentals[$i]->start_date);

            if ($curStart > $currentDate && $curStart->diffInMonths($currentDate) >= 3){
                $this_res = array();
                $this_res[0] = $currentDate; //->addDays(1);
                $this_res[1] = $curStart->subDays(1);
                array_push($avaArray, $this_res);
            }

            $this_res = array();
            $curEnd = FrozenToDate($rentals[$i]->end_date);
            $this_res[0] = $curEnd->addDays(1);
            $this_res[1] = null;
            array_push($avaArray, $this_res);
            //debug($avaArray);
        }
        elseif ($i == count($rentals)-1 && $i != 0){
            $this_res = array();
            $curEnd = FrozenToDate($rentals[$i]->end_date);
            $this_res[0] = $curEnd->addDays(1);
            $this_res[1] = null;
            array_push($avaArray, $this_res);
        }
        else{
            $curEnd = FrozenToDate($rentals[$i]->end_date);
            $nextStart = FrozenToDate($rentals[$j]->start_date);
            //debug($curEnd->diffInMonths($nextStart));
            //debug($curEnd);
            //debug($nextStart);
            if ($curEnd->diffInMonths($nextStart) >= 3 && $curEnd < $nextStart){
                $this_res = array();
                $this_res[0] = $curEnd->addDays(1);
                $this_res[1] = $nextStart->subDays(1);
                array_push($avaArray, $this_res);
            }
            $j += 1;
        }
    }
}
else{
    $currentDate = getCurrent();
    //debug($currentDate);
    $counter = 0;
    foreach ($rentals as $rental){                                                                                      //  Active Rentals
        $matrix[$counter] = array();
        for($i=0; $i<365; $i++){ $matrix[$counter][$i] = null; }                                                        // add rental column to matrix

        $start = FrozenToDate($rental->start_date);                                                                     // Rent Info
        $end = FrozenToDate($rental->end_date);
        //debug($start);
        //debug($end);
        $rentalRoomBeds = getRentalRoomBeds($rental_room_beds, $rental);

        if ($start <= $currentDate && $end >= $currentDate){                                                             // Start before CurrentDate
            $startIndex = 0;
            $endIndex = $currentDate->diffInDays($end);
            //debug($endIndex);
            if ($endIndex >= 365){                                                                                       // Start before CurrentDate && Ends after a year
                $res = getCapacityAndBeds($rentalRoomBeds, $room_beds);
                $cap = $res[0];
                $bedArray = $res[1];

                for ($i=0; $i < 365; $i++){
                    $matrix[$counter][$i][0] = $cap;
                    $matrix[$counter][$i][1] = $bedArray;
                }
            }else{                                                                                                       // Start before CurretDate && Ends within a year
                //debug($counter);
                $res = getCapacityAndBeds($rentalRoomBeds, $room_beds);
                $cap = $res[0];
                $bedArray = $res[1];

                for ($i=0; $i <= $endIndex; $i++){
                    $matrix[$counter][$i][0] = $cap;
                    $matrix[$counter][$i][1] = $bedArray;
                }
                //debug($matrix);
            }
        }
        if ($start > $currentDate){                                                                                      // Start after currentDate
            //debug($start);
            //debug($currentDate);
            $startIndex = $currentDate->diffInDays($start);
            //debug($startIndex);

            $endIndex = $currentDate->diffInDays($end);
            //debug('');
            //debug($currentDate);
            //debug($start);
            //debug($startIndex);
            //debug($end);
            //debug($endIndex);
            $dur = $start->diffInDays($end);
            //debug($dur);
            //debug('');

            if ($endIndex >= 365){                                                                                       // Start after CurrentDate && End after a year
                $res = getCapacityAndBeds($rentalRoomBeds, $room_beds);
                $cap = $res[0];
                $bedArray = $res[1];

                for ($i=$startIndex; $i<365; $i++){
                    $matrix[$counter][$i][0] = $cap;
                    $matrix[$counter][$i][1] = $bedArray;
                }
            }else{                                                                                                       // Start after CurrentDate && End within a year
                $res = getCapacityAndBeds($rentalRoomBeds, $room_beds);
                $cap = $res[0];
                $bedArray = $res[1];
                if ($endIndex == 88){
                    debug($bedArray);
                }

                for ($i=$startIndex; $i <= $endIndex; $i++){
                    $matrix[$counter][$i][0] = $cap;
                    $matrix[$counter][$i][1] = $bedArray;
                }
            }
        }
        $counter += 1;
    }

    foreach ($matrix as $row){                                                                                          // For each rental
        //debug($row);
        for ($i=0; $i<365; $i++){                                                                                        // for 365
            if ($resArray[$i] == Null && $row[$i] == Null){                                                             // Rental and resArray both Null
                continue;
            }
            if ($row[$i] != Null){                                                                                      // Rental not Null
                if ($resArray[$i] == Null) {                                                                            // Rental not Null && resArray is Null
                    $resArray[$i][0] = $row[$i][0];
                    $resArray[$i][1] = $row[$i][1];
                }
                else{                                                                                                   // Rental not Null && resArray is Not Null
                    $resArray[$i][0] += $row[$i][0];
                    foreach ($row[$i][1] as $a_bed){
                        array_push($resArray[$i][1], $a_bed);
                    }
                }
            }
        }
    }

    //debug($resArray);


    $sharedAvaBeds = array();

    for ($i=0; $i<365; $i++){
        $sharedAvaBeds[$i] = array();
        if ($resArray[$i] == null){
            foreach ($room_beds as $rb){
                $tmp = array();
                array_push($tmp, $rb->id);
                array_push($tmp, $rb->capacity);
                array_push($sharedAvaBeds[$i], $tmp);
            }
        }
        else{
            $usedBeds = $resArray[$i][1];
            $f = 1;
            foreach ($room_beds as $b){
                $f = 1;
                foreach ($usedBeds as $ub){
                    if ($ub->id == $b->id){
                        $f = 0;
                    }
                }
                if ($f == 1){
                    $tmp = array();
                    array_push($tmp, $b->id);
                    array_push($tmp, $b->capacity);
                    array_push($sharedAvaBeds[$i], $tmp);
                }
            }
        }
    }
    //debug($sharedAvaBeds);

    $currentDate = getCurrent();
    $lastCap = 0;
    $nullFlag = 1;
    $j = 0;
    $slotStart = $currentDate;
    $lastEnd = $currentDate;
    $k = 0;

    //debug($currentDate);
    //debug($resArray);

    for ($i=0; $i<365; $i++){
        if ($resArray[$i] == null){
            if ($nullFlag == 1){
                continue;
            }else{                                                                                                      // Changed to null from number
                $slot_res = generateSlot($i, $j, $slotStart, $currentDate, $resArray);
                //debug($slot_res);

                $j = $i;                                                                                                        // update slot
                $lastCap = $resArray[$i][0];
                $slotStart = new \Cake\I18n\Time($slot_res[2]);
                $slotStart->addDays(1);
                $lastEnd = new \Cake\I18n\Time($slot_res[2]);

                if ($slot_res[0] != 0){
                    $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                    //$avaArray[$k][0]->addDays(-1);
                    $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                    //$avaArray[$k][1]->addDays(-1);
                    $avaArray[$k][2] = $resArray[$i-1][0];
                    $avaArray[$k][3] = $slot_res[3];
                    $k += 1;
                }

                $nullFlag = 1;
            }
        }
        else{
            if ($nullFlag == 1){                                                                                        // Changed to number from null
                //debug($i);
                //debug($j);
                $slot_res = generateSlot($i, $j, $slotStart, $currentDate, $resArray);
                //debug($slot_res);

                $j = $i;                                                                                                // update slot
                $lastCap = $resArray[$i][0];
                $slotStart = new \Cake\I18n\Time($slot_res[2]);
                $slotStart->addDays(1);
                $lastEnd = new \Cake\I18n\Time($slot_res[2]);

                if ($slot_res[0] != 0){
                    $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                    //$avaArray[$k][0]->addDays(-1);
                    $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                    //$avaArray[$k][1]->addDays(-1);
                    $avaArray[$k][2] = $resArray[$i-1][0];
                    $avaArray[$k][3] = $slot_res[3];
                    $k += 1;
                }

                $nullFlag = 0;
            }
            if ($resArray[$i][0] != $lastCap){                                                                          // Changed to number from number                                                                      //
                $slot_res = generateSlot($i, $j, $slotStart, $currentDate, $resArray);
                //debug($slot_res);

                $j = $i;
                $lastCap = $resArray[$i][0];
                $slotStart = new \Cake\I18n\Time($slot_res[2]);
                $slotStart->addDays(1);
                $lastEnd = new \Cake\I18n\Time($slot_res[2]);

                if ($slot_res[0] != 0){
                    $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                  //  $avaArray[$k][0]->addDays(-1);
                    $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                   // $avaArray[$k][1]->addDays(-1);
                    $avaArray[$k][2] = $resArray[$i-1][0];
                    $avaArray[$k][3] = $slot_res[3];
                    $k += 1;
                }
                //debug($avaArray[$k-1]);

                $nullFlag = 0;
            }else{
                continue;
            }
        }
    }
}
//debug($avaArray);
//debug($resArray);
?>
<!-- end Availability -->

<!-- totoal room cap -->
<?php
$room_capacity=0;
foreach ($room_beds as $rb){
    $room_capacity += $rb->capacity;
}
?>
<input type="hidden" value="<?php echo $room_capacity; ?>" id="total_cap">
<input id="room_type" type="hidden" value="<?php echo $room->room_type; ?>">
<!-- total room cap -->


<!-- top nav bar -->
<?php echo $this->element('admin_topbar'); ?>
<!-- end of top nav bar -->

<body>
<!-- page content -->
<?= $this->Form->create($rental) ?>
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
                <h2>Accept Application and Create Rental</h2>
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
                        <h2 style="text-align: center">Confirm Rental Information</h2>
                        <hr>

                        <!-- NOT EDITABLE: office section -->
                        <div class="control-group" id="officeuse" style="margin-bottom:10px;">
                            <div class="control-group" style="padding-left:5px;">
                                <h3>Office Use</h3>
                                <div style="padding-left:10px;">
                                    <div class="inline_field">
                                        <span>Rental will be created on</span>
                                    </div>
                                    <div class="inline_field">
                                        <?php echo "<p><b style='color:black;'>".$location." | ".$r_n."</b></p>"; ?>
                                    </div>
                                </div>
                                <div style="padding-left:10px;">
                                    <div class="inline_field">
                                        The Application of this Rental was created on
                                    </div>
                                    <div class="inline_field">
                                        <?php
                                        $cd = getCurrent();
                                        $enquiry_date =  $this->Time->format(
                                                $cd, #Your datetime variable
                                                'dd/MM/Y'            #Your custom datetime format
                                            );
                                        echo "<h4 class='inline_field'><u>".$enquiry_date."</u></h4>";
                                        ?>
                                        &nbsp;
                                    </div>
                                    <div>
                                        <?php
                                        echo $this->Html->Link(
                                            'Go to Bottom of Page for the Details of this Application',
                                            '#app'
                                        );

                                        ?>
                                    </div>
                                    <br>
                                </div>


                            </div>
                        </div>
                        <!-- end office section -->

                        <!-- ROOM AVABILITY -->
                        <div  id="dis_av" onclick="show_info();">
                            <div style="background-color: #EAFAF1; border-radius: 10px; margin-top:3px; margin-bottom:10px;">
                                <p class="inline_field fas fa-info-circle" style="margin-top:5px; padding: 5px;"></p>&nbsp;Click me to see this room's Availability.
                            </div>
                        </div>
                        <div id="r_av"  onclick="hide_info();" style=" display:none;">
                            <div style="color:black; border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #EAFAF1;">
                                <div style="padding: 5px; padding-bottom:0;">
                                    <p class="inline_field fas fa-info-circle"></p>&nbsp;Click to close me.
                                    <div>
                                        <h5>Room Availability:</h5>
                                        <?php
                                        if (count($avaArray) == 0){
                                            echo "<p class='inline_field'>The room is </p><b>  &nbsp;available now!</b><br>";
                                        }
                                        else{
                                            if ($room->room_type == 0){
                                                $afterAYear = new \Cake\I18n\Time(end($avaArray)[1]);
                                                $afterAYear->addDays(365);
                                                foreach ($avaArray as $ava){
                                                    //debug($ava);
                                                    if (count($avaArray) == 1){
                                                        if (end($avaArray)[1] == null){
                                                            if (end($avaArray)[0] > $afterAYear){
                                                                echo "<p>The room currently has no Available time slot.</p>";
                                                            }
                                                            else{
                                                                $s = new \Cake\I18n\Time(end($avaArray)[0]);
                                                                $s =  $this->Time->format($s,'dd/MM/Y');
                                                                echo "<div>
                                                                        <div style='margin-left:10px;' class='inline_field'>- Available from&nbsp;</div>
                                                                        <p class='inline_field'><b class='inline_field'>".$s."</b></p>
                                                                  </div>";
                                                            }
                                                        }
                                                    }
                                                    elseif ($ava[1] != null){
                                                        $s = new \Cake\I18n\Time($ava[0]);
                                                        $e = new \Cake\I18n\Time($ava[1]);
                                                        $s =  $this->Time->format($s,'dd/MM/Y');
                                                        $e =  $this->Time->format($e,'dd/MM/Y');
                                                        echo "<div>
                                                                        <div style='margin-left:10px;' class='inline_field'>- Available from&nbsp;</div>
                                                                        <p class='inline_field'><b class='inline_field'>".$s."&nbsp;~&nbsp;".$e."</b></p>
                                                                  </div>";
                                                    }
                                                    elseif (end($avaArray)[1] == null){
                                                        if (end($avaArray)[0] > $afterAYear){
                                                            echo "<p>The room currently has no Available time slot.</p>";
                                                        }
                                                        else{
                                                            $s = new \Cake\I18n\Time(end($avaArray)[0]);
                                                            $s =  $this->Time->format($s,'dd/MM/Y');
                                                            echo "<div>
                                                                    <div style='margin-left:10px;' class='inline_field'>- Available from&nbsp;</div>
                                                                    <p class='inline_field'><b class='inline_field'>".$s."</b></p>
                                                              </div>";
                                                        }
                                                    }
                                                }
                                            }
                                            else{
                                                foreach ($avaArray as $ava){
                                                    $s = new \Cake\I18n\Time($ava[0]);
                                                    $s =  $this->Time->format($s,'dd/MM/Y');
                                                    $e = new \Cake\I18n\Time($ava[1]);
                                                    $e =  $this->Time->format($e,'dd/MM/Y');
                                                    echo "<div>
                                                      <div style='margin-left:10px;' class='inline_field'>- From</div>
                                                      <p class='inline_field'><b class='inline_field' style='color:black;'>".$s."&nbsp;~&nbsp;".$e."</b></p>
                                                      <div class='inline_field'>&nbsp;(capacity of&nbsp;".($room_capacity-$ava[2])."&nbsp;available)</div>
                                                  </div>";

                                                }
                                                $afterAYear = new \Cake\I18n\Time(end($avaArray)[1]);
                                                $afterAYear->addDays(365);
                                                if (end($avaArray)[1] < $afterAYear){
                                                    $cap_num = 0;
                                                    if (end($resArray)==null){
                                                        $cap_num = $room_capacity;
                                                    }else{
                                                        $cap_num = ($room_capacity-end($resArray)[0]);
                                                    }
                                                    $s = new \Cake\I18n\Time(end($avaArray)[1]);
                                                    $s->addDays(1);
                                                    $s =  $this->Time->format($s,'dd/MM/Y');
                                                    echo "<div>
                                                      <div style='margin-left:10px;' class='inline_field'>- From</div>
                                                      <p class='inline_field'><b class='inline_field' style='color:black;'>".$s."&nbsp;</b></p>
                                                      <div class='inline_field'>&nbsp;(capacity of&nbsp;".$cap_num."&nbsp;available)</div>
                                                  </div>";
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END AVAILABILITY -->

                        <!-- ROOM RENTAL -->
                        <div  id="dis_av_r" onclick="show_info_r();">
                            <div style="background-color: #ecfaff; border-radius: 10px; margin-top:3px; margin-bottom:10px;">
                                <p class="inline_field fas fa-info-circle" style="margin-top:5px; padding: 5px;"></p>&nbsp;Click me to see this room's Availability.
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
                                            foreach ($rentals as $rental){
                                                $s = new \Cake\I18n\Time($rental->start_date);
                                                $s =  $this->Time->format($s,'dd/MM/Y');
                                                $e = new \Cake\I18n\Time($rental->end_date);
                                                $e =  $this->Time->format($e,'dd/MM/Y');
                                                echo "<div style='padding:2px;'>";
                                                $rental_name = " - View Rental ".$counter." ";
                                                echo $this->Html->Link(
                                                    $rental_name,
                                                        ['controller' => 'Rentals', 'action'=>'view', $rental->id],
                                                        ['class'=> 'inline_field']
                                                );
                                                echo "&nbsp;&nbsp;&nbsp;<p class='fas fa-calendar-alt inline_field'></p>&nbsp;<p style='color:black' class='inline_field'>".$s." ~ ".$e."</p>,&nbsp;&nbsp;";
                                                echo "<p class='fas fa-user inline_field'></p><p class='inline_field'>&nbsp;".$rental->number_of_tenant."</p><p class='inline_field' style='color:black;'></p>,&nbsp;&nbsp;";
                                                $bedStr = '';
                                                foreach ($rent_bed_rooms as $rbr){
                                                    if ($rbr->rental_id == $rental->id){
                                                        $brid = $rbr->bed_room_id;
                                                        foreach($room_beds as $rb){
                                                            if ($rb->id == $brid){
                                                                foreach ($beds as $b){
                                                                    if ($b->id == $rb->bed_id){
                                                                        $bedStr = $bedStr.$b->bed_name.".&nbsp";
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

                        <!-- hidden fields -->
                        <?php
                        echo $this->Form->control(
                            'application_id',
                            ['type'=>'hidden', 'value'=>$aid]
                        );

                        echo $this->Form->control(
                            'room_id',
                            ['type'=>'hidden', 'value' => $room->id]
                        );

                        echo $this->Form->control(
                            'property_id',
                            ['type'=>'hidden', 'value'=> $property->id]
                        );

                        echo $this->Form->control('end_date', [
                            'type' => 'hidden',
                            'value' => '11/12/2080']);

                        $c_d = getCurrent()->format('d/m/Y');
                        echo  $this->Form->control('create_date', [
                            'type' => 'hidden',
                            'value' => $c_d]);

                        echo $this->Form->control('rental_status', [
                            'type'=>'hidden',
                            'value'=>0
                        ]);
                        ?>
                        <!-- hidden fields end -->

                        <!-- Rental Form Begin -->
                        <!-- Confirm Staying Time -->
                        <input type="hidden" value="0" id="stayingTime">
                        <h3>Confirm Staying Time</h3>

                        <!-- end before today time warning msg -->
                        <input type="hidden" id="endbeforetodayflag" value="0">
                        <div id="endbeforetoday" style="display:none;">
                            <div style="padding:10px; background-color: #fff9e1;  border-radius:3px; ">
                                <p class="fas 	fas fa-exclamation-circle" style="color:orange"></p><br>
                                <span style="color:black;margin-top:3px; margin-bottom:10px;">
                                    Note you finish at or before current date, we allow you to do so but please be sure this is not a mistake, your rental will be marked as Expired.
                                    We will NOT check the availability in this case so please be sure to enter the correct information for tenants.&nbsp;
                                    For shared rooms, we also will NOT validate the beds the tenants are staying on, you will need to skip the 'Select Beds section'.
                                </span>
                            </div>
                        </div>
                        <!-- warning end -->
                        <!-- start before today warning msg -->
                        <div id="startbeforetoday" style="display:none;">
                            <p class="fas 	fas fa-exclamation-circle" style="color:orange"></p><br>
                            <span style="color:black; border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #fff9e1;">
                                Your Rental Starts Before Today. Note that you are allowed to create a rental that STARTS BEFORE today.
                                This rental will be marked as active, please make sure this is what you want. </span>
                        </div>
                        <!-- start before today warning end -->

                    <!-- tenant num in consistnet error msg -->
                    <div id="step1ErrorMsg" class="step1ErrorMsg" style="display:none;">
                        <div style="border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #fddfdf;">
                            <div style="padding:10px;">
                                <p class="fas fa-times-circle" style="color:red"></p><br>
                                <span style="color:red; ">
                                    For this time slot chosen, your recorded number of tenant is bigger than the capacity the beds you selected can take.
                                    Please check against the Beds you selected or the Room's Availability under the Office Use section and fix this.
                                    Or please go to the tenant section to reduce the number of tenants you are recording.
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- end error msg -->

                    <!--  PRIVATE TIME SLOT UNAVAILABLE ERROT MSG -->
                    <div id="step1ErrorMsg_p" class="step1ErrorMsg_p" style="display:none;">
                        <div style="border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #fddfdf;">
                            <div style="padding:10px;">
                                <p class="fas fa-times-circle" style="color:red"></p><br>
                                <span style="color:red; ">
                                    This time slot is not available, please check against the room availability or the room rentals.
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- end error msg -->

                        <br>
                        <div class="input-group date">
                            <div>
                            <?php
                            $date_display = $application->start_date->format('d/m/Y');

                            echo $this->Form->control('start_date',
                                ['label' => 'Rental Start Date',
                                    'id' => 'datepicker',
                                    'class' => 'span4 dateAndDuration',
                                    'style' => 'height:35px;',
                                    'type' => 'text',
                                    'value' => $date_display,
                                    'readonly' => 'true'
                                   // 'data-provide' => "datepicker"
                                ]);
                            ?>
                            <span class="help-inline">The date that your tenant(s) move in.</span>
                        </div>
                            <br>
                            <div>
                            <?php
                            echo $this->Form->control('duration',
                                [
                                    'label' => 'Number of Months staying',
                                    'value' => $application->duration,
                                    'min' => 3,
                                    'class' => 'span4 dateAndDuration',
                                    'type' => 'number',
                                    'style' => "height:30px;",
                                    'data-validation' => 'number',
                                    'data-validation-allowing'=>'range[3;12]',
                                    'data-validation-error-msg'=>"The duration is out of range.\nIt ranges from 3 to 12 months"
                                ]);
                            ?>
                            <span class="help-inline">The duration this rental will last.</span><br><br>
                            <span style="color:red">&nbsp;**Note that if you wish to extend this rental in the future, the <b style="color:red">Start Date</b> and the <b style="color:red;">Duration</b> need to be consistent.</span>
                        </div>
                        </div>


                    </div>

                    <br><hr>

                    <!-- Confirm Main Contact Information -->
                    <h3>Confirm Rental Contact Information</h3>
                    <div>
                    <div>
                        <div class="inline_field">
                            <?php
                            echo $this->Form->control('contact_name',
                                ['label' => 'Main Contact Name',
                                    'type' => 'text',
                                    'value' => $application->contact_name,
                                    'placeholder'=>'Contact Name',
                                    'data-validation'=>'custom',
                                    'data-validation-regexp' => "^([A-Za-z ]+)$",
                                    'data-validation-error-msg'=> "Please enter a valid name",
                                    'class' => '',
                                    'style' => 'height:30px; margin-bottom:10px;'
                                ]);
                            ?>
                        </div>
                        <div class="inline_field">
                            <?php
                            echo $this->Form->control('contact_email',
                                ['label' => 'Main Contact Email',
                                    'type' => 'email',
                                    'value' => $application->contact_email,
                                    'placeholder'=>'Email',
                                    'id' => 'email',
                                    'data-validation'=> 'email',
                                    'style'=>'height:30px;  margin-bottom:10px;']);
                            ?>
                        </div>
                        <div class="inline_field">
                            <?php
                            echo $this->Form->control('contact_phone',
                                ['label' => 'Phone Number (Australian preferred)',
                                    'class' => 'span2',
                                    'type' => 'text',
                                    'value' => $application->contact_number,
                                    'placeholder'=>'04',
                                    "data-validation" => "custom",
                                    'data-validation-regexp' => '^([0-9+ ]+)$',
                                    "data-validation-length" => "10",
                                    "data-validation-error-msg" => "Please enter a valid Australian contact phone number.",
                                    'style'=>'height:30px;  margin-bottom:10px;;'
                                ]);
                            echo "<span>If you don't have an Australian phone number, please enter your country code before the phone number. Possible format: +86 18844576263</span>";
                            /*
                             * 'label' => 'Phone Number (Australian preferred)',
                                                        'type' => 'text',
                                                        'placeholder'=>'04',
                                                        "data-validation" => "custom",
                                                        "data-validation-regexp" => "^([0-9+ ]+)$",
                                                        "data-validation-error-msg" => "Please enter a valid Australian contact phone number."
                                                    ]);
                                                ?>
                             */
                            ?>
                        </div>
                    </div>
                </div>
                    <!--  end Confirm Main Contact Information -->

                    <br><hr>

                    <!-- Confirm Beds Staying -->
                    <input type="hidden" value="0" id="bedOccupied">
                    <h3>Confirm Beds This Rental Occupies</h3>
                    <div>
                        <p id="nobed"  style="color:red; display:none;">No Beds Available During Your Selected Time Slot.</p>
                    <?php
                    //debug($application);
                    //debug($app_room_beds);
                    ?>
                    <!-- Unlock Fields -->
                    <?php
                    $this->Form->unlockField('beds_rooms._ids');
                    for ($i=0; $i<1000; $i++){
                        $this->Form->unlockField('beds_rooms._ids.'.$i.'');
                    }
                    ?>
                    <!-- End unlock fields -->

                    <!-- rental ends before today no select beds warnning msg -->
                    <div id="bedsHidden" style="display:none;">
                        <div style="padding:10px; background-color: #fff9e1;  border-radius:3px; ">
                            <p class="fas 	fas fa-exclamation-circle" style="color:orange"></p><br>
                            <span style="color:black;margin-top:3px; margin-bottom:10px;">
                                Note you finish at or before current date, you will not need to select beds for this rental. Please skip this section.
                            </span>
                        </div>
                        <br>
                    </div>
                    <!-- warn msg end -->

                        <!-- beds cap > tent num warning msg -->
                        <div class="bedCapBigger" style="display:none;">
                            <div style="border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #fff9e1;">
                                <div style="padding:10px;">
                                    <p class="fas 	fas fa-exclamation-circle" style="color:orange"></p><br>
                                    <span style="color:black; ">
                                       The capacity of the beds you chosen is bigger than the number of tenant you recorded. Note that this is allowed, but please be sure this is not a mistake. </span>
                                </div>
                            </div>
                        </div>
                        <!-- warning end -->

                        <!-- BED enant num inconsistnet error msg -->
                        <div class="step1ErrorMsg" style="display:none;">
                            <div style="border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #fddfdf;">
                                <div style="padding:10px;">
                                    <p class="fas fa-times-circle" style="color:red"></p><br>
                                    <span style="color:red; ">
                                        Please check against the Beds you selected as for this time slot chosen, your recorded number of tenant is bigger than the capacity the beds you selected can take.
                                        Or you can check against the Room's Availability under the Office Use section to fix this, or please go to the tenant section to reduce the number of tenants you are recording.
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- end error msg -->

                    <?php
                    if ($room->room_type==0){                                                               // Private Room Beds
                        ?>
                        <p>Note that if this is a Private Rental, please ignore this section.</p><br>
                        <!-- prepare checkbox -->
                        <?php
                        $avaBeds = $room_beds;
                        $name_array = array();
                        $id_array = array();
                        foreach ($avaBeds as $ab){
                            $bedName = getBedName($beds, $ab->bed_id);
                            array_push($name_array, $bedName);
                            array_push($id_array, $ab->id);
                        } ?>
                        <!-- display checkbox -->
                        <?php
                        //   onclick="return false;" onkeydown="return false;"
                        $counter = 0;
                        foreach ($avaBeds as $ab){
                            echo "<div class='sharedRoomBedCheck' id='sharedRoomBedCheck".$id_array[$counter]."' style=''>
                                                        <div class=\"inline_field\">".
                                $this->Form->control('beds_rooms._ids.'.$id_array[$counter],
                                    ['class'=>'step2Validate my_bed',
                                            'checked'=>'checked',
                                        'style'=>'',
                                        'label'=> $name_array[$counter],
                                        'type'=>'checkbox',
                                        'value'=>$id_array[$counter],
                                        'onclick'=>'return false;',
                                        'onkeydown'=>'return false;']).
                                "</div></div>";
                            $counter += 1;
                        }
                    }
                    else{                                                                                  // Shared Room Beds
                        ?>
                        <!-- prepare checkbox -->
                        <?php
                        $avaBeds = $room_beds;
                        $name_array = array();
                        $id_array = array();
                        foreach ($avaBeds as $ab){
                            $bedName = getBedName($beds, $ab->bed_id);
                            array_push($name_array, $bedName.' (capacity of '.$ab->capacity.')');
                            array_push($id_array, $ab->id);
                        } ?>
                        <?php
                        $counter = 0;
                        //debug($avaBeds);
                        foreach ($avaBeds as $ab){
                            $checked = 0;
                            foreach ($app_room_beds as $arb){
                                //debug($ab->id);
                                //debug($arb->bed_room_id);
                                if ($ab->id == $arb->bed_room_id){
                                    $checked = 1;
                                    echo "<div class='sharedRoomBedCheck' id='sharedRoomBedCheck".$id_array[$counter]."' style=''>
                                                        <div class=\"inline_field\">".
                                        $this->Form->control('beds_rooms._ids.'.$id_array[$counter],
                                            [
                                                'class'=>'step2Validate my_bed',
                                                'style'=>'',
                                                'label'=> $name_array[$counter],
                                                'type'=>'checkbox',
                                                'value'=>$id_array[$counter]]).
                                        "</div></div>";
                                }
                            }
                            if ($checked == 0) {
                                echo "<div class='sharedRoomBedCheck' id='sharedRoomBedCheck" . $id_array[$counter] . "' style=''>
                                                        <div class=\"inline_field\">" .
                                    $this->Form->control('beds_rooms._ids.' . $id_array[$counter],
                                        [
                                            'class' => 'step2Validate my_bed',
                                            'style' => '',
                                            'label' => $name_array[$counter],
                                            'type' => 'checkbox',
                                            'value' => $id_array[$counter]]) .
                                    "</div></div>";
                            }

                            $counter += 1;
                        }
                    }
                    ?>
                </div>

                    <!-- end application detail -->
                    <br><hr>

                    <!-- Tenants -->
                    <input type="hidden" value="<?php echo $application->number_of_people; ?>" id="num-ppl">
                    <div id="tent" class="control-group">
                        <h3>Confirm Tenants Details</h3>
                        <!--  end before today free add tenant warning msg -->
                        <div id="freeadd" style="display:none;">
                            <div style="padding:10px; background-color: #fff9e1;  border-radius:3px; ">
                                <p class="fas 	fas fa-exclamation-circle" style="color:orange"></p><br>
                                <span style="color:black;margin-top:3px; margin-bottom:10px;">
                                    Note you finish at or before current date, you can add as many tenant as you desire. Be sure you are recording the correct number of tenants as we are not able to validate this.
                                </span>
                            </div>
                            <br>
                        </div>
                        <!-- warning msg end -->
                        <!-- beds cap > tent num warning msg -->
                        <div class="bedCapBigger" style="display:none;">
                            <div style="border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #fff9e1;">
                                <div style="padding:10px;">
                                    <p class="fas 	fas fa-exclamation-circle" style="color:orange"></p><br>
                                    <span style="color:black; ">
                                       The capacity of the beds you chosen is bigger than the number of tenant you recorded. Note that this is allowed, but please be sure this is not a mistake. </span>
                                </div>
                            </div>
                        </div>
                        <!-- warning end -->
                        <!-- tenant num in consistnet error msg -->
                        <div id="step1ErrorMsg" class="step1ErrorMsg" style="display:none;">
                            <div style="border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #fddfdf;">
                                <div style="padding:10px;">
                                    <p class="fas fa-times-circle" style="color:red"></p><br>
                                    <span style="color:red; ">
                                    For this time slot chosen, your recorded number of tenant is bigger than the capacity the beds you selected can take.
                                    Please check against the Beds you selected or the Room's Availability under the Office Use section and fix this.
                                    Or please go to the tenant section to reduce the number of tenants you are recording.
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- end error msg -->

                        <!--  PRIVATE TIME SLOT UNAVAILABLE ERROT MSG -->
                        <div id="step1ErrorMsg_p" class="step1ErrorMsg_pt" style="display:none;">
                            <div style="border-radius:3px; margin-top:3px; margin-bottom:10px;background-color: #fddfdf;">
                                <div style="padding:10px;">
                                    <p class="fas fa-times-circle" style="color:red"></p><br>
                                    <span style="color:red; ">
                                    The tenants recorded if bigger than the rooms capacity, please remove the exceeded tenants.
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- end error msg -->


                        <a type="button" id="add_t" class="button btn-success btn-sm" style="border-radius: 50px;">Add Another Tenant into this Rental</a>
                        <?php
                        $this->Form->unlockField('tenants._ids');
                        for ($i=0; $i<99; $i++){
                            $this->Form->unlockField('tenants.'.$i.'.first_name');
                            $this->Form->unlockField('tenants.'.$i.'.last_name');
                            $this->Form->unlockField('tenants.'.$i.'.preferred_name');
                            $this->Form->unlockField('tenants.'.$i.'.gender');
                            $this->Form->unlockField('tenants.'.$i.'.is_aus_citizen');
                            $this->Form->unlockField('tenants.'.$i.'.personal_contact_phone');
                        }

                        $i = 0;
                        //debug($applicants);
                        foreach ($applicants as $applicant){
                            $tag_id = "tenant".$i;
                            ?>
                            <div class="tent_field" id="<?php echo $tag_id; ?>">
                                <div  style="border-radius: 10px; border: solid 1px #ffc107;">
                                    <div style="padding-left:10px;">
                                        <br>
                                        <div>
                                            <div>
                                                <h4><u class="tent_head">Tenant <?php echo $i+1; ?></u></h4>
                                                <a type="button" id="<?php echo "remove".$tag_id; ?>" class="button btn-danger btn-sm rm" style="margin-top:10px; border-radius: 50px;">Remove This Tenant from this Rental</a>
                                            </div>
                                        </div>
                                        <div>

                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->control('tenants.'.$i.'.first_name',
                                                    ['label' => 'First Name',
                                                        'type' => 'text',
                                                        'value'=>$applicant->first_name,
                                                        'style' => 'height:35px;',
                                                        'data-validation'=>'custom',
                                                        'data-validation-regexp' => '^([A-Za-z ]+)$',
                                                        'data-validation-error-msg'=> "Please enter a valid first name",
                                                        'class' => ''
                                                    ]);
                                                ?>
                                            </div>
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->control('tenants.'.$i.'.last_name',
                                                    ['label' => 'Last Name',
                                                        'type' => 'text',
                                                        'value'=>$applicant->last_name,
                                                        'style' => 'height:35px;',
                                                        'data-validation'=>'custom',
                                                        'data-validation-regexp' => '^([A-Za-z ]+)$',
                                                        'data-validation-error-msg'=> "Please enter a valid last name",
                                                        'class' => ''
                                                    ]);
                                                ?>
                                            </div>
                                            <div class="inline_field">
                                                <?php
                                                echo $this->Form->control('tenants.'.$i.'.preferred_name',
                                                    ['label' => 'Preferred Name',
                                                        'type' => 'text',
                                                        'class' => '',
                                                        'style' => 'height:35px;',
                                                        'value'=>$applicant->preferred_name,
                                                        'data-validation'=>'custom',
                                                        'data-validation-regexp' => '^([A-Za-z ]+)$',
                                                        'data-validation-error-msg'=> "Please enter a valid last name",
                                                        'data-validation-optional' => 'true'
                                                    ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div style="padding-top:10px;">
                                            <div class="inline_field">
                                                <?php
                                                $gender_list = array();
                                                $gender_list[0] = 'Male';
                                                $gender_list[1] = "Female";
                                                $gender_list[2] = "Other";
                                                echo $this->Form->control(
                                                    'tenants.'.$i.'.gender',
                                                    ['label' => 'Gender',
                                                        'required' => 'required',
                                                        'type'  => 'select',
                                                        'default' => $applicant->gender,
                                                        'options' => $gender_list,
                                                    ]); ?>
                                            </div>
                                            <div class="inline_field">
                                                <?php
                                                $my_list = array();
                                                $my_list[0] = 'Yes';
                                                $my_list[1] = "No";
                                                echo $this->Form->control(
                                                    'tenants.'.$i.'.is_aus_citizen',
                                                    ['label' => 'Is Australian Citizen',
                                                        'required' => 'required',
                                                        'type'  => 'select',
                                                        'default' => $applicant->australian_citizen,
                                                        'options' => $my_list
                                                    ]); ?>
                                            </div>
                                        </div>
                                        <div class="inline_field" style="padding-top:10px;">
                                            <?php   echo $this->Form->control(
                                                'tenants.'.$i.'.personal_contact_phone',
                                                ['label' => 'Personal Phone (Australian preferred)',
                                                    'type'  => 'text',
                                                    'placeholder' => '04',
                                                    'class' => '',
                                                    'style' => 'height:35px;',
                                                    'value' => $applicant->personal_contact_phone,
                                                    'data-validation-optional' => 'true',
                                                    'data-validation' => 'custom',
                                                    "data-validation-regexp" => "^([0-9+ ]+)$",
                                                    'data-validation-error-msg' => 'Please enter a valid Australian phone number if you have one. Please leave it blank if you do not.',
                                                    'data-validation-length' => 10
                                                ]);
                                            /*
                                             *  'label' => 'Phone Number (Australian preferred)',
                                                        'type' => 'text',
                                                        'placeholder'=>'04',
                                                        "data-validation" => "custom",
                                                        "data-validation-regexp" => "^([0-9+ ]+)$",
                                                        "data-validation-error-msg" => "Please enter a valid Australian contact phone number."
                                                    ]);
                                                ?>

                                             */
                                            echo "<span>If you don't have an Australian phone number, please enter the country code before the phone number. Possible format: +86 18844576263</span><br><br>";
                                            ?>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                            </div>

                            <?php $i++;
                        } ?>
                    </div>
                    <!-- end tenants -->
                </div>
            </div>
        <!-- end main content -->

        <?php echo $this->Form->button('Accept Application and Create Rental',
            ['type' => 'submit',
                'class' => 'button btn-success span11',
                'id' => 'submitButton',
                'style' => 'border-radius: 8px;',
                'onclick' => 'return finalValidate();',
                'disabled' => 'true'
            ]); ?>

        <hr><div id="app">
            <?php
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
                                <p>Main Contact: <?php echo $application->contact_name."&nbsp;&nbsp;(".$application->contact_number.",&nbsp;".$application->contact_email.")" ; ?></p>
                                <p>Expected Staying: <?php echo "From&nbsp<u>".$st."&nbsp;to&nbsp;".$ed."</u>&nbsp;(".$application->duration."&nbsp;mons)"; ?></p>
                            </div>
                            <br></br>
                            <p><b style="color:black;">Applicants Information</b></p>
                            <?php
                            $counter = 1;
                            foreach ($applicants as $a){
                                echo "<div style='padding-left:10px;'>";
                                echo "<u style='color:black;'>Applicant&nbsp;".$counter."</u>";
                                $p = "--";
                                if ($a->preferred_name != '' && $a->preferred_name != ""){
                                    $p = $a->preferred_name;
                                }
                                $g = '--';
                                if (strval($a->gender)=="0"){
                                    $g = 'Male';
                                }else{ $g = 'Female'; }
                                $ausc = "--";
                                if (strval($a->australian_citizen) == "0"){
                                    $ausc = 'Is Australian Citizen';
                                }else{ $ausc = "Not Australian Citizen"; }
                                $p = "No Phone Provided";
                                if ($a->personal_contact_phone != null && $a->personal_contact_phone != ""){
                                    $p = $a->personal_contact_phone;
                                }

                                echo "<p>".$a->first_name."&nbsp;".$a->last_name."&nbsp;(".$p."),&nbsp;".$g.",&nbsp;".$ausc."&nbsp;(".$p.")</p>";

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
<?= $this->Form->end() ?>

<input type="hidden" id="tenant_id" value="0">




<input type="hidden" id="timeFlag" value="0">
<input type="hidden" id="bedFlag" value="0">
<input type="hidden" id="tentFlag" value="0">

<?php
/*debug($resArray);
debug($avaArray);*/
?>

<!-- footer -->
<?php echo $this->element('admin_footer'); ?>
<!-- end of footer -->
</body>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

<!-- final validation -->
<script>
    function finalValidate(){
        // alert('enable to submit');
        let method = document.getElementsByName('_method');
        method[0].setAttribute('value', 'POST');
        //console.log(method[0]);
        return enableSubmit();
        // check all stage flag == 1, then return, else not
    }

    function enableSubmit(){
        //validateDate();
        //validateTenant();
        let room_type = document.getElementById('room_type').value;
        if (room_type == 1){
            console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!SHARING ENABLING SUBMIT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
            let bedFlag =  $('#bedFlag').val();
            if (bedFlag == '1'){
                enableTime();
            }
            let timeFlag =  $('#timeFlag').val();
            // let tentFlag =  $('#tentFlag').val();  && tentFlag=='1'

            if (timeFlag=='1' && bedFlag=='1'){
                $('#submitButton').prop('disabled', '');
                //console.log('submit Enabled');
                return true;
            }else{
                $('#submitButton').prop('disabled', 'true');
            }
            let count = 0;
            let beds = $('.sharedRoomBedCheck');
            for (let i=0; i<beds.length; i++){
                if (beds[i].style.display == 'none'){
                    count = count + 1;
                }
            }
            if (count == beds.length){
                // show no beds available
                $('#nobed').prop('style', 'color:red; font-weight900;');
            }else{
                $('#nobed').prop('style', 'display:none;');
            }
            /* console.log(timeFlag);
             console.log(bedFlag);
             console.log(tentFlag);*/


            return false;
        }else{
            console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!PRIVATE ENABLING SUBMIT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
            let bedFlag =  $('#bedFlag').val();
            let timeFlag =  $('#timeFlag').val();
            if (timeFlag=='1' && bedFlag=='1'){
                $('#submitButton').prop('disabled', '');
                //console.log('submit Enabled');
                return true;
            }else{
                $('#submitButton').prop('disabled', 'true');
            }
        }
    }
</script>

<!-- onload validation -->
<script>
    $(function(){
        // procress private bed flag
        let bed_cap = calBedCap();
        console.log(bed_cap);

        let tentNum = calTentNum();                                                                                      // init supporting fields
        $('#num-ppl').prop('value', tentNum);
        $('#tenant_id').prop('value', tentNum-1);

        // STAGE 1
        var timeValid = validateTime();                                                                                  // onload validation start
        if (timeValid == true){
            //console.log("<<<PASSED Step1 Validation -- Time>>>");
            $('#timeFlag').prop('value', '1');
        }else{
            $('#timeFlag').prop('value', '0');
        }
        //console.log("-------------------End validating Time");
        // STAGE 2
        var bedValid = validateBed();
        if (bedValid == true){
           // console.log("<<<PASSED Step2 Validation -- Bed>>>");
            $('#bedFlag').prop('value', '1');
        }else{
            $('#bedFlag').prop('value', '0');
        }
        //console.log("-------------------End validating Bed");
        // STAGE 3
        var tenantValid = validateTenant();
        if (tenantValid == true){
          //  console.log("<<<PASSED Step3 Validation -- Tenant>>>");
            $('#tentFlag').prop('value', '1');
        }else{
            $('#tentFlag').prop('value', '0');
        }
        enableSubmit();
       // console.log("-------------------End validating Bed");
    });
</script>

<!-- 3 STAGES VALIDATION -->
<script>
    // Stage ONE validation Declaration
    function validateTime(){
        //console.log('----------Start validating Time');
        var startValid = 1;
        $('.dateAndDuration').each(function() {
            if ($(this).val() === '') {
                startValid = 0;
            }
        });
        if (startValid == 1){                                                                                           // all fields entered, start validation
            //console.log('==>All entry filled in, begin validation');
            var validRes = validateDate();
        }
        else{
           // console.log('=====!!!Stage ONE EMPTY input detected');
            return false;
        }
        return validRes;
    }

    function validateDate(){
        var gd = $('#datepicker').val();
        let gd_array = gd.split("/");
        let givenDate = gd_array[2] +"-"+ gd_array[1] + "-"+ gd_array[0];
        let currentDate = new Date();
        givenDate = new Date(givenDate);
        var room_type = document.getElementById('room_type').value;

        if (room_type == 0){                                                                                            // private room check
            var prepare = document.getElementById('datepicker').value;
            prepare = prepare.split("/");
            var startDateString = prepare[1]+'/'+prepare[0]+'/'+prepare[2];
            var duration = document.getElementById('duration').value;
            var s = new Date(startDateString);
            var e = new Date(startDateString);
            let currentDate = new Date();
            for (var j=0; j<duration; j++){
                e = e.addMonths(1);
            }
            currentDate.setHours(0);                                                      // set time to 0 for compare
            currentDate.setMinutes(0);
            currentDate.setSeconds(0);
            currentDate.setMilliseconds(0);
            s.setHours(0);                                                      // set time to 0 for compare
            s.setMinutes(0);
            s.setSeconds(0);
            s.setMilliseconds(0);
            e.setHours(0);
            e.setMinutes(0);
            e.setSeconds(0);
            e.setMilliseconds(0);


            // only validate if the end is before current, else display endbeforetoday warning
            //console.log(currentDate);
            //console.log(e);
            if (currentDate < e){
                selectbeds_p();
                $('#endbeforetoday').prop('style', 'display:none;');
                $('#endbeforetodayflag').prop('value', '0');
                $('#freeadd').prop('style', 'display:none;');
                var avaArray = <?php echo json_encode($avaArray); ?>;
                console.log(avaArray);

                //console.log(avaArray);
                var flag = 0;
                for (var i=0; i<avaArray.length; i++){
                    var this_s = new Date(avaArray[i][0]);
                    if (avaArray[i][1] != null){
                       // alert(this_s);
                        //alert(currentDate);
                        if (!(this_s > currentDate) && !(this_s < currentDate) || s < currentDate){
                            s = currentDate;
                        }
                        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                        var this_e = new Date(avaArray[i][1]);
                        this_s.setHours(0);                                         // set time to 0 for compare
                        this_s.setMinutes(0);
                        this_s.setSeconds(0);
                        this_s.setMilliseconds(0);
                        this_e.setHours(0);
                        this_e.setMinutes(0);
                        this_e.setSeconds(0);
                        this_e.setMilliseconds(0);
                        if (s >= this_s && e <= this_e){
                            flag = 1;
                        }
                    }
                    else{
                        console.log(currentDate);
                        console.log(this_s);
                        if (!(this_s > currentDate) && !(this_s < currentDate) || s < currentDate){
                            s = currentDate;
                        }
                        if (s >= this_s){
                            console.log("END NULL, START VALID");
                            flag = 1;
                        }
                    }
                }

                if (flag == 0){                                                                                              // this time slot not available
                    // display error msg
                    let step1errormsg = document.getElementsByClassName('step1ErrorMsg_p');
                    for (let i=0; i<step1errormsg.length; i++){
                        step1errormsg[i].setAttribute('style', 'padding-top:10px;');
                    }
                    return false;
                }
                else{                                                                                                        // time validate successful

                    let step1errormsg = document.getElementsByClassName('step1ErrorMsg_p');
                    for (let i=0; i<step1errormsg.length; i++){
                        //step1errormsg[i].setAttribute('style', 'padding-top:10px;');
                        step1errormsg[i].setAttribute('style', 'display:none;');
                    }
                    let step1errormsg2 = document.getElementsByClassName('step1ErrorMsg');
                    for (let i=0; i<step1errormsg2.length; i++){
                        //step1errormsg[i].setAttribute('style', 'padding-top:10px;');
                        step1errormsg2[i].setAttribute('style', 'display:none;');
                    }

                    return true;
                }

            }
            else{                                                                                                        // display endbeforetoday warning
                $('#endbeforetoday').prop('style', '');
                $('#endbeforetodayflag').prop('value', '1');
                $('#freeadd').prop('style', '0');
                $('#step1ErrorMsg_p').prop('style', 'display:none;');
                hideBeds();
                console.log('HERE');
                return true;
            }
        }
        else{                                                                                                           // shared room check // generate current tent num and full num the room can take
            var cap = calTentNum();                                                                                     // current num of tenants
            var totalCap = document.getElementById('total_cap').value;
            // generating start and end time
            var sprepare = document.getElementById('datepicker').value;
            sprepare = sprepare.split("/");
            var sstartDateString = sprepare[1]+'/'+sprepare[0]+'/'+sprepare[2];
            var sduration = document.getElementById('duration').value;
            var ss = new Date(sstartDateString);
            var se = new Date(sstartDateString);
            var scurrentDate = new Date();
            for (var k=0; k<sduration; k++){
                se = se.addMonths(1);
            }
            scurrentDate.setHours(0);     // set time to 0 for compare
            scurrentDate.setMinutes(0);
            scurrentDate.setSeconds(0);
            scurrentDate.setMilliseconds(0);
            ss.setHours(0);   // set time to 0 for compare
            ss.setMinutes(0);
            ss.setSeconds(0);
            ss.setMilliseconds(0);
            se.setHours(0);
            se.setMinutes(0);
            se.setSeconds(0);
            se.setMilliseconds(0);

            let endBeforeTodayFlag =0;

            if (se < currentDate) {                                                                                      // if ends before today, no validation
                let bedCapBigger = $('.bedCapBigger');
                for (let i=0; i < bedCapBigger.length; i++){
                    bedCapBigger[i].setAttribute('style', 'display:none');
                }

                let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                for (let i=0; i<sstep1errormsg.length; i++){
                    sstep1errormsg[i].setAttribute('style', 'display:none;');
                }

                $('#endbeforetoday').prop('style', '');
                $('#freeadd').prop('style', '');

                let step1errormsg_ = $('.step1ErrorMsg');
                for (let i=0; i<step1errormsg_.length; i++) {
                    step1errormsg_[i].setAttribute('style', 'display:none;');
                }

                $('#endbeforetodayflag').prop('value', '1');
                //console.log("HERE!!!!!!!!!");
                hideBeds();
                endBeforeTodayFlag  = 1;
            }
            else{                                                                                                        // if not ends before, then valida ava
                $('#endbeforetoday').prop('style', 'display:none;');
                $('#freeadd').prop('style', 'display:none');
                $('#bedsHidden').prop('style', 'display:none');
                $('#endbeforetodayflag').prop('value', '0');
                var resArray = <?php echo json_encode($resArray); ?>;                                                   // checking tentNum against resArray
                //console.log(resArray);
                var startIndex = 0;
                if (ss <= currentDate){
                    startIndex = 0;
                }else{
                    startIndex = getDaysInBetween(scurrentDate, ss);
                    //console.log(scurrentDate);
                    //console.log(ss);
                    //console.log('here');
                    //console.log(startIndex);
                }
                var endIndex = getDaysInBetween(scurrentDate, se);
                //console.log('here');
                //console.log(endIndex);
                var thisFlag = 1;
                for (var a = startIndex; a <= endIndex; a++){
                    var realCap = 0;
                    if (resArray[a] == null){
                        realCap = 0;
                    }else{
                        realCap = parseInt(resArray[a][0], 10);
                    }
                    if (a < resArray.length){
                        if ((totalCap-realCap) < cap){
                            thisFlag = 0;
                            break;
                        }
                    }
                }
            }
            // thisFlag == 0 if num of tent exceed ava ppl-num
            // thisFlag == 1 if num of tent satisfied ava ppl-num

            if (endBeforeTodayFlag==0){                                                                                  // if ends before today, no need to validate, the rental is expired already
                  //  console.log('==> capacity validation passed');
                    var sstep1ppl = document.getElementById('num-ppl').value;

                    var allBeds = <?php echo json_encode($room_beds); ?>;                                              // generate beds to display
                    var tohide = [];
                    //console.log(startIndex);
                    //console.log(endIndex);
                    //console.log(resArray[88]);
                    //console.log(resArray);
                    for (var b = startIndex; b <= endIndex; b++){
                      //  console.log(b);
                       // console.log(resArray[b]);
                        if (resArray[b] != null){
                            for (var p=0; p < resArray[b][1].length; p++){
                                var ft = tohide.includes(resArray[b][1][p].id);
                                if (ft != true){
                                    tohide.push(resArray[b][1][p].id);
                                }
                            }
                        }
                    }

                    //console.log(tohide);

                    let myBeds = $('.my_bed');
                    //console.log(myBeds);

                    for (let k=0; k<myBeds.length; k++){
                        let id_string = '#beds-rooms-ids-'+myBeds[k].value;
                        //console.log(myBeds[k]);
                        $(id_string).prop('disabled', '');
                        $(id_string).prop('checked', '');
                        let this_id = '#sharedRoomBedCheck'+myBeds[k].value;
                        $(this_id).prop('style', '');
                        //console.log(myBeds[k]);
                        //console.log(this_id);
                        //console.log($(this_id));
                    }

                    for (var n=0; n < tohide.length; n++){
                        //console.log(tohide[n]);
                        var idString = "sharedRoomBedCheck"+tohide[n];
                        var this_bed = document.getElementById(idString);
                        this_bed.setAttribute('disable', 'true');                                                       // disable those not to display to prevent upload
                        this_bed.setAttribute('style', 'display:none;');
                    }

                    selectBeds();                                                                                        // select the beds chosen in the application (if the bed is displayed)
                    let bed_error = showBedTentWarning_error();
                    if (bed_error == false){
                        $('#bedFlag').prop('value', '0');
                    }else{
                        $('#bedFlag').prop('value', '1');
                    }
                    enableSubmit();
                // after select beds, validate current select cap and current num tenant
                    let currentBedCap =  calBedCap();
                    let currentNumTent = $('.tent_field').length;

                if (currentBedCap >= currentNumTent){
                    let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                    for (let i=0; i<sstep1errormsg.length; i++){
                        sstep1errormsg[i].setAttribute('style', 'display:none;');
                    }
                }else{
                    let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                    for (let i=0; i<sstep1errormsg.length; i++){
                        sstep1errormsg[i].setAttribute('style', 'padding-top:10px;');
                    }
                }


               // console.log('==>responsive bed selected');
                if (thisFlag == 0){
                    let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                    for (let i=0; i<sstep1errormsg.length; i++){
                        sstep1errormsg[i].setAttribute('style', 'padding-top:10px;');
                    }
                    return false;
                }
            }
            else{                                                                                                       // if ends before today, no need to validate cap, set bed validate to 1, set tent num validation to 1, show at beds select section
                //console.log("==>this rental ends before today, no need to select beds");
                hideBeds();
            }
            return true;
        }
    }

    function selectbeds_p(){
        let displayedBeds = document.getElementsByClassName('sharedRoomBedCheck');
        $('#bedsHidden').prop('style', 'display:none;');
        for (let i=0; i<displayedBeds.length; i++){
            let id_string = '#beds-rooms-ids-'+displayedBeds[i].getAttribute('id').split('sharedRoomBedCheck')[1];
            $(id_string).prop('disabled', '');
            $(id_string).prop('checked', 'checked');
            displayedBeds[i].setAttribute('style', '');
        }
        console.log("end select beds");
    }

    function hideBeds(){
        let displayedBeds = document.getElementsByClassName('sharedRoomBedCheck');
        console.log(displayedBeds);
        $('#bedsHidden').prop('style', '');
        for (let i=0; i<displayedBeds.length; i++){
            console.log('!');
            let id_string = '#beds-rooms-ids-'+displayedBeds[i].getAttribute('id').split('sharedRoomBedCheck')[1];
            $(id_string).prop('disabled', 'true');
            $(id_string).prop('checked', '');
            displayedBeds[i].setAttribute('style', '');
        }
        console.log("end hide beds");
    }

    function selectBeds(){
        /*
        Check the beds from the generated displayed list (of those in the application chosen beds)
         */
        let displayedBeds = document.getElementsByClassName('sharedRoomBedCheck');
        let selectedBeds = <?php echo json_encode($app_room_beds); ?>;
        for (let i=0; i<displayedBeds.length; i++){
            if (!displayedBeds[i].getAttribute('disable')){
                for (let j=0; j < selectedBeds.length; j++){
                    if (displayedBeds[i].getAttribute('id').split('sharedRoomBedCheck')[1] == selectedBeds[j].bed_room_id){
                        let id_string = '#beds-rooms-ids-'+displayedBeds[i].getAttribute('id').split('sharedRoomBedCheck')[1];
                        $(id_string).prop('checked', 'checked');
                    }
                }
            }
        }
    }

    // Stage TWO validation Declaration
    function validateBed(){
       // console.log('------------------Start validating Bed');
        if ($('#endbeforetodayflag').val() == '0'){
         //   console.log('==>this rental ends after today');
            if ($('.my_bed:checkbox:checked').length > 0 ){                                                           // if rental ends after today, check at least one bed is selected
           //     console.log("==>at least one bed selected");
                let bed_cap = calBedCap();
                let tent_field = $('.tent_field');
               if (tent_field.length < bed_cap){                                                                       // if current num tent not equal to bed cap, show warming in bed section
               //     console.log("==>WARNING bed, num tent smaller than beds cap selected");
                }
               if (tent_field.length > bed_cap){
                 //  console.log("==>ERROR bed, num tent bigger than beds cap selected");
                   return false;
               }
            }else{
               // console.log("==>NO beds selected, false returned");
                return false;
            }
        }
        else{
            //console.log("==>End before today, no bed selection required show warning");
        }
        //console.log("==>set stage 2 validation flag to 1");
        return true;
    }

    // Stage THREE validation Declaration
    function validateTenant(){
       // console.log('------------------Start validating Tenant');
        // validate tenant number
        let bed_cap = calBedCap();
        let tent_field = $('.tent_field');
        if (tent_field.length < bed_cap){                                                                       // if current num tent not equal to bed cap, show warming in bed section
         //   console.log("==>WARNING tent, num tent smaller than beds cap selected");
        }
        if (tent_field.length > bed_cap){
           // console.log("==>ERROR tent, num tent bigger than beds cap selected");
            return false;
        }
        //console.log("tenant num is smaller than or equal to cap");
        return true;
    }

    function calBedCap(){
        let room_beds =  <?php echo json_encode($room_beds); ?>;
        let selectedBeds = $('.my_bed:checkbox:checked');
        let cap = 0;
        for (let i=0; i < selectedBeds.length; i++){
            let bed_id = selectedBeds[i].value;
            for (let j=0; j < room_beds.length; j++){
                if (bed_id == room_beds[j].id){
                    cap = cap + room_beds[j].capacity;
                }
            }
        }
        return cap;
    }
</script>
<!-- end onload validation -->

<!-- on change validation -->
<script>
    $(function(){
        // STAGE 1 ON CHANGE
        $('.dateAndDuration').on('change', function(){
            let bed_error = showBedTentWarning_error();
            if (bed_error == false){
                $('#bedFlag').prop('value', '0');
            }else{
                $('#bedFlag').prop('value', '1');
            }
            enableSubmit();
         //   console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");

            var timeValid = validateTime();                                                                                  // onload validation start
            if (timeValid == true){
           //     console.log("<<<PASSED on change stage 1 Validation>>>");
                $('#timeFlag').prop('value', '1');
            }else{
                $('#timeFlag').prop('value', '0');
            }
            enableSubmit();
           // console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
        });

        $('.sharedRoomBedCheck').on('change', function(){
            let bed_error = showBedTentWarning_error();
            if (bed_error == false){
                $('#bedFlag').prop('value', '0');
            }else{
                $('#bedFlag').prop('value', '1');
            }
            enableSubmit();
            //console.log('Beds Being Selected By User');
        });



    });

</script>
<!-- end on change validation -->

<!--  tenant generate ADD && RM-->
<script>
    function calCurrentCap() {                                                                                          // current num of tenants
        var totalCap = calFullBedCap();
        var sprepare = document.getElementById('datepicker').value;
        sprepare = sprepare.split("/");
        var sstartDateString = sprepare[1]+'/'+sprepare[0]+'/'+sprepare[2];
        var sduration = document.getElementById('duration').value;
        var ss = new Date(sstartDateString);
        var se = new Date(sstartDateString);
        var scurrentDate = new Date();
        for (var k=0; k<sduration; k++){
            se = se.addMonths(1);
        }
        scurrentDate.setHours(0);     // set time to 0 for compare
        scurrentDate.setMinutes(0);
        scurrentDate.setSeconds(0);
        scurrentDate.setMilliseconds(0);
        ss.setHours(0);   // set time to 0 for compare
        ss.setMinutes(0);
        ss.setSeconds(0);
        ss.setMilliseconds(0);
        se.setHours(0);
        se.setMinutes(0);
        se.setSeconds(0);
        se.setMilliseconds(0);


        let resArray = <?php echo json_encode($resArray); ?>;                                                   // checking tentNum against resArray
        let startIndex = 0;
        if (ss <= scurrentDate) {
            startIndex = 0;
        } else {
            startIndex = getDaysInBetween(scurrentDate, ss);
        }
        var endIndex = getDaysInBetween(scurrentDate, se);

        let res = totalCap;

        for (var a = startIndex; a <= endIndex; a++) {
            var realOcu = 0;
            if (resArray[a] == null) {
                realOcu = 0;
            } else {
                realOcu = parseInt(resArray[a][0], 10);
            }
            if ((totalCap-realOcu) < res){
                res = totalCap - realOcu;
            }
        }
        return res;
    }

    function calFullBedCap(){
        let room_beds =  <?php echo json_encode($room_beds); ?>;
        //let selectedBeds = $('.my_bed:checkbox:checked');
        let cap = 0;
        for (let i=0; i < room_beds.length; i++){
            cap = cap + room_beds[i].capacity;
        }
        return cap;
    }

    $(document).ready(function(){
        // tenant remove
        $(document).on('click', '.rm', function(){
            console.log("REMOVE PROCESS ACTIVIED");

            if ($('.tent_field').length > 1){
                let id = '#tenant'+ $(this)[0].id.split('removetenant')[1];
               // console.log(id);
                $(id).remove();

                let heads = $('.tent_head');

                for (let i=0; i <heads.length; i++){
                    heads[i].innerHTML = "<u style='color:black;'>Tenant "+(i+1).toString()+"</u>";
                }

                let endbeforetodayflag = $('#endbeforetodayflag').val();

                if (endbeforetodayflag == 0){
                    let bed_error = showBedTentWarning_error();
                    if (bed_error == false){
                        $('#bedFlag').prop('value', '0');
                    }else{
                        $('#bedFlag').prop('value', '1');
                    }
                }

                console.log('ready to remove');
                enableSubmit();

                //fullValidation();

            }else{
                alert("Cannot remove. Your rental should at least have one tenant.");
            }
        });

        // tenant add
        $("#add_t").click(addTenant);
        function addTenant(){
            let endbeforetodayflag = $('#endbeforetodayflag').val();

            var ref = document.getElementById('tent');
            //alert("here");
            // create another tenant field, if the max cap isn't exceeded.
            var ele = calCurrentCap();
            //console.log(ele);
            var selectedCap = calBedCap();
            //console.log(selectedCap);

            var currentTentNum = $('.tent_field').length;

            if (endbeforetodayflag == 0){                                                                                // if not end before today, validate

                if (currentTentNum == selectedCap){
                    alert("Cannot add more tenant. The beds you selected cannot afford more people, please go select more beds or adjust your time slot for more beds.");
                    return false;
                }
                if (currentTentNum > selectedCap){
                    alert("ERROR! Tenant num bigger than selected bed cap!");
                    return false;
                }
            }


            let i = parseInt($('#tenant_id').val())+1;
            //console.log(i);

            let nextline = document.createElement('br');

            let id = 'tenant'+i;
            let outer_outer_div = document.createElement('div');
            outer_outer_div.setAttribute('class', 'tent_field');
            outer_outer_div.setAttribute('id', id);

            let outter_div = document.createElement('div');
            outter_div.setAttribute('style', 'border-radius:10px; border:solid 1px #ffc107');

            outter_div.appendChild(document.createElement('br'));

            let content_div = document.createElement('div');
            content_div.setAttribute('style', 'padding-left:10px;');

            let button_div_outter = document.createElement('div');

            let button_div_layer2 = document.createElement('div');

            let button_div_layer2_header = document.createElement('h4');

            let button_div_layer2_header_u = document.createElement('u');
            button_div_layer2_header_u.setAttribute('class', 'tent_head');

            let button_div_layer2_button = document.createElement('a');
            button_div_layer2_button.setAttribute('type', 'button');
            id = 'removetenant'+i;
            button_div_layer2_button.setAttribute('id', id);
            button_div_layer2_button.setAttribute('class', 'button btn-danger btn-sm rm');
            button_div_layer2_button.setAttribute('style', 'margin-top:10px; border-radius:50px;');
            button_div_layer2_button.innerHTML = "Remove This Tenant From This Rental";

            button_div_layer2_header.appendChild(button_div_layer2_header_u);
            button_div_layer2.appendChild(button_div_layer2_header);
            button_div_layer2.appendChild(button_div_layer2_button);
            button_div_outter.appendChild(button_div_layer2);

            content_div.appendChild(nextline);
            content_div.appendChild(button_div_outter);

            // INPUT CONTENT START
            let second_outter_div = document.createElement('div');

            // FIRST DIV
            // FIRSTNAME
            let fn_div = document.createElement('div');
            fn_div.setAttribute('class', 'inline_field');

            let fn_div_inner = document.createElement('div');
            fn_div_inner.setAttribute('class', 'input text required');
            fn_div_inner.setAttribute('style', 'padding-right:3px;');

            let fn_label = document.createElement('label');
            let for_text = "tenants-"+i+"-first-name";
            fn_label.setAttribute('for', for_text);
            fn_label.innerHTML = "First Name";

            let fn_input = document.createElement('input');
            fn_input.setAttribute('type', 'text');
            let name_text = "tenants["+i+"][first_name]";
            fn_input.setAttribute('name', name_text);
            fn_input.setAttribute('style', 'height:35px;');
            fn_input.setAttribute('data-validation', 'custom');
            fn_input.setAttribute('data-validation-regexp', "^([A-Za-z ]+)$");
            fn_input.setAttribute('data-validation-error-msg', "Please enter a valida first name");
            fn_input.setAttribute('required', "required");
            fn_input.setAttribute('maxlength', "255");
            id = "tenants-"+i+"-first-name";
            fn_input.setAttribute('id', id);
            fn_input.setAttribute('default', 'enter first name');

            fn_div_inner.appendChild(fn_label);
            fn_div_inner.appendChild(fn_input);

            fn_div.appendChild(fn_div_inner);

            // LASTNAME
            let ln_div = document.createElement('div');
            ln_div.setAttribute('class', 'inline_field');

            let ln_div_inner = document.createElement('div');
            ln_div_inner.setAttribute('class', 'input text required');
            ln_div_inner.setAttribute('style', 'padding-right:3px;');

            let ln_label = document.createElement('label');
            for_text = "tenants-"+i+"-last-name";
            ln_label.setAttribute('for', for_text);
            ln_label.innerHTML = "Last Name";

            let ln_input = document.createElement('input');
            ln_input.setAttribute('type', 'text');
            name_text = "tenants["+i+"][last_name]";
            ln_input.setAttribute('name', name_text);
            ln_input.setAttribute('style', 'height:35px;');
            ln_input.setAttribute('data-validation', 'custom');
            ln_input.setAttribute('data-validation-regexp', "^([A-Za-z ]+)$");
            ln_input.setAttribute('data-validation-error-msg', "Please enter a valida last name");
            ln_input.setAttribute('required', "required");
            ln_input.setAttribute('maxlength', "255");
            id = "tenants-"+i+"-last-name";
            ln_input.setAttribute('id', id);
            ln_input.setAttribute('default', 'enter last name');

            ln_div_inner.appendChild(ln_label);
            ln_div_inner.appendChild(ln_input);

            ln_div.appendChild(ln_div_inner);

            // PREFERRED NAME
            let pn_div = document.createElement('div');
            pn_div.setAttribute('class', 'inline_field');

            let pn_div_inner = document.createElement('div');
            pn_div_inner.setAttribute('class', 'input text required');

            let pn_label = document.createElement('label');
            for_text = "tenants-"+i+"-preferred-name";
            pn_label.setAttribute('for', for_text);
            pn_label.innerHTML = "Preferred Name";

            let pn_input = document.createElement('input');
            pn_input.setAttribute('type', 'text');
            name_text = "tenants["+i+"][preferred_name]";
            pn_input.setAttribute('name', name_text);
            pn_input.setAttribute('style', 'height:35px;');
            pn_input.setAttribute('data-validation', 'custom');
            pn_input.setAttribute('data-validation-regexp', "^([A-Za-z ]+)$");
            pn_input.setAttribute('data-validation-error-msg', "Please enter a valida preferred name");
            pn_input.setAttribute('data-validation-optional', 'true');
            pn_input.setAttribute('maxlength', "255");
            id = "tenants-"+i+"-preferred-name";
            pn_input.setAttribute('id', id);
            pn_input.setAttribute('default', 'enter preferred name');

            pn_div_inner.appendChild(pn_label);
            pn_div_inner.appendChild(pn_input);

            pn_div.appendChild(pn_div_inner);

            second_outter_div.appendChild(fn_div);
            second_outter_div.appendChild(ln_div);
            second_outter_div.appendChild(pn_div);


            // third DIV
            let third_outter_div = document.createElement('div');
            third_outter_div.setAttribute('style', 'padding-top:10px;');
            // GENDER
            let g_input_inner = document.createElement('div');
            g_input_inner.setAttribute('class', 'inline_field');
            let g_input = document.createElement('div');
            g_input.setAttribute('class', 'input select required');
            g_input.setAttribute('style', 'padding-right:3px;');
            let g_label = document.createElement('label');
            for_text = "tenants-"+i+"-gender";
            g_label.setAttribute('for', for_text);
            g_label.innerHTML = "Gender";
            name_text = "tenants["+i+"][gender]";
            id = "tenants-"+i+"-gender";

            let g_select = document.createElement('select');
            g_select.setAttribute('name', name_text);
            g_select.setAttribute('required', 'required');
            g_select.setAttribute('id', id);
            let option1 = document.createElement('option');
            option1.setAttribute('value', '0');
            option1.innerHTML = "Male";
            g_select.appendChild(option1);
            let option2 = document.createElement('option');
            option2.setAttribute('value', '1');
            option2.innerHTML = 'Female';
            g_select.appendChild(option2);
            let option3 = document.createElement('option');
            option3.setAttribute('value', '2');
            option3.innerHTML = 'Other';
            g_select.appendChild(option3);

            g_input.appendChild(g_label);
            g_input.append(g_select);
            g_input_inner.appendChild(g_input);

            // IS_AUS_C
            let c_input_inner = document.createElement('div');
            c_input_inner.setAttribute('class', 'inline_field');
            let c_input = document.createElement('div');
            c_input.setAttribute('class', 'input select required');
            let c_label = document.createElement('label');
            for_text = "tenants-"+i+"-is-aus-citizen";
            c_label.setAttribute('for', for_text);
            c_label.innerHTML = "Is Australian Citizen";
            name_text = "tenants["+i+"][is_aus_citizen]";
            id = "tenants-"+i+"-is-aus-citizen";

            let c_select = document.createElement('select');
            c_select.setAttribute('name', name_text);
            c_select.setAttribute('required', 'required');
            c_select.setAttribute('id', id);
            option1 = document.createElement('option');
            option1.setAttribute('value', '0');
            option1.innerHTML = "Yes";
            c_select.appendChild(option1);
            option2 = document.createElement('option');
            option2.setAttribute('value', '1');
            option2.innerHTML = 'No';
            c_select.appendChild(option2);

            c_input.appendChild(c_label);
            c_input.append(c_select);
            c_input_inner.appendChild(c_input);


            third_outter_div.appendChild(g_input_inner);
            third_outter_div.appendChild(c_input_inner);


            // forth DIV
            let forth_outter_div = document.createElement('div');
            forth_outter_div.setAttribute('style', 'padding-top:10px;');
            forth_outter_div.setAttribute('class', 'inline-field');
            // PHONE
            let ph_input_inner = document.createElement('div');
            ph_input_inner.setAttribute('class', 'input text');

            ph_input_inner.innerHTML = "" +
                "<label for=\"tenants-"+i.toString()+"-personal-phone\">Personal Phone (Australian preferred)</label>" +
                "<input type=\"text\" " +
                "name=\"tenants["+i.toString()+"][personal_contact_phone]\"  " +
                "placeholder=\"04\" " +
                "class=\"span3\" " +
                "style=\"height:35px;\" " +
                "id=\"tenants-"+i.toString()+"-personal-phone\" " +
                "data-validation=\"custom\"" +
                " data-validation-regexp=\"^([0-9+ ]+)$\"" +
               // " data-validation-length=\"10\"" +
                " data-validation-optional=\"true\"" +
                " data-validation-error-msg = \"Please enter a valid Australian phone number if you have one. Please leave it blank if you do not have one.\">"+
            "<span>If you don't have an Australian phone number, please enter your country code before the phone number. Possible format: +86 18844576263</span><br><br>";

            /*
            "data-validation-regexp" => "^([0-9+ ]+)$",
             */

            forth_outter_div.appendChild(ph_input_inner);

            content_div.appendChild(second_outter_div);
            content_div.appendChild(third_outter_div);
            content_div.appendChild(forth_outter_div);

            outter_div.appendChild(content_div);

            outer_outer_div.appendChild(outter_div);
            outer_outer_div.appendChild(document.createElement('br'));

            ref.appendChild(outer_outer_div);


            $.validate({});

            let heads = $('.tent_head');

            for (let i=0; i <heads.length; i++){
                heads[i].innerHTML = "<u style='color:black;'>Tenant "+(i+1).toString()+"</u>";
            }

            $('#tenant_id').prop('value', i+1);



            if  (endbeforetodayflag == 0){
                let bed_error = showBedTentWarning_error();
                if (bed_error == false){
                    $('#bedFlag').prop('value', '0');
                }else{
                    $('#bedFlag').prop('value', '1');
                }
            }
            enableSubmit();
        }
    });
</script>
<!-- end tenant generate ADD -->

<!-- all other function declaration -->
<Script>
    function noBedTimeValidate(){

        var gd = $('#datepicker').val();
        let gd_array = gd.split("/");
        let givenDate = gd_array[2] +"-"+ gd_array[1] + "-"+ gd_array[0];
        let currentDate = new Date();
        givenDate = new Date(givenDate);
        var room_type = document.getElementById('room_type').value;

        if (room_type == 0){                                                                                            // private room check
            var prepare = document.getElementById('datepicker').value;
            prepare = prepare.split("/");
            var startDateString = prepare[1]+'/'+prepare[0]+'/'+prepare[2];
            var duration = document.getElementById('duration').value;
            var s = new Date(startDateString);
            var e = new Date(startDateString);
            let currentDate = new Date();
            for (var j=0; j<duration; j++){
                e = e.addMonths(1);
            }
            currentDate.setHours(0);                                                      // set time to 0 for compare
            currentDate.setMinutes(0);
            currentDate.setSeconds(0);
            currentDate.setMilliseconds(0);
            s.setHours(0);                                                      // set time to 0 for compare
            s.setMinutes(0);
            s.setSeconds(0);
            s.setMilliseconds(0);
            e.setHours(0);
            e.setMinutes(0);
            e.setSeconds(0);
            e.setMilliseconds(0);

            var avaArray = <?php echo json_encode($avaArray); ?>;
            //console.log(avaArray);
            var flag = 0;
            //alert(avaArray.length);
            for (var i=0; i<avaArray.length; i++){
                var this_s = new Date(avaArray[i][0]);
                //alert(avaArray[i][1]);
                if (avaArray[i][1] != null){
                    var this_e = new Date(avaArray[i][1]);
                    this_s.setHours(0);                                         // set time to 0 for compare
                    this_s.setMinutes(0);
                    this_s.setSeconds(0);
                    this_s.setMilliseconds(0);
                    this_e.setHours(0);
                    this_e.setMinutes(0);
                    this_e.setSeconds(0);
                    this_e.setMilliseconds(0);
                    if (s >= this_s && e <= this_e){
                        flag = 1;
                    }
                }
                else{
                    if (s >= this_s){
                        flag = 1;
                    }
                }
            }
            if (flag == 0){
                // display error msg
                var step1errormsg = document.getElementsByClassName('step1ErrorMsg');
                for (let i=0; i<step1errormsg.length; i++){
                    step1errormsg[i].setAttribute('style', 'padding-top:10px;');
                }
                return false;
            }
            else{
                var step1errormsg = document.getElementById('step1ErrorMsg');
                step1errormsg.setAttribute('style', 'display:none;');

                var step1ppl = document.getElementById('num-ppl').value;
                var ppl = document.getElementById('number-of-people');
                ppl.setAttribute('value', step1ppl);
                $('select option[value="'+step1ppl+'"]').attr("selected",true);
                updateForm();
                var step3startdate = document.getElementById('start-date');
                var step1startdate = document.getElementById('datepicker').value;
                step3startdate.setAttribute('value', step1startdate);

                $('#tab1').prop('checked', false);
                $('#tab2').prop('checked', true);
                var tab1Label = document.getElementById('tab1Label');
                var step1errormsg1 = document.getElementById('step1ErrorMsg');
                step1errormsg1.setAttribute('style', 'padding-top:10px; display:none;');
                tab1Label.setAttribute('style', 'background:#d2f8d2;');
                $('#step2Next').prop('disabled', false);
                $('#step_counter').prop('value', 'step2');

            }

        }
        else{                                                                                                           // shared room check
            // generate current tent num and full num the room can take
            var cap = calTentNum();                                                                                     // current num of tenants
            var totalCap = document.getElementById('total_cap').value;
            // generating start and end time
            var sprepare = document.getElementById('datepicker').value;
            sprepare = sprepare.split("/");
            var sstartDateString = sprepare[1]+'/'+sprepare[0]+'/'+sprepare[2];
            var sduration = document.getElementById('duration').value;
            var ss = new Date(sstartDateString);
            var se = new Date(sstartDateString);
            var scurrentDate = new Date();
            for (var k=0; k<sduration; k++){
                se = se.addMonths(1);
            }
            scurrentDate.setHours(0);     // set time to 0 for compare
            scurrentDate.setMinutes(0);
            scurrentDate.setSeconds(0);
            scurrentDate.setMilliseconds(0);
            ss.setHours(0);   // set time to 0 for compare
            ss.setMinutes(0);
            ss.setSeconds(0);
            ss.setMilliseconds(0);
            se.setHours(0);
            se.setMinutes(0);
            se.setSeconds(0);
            se.setMilliseconds(0);

            let endBeforeTodayFlag =0;

            if (se < currentDate) {                                                                                      // if ends before today, no validation
                let bedCapBigger = $('.bedCapBigger');
                for (let i=0; i < bedCapBigger.length; i++){
                    bedCapBigger[i].setAttribute('style', 'display:none');
                }

                let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                for (let i=0; i<sstep1errormsg.length; i++){
                    sstep1errormsg[i].setAttribute('style', 'display:none;');
                }

                $('#endbeforetoday').prop('style', '');
                $('#freeadd').prop('style', '');

                let step1errormsg_ = $('.step1ErrorMsg');
                for (let i=0; i<step1errormsg_.length; i++) {
                    step1errormsg_[i].setAttribute('style', 'display:none;');
                }

                $('#endbeforetodayflag').prop('value', '1');
                //console.log("HERE!!!!!!!!!");
                hideBeds();
                endBeforeTodayFlag  = 1;
            }
            else{                                                                                                        // if not ends before, then valida ava
                $('#endbeforetoday').prop('style', 'display:none;');
                $('#freeadd').prop('style', 'display:none');
                $('#bedsHidden').prop('style', 'display:none');
                $('#endbeforetodayflag').prop('value', '0');
                var resArray = <?php echo json_encode($resArray); ?>;                                                   // checking tentNum against resArray
                //console.log(resArray);
                var startIndex = 0;
                if (ss <= currentDate){
                    startIndex = 0;
                }else{
                    startIndex = getDaysInBetween(scurrentDate, ss);
                    //console.log(scurrentDate);
                    //console.log(ss);
                    //console.log('here');
                    //console.log(startIndex);
                }
                var endIndex = getDaysInBetween(scurrentDate, se);
                //console.log('here');
                //console.log(endIndex);
                var thisFlag = 1;
                for (var a = startIndex; a <= endIndex; a++){
                    var realCap = 0;
                    if (resArray[a] == null){
                        realCap = 0;
                    }else{
                        realCap = parseInt(resArray[a][0], 10);
                    }
                    if (a < resArray.length){
                        if ((totalCap-realCap) < cap){
                            thisFlag = 0;
                            break;
                        }
                    }
                }
            }
            // thisFlag == 0 if num of tent exceed ava ppl-num
            // thisFlag == 1 if num of tent satisfied ava ppl-num

            if (endBeforeTodayFlag==0){                                                                                  // if ends before today, no need to validate, the rental is expired already
                //console.log('==> capacity validation passed');
                var sstep1ppl = document.getElementById('num-ppl').value;

                var allBeds = <?php echo json_encode($room_beds); ?>;                                              // generate beds to display
                var tohide = [];
                //console.log(startIndex);
                //console.log(endIndex);
                //console.log(resArray[88]);
                //console.log(resArray);
                for (var b = startIndex; b <= endIndex; b++){
                    //console.log(b);
                    //console.log(resArray[b]);
                    if (resArray[b] != null){
                        for (var p=0; p < resArray[b][1].length; p++){
                            var ft = tohide.includes(resArray[b][1][p].id);
                            if (ft != true){
                                tohide.push(resArray[b][1][p].id);
                            }
                        }
                    }
                }

               // console.log(tohide);

                let myBeds = $('.my_bed');
                //console.log(myBeds);

                for (let k=0; k<myBeds.length; k++){
                    let id_string = '#beds-rooms-ids-'+myBeds[k].value;
                    //console.log(myBeds[k]);
                    $(id_string).prop('disabled', '');
                    $(id_string).prop('checked', '');
                    let this_id = '#sharedRoomBedCheck'+myBeds[k].value;
                    $(this_id).prop('style', '');
                    //console.log(myBeds[k]);
                    //console.log(this_id);
                    //console.log($(this_id));
                }

                for (var n=0; n < tohide.length; n++){
                    //console.log(tohide[n]);
                    var idString = "sharedRoomBedCheck"+tohide[n];
                    var this_bed = document.getElementById(idString);
                    this_bed.setAttribute('disable', 'true');                                                       // disable those not to display to prevent upload
                    this_bed.setAttribute('style', 'display:none;');
                }

                selectBeds();                                                                                        // select the beds chosen in the application (if the bed is displayed)
                let bed_error = showBedTentWarning_error();
                if (bed_error == false){
                    $('#bedFlag').prop('value', '0');
                }else{
                    $('#bedFlag').prop('value', '1');
                }
                enableSubmit();
                // after select beds, validate current select cap and current num tenant
                let currentBedCap =  calBedCap();
                let currentNumTent = $('.tent_field').length;

                if (currentBedCap >= currentNumTent){
                    let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                    for (let i=0; i<sstep1errormsg.length; i++){
                        sstep1errormsg[i].setAttribute('style', 'display:none;');
                    }
                }else{
                    let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                    for (let i=0; i<sstep1errormsg.length; i++){
                        sstep1errormsg[i].setAttribute('style', 'padding-top:10px;');
                    }
                }


                //console.log('==>responsive bed selected');
                if (thisFlag == 0){
                    let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                    for (let i=0; i<sstep1errormsg.length; i++){
                        sstep1errormsg[i].setAttribute('style', 'padding-top:10px;');
                    }
                    return false;
                }
            }
            else{                                                                                                       // if ends before today, no need to validate cap, set bed validate to 1, set tent num validation to 1, show at beds select section
                //console.log("==>this rental ends before today, no need to select beds");
                hideBeds();
            }
            return true;
        }
    }

    function enableTime(){
        $('#timeFlag').prop('value', '1');
    }

    function fullValidation(){
        let tentNum = calTentNum();                                                                                      // init supporting fields
        $('#num-ppl').prop('value', tentNum);
        $('#tenant_id').prop('value', tentNum-1);

        // STAGE 1
        var timeValid = validateTime();                                                                                  // onload validation start
        if (timeValid == true){
           // console.log("<<<PASSED Step1 Validation -- Time>>>");
            $('#timeFlag').prop('value', '1');
        }else{
            $('#timeFlag').prop('value', '0');
        }
       // console.log("-------------------End validating Time");
        // STAGE 2
        var bedValid = validateBed();
        if (bedValid == true){
            //console.log("<<<PASSED Step2 Validation -- Bed>>>");
            $('#bedFlag').prop('value', '1');
        }else{
            $('#bedFlag').prop('value', '0');
        }
        //console.log("-------------------End validating Bed");
        // STAGE 3
        var tenantValid = validateTenant();
        if (tenantValid == true){
            //console.log("<<<PASSED Step3 Validation -- Tenant>>>");
            $('#tentFlag').prop('value', '1');
        }else{
            $('#tentFlag').prop('value', '0');
        }
        enableSubmit();
        //console.log("-------------------End validating Bed");
    }
    function showBedTentWarning_error(){
        var room_type = document.getElementById('room_type').value;

        var currentBedCap = calFullBedCap();
        if (room_type == 0){
            currentBedCap = calFullBedCap();
        }else{
            //console.log("SHARE!!!");
            //console.log(calBedCap());
            currentBedCap =  calBedCap();
        }
        //console.log("REACHED HERE");
        //console.log(currentBedCap);
        //console.log(room_type);

        //alert(currentBedCap);


        let currentNumTent = $('.tent_field').length;
        //alert(currentNumTent);

        if (currentBedCap >= currentNumTent){
            if (room_type == 0){
                let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg_pt');                          // room ava at this time slot < num tent
                for (let i=0; i<sstep1errormsg.length; i++){
                    sstep1errormsg[i].setAttribute('style', 'display:none;');
                }
            }else{
                let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                for (let i=0; i<sstep1errormsg.length; i++){
                    sstep1errormsg[i].setAttribute('style', 'display:none;');
                }
            }
        }
        else{

            if (room_type == 0){
                //alert("tent more than bed!!!");
                let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg_pt');                          // room ava at this time slot < num tent
                for (let i=0; i<sstep1errormsg.length; i++){
                    sstep1errormsg[i].setAttribute('style', 'padding-top:10px;');
                }
                let bedCapBigger = $('.bedCapBigger');
                for (let i=0; i < bedCapBigger.length; i++){
                    bedCapBigger[i].setAttribute('style', 'display:none');
                }
            }
            else{
                let sstep1errormsg = document.getElementsByClassName('step1ErrorMsg');                          // room ava at this time slot < num tent
                for (let i=0; i<sstep1errormsg.length; i++){
                    sstep1errormsg[i].setAttribute('style', 'padding-top:10px;');
                }
                let bedCapBigger = $('.bedCapBigger');
                for (let i=0; i < bedCapBigger.length; i++){
                    bedCapBigger[i].setAttribute('style', 'display:none');
                }
            }

            return false;
        }

        if (room_type == 1){
            //console.log("HEREEEEEEEEE REACHED");
            //console.log(currentBedCap);
            //console.log(currentNumTent);
            if (currentBedCap > currentNumTent){
                let bedCapBigger = $('.bedCapBigger');
                //console.log(bedCapBigger);
                for (let i=0; i < bedCapBigger.length; i++){
                    //console.log(bedCapBigger[i]);
                    bedCapBigger[i].setAttribute('style', '');
                }
            }
            if (currentBedCap == currentNumTent){
                let bedCapBigger = $('.bedCapBigger');
                for (let i=0; i < bedCapBigger.length; i++){
                    bedCapBigger[i].setAttribute('style', 'display:none');
                }
            }
        }
    }
    function getDaysInBetween(currentDate, anotherDate){
        // To calculate the time difference of two dates
        var Difference_In_Time = anotherDate.getTime() - currentDate.getTime();
        // To calculate the no. of days between two dates
        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
        return Math.floor(Difference_In_Days);
    }

    function calTentNum(){
        return document.getElementsByClassName('tent_field').length;
    }
</Script>
<!-- end all other function declareation -->

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

<!-- date related function declareation -->
<script>
    Date.isLeapYear = function (year) {
        return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
    };

    Date.getDaysInMonth = function (year, month) {
        return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
    };

    Date.prototype.isLeapYear = function () {
        return Date.isLeapYear(this.getFullYear());
    };

    Date.prototype.getDaysInMonth = function () {
        return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
    };

    Date.prototype.addMonths = function (value) {
        var n = this.getDate();
        this.setDate(1);
        this.setMonth(this.getMonth() + value);
        this.setDate(Math.min(n, this.getDaysInMonth()));
        return this;
    };
</script>
<!-- end date related function declareation -->

<!-- datepicker -->
<script>
    $( function() {
        $( "#datepicker" ).datepicker({
            showWeek: true,
            firstDay: 1,
            maxDate: 365,
            dateFormat: 'dd/mm/yy'
            //maxDate: "+0M +10D"
        });
    } );
</script>
<!-- end datepicker -->

<!-- general validation -->
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
<!-- end help info display and hide -->







