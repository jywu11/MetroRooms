
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Homes Template">
    <meta name="keywords" content="Homes, Marika">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Room Detail | Metrorooms</title>
    <?php $this->assign('title','Property Detail | NAIM'); ?>
</head>

<?= $this->Html->css('my_front') ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Faq[]|\Cake\Collection\CollectionInterface $faqs
 */
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Faq[]|\Cake\Collection\CollectionInterface $faqs
 */
?>

<?php echo $this->element('front_topbar'); ?>

<!-- http://ie.infotech.monash.edu/team107/team107-app/app//webroot/img/empty.svg -->
<!-- Hero Section Begin, map place holder -->
<section class="hero-section home-page set-bg" data-setbg="">
    <!-- <section class="hero-section home-page set-bg" data-setbg="/img/ie/toppage.jpg"> -->
</section>
<!-- Hero Section End -->

<style>
    .inline_field{
        display: inline-block;
    }

    .hero-section {
        height: 190px;
        position: relative;
        z-index: 1;
        opacity: 0.7;
    }

    .hero-section:after {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: #f9bd39;
        content: "";
        z-index: -1;
    }

    p{
        word-break: break-all;
    }

    header {
        background-color: #D33C44;
        font-size: 30px;
        height: 100px;
        line-height: 64px;
        padding: 16px 0;
        box-shadow: 0 1px rgba(0, 0, 0, 0.24);
    }

    .spt-40 {
        padding-top: 10px;
    }

    @media (min-width: 320px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:200px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 420px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:250px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 640px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:350px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 768px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:450px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 990px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:550px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 1024px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:700px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    @media (min-width: 1200px){
        .ling_img{
            display: block !important;
            max-width:100% !important;
            max-height:700px; !important;
            width: auto !important;
            height: auto !important;
        }
    }

    .display_redo p{
        color:black !important;
    }

    .display_redo strong{
        font-weight:900;
    }

    .display_redo h4{
        font-size:1.5em;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
        font-weight:bold;
    }

</style>

<?php

$country = $property->country;
$state = $property->state;
$suburb = $property->suburb;
$street = $property->street;
$postcode = $property->postcode;

$br_num = $property->number_of_bedroom;
$ba_num = $property->number_of_bathroom;
$t_num = $property->number_of_toilet;
$info = $property->general_information;
$st_location = $street.", ".$suburb.", ".$state." ".$postcode;
$location = $st_location.", ".$country;
$features = $property->features;

$id = $room->id;
$r_t = $room->room_type;
if ($r_t == 0){
    $r_t = 'Private';
    if ($room->room_type_desc != null){
        $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
    }
}else{
    $r_t = 'Sharing';
    if ($room->room_type_desc != null){
        $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
    }
}
$items = $room->items;
// debug($room);
$general_info = $room->room_general_information;
$images = $room->properties_images;
/*debug($r_t);
debug($items);
debug($general_info);
debug($images);*/

$room_capacity=0;
foreach ($room_beds as $rb){
    $room_capacity += $rb->capacity;
}

?>

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
                $this_res[0] = $currentDate->addDays(1);
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
                   // $avaArray[$k][0]->addDays(-1);
                    $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                    //$avaArray[$k][1]->addDays(-1);
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
<?php
/*    function getCurrent(){
        $currentDate = \Cake\I18n\Time::now();
        $currentDate->setTimezone(new \DateTimeZone('Australia/Melbourne'));
        return $currentDate;
    }

    function FrozenToDate($FrozenDate){
        $Date = new \Cake\I18n\Time($FrozenDate);
        return $Date;
    }*/

/*
function getRentalRoomBeds($rental_room_beds, $rental){

        //  Return Rental_Room_Bed where RentalID = this Rental (Beds Occupied by this rental)

        $rentalRoomBeds = Array(); $i=0;
        foreach ($rental_room_beds as $rental_room_bed){
            if ($rental_room_bed->rental_id == $rental->id){
                $rentalRoomBeds[$i] = $rental_room_bed;
                $i += 1;
            }
        }
        return $rentalRoomBeds;
    }
*/

/*
    function getCapacityAndBeds($rentalRoomBeds, $room_beds){

         //  Return Capacity of this rental and the beds its occupied

        $res = array();
        $res[0] = 0;
        $res[1] = array();
        $i = 0;
        foreach ($rentalRoomBeds as $rentalRoomBed) {
            $this_bed = null;
            foreach ($room_beds as $room_bed){
                if ($room_bed->id == $rentalRoomBed->bed_room_id){
                    $this_bed = $room_bed;                                                                               // get the beds info for each bed occupied
                }
            }
            $res[0] += $this_bed->capacity;
            $res[1][$i] = $this_bed;
            $i += 1;
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
*/?>
<?php
/*
//debug($rentals);
    $matrix = array();
    $resArray = array();
    $avaArray = array();
    // init res array
    for ($i=0; $i<365; $i++){ $resArray[$i] = null; }

    if ($room->room_type == 0){                                                                                        // Private Room Ava
        $j = 1;
        $rrr = $rentals;
        $rentals = array();
        foreach ($rrr as $rental){
            array_push($rentals, $rental);
        }
        for ($i=0; $i<count($rentals); $i++){
            if ($i == 0 && $i == count($rentals)-1){
                //debug($i);
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
        $counter = 0;
        foreach ($rentals as $rental){                                                                                      //  Active Rentals
            $matrix[$counter] = array();
            for($i=0; $i<365; $i++){ $matrix[$counter][$i] = null; }                                                        // add rental column to matrix

            $start = FrozenToDate($rental->start_date);                                                                     // Rent Info
            $end = FrozenToDate($rental->end_date);
            $rentalRoomBeds = getRentalRoomBeds($rental_room_beds, $rental);

            if ($start <= $currentDate && $end >= $currentDate){                                                             // Start before CurrentDate
                $startIndex = 0;
                $endIndex = $currentDate->diffInDays($end);
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

                    for ($i=0; $i < $endIndex; $i++){
                        $matrix[$counter][$i][0] = $cap;
                        $matrix[$counter][$i][1] = $bedArray;
                    }
                    //debug($matrix);
                }
            }
            if ($start > $currentDate){                                                                                      // Start after currentDate
                $startIndex = $currentDate->diffInDays($start);
                $endIndex = $currentDate->diffInDays($end);
                $dur = $start->diffInDays($end);

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

                    for ($i=$startIndex; $i < $endIndex; $i++){
                        $matrix[$counter][$i][0] = $cap;
                        $matrix[$counter][$i][1] = $bedArray;
                    }
                }
            }
            $counter += 1;
        }

        foreach ($matrix as $row){                                                                                          // For each rental
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

        $currentDate = getCurrent();
        $lastCap = 0;
        $nullFlag = 1;
        $j = 0;
        $slotStart = $currentDate;
        $lastEnd = $currentDate;
        $k = 0;
        for ($i=0; $i<365; $i++){
            if ($resArray[$i] == null){
                if ($nullFlag == 1){
                    continue;
                }else{                                                                                                      // Changed to null from number
                    $slot_res = generateSlot($i, $j, $slotStart, $currentDate, $resArray);
                    // debug($slot_res);

                    $j = $i;                                                                                                        // update slot
                    $lastCap = $resArray[$i][0];
                    $slotStart = new \Cake\I18n\Time($slot_res[2]);
                    $slotStart->addDays(1);
                    $lastEnd = new \Cake\I18n\Time($slot_res[2]);

                    if ($slot_res[0] != 0){
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                        $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                        $avaArray[$k][2] = $resArray[$i-1][0];
                        $avaArray[$k][3] = $slot_res[3];
                        $k += 1;
                    }

                    $nullFlag = 1;
                }
            }
            else{
                if ($nullFlag == 1){                                                                                        // Changed to number from null
                    $slot_res = generateSlot($i, $j, $slotStart, $currentDate, $resArray);
                    // debug($slot_res);

                    $j = $i;                                                                                                // update slot
                    $lastCap = $resArray[$i][0];
                    $slotStart = new \Cake\I18n\Time($slot_res[2]);
                    $slotStart->addDays(1);
                    $lastEnd = new \Cake\I18n\Time($slot_res[2]);

                    if ($slot_res[0] != 0){
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                        $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                        $avaArray[$k][2] = $resArray[$i-1][0];
                        $avaArray[$k][3] = $slot_res[3];
                        $k += 1;
                    }

                    $nullFlag = 0;
                }
                if ($resArray[$i][0] != $lastCap){                                                                          // Changed to number from number                                                                      //
                    $slot_res = generateSlot($i, $j, $slotStart, $currentDate, $resArray);
                    // debug($slot_res);

                    $j = $i;
                    $lastCap = $resArray[$i][0];
                    $slotStart = new \Cake\I18n\Time($slot_res[2]);
                    $slotStart->addDays(1);
                    $lastEnd = new \Cake\I18n\Time($slot_res[2]);

                    if ($slot_res[0] != 0){
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                        $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                        $avaArray[$k][2] = $resArray[$i-1][0];
                        $avaArray[$k][3] = $slot_res[3];
                        $k += 1;
                    }

                    $nullFlag = 0;
                }else{
                    continue;
                }
            }
        }
    }
//debug($avaArray);
*/?>
<!-- end Availability -->

<?php
if ($property->property_status == 1){
    ?>
    <div class="single-property">
        <div class="container">
            <div class="row">
                <ul class="breadcrumb">
                    <li><?php echo $this->Html->link('Home', ['controller' => 'Properties', 'action' => 'index']); ?></li>
                    <li style="color: white">Room Details</li>
                </ul>
            </div>
        </div>
    </div>
    <br>
    <section class="property-details">
        <div class="container">
            <div class="row sp-40 spt-40">
                <p class="fa fa-frown-o" style="font-size:60px; text-align: center; color:red; "></p>
            </div>

            <div class="row sp-40 spt-40" style="padding-top:0; margin-top: 0;">
                <div class="inline_field">
                    <h5 class="inline_field">Sorry, the Room you are looking for is currently unavailable. For more information, please&nbsp;</h5>
                </div>

                <?php
                echo $this->HTML->Link(
                    '<h5 class="inline_field"><u style="color: #007BFF" class="inline_field">Contact us</u></h5>',
                    ['controller'=>'Faqs', 'action'=>'contactus'],
                    ['escape'=>false, 'class'=>'inline_field']
                );
                ?>

                <div class="inline_field">
                    <h5>&nbsp;or check the</h5>
                </div>
                <?php
                echo $this->HTML->Link(
                    '&nbsp;<h5 class="inline_field"><u style="color: #007BFF" class="inline_field">FAQs</u></h5>',
                    ['controller'=>'Faqs', 'action'=>'index'],
                    ['escape'=>false, 'class'=>'inline_field']
                );
                ?>
                <br>
                <br>
                <br>

            </div>
        </div>
    </section>
<?php
}else{

?>
<!-- Single Property Section Begin -->
<div class="single-property">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><?php echo $this->Html->link('Home', ['controller' => 'Properties', 'action' => 'index']); ?></li>
                <li><?php echo $this->Html->link('Property Details', ['controller' => 'Properties', 'action' => 'detail', $room->property_id]); ?></li>
                <li style="color: white">Room Details</li>
            </ul>
        </div>


        <!-- image -->
        <div class="row sp-40 spt-40" style="padding-bottom:20px;">
            <div class="col-lg-12" style="padding-bottom:0;">
                <div class="property-img owl-carousel">
                    <?php
                    $counter_1 = 0;
                    foreach ($images as $pi){
                        $counter_1 = $counter_1 + 1;
                    }
                    if ($counter_1===0){
                        //$path = '/img/placeholder.jpg';
                        //$path = '/img/placeholder.jpg'; ?>
                        <div class="single-img" style="background-color: #f4f4f4;">
                            <?php echo $this->Html->image('placeholder.jpg', ['alt' => 'placeholder can\'t be displayed :((', 'class' => 'ling_img']); ?>
                        </div>
                    <?php }else{
                        foreach ($images as $p){
                            //$path = 'img/'.$p->photo_name;
                            $path = "property/".$p->property_id."/room/".$p->room_id."/".$p->photo_name;
                            // debug($p);
                            ?>
                            <div class="single-img">
                                <?php echo $this->Html->image($path, ['alt' => 'The image is gone :(((', 'class' => 'ling_img']); ?>
                            </div>
                            <?php
                        }
                    }?>

                </div>
            </div>
        </div>
    </div>
</div>

<section class="property-details">
    <div class="container">
        <!-- after image header -->
            <div class="inline_field">
                <h2><?php echo $room->room_name; ?></h2>
            </div>
            <div class="inline_field">
                <p>&nbsp&nbspfrom&nbsp&nbsp</p>
            </div>
            <div class="inline_field">
                <h6><?php echo $location; ?></h6>
            </div>
        <!-- after image header ends -->

        <!-- room details -->
        <div class="row sp-40 spt-40">
            <div class="col-lg-8">
                <div class="p-ins">
                    <div class="row details-top">
                        <div class="col-lg-12" style="padding-bottom:0;">
                            <div class="progress-info">
                                <div class="inline_field">Room Type:</div>&nbsp&nbsp<div class="inline_field"><h4><?php echo $r_t; ?></h4></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Description begins -->
                            <div class="property-description">
                                <br>
                                <h4>Room Total Capacity and Beds</h4>
                                <div>
                                    <p class="inline_field">Room Total Capacity:&nbsp;</p>
                                    <div class="inline_field"> <?php echo $room_capacity.'&nbsp;ppl';?></div>
                                </div>
                                <div>
                                    <p class="inline_field">Beds in the Room:&nbsp;</p>
                                    <?php
                                    /*function getBedName($beds, $id){
                                        foreach ($beds as $bed){
                                            if ($bed->id == $id){
                                                return $bed->bed_name;
                                            }
                                        }
                                        return '-';
                                    }*/
                                    $c = 0;
                                    foreach ($room_beds as $rb){
                                        if ($c != count($room_beds)-1){
                                            $bn = getBedName($beds, $rb->bed_id);
                                            ?>
                                            <div class="inline_field"> <?php echo $bn.",";?></div>
                                        <?php   }else{
                                            $bn = getBedName($beds, $rb->bed_id);
                                            ?>
                                            <div class="inline_field"> <?php echo $bn;?></div>
                                            <?php

                                        }$c+=1;
                                       ?>

                                    <?php
                                    }
                                    ?>

                                </div>
                                <br>
                                <br>
                                <h4>Room Availability</h4>
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
                                                        echo "<p>The room currently has no Available time slot for application.</p>";
                                                    }
                                                    else{
                                                        $s = new \Cake\I18n\Time(end($avaArray)[0]);
                                                        $s =  $this->Time->format($s,'dd/MM/Y');
                                                        echo "<div>
                                                                    <p style='margin-left:10px;' class='inline_field'>- Available from&nbsp;</p>
                                                                    <div class='inline_field'>".$s."</div>
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
                                                                    <p style='margin-left:10px;' class='inline_field'>- Available from&nbsp;</p>
                                                                    <div class='inline_field'>".$s."&nbsp;~&nbsp;".$e."</div>
                                                              </div>";
                                            }
                                            elseif (end($avaArray)[1] == null){
                                                if (end($avaArray)[0] > $afterAYear){
                                                    echo "<p>The room currently has no Available time slot for application.</p>";
                                                }
                                                else{
                                                    $s = new \Cake\I18n\Time(end($avaArray)[0]);
                                                    $s =  $this->Time->format($s,'dd/MM/Y');
                                                    echo "<div>
                                                                <p style='margin-left:10px;' class='inline_field'>- Available from&nbsp;</p>
                                                                <div class='inline_field'>".$s."</div>
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
                                                  <p style='margin-left:10px;' class='inline_field'>- From&nbsp;</p>
                                                  <div class='inline_field'>".$s."&nbsp;~&nbsp;".$e.",&nbsp;capacity of&nbsp;".($room_capacity-$ava[2])."&nbsp;ppl available</div>
                                              </div>";

                                        }
                                        $afterAYear = new \Cake\I18n\Time(end($avaArray)[1]);
                                        $afterAYear->addDays(365);
                                        if (end($avaArray)[1] < $afterAYear){
                                            $cap_num = 0;
                                            if (end($resArray)==null){
                                                $cap_num = $room_capacity;
                                            }else{
                                                $cap_num = ($room_capacity-end($avaArray)[2]);
                                            }
                                            $s = new \Cake\I18n\Time(end($avaArray)[1]);
                                            $s->addDays(1);
                                            $s =  $this->Time->format($s,'dd/MM/Y');
                                            echo "<div>
                                                  <p style='margin-left:10px;' class='inline_field'>- From&nbsp;</p>
                                                  <div class='inline_field'>".$s.",&nbsp;capacity of&nbsp;".$cap_num."&nbsp;ppl available</div>
                                              </div>";
                                        }
                                    }
                                }
                                ?>
                                <br>
                                <br>
                                <h4>Description</h4>
                                <div class="display_redo">
                                <?php
                                if ($general_info == null || strlen($general_info) == 0){
                                    echo "<p style='white-space: pre-line'>This room has no recorded description.</p>";
                                }else{ ?>
                                    <p style="white-space: pre-line"><?php echo $general_info; ?></p>
                                <?php
                                }
                                ?>
                                </div>

                            </div>
                            <!-- Description ends -->
                            <br>

                            <!-- feature begins -->
                            <div class="property-features">
                                <h4>Furnishings In The Room</h4>
                                <div class="property-table">
                                    <table>
                                        <?php
                                        $items = $property->items;
                                        // debug($items);
                                        $flag = 0;
                                        $counter = 1;
                                        $reminder = 0; ?>
                                        <tr>
                                            <?php
                                            // items
                                            $items = $room->items;
                                            foreach ($items as $item){
                                            if ($counter%2 != 0){
                                                $flag = 1;?>
                                                <!-- <td><img src="/img/tem/check.png" alt=""><?php //echo $f->name;?></td> -->
                                                <td><?php echo $this->Html->image('tem/check.png', ['alt' => ' ']); ?>
                                                    <!--<img src="/img/tem/check.png" alt="">--><?php echo "with ".$item->_joinData->quantity." ".$item->name;?></td>
                                            <?php }else{ ?>
                                            <!-- <td><img src="/img/tem/check.png" alt=""><?php // echo $f->name;?></td> -->
                                            <td><?php echo $this->Html->image('tem/check.png', ['alt' => ' ']); ?><?php echo "with ".$item->_joinData->quantity." ".$item->name;?></td>
                                            <!--<td><img src="/img/tem/check.png" alt=""></td>-->
                                        </tr>
                                        <tr>
                                            <?php  }
                                            $counter = $counter + 1;
                                            }
                                            ?></tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td>
                                                <?php if ($flag == 0){
                                                echo "<p>This room currently has no furnishing information available</p>";
                                                } ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- feature ends -->


                            <!--Sleeping arrangements-->
                            <div class="property-features">
                                <h4>Other Sleeping Arrangements in this Property</h4>

                            <?php
                            $num_of_room_left = 0;
                            $rooms = $property->rooms;
                            foreach ($rooms as $room){
                                if ($room->id != $id){
                                    $num_of_room_left += 1;
                                }
                            }
                            ?>
                            <?php if ($num_of_room_left == 0){
                                echo "<br><p style=\"white-space: pre-line\">There's no other sleeping arrangements in this Property.</p>";
                            }else{
                            ?>
                            <div class="row">
                                <?php
                                // debug($property);

                                $counter = 1;
                                $images = $property->properties_images;
                                $num_of_room_left = 0;
                                foreach ($rooms as $room){
                                    // image
                                    if ($room->id != $id) {
                                        $num_of_room_left += 1;
                                        $my_image = null;
                                        $path = '';
                                        foreach ($images as $image) {
                                            if ($image->room_id == $room->id) {
                                                $my_image = $image;
                                                // debug($my_image);
                                                break;
                                            }
                                        }
                                        if ($my_image == null) {
                                            $path = '../../webroot/img/placeholder.jpg';
                                        } else {
                                            $path = "../../webroot/img/property/".$room->property_id."/room/".$room->id."/".$my_image->photo_name;
                                            // debug($path);
                                        }

                                        // room type
                                        $r_t = $room->room_type;
                                        ?>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="room-items">

                                                <a href=<?php echo $room->id; ?>>
                                                    <div class="room-img set-bg" data-setbg=<?php echo $path; ?>></div>
                                                </a>

                                                <div class="room-text">
                                                    <div class="room-details">
                                                        <div class="room-title">
                                                            <a href="<?php echo $room->id; ?>">
                                                                <h5 style="text-decoration: underline;"><?php echo $room->room_name; ?></h5>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $r_t = $room->room_type;
                                                    if ($r_t == 0){
                                                        $r_t = 'Private';
                                                        if ($room->room_type_desc != null){
                                                            $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
                                                        }
                                                    }else{
                                                        $r_t = 'Sharing';
                                                        if ($room->room_type_desc != null){
                                                            $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    $room_capacity = 0;
                                                    //debug($all_room_beds);
                                                    foreach ($all_room_beds as $rb){
                                                        if ($rb->room_id == $room->id){
                                                            $room_capacity += $rb->capacity;
                                                            //debug($room_capacity);
                                                        }
                                                    }
                                                    ?>
                                                    <div class="room-info">
                                                        <div><p class="inline_field" style="padding-bottom: 0; margin-bottom: 0;">Room Type: &nbsp;</p><?php echo "<h7 class='inline_field'><b>".$r_t."</b></h7>";?>&nbsp;&nbsp;<p class="inline_field">|</p>&nbsp;
                                                            <p class="inline_field" style="padding-bottom: 0; margin-bottom: 0;">Room Capacity: &nbsp;</p> <?php echo "<h7 class='inline_field'><b>".$room_capacity."</b></h7>"; ?></div>
                                                    </div>

                                                </div>
                                                <div class="room-items" style="margin-bottom: 0;">
                                                    <div class="room-text">
                                                    <?php
                                                    if ($room->rental_end_date != null){
                                                        $e_d = $room->rental_end_date;
                                                        $e_d = $e_d->i18nFormat('dd-MM-yyyy');
                                                        echo "<p class='inline_field' style='margin-bottom: 0;'>Available after:  &nbsp;</p>"."<h7 class='inline_field' style='margin-bottom: 0;'><b>".$e_d."</b></h7><br>";
                                                    }else{
                                                        echo "<h7 class='inline_field'><b>Available now!</b></h7>";
                                                    }
                                                    ?>
                                                    </div>
                                                </div>
                                                <div class="room-text">
                                                <?php
                                                echo $this->Html->link(
                                                    'Enquire Now!',
                                                    ['controller' => 'applications', 'action' => 'frontadd', $room->id],
                                                    ['class' => '',  'style' => 'font-size:100%;']
                                                );
                                                ?>
                                                </div>

                                            </div>
                                        </div>

                                        <!--<div class="col-lg-3 col-md-3">
                                    <div class="room-items">

                                        <a href=<?php /*echo ''; */
                                        ?>>
                                            <div class="room-img set-bg" data-setbg=<?php /*echo $path; */
                                        ?>></div>
                                        </a>

                                        <div class="room-text">
                                            <div class="room-details">
                                                <div class="room-title">
                                                    <h5>abc</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                        <?php
                                        $counter += 1;

                                        if(strlen($path)==0){
                                            $path = 'img/placeholder.jpg';
                                        }
                                    }
                                } ?>
                            </div>

                            <?php } ?>

                            </div>

                            <!-- end Sleeping arrangements-->

                        </div>
                    </div>



                </div>
            </div>
            <!-- MOTHER PROPERTY INFO -->
            <div class="col-lg-4">
                <!-- enquirey -->
                <div style="padding-bottom:0;" class="row pb-30">
                    <div class="col-lg-12" style="padding-bottom:20px;">
                        <div class="contact-service">
                            <div class="inline_field">
                                <div class="col-lg-12" style="padding-bottom:0;">
                                    <h5 style="font-weight:700;">Enquiry, Now!</h5>
                                    <div class="col-lg-12" style="padding-bottom:0;">
                                        <?php
                                        echo $this->Html->link(
                                            'Send Expression of Interest',
                                            ['controller' => 'applications', 'action' => 'frontadd', $id],
                                            ['class' => '',  'style' => 'font-size:120%;']
                                        );
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12" style="padding-bottom:0;">
                                <?php
                                echo $this->Html->link(
                                    'Having doubts? Go to FAQ',
                                    ['controller' => 'Faqs', 'action' => 'index'],
                                    ['class' => '', 'style' => 'font-size:80%;']
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- property features -->
                <div class="row pb-30" style="padding-bottom:20px;">
                    <div class="col-lg-12" style="padding-bottom:0;">
                        <div class="contact-service"  style="padding-bottom:1px;">
                            <h5>Property Features</h5>
                            <table>
                                <tr>

                                    <td style="text-align:center;">
                                        Bed <span><?php echo $br_num; ?></span>&nbsp&nbsp
                                        Bath <span><?php echo $ba_num; ?></span>&nbsp&nbsp
                                        Toilet <span><?php echo $t_num; ?></span>
                                    </td>
                                </tr>
                                <?php
                                foreach ($features as $f){
                                    ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $this->Html->image('tem/check.png', ['alt' => ' ']); ?>
                                            <?php echo $f->name;?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td style='text-align:center'>
                                        <?php
                                        echo $this->Html->link(
                                            'Back to Property',
                                            ['controller' => 'Properties', 'action' => 'detail', $property->id],
                                            ['style' => 'text-align:center',
                                                'class' => '']
                                        )
                                        ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- property items -->
                <div class="row pb-30" style="padding-bottom:0;">
                    <div class="col-lg-12">
                        <div class="contact-service" style="padding-bottom:1px;">
                            <h5>Property Furnishings</h5>
                            <table>
                                <?php
                                foreach ($property->items as $item){
                                    ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $this->Html->image('tem/check.png', ['alt' => ' ']); ?>
                                            <?php echo $item->_joinData->quantity." ".$item->name;?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td style='text-align:center'>
                                        <?php
                                        echo $this->Html->link(
                                            'Back to Property',
                                            ['controller' => 'Properties', 'action' => 'detail', $property->id],
                                            ['style' => 'text-align:center',
                                                'class' => '']
                                        )
                                        ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Single Property End -->

<?php
}
?>
<!-- front-end footer element -->
<?php echo $this->element('front_footer'); ?>
</body>




