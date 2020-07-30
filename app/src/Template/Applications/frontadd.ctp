<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
?>

<head>
    <?php $this->assign('title','Application | NAIM');
    echo $this->Html->css('navbar.css');
    echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
    ?>
    <title>Submit Application | Metrorooms</title>

</head>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<section id = "myHead">
    <?= $this->Html->css('my_front') ?>
    <?php echo $this->element('front_topbar'); ?>
</section>
<section  class="hero-section home-page set-bg" data-setbg="">
    <!-- <section class="hero-section home-page set-bg" data-setbg="/img/ie/toppage.jpg"> -->
</section>

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

    header {
        background-color: #D33C44;
        font-size: 30px;
        height: 100px;
        line-height: 64px;
        padding: 16px 0;
        box-shadow: 0 1px rgba(0, 0, 0, 0.24);
    }

    .required label:after {
        color: #e32;
        content: ' *';
        display:inline;
    }

    #mybutton{
        padding-left:10px
    }
    .contact-form .site-btn.c-btn, .contact-info .site-btn.c-btn {
        border: none;
        background: #8AD144;
        color: #fff;
        position: inherit;
        /* top: -5px; */
    }

    .sticky {
        position: fixed;
        top: 50px;
    }

    .sticky + .content {
        padding-top: 102px;
    }

    .col-lg-6{
        padding-bottom:0;
    }

</style>

<?php
if ($property->property_status == 1){
    ?>
    <div class="single-property">
        <div class="container">
            <div class="row">
                <ul class="breadcrumb">
                    <li><?php echo $this->Html->link('Home', ['controller' => 'Properties', 'action' => 'index']); ?></li>
                    <li style="color: white">Application</li>
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
                    <h5 class="inline_field">Sorry, the Room currently unavailable for applications. For more information, please&nbsp;</h5>
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
<!-- information begin -->
<?php
$rid = $room->id;
$pid = $property->id;
$red = $room->rental_end_date;

if ($red == null){
    $red = \Cake\I18n\Time::now();
}

$r_name = $room->room_name;
$cap = $room->room_capacity;
$addr = $property->street.', '.$property->suburb.', '.$property->state.' '.$property->postcode;


$room_capacity=0;
foreach ($room_beds as $rb){
    $room_capacity += $rb->capacity;
}

?>

<input type="hidden" value="<?php echo $room_capacity; ?>" id="total_cap">
<!-- informaiton end -->


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

    $beginningOfArrayFlag = 1;
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
                    if ($beginningOfArrayFlag == 1){
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                        $beginningOfArrayFlag = 0;
                    }else{
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                   //     $avaArray[$k][0]->addDays(-1);
                    }
                    $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                 //   $avaArray[$k][1]->addDays(-1);
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
                // debug($slot_res);

                $j = $i;                                                                                                // update slot
                $lastCap = $resArray[$i][0];
                $slotStart = new \Cake\I18n\Time($slot_res[2]);
                $slotStart->addDays(1);
                $lastEnd = new \Cake\I18n\Time($slot_res[2]);

                if ($slot_res[0] != 0){
                    if ($beginningOfArrayFlag == 1){
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                        $beginningOfArrayFlag = 0;
                    }else{
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                   //     $avaArray[$k][0]->addDays(-1);
                    }
                    $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                 //   $avaArray[$k][1]->addDays(-1);
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
                    if ($beginningOfArrayFlag == 1){
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                        $beginningOfArrayFlag = 0;
                    }else{
                        $avaArray[$k][0] = new \Cake\I18n\Time($slot_res[1]);
                       // $avaArray[$k][0]->addDays(-1);
                    }
                    $avaArray[$k][1] = new \Cake\I18n\Time($slot_res[2]);
                   // $avaArray[$k][1]->addDays(-1);
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
//debug($resArray);
?>
<!-- end Availability -->


<!-- Page Content Begin -->
<body>
<section class="contact-section">
    <div class="container">
        <div class="row">

            <div class="col-lg-8">
                <?= $this->Form->create($application) ?>
                <div class="contact-form">
                    <h3>Express of Interest Form</h3><br>
                    <div>
                        <?php
                        echo $this->Html->link(
                            'Back to this Room\'s Information',
                            ['controller' => 'Rooms', 'action' => 'detail', $rid],
                            ['confirm' =>  'Are you sure to leave this page?\nYour application will NOT be submitted',
                                    'style' => 'text-align:center',
                                'class' => 'btn btn-primary']
                        )
                        ?>
                    </div>
                    <input type="hidden" id="step_counter" value="step1">

                    <div class="tab-wrap">
                        <?php
                        $this->Form->unlockField('tabGroup1');
                        ?>
                        <input type="radio" id="tab1" name="tabGroup1" class="tab" onkeydown='return false;' onclick="validateContinue();" checked disabled>
                        <label id='tab1Label' for="tab1" style="cursor:default;">Step 1</label>
                        <input type="radio" id="tab2" name="tabGroup1" class="tab"  onclick='return false;' onkeydown='return false;'>
                        <label id='tab2Label' for="tab2" style="cursor:default;">Step 2</label>
                        <input type="radio" id="tab3" name="tabGroup1" class="tab" onclick='return false;' onkeydown='return false;'>
                        <label for="tab3" style="cursor:default;">Step 3</label>

                        <!-- step 1 -->
                        <div class="tab__content">
                            <div id="step1">
                                <br>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <?php
                                            $currentDate = \Cake\I18n\Time::now();
                                            $DaysToRentEnd = $currentDate->diffInDays($red); ?>
                                            <input id ="DaysToRentEnd" type="hidden" value=<?php echo $DaysToRentEnd+10; ?>>
                                            <input id="room_type" type="hidden" value="<?php echo $room->room_type; ?>">

                                            <?php
                                            echo
                                            $this->Form->control('start_date', [
                                                    'class' => 'step1',
                                                'label' => 'Expected Rental Starting Date',
                                                'type' => 'text',
                                                'placeholder' => 'Select a Date',
                                                'id' => 'datepicker',
                                                'readonly'=> 'readonly',
                                                'data-validation'=>"required"]);

                                            ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <?php
                                            echo $this->Form->control('duration',
                                                [
                                                    'class' => 'step1',
                                                    'label' => 'Number of Months staying',
                                                    'value' => 3,
                                                    'min' => 3,
                                                    'type' => 'number',
                                                    'required' => '',
                                                    'data-validation' => 'number required',
                                                    'data-validation-allowing'=>'range[3;12]',
                                                    'data-validation-error-msg'=>"The duration is out of range.\nIt ranges from 3 to 12 months"
                                                ]);
                                            // ],
                                            //

                                            ?>
                                            <input type="hidden" value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6" id="cap">
                                            <?php
                                            $cap=0;
                                            foreach ($room_beds as $rb){
                                                $cap += $rb->capacity;
                                            }

                                            $my_list = array();
                                            for ($i=0; $i<$cap; $i++){
                                                $my_list[$i+1] = $i+1;
                                            }

                                            echo $this->Form->control(
                                                'num_ppl',
                                                ['class' => 'step1',
                                                    'label' => 'Number of People staying',
                                                    'default' => 1,
                                                    'type'  => 'select',
                                                    'options' => $my_list
                                                ]); ?>
                                            <br>
                                        </div>
                                    </div>

                                    <!-- error msg -->
                                    <div style="padding-top:10px; display:none;" id="step1ErrorMsg">
                                        <div style="background-color: #fddfdf; border-radius: 7px; ">
                                            <div style="padding:10px;padding-bottom: 0;">
                                                <p class="inline_field fa fa-close" style="color:red;"></p><span class="inline_field" style="color:red;">&nbsp;Something wrong with the above information.</span><br>
                                                <span>The Room is not Available for the Time and Number of People given. Please check the room availability on the right side for reference. Then click Next again to validate. </span><br><br>
                                                <span>For mobile user or users with a narrowed view, please go to the end of the page for room availability reference.</span>
                                                <span>Note that we are not accepting application with rentals start after one year or more from the current date.</span>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- end error msg-->

                                    <div id="mybutton" class="pull-right">
                                        <?php
                                        echo $this->Form->button('Next',
                                            ['type'=>'button',
                                                    'id' => 'step1Next',
                                                'class' => 'site-btn c-btn float-right pull-right', 'onclick'=>'step1Validate();', 'disabled'=>'true']); //?>
                                    </div>

                                    <!--<script>
                                        $( function() {
                                            var isValid = true;
                                            $('.step1').each(function() {
                                                if ( $(this).val() === '' )
                                                    isValid = false;
                                            });
                                            if (isValid == false){
                                                var step1next = document.getElementById('step1Next');
                                                step1next.setAttribute('disabled', true);
                                            }
                                        } );
                                    </script>-->
                                </fieldset>
                            </div>
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
                            <script>
                                function getDaysInBetween(currentDate, anotherDate){
                                    // To calculate the time difference of two dates
                                    var Difference_In_Time = anotherDate.getTime() - currentDate.getTime();
                                    // To calculate the no. of days between two dates
                                    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                                    //console.log(Math.floor(Difference_In_Days));
                                    return Math.floor(Difference_In_Days);
                                }

                                function step1Validate(){
                                    var step1next = document.getElementById('step1Next');
                                    if (step1next.disabled) { // or this.disabled
                                        return false;
                                    }else{
                                        // validation
                                        /*
                                        1. for private room, check if start and end in non-ava time
                                         */
                                        var room_type = document.getElementById('room_type').value;
                                        if (room_type == 0){                                                    // private room check
                                            var prepare = document.getElementById('datepicker').value;
                                            prepare = prepare.split("/");
                                            var startDateString = prepare[1]+'/'+prepare[0]+'/'+prepare[2];
                                            var duration = document.getElementById('duration').value;
                                            var s = new Date(startDateString);
                                            var e = new Date(startDateString);
                                            var currentDate = new Date();
                                            for (var j=0; j<duration; j++){
                                                e = e.addMonths(1);
                                            }
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
                                                var step1errormsg = document.getElementById('step1ErrorMsg');
                                                step1errormsg.setAttribute('style', 'padding-top:10px;');
                                                return false;
                                            }
                                            else{
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
                                                $('#step3_duration').prop('value', $('#duration').val());

                                            }

                                        }
                                        else{
                                            // shared room check
                                            var cap = document.getElementById('num-ppl').value;
                                            var totalCap = document.getElementById('total_cap').value;
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
                                            ss.setHours(0);                                                      // set time to 0 for compare
                                            ss.setMinutes(0);
                                            ss.setSeconds(0);
                                            ss.setMilliseconds(0);
                                            se.setHours(0);
                                            se.setMinutes(0);
                                            se.setSeconds(0);
                                            se.setMilliseconds(0);


                                            // check against resArray
                                            var resArray = <?php echo json_encode($resArray); ?>;
                                            var startIndex = getDaysInBetween(scurrentDate, ss);
                                            var endIndex = getDaysInBetween(scurrentDate, se);
                                            //console.log(resArray[startIndex]);

                                            var thisFlag = 1;
                                            for (var a = startIndex; a <= endIndex; a++){
                                                //console.log(a);
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

                                            if (thisFlag == 0){
                                                var sstep1errormsg = document.getElementById('step1ErrorMsg');
                                                sstep1errormsg.setAttribute('style', 'padding-top:10px;');
                                                return false;
                                            }else{
                                                var sstep1ppl = document.getElementById('num-ppl').value;
                                                var sppl = document.getElementById('number-of-people');
                                                sppl.setAttribute('value', sstep1ppl);
                                                $('select option[value="'+sstep1ppl+'"]').attr("selected",true);
                                                updateForm();
                                                var sstep3startdate = document.getElementById('start-date');
                                                var sstep1startdate = document.getElementById('datepicker').value;
                                                sstep3startdate.setAttribute('value', sstep1startdate);

                                                // generate beds to display
                                                var allBeds = <?php echo json_encode($room_beds); ?>;
                                                //console.log(allBeds);
                                                var tohide = [];

                                                console.log(allBeds);


                                                for (var b = startIndex; b <= endIndex; b++){
                                                    //console.log(resArray[b]);
                                                    if (resArray[b] != null){
                                                        for (var p=0; p < resArray[b][1].length; p++){
                                                            //console.log(resArray[b][1][p].id);
                                                            var ft = tohide.includes(resArray[b][1][p].id);
                                                            //console.log(ft);
                                                            if (ft != true){
                                                                tohide.push(resArray[b][1][p].id);
                                                            }
                                                        }
                                                    }

                                                    /*var tmp = sharedAvaBeds[b][0];
                                                    for (var c = 0; c < tmp.length; c++){
                                                        var usedBedId = sharedAvaBeds[b][0][0];
                                                        var idString = "sharedRoomBedCheck"+usedBedId;
                                                        var this_bed = document.getElementById(idString);
                                                        this_bed.setAttribute('style', '');
                                                    }*/
                                                }

                                                // end generate beds to display
                                                for (var n=0; n < tohide.length; n++){

                                                    var idString = "sharedRoomBedCheck"+tohide[n];
                                                    var this_bed = document.getElementById(idString);
                                                    this_bed.setAttribute('disable', 'true');                           // disable those not to display to prevent upload

                                                    this_bed.setAttribute('style', 'display:none;');
                                                    //console.log(idString);
                                                }

                                                //var step2numppl = document.getElementById('step2num-ppl');
                                                $('#step2num-ppl').text(sstep1ppl);
                                                //step2numppl.setAttribute('text', sstep1ppl);

                                                $('#step2Next').prop('disabled', true);
                                                $('#tab1').prop('checked', false);
                                                $('#tab2').prop('checked', true);
                                                var stab1Label = document.getElementById('tab1Label');
                                                var sstep1errormsg1 = document.getElementById('step1ErrorMsg');
                                                sstep1errormsg1.setAttribute('style', 'padding-top:10px; display:none;');
                                                stab1Label.setAttribute('style', 'background:#d2f8d2;');
                                                $('#step_counter').prop('value', 'step2');
                                                $('#step3_duration').prop('value', $('#duration').val());
                                            }
                                        }
                                    }
                                }
                            </script>
                            <script>
                                $(function(){
                                    $( ".step1" ).change(function() {
                                        var startValid = 1;
                                        $('.step1').each(function() {
                                            if ( $(this).val() === '' )
                                                startValid = 0;
                                        });
                                        if (startValid == 1){
                                            // all fields entered, start validation
                                            //var step1next = document.getElementById('step1Next');
                                            $('#step1Next').prop('disabled', false);
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <!-- end step 1 -->

                        <!-- step 2 -->
                        <div class="tab__content">
                            <div id="step2"><br>
                                <h4 style="margin-bottom: 20px;">Choose the Beds</h4>
                                <?php
                                $this->Form->unlockField('beds_rooms._ids');
                                for ($i=0; $i<99; $i++){
                                    $this->Form->unlockField('beds_rooms._ids.'.$i.'');
                                }
                                ?>
                                <?php
                                if ($room->room_type==0){                                                               // Private Room Beds
                                    ?>
                                    <p>Note that if you're applying for a Private Room, please skip this step by click Next.</p><br>
                                    <?php
                                    // enable next
                                    ?>

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
                                            echo "<div>
                                                        <div class=\"inline_field\">".
                                                $this->Form->control('beds_rooms._ids.'.$id_array[$counter],
                                                    ['checked'=>'checked',
                                                        'style'=>'width:20px; height:20px;',
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
                                    <!-- prepare validation -->
                                    <div>
                                        <p class="inline_field">Your Number of People Staying: </p>
                                        <p class="inline_field" id="step2num-ppl"></p>
                                    </div>

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
                                    foreach ($avaBeds as $ab){
                                        echo "<div class='sharedRoomBedCheck' id='sharedRoomBedCheck".$id_array[$counter]."' style=''>
                                                        <div class=\"inline_field\">".
                                            $this->Form->control('beds_rooms._ids.'.$id_array[$counter],
                                                [
                                                    'class'=>'step2Validate',
                                                    'style'=>'width:20px; height:20px;',
                                                    'label'=> $name_array[$counter],
                                                    'type'=>'checkbox',
                                                    'value'=>$id_array[$counter]]).
                                            "</div></div>";
                                        ?>
                                        <?php
                                        ?>
                                        <?php
                                        $counter += 1;
                                    }
                                }
                                ?>
                            </div><br>

                            <!-- error msg -->
                            <div style="padding-top:10px; display:none;" id="step2ErrorMsg">
                                <div style="background-color: #fddfdf; border-radius: 7px; ">
                                    <div style="padding:10px;padding-bottom: 0;">
                                        <p class="inline_field fa fa-close" style="color:red;"></p><span class="inline_field" style="color:red;">&nbsp;Something wrong with the above information.</span><br>
                                        <span>The total capacity of the beds you selected must be bigger or equal to the number of people staying you gave in STEP 1. Please check the room availability on the right side for reference. Then click Next again to validate. </span><br><br>
                                        <span>For mobile user or users with a narrowed view, please go to the end of the page for room availability reference.</span>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <br>
                            <!-- end error msg-->

                            <div id="mybutton" class="pull-left">
                                <?php
                                echo $this->Form->button('Previous',
                                    ['type'=>'button',
                                            'class' => 'button site-btn c-btn float-right pull-right',
                                        'style' => 'background: grey;',
                                        'onclick'=>'step2to1();', 'disabled'=>'false']); ?>
                            </div>
                            <div id="mybutton" class="pull-right">
                                <?php
                                echo $this->Form->button('Next',
                                    ['type'=>'button',
                                            'class' => 'button site-btn c-btn float-right pull-right',
                                        'id'=>'step2Next',
                                        'onclick'=>'step2Validate();',
                                        'disabled'=>'true']); ?>
                            </div>
                            <script>
                                function step2to1(){
                                    // generate beds to display
                                    var allBeds = document.getElementsByClassName('sharedRoomBedCheck');
                                    //console.log(allBeds);
                                    //console.log(allBeds);
                                    //console.log(allBeds.length);
                                    for (var m=0; m < allBeds.length; m++){
                                            console.log(allBeds[m]);
                                            var this_bed = allBeds[m];
                                            this_bed.setAttribute('style', '');
                                    }
                                    var allBedChecks = document.getElementsByClassName('step2Validate');
                                    for (var o =0; o < allBedChecks.length; o++){
                                        allBedChecks[o].checked = false;
                                        allBedChecks[o].disabled = false;
                                    }

                                    var stap2Label = document.getElementById('tab2Label');
                                    var step2errormsg = document.getElementById('step2ErrorMsg');
                                    step2errormsg.setAttribute('style', 'padding-top:10px; display:none;');
                                    stap2Label.setAttribute('style', '');

                                    $('#tab2').prop('checked', false);
                                    $('#tab1').prop('checked', true);

                                    var tab1Label = document.getElementById('tab1Label');
                                    tab1Label.setAttribute('style', 'background:white;');
                                    $('#step_counter').prop('value', 'step1');
                                }
                            </script>
                            <script>
                                function step2Validate(){
                                    var room_type = document.getElementById('room_type').value;
                                    if (room_type==0){                                                                  // Private room: skip
                                        $('#tab2').prop('checked', false);
                                        $('#tab3').prop('checked', true);
                                        var tab1Label = document.getElementById('tab2Label');
                                        tab1Label.setAttribute('style', 'background:#d2f8d2;');
                                        $('#step_counter').prop('value', 'step3');
                                    }
                                    else{                                                                               // Shared Room Validate
                                        var step2ppl = document.getElementById('num-ppl').value;
                                        // get all checked checkboxes
                                        var checked = $('.step2Validate:checkbox:checked');

                                        var aux = <?php echo json_encode($room_beds); ?>;
                                        var checkedCap = 0;
                                        for (var c=0; c < checked.length; c++){
                                            for (var d=0; d<aux.length; d++){
                                                if (aux[d].id == checked[c].value){
                                                    checkedCap += aux[d].capacity;
                                                }
                                            }
                                        }

                                        if (checkedCap >=step2ppl){
                                            if (checkedCap > step2ppl){
                                                var con = confirm('The total bed capacity you selected is bigger than the number of people staying you gave, do you wish to continue.');
                                                if (con == false){
                                                    return false;
                                                }
                                            }
                                            $('#tab2').prop('checked', false);
                                            $('#tab3').prop('checked', true);
                                            var stab2Label = document.getElementById('tab2Label');
                                            var step2errormsg = document.getElementById('step2ErrorMsg');
                                            step2errormsg.setAttribute('style', 'padding-top:10px; display:none;');
                                            stab2Label.setAttribute('style', 'background:#d2f8d2;');
                                            $('#step_counter').prop('value', 'step3');
                                        }else{
                                            var step2msg = document.getElementById('step2ErrorMsg');
                                            step2msg.setAttribute('style', 'padding-top:10px;');
                                            return false;
                                        }
                                    }
                                }
                            </script>
                            <script>
                                $(function(){
                                    $(".step2Validate").change(function() {
                                        if ($('.step2Validate:checkbox:checked').length > 0 ){
                                            $('#step2Next').prop('disabled', false);
                                        }else{
                                            $('#step2Next').prop('disabled', true);
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <!-- end step 2 -->

                        <!-- step 3 -->
                        <div class="tab__content">
                            <br>
                            <!-- field unlock -->
                            <?php
                            $field_array = array();
                            for ($i=0; $i < 100; $i ++){
                                //$field_array[$i] = "applicants.".$i.".australian_citizen";
                                $this->Form->unlockField("applicants.".$i.".australian_citizen");
                            }
                            for ($i=0; $i < 100; $i ++){
                                //$field_array[$i] = "applicants.".$i.".first_name";
                                $this->Form->unlockField("applicants.".$i.".first_name");
                            }
                            for ($i=0; $i < 100; $i ++){
                                //$field_array[$i] = "applicants.".$i.".gender";
                                $this->Form->unlockField("applicants.".$i.".gender");
                            }
                            for ($i=0; $i < 100; $i ++){
                                //$field_array[$i] = "applicants.".$i.".last_name";
                                $this->Form->unlockField("applicants.".$i.".last_name");
                            }
                            for ($i=0; $i < 100; $i ++){
                                //$field_array[$i] = "applicants.".$i.".personal_contact_phone";
                                $this->Form->unlockField("applicants.".$i.".personal_contact_phone");
                            }
                            for ($i=0; $i < 100; $i ++){
                                //$field_array[$i] = "applicants.".$i.".preferred_name";
                                $this->Form->unlockField("applicants.".$i.".preferred_name");
                            }





                            for ($i=0; $i < count($field_array); $i++) {
                                $this->Form->unlockField($field_array[$i]);
                            }

                            /* $this->Form->unlockField('.1.');
                             $this->Form->unlockField('applicants.1.australian_citizen');

                             $this->Form->unlockField('Applicants');*/
                            ?>
                            <div id="step3">
                                <!-- <form id="myform">-->
                                    <fieldset>
                                        <div class="row" id="ref_child">
                                            <div class="col-lg-6" id="cap">
                                                <?php $my_list = array();
                                                for ($i=0; $i<$cap; $i++){
                                                    $my_list[$i+1] = $i+1;
                                                }
                                                echo $this->Form->control(
                                                    'number_of_people',
                                                    ['label' => 'Number of People staying',
                                                        'default' => 0,
                                                        'type'  => 'select',
                                                        'options' => $my_list,
                                                        'disabled'=>'disabled',
                                                        'required' => ''
                                                    ]); ?>
                                                <p>You can change this in Step 1</p>
                                            </div>
                                        </div>
                                        <div class="added">
                                            <div class="card border-warning">
                                                <h6 class="card-header">Details of Applicant 1</h6>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php
                                                            echo $this->Form->control(
                                                                'applicants.0.first_name',
                                                                ['label' => 'First Name',
                                                                    'type'  => 'text',
                                                                    'required' => 'required',
                                                                    'placeholder' => 'First Name'
                                                                ]); ?>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <?php   echo $this->Form->control(
                                                                'applicants.0.last_name',
                                                                ['label' => 'Last Name',
                                                                    'type'  => 'text',
                                                                    'required' => 'required',
                                                                    'placeholder' => 'Last Name'
                                                                ]); ?>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <?php   echo $this->Form->control(
                                                                'applicants.0.preferred_name',
                                                                ['label' => 'Preferred Name',
                                                                    'type'  => 'text',
                                                                    'placeholder' => 'Preferred Name'
                                                                ]); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php
                                                            $gender_list = array();
                                                            $gender_list[0] = 'Male';
                                                            $gender_list[1] = "Female";
                                                            $gender_list[2] = "Other";
                                                            echo $this->Form->control(
                                                                'applicants.0.gender',
                                                                ['label' => 'Gender',
                                                                    'required' => 'required',
                                                                    'default' => 0,
                                                                    'type'  => 'select',
                                                                    'options' => $gender_list
                                                                ]); ?>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <?php
                                                            $my_list = array();
                                                            $my_list[0] = 'Yes';
                                                            $my_list[1] = "No";
                                                            echo $this->Form->control(
                                                                'applicants.0.australian_citizen',
                                                                ['label' => 'Is Australian Citizen',
                                                                    'required' => 'required',
                                                                    'default' => 0,
                                                                    'type'  => 'select',
                                                                    'options' => $my_list
                                                                ]); ?>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <?php   echo $this->Form->control(
                                                                'applicants.0.personal_contact_phone',
                                                                ['label' => 'Personal Contact Phone',
                                                                    'type'  => 'text',
                                                                    'placeholder' => 'Personal Contact Phone'
                                                                ]); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <br>
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <?php
                                                echo $this->Form->control('contact_name',
                                                    ['label' => 'Main Contact Name',
                                                        'type' => 'text',
                                                        'placeholder'=>'Contact Name',
                                                        'data-validation'=>'custom',
                                                        'data-validation-regexp' => "^([A-Za-z ]+)$",
                                                        'data-validation-error-msg'=> "Please enter a valid name"
                                                    ]);
                                                ?>
                                            </div>
                                            <div  class="col-lg-6">
                                                <?php
                                                echo $this->Form->control('contact_email',
                                                    ['label' => 'Main Contact Email',
                                                        'type' => 'email',
                                                        'placeholder'=>'Email',
                                                        'id' => 'email',
                                                        'data-validation'=> 'email']);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <?php
                                                echo $this->Form->control('contact_number',
                                                    ['label' => 'Phone Number (Australian preferred)',
                                                        'type' => 'text',
                                                        'placeholder'=>'04',
                                                        "data-validation" => "custom",
                                                        "data-validation-regexp" => "^([0-9+ ]+)$",
                                                        "data-validation-error-msg" => "Please enter a valid Australian contact phone number."
                                                    ]);
                                                ?>
                                                <p>If you don't have an Australian phone number, please enter your country code before the phone number. Possible format: +86&nbsp;18844576263</p>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <?php
                                                $currentDate = \Cake\I18n\Time::now();
                                                $DaysToRentEnd = $currentDate->diffInDays($red); ?>
                                                <input id ="DaysToRentEnd" type="hidden" value=<?php echo $DaysToRentEnd+10; ?>>

                                                <?php

                                                echo
                                                $this->Form->control('start_date', [
                                                    'label' => 'Expected Rental Starting Date',
                                                    'type' => 'text',
                                                    //'placeholder' => 'Select a Date',
                                                    //'id' => 'datepicker',
                                                    'readonly'=> 'readonly',
                                                    'data-validation'=>"required"]);?>
                                                <p>Note that you can change this in Step 1</p>
                                                <?php

                                                echo
                                                $this->Form->control('end_date', [
                                                    'type' => 'hidden',
                                                    'value' => '11/12/2080']);

                                                echo  $this->Form->control('create_date', [
                                                    'type' => 'hidden',
                                                    'value' => '11/12/2080']);

                                                echo  $this->Form->control('application_status', [
                                                    'label' => 'Expected Rental Starting Date',
                                                    'type' => 'hidden',
                                                    'value' => 'p']);

                                                echo  $this->Form->control('room_id', [
                                                    'type' => 'hidden',
                                                    'value' => $rid]);

                                                echo  $this->Form->control('property_id', [
                                                    'type' => 'hidden',
                                                    'value' => $pid]);

                                                ?>
                                            </div>
                                            <div class="col-lg-6">

                                            <?php
                                                echo $this->Form->control('step3_duration',
                                                    [
                                                        'label' => 'Number of Months staying',
                                                        'default' => 3,
                                                        'min' => 3,
                                                        'type' => 'number',
                                                        'id' => 'step3_duration',
                                                        'data-validation' => 'number',
                                                        'data-validation-allowing'=>'range[3;12]',
                                                        'data-validation-error-msg'=>"The duration is out of range.\nIt ranges from 3 to 12 months",
                                                        'disabled'=>'disabled'
                                                    ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <?php
                                                echo $this->Form->control('additional_comment', ['label' => 'Additional Comment', 'type' => 'textarea', 'placeholder'=>'Leave your comments here']);
                                                ?>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5>Terms and Conditions</h5>
                                                <?php
                                                if ($frontcontent->terms_conditions == null || $frontcontent->terms_conditions == ""){
                                                    echo "<p>The expression of interest submitted by 
    the applicant is non-binding. The owner reserves all rights to revoke the expression of interest for 
    any reason. Please note that a response may take anywhere between 5 to 10 working days.</p>";
                                                }else{
                                                    echo "<p>".$frontcontent->terms_conditions."</p>";
                                                }

                                                ?>



                                                <div class="inline_field">
                                                    <input type="checkbox" data-validation="required" style="width:20px; height:20px;"
                                                           data-validation-error-msg=" You have to agree to our terms">
                                                </div>
                                                <div class="inline_field">
                                                    <p>I agree to the terms and conditions</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="lastStep" class="pull-left" style="padding-right:10px;">
                                            <?php
                                            echo $this->Html->link('Previous',
                                                '#back',
                                                ['class' => 'button site-btn c-btn float-right pull-right', 'style' => 'background: grey;', 'onclick' => 'step3to2();']); ?>
                                        </div>

                                        <div id="mybutton" class="pull-right">
                                            <?php echo $this->Form->button('Submit',
                                                ['type' => 'submit',
                                                    'class' => 'site-btn c-btn pull-right',
                                                    'style' => '',
                                                    'value' => 'Validate',
                                                    'onclick' => 'return onSubmit();'
                                                ]); ?>
                                        </div>

                                    </fieldset>

                                <!--</form>-->


                            </div>


                            <script>
                                function step3to2(){
                                    $('#tab3').prop('checked', false);
                                    $('#tab2').prop('checked', true);
                                    var tab2Label = document.getElementById('tab2Label');
                                    tab2Label.setAttribute('style', 'background:white;');
                                    $('#step_counter').prop('value', 'step2');
                                }
                            </script>
                        </div>
                        <!-- end step 3 -->
                    </div>



                </div>
                <?= $this->Form->end() ?>
            </div>



            <!-- help info section -->
            <div class="col-lg-4" id="helpInfo">
                <div class="contact-info" id="myCard">
                    <h5>The Room Enquired:</h5>
                    <br>
                    <ul class="contact-addr">
                        <li>
                            <?php
                            echo $this->Html->image('house.svg', [
                                'style' => 'max-width:7%;height:auto;padding-right:0;',
                            ])
                            ?>
                            <span style="margin-left:0;"> <?php echo " ".$addr; ?></span>
                        </li>
                        <li><?php echo "<span>".$property->number_of_bedroom." bedrooms, ".$property->number_of_bathroom." bathrooms, ".$property->number_of_toilet." toilets"."</span>"?></li>
                        <li>
                            <?php
                            echo $this->Html->image('bed.svg', [
                                'style' => 'max-width:5%;height:auto;padding-right:0;',
                            ])
                            ?>
                            <span style=margin-left:0;"><?php echo " ".$room->room_name; ?></span>
                        </li>
                        <?php
                        if ($room->room_type == 0){
                            $r_t = 'Private';
                            if ($room->room_type_desc != null || $room->room_type_desc != ''){
                                $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
                            }
                        }else{
                            $r_t = 'Sharing';
                            if ($room->room_type_desc != null || $room->room_type_desc != ''){
                                $r_t = $r_t."&nbsp;-&nbsp;".$room->room_type_desc;
                            }
                        }

                        ?>
                        <li>
                            <span><?php echo $r_t." room"; ?></span>
                            <!-- , capacity: ".$room->current_number_of_people_staying."/".$room->room_capacity -->
                        </li>
                        <li><?php
                            echo $this->Html->image('date.svg', [
                                'style' => 'max-width:7%;height:auto;padding-right:0;',
                            ])
                            ?>
                            <span style="margin-left:0;">Room Availability</span>
                        </li>
                            <!-- DISPLAY FULL ROOM AVAILABILIY, CHANGE WITH THE CHANGE OF CAP -->
                        <li>
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
                                                  <div class='inline_field'>".$s."&nbsp;~&nbsp;".$e."</div>
                                                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;capacity of&nbsp;".($room_capacity-$ava[2])."&nbsp;available</p>
                                              </div><hr>";
                                    }
                                    $afterAYear = new \Cake\I18n\Time(end($avaArray)[1]);
                                    $afterAYear->addDays(365);
                                    if (end($avaArray)[1] < $afterAYear){
                                        $cap_num = 0;
                                        //debug(end($resArray));
                                        if (end($resArray)==null){
                                            $cap_num = $room_capacity;
                                        }else{
                                            $cap_num = ($room_capacity-end($resArray)[0]);
                                        }
                                        $s = new \Cake\I18n\Time(end($avaArray)[1]);
                                        $s->addDays(1);
                                        $s =  $this->Time->format($s,'dd/MM/Y');
                                        echo "<div>
                                                  <p style='margin-left:10px;' class='inline_field'>- From&nbsp;</p>
                                                  <div class='inline_field'>".$s."</div>
                                                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;capacity of&nbsp;".$cap_num."&nbsp;available</p>
                                              </div><hr>";
                                    }
                                }
                            }
                            ?>
                        </li>
                        <li>
                            <div class="inline_field">
                                If you have any question or concern regarding the room or your staying time, please
                            </div>
                            <?php
                            echo $this->HTML->Link(
                                '<p class="inline_field"><u style="color: #007BFF" class="inline_field">Contact us</u></p>',
                                ['controller'=>'Faqs', 'action'=>'contactus'],
                                ['escape'=>false, 'class'=>'inline_field']
                            );
                            ?>
                            <div class="inline_field">
                                &nbsp;for more information or check the&nbsp;
                            </div>
                            <?php
                            echo $this->HTML->Link(
                                '<p class="inline_field"><u style="color: #007BFF" class="inline_field">FAQs</u></p>',
                                ['controller'=>'Faqs', 'action'=>'index'],
                                ['escape'=>false, 'class'=>'inline_field']
                            );
                            ?>
                        </li>
                    </ul>
                    <!--<div id="carddatepicker"></div>-->
                </div>
            </div>
            <!-- end help info section -->
        </div>
    </div>
</section>

</body>
<!-- Page Content End -->

<?php
}
?>

<!--Footer  -->
<?php echo $this->element('front_footer'); ?>


<script>
        function onSubmit(){
            let step3_input = $('step3_input');
           // for (let i=0; i<step3_input)
return true;
        }

</script>



<script>
    function updateForm(){
        var ele = document.getElementById('cap');
        var new_num = document.getElementById('number-of-people').value;
        var ref = document.getElementById('ref_child');


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
                " data-validation-regexp=\"^([A-Za-z ]+)$\"" +
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
                "data-validation-regexp=\"^([A-Za-z ]+)$\"" +
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
                "<label for=\"personal-contact-phone\">Personal Phone Number (Australian preferred)</label>" +
                "<input type=\"text\"   " +
                "name=\"applicants["+i.toString()+"][personal_contact_phone]\" " +
                "placeholder=\"04\" " +
                " "+
                "id=\"applicants-"+i.toString()+"-personal-contact-phone\" " +
                "data-validation-optional=\"true\" " +
                "data-validation=\"custom\" " +
                "data-validation-regexp=\"([0-9+ ]+)$\"" +
                "data-validation-length=\"10\"" +
                " data-validation-error-msg = \"Please enter a valid Australian phone number if you have one. Please leave it blank if you do not.\">" +
                "<p>If you don't have an Australian phone number, please enter your country code before the phone number. Possible format: +86 18844576263</p>";
            pc_div_div.appendChild(pc_div);
            row_3.appendChild(pc_div_div);

            /*
            'label' => 'Phone Number (Australian preferred)',
                                                        'type' => 'text',
                                                        'placeholder'=>'04',
                                                        "data-validation" => "custom",
                                                        "data-validation-regexp" => "^([0-9+ ]+)$",
                                                        "data-validation-error-msg" => "Please enter a valid Australian contact phone number."
                                                    ]);
                                                ?>

             */

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
            $.validate({});
        }
    }
</script>


<!-- script -->
<script>
    $(document).ready(function(){
        // my jquery methods
        $("#number-of-people").change(updateForm);
        window.onload = function() {
            updateForm();
        };

      /*  function updateForm(){
            var ele = document.getElementById('cap');
            var new_num = document.getElementById('number-of-people').value;
            var ref = document.getElementById('ref_child');


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
                                                                        " data-validation-regexp=\"^([A-Za-z ]+)$\"" +
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
                                                                        "data-validation-regexp=\"^([A-Za-z ]+)$\"" +
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
                $.validate({});
            }
        }*/
    });
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>


<!-- data validation -->
<script>
    $.validate({});
   /* $.validate({

        modules : 'toggleDisabled',
        disabledFormFilter : 'myform.toggle-disabled',
        showErrorDialogs : false
    });*/

 /*   $('#contact_email').on('input', function(){
       var dumb = 1;
    });*/

</script>
<!-- end data validation -->

<!-- sticky -->
<script>
    // When the user scrolls the page, execute myFunction
    window.onscroll = function() {myFunction()};

    // Get the header
    var header = document.getElementById("myCard");

    // Get the offset position of the navbar
    var head = document.getElementById("myHead");
    var sticky = head.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {

        var step = document.getElementById('step_counter').value;

        if (step == 'step3'){
            var windowWidth = $(window).width();

            if (windowWidth > 996) {
                if (window.pageYOffset > sticky) {
                    header.classList.add("sticky");
                } else {
                    header.classList.remove("sticky");
                }
            }
        }else{
            header.classList.remove("sticky");
        }
    }
</script>
<!-- sticky end -->

<script>
    $( function() {
        var DaysToRentEnd = document.getElementById('DaysToRentEnd').value;
        $( "#carddatepicker" ).datepicker({
            minDate: DaysToRentEnd,
        });
    } );
</script>

<script>
    $( function() {
        var DaysToRentEnd = document.getElementById('DaysToRentEnd').value;
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: 7,
            maxDate:365,
            showWeek: true,
            firstDay: 1,
            anim: 'blind',
            dateFormat: "dd/mm/yy"
        });
        // DaysToRentEnd

    } );
</script>



