<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;

use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;

class ExpireCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        // LOADING MODELS
        $this->Rentals = TableRegistry::get('Rentals');
        $this->Tenants = TableRegistry::get('Tenants');
        $this->Beds_rooms_rentals = TableRegistry::get('Beds_rooms_rentals');

        $this->Beds = TableRegistry::get('Beds');
        $this->Beds_rooms = TableRegistry::get('Beds_rooms');
        $this->Properties = TableRegistry::get('Properties');
        $this->Rooms = TableRegistry::get('Rooms');

        // RETRIEVE DATA
        $rentals = $this->Rentals->find()->where(['rental_status' => 1])->all();

        // START CODE
        $currentDate = $this->getCurrent();

        foreach ($rentals as $rental){
            $end_date = $rental->end_date;
            $end_date = $this->FrozenToDate($end_date);
            if ($end_date < $currentDate){
                // EXPIRE THE RENTAL
                $rental->rental_status = 0;
                $this->Rentals->save($rental);
            }
        }

        $this->bedOccupationCheck();

        $rooms = $this->Rooms->find()->where()->all();
        foreach ($rooms as $room){
            $this->updateearliest($room->id);
        }

       // $io->out('Hello world.');
    }

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

    function bedOccupationCheck(){
        $this->Rentals = TableRegistry::get('Rentals');
        $this->Beds_rooms_rentals = TableRegistry::get('Beds_rooms_rentals');
        $this->Beds_rooms = TableRegistry::get('Beds_rooms');

        $active_rentals = $this->Rentals->find()->where(['rental_status'=>1])->all();

        // CONSTRUCT AUX ARRAY
        $all_beds = $this->Beds_rooms->find()->all();
        $aux = array();
        foreach ($all_beds as $b){
            $aux[$b->id] = 0;
        }
        foreach ($active_rentals as $rental){
            $this_beds = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$rental->id])->all();
            foreach ($this_beds as $tb){
                $aux[$tb->bed_room_id] += 1;
            }
        }
       // debug($aux);
        foreach ($all_beds as $b){
            if ($aux[$b->id] != 0){
                $b->occupied = 1;
            }
            else{
                $b->occupied = 0;
            }
            $this->Beds_rooms->save($b);
        }
    }

    public function updateearliest($room_id){
        // EXECUTED AFTER A CHANGE OF RENTAL, DOESNT MATTER WHAT'S THE CHANGE, BASE ON A ROOM
        // THE RES_ARRAY AND AVA_ARRAY ARE RECONSTRUCTED
        // FIND THE EARLIEST AVA DATE FOR EACH ROOM

        // BE SURE ALL TABLE RETRIEVED ONLY ACTIVE DATA
        $this->Beds = TableRegistry::get('Beds');
        $this->Beds_rooms = TableRegistry::get('Beds_rooms');
        $this->Properties = TableRegistry::get('Properties');
        $this->Rooms = TableRegistry::get('Rooms');
        $this->Rentals = TableRegistry::get('Rentals');
        $this->Tenants = TableRegistry::get('Tenants');
        $this->Beds_rooms_rentals = TableRegistry::get('Beds_rooms_rentals');

        // DECLARE VARIABLES
        // room -- THIS room
        $rooms = $this->Rooms->find()->where(['id'=>$room_id])->all();
        $room = null;
        foreach ($rooms as $r){
            $room = $r;
            break;
        }
        // property -- THIS property
        $properties = $this->Properties->find()->where(['id'=>$room->property_id])->all();
        $property = null;
        foreach ($properties as $p){
            $property = $p;
            break;
        }
        // rentals -- ALL ACTIVE rentals on THIS room
        $rentals = $this->Rentals->find('all',['order'=>'start_date'])->where(['room_id'=>$room->id, 'rental_status'=>1])->all();
        // Rental_Room_Bed -- ALL
        $rental_room_beds = $this->Beds_rooms_rentals->find()->all();
        // Beds Rooms -- ALL on THIS room
        $room_beds = $this->Beds_rooms->find()->where(['room_id'=>$room->id])->all();
        // Beds -- ALL
        $beds = $this->Beds->find()->all();
        // rental room beds  -- ?????????????
        $rent_bed_rooms = $this->Beds_rooms_rentals->find()->all();


        // START CODE
        // init data structures
        $matrix = array();
        $resArray = array();
        $avaArray = array();
        // init res array
        for ($i=0; $i<365; $i++){ $resArray[$i] = null; }

        $currentDate = $this->getCurrent();
        if ($room->room_type == 0){                                                                                     // Private Room Ava
            // START CONSTRUCT RES ARRAY FOR PRIVATE ROOM
            $j = 1;
            $rrr = $rentals;
            // debug($rrr); Rental retrieved correctly
            $rentals = array();
            foreach ($rrr as $rental){
                array_push($rentals, $rental);
            }
            // debug($rentals); Rental array formatted correctly
            if (count($rentals)==0){
                $this_res = array();
                $curEnd = $this->getCurrent();
                $this_res[0] = $curEnd;
                $this_res[1] = null;
                array_push($avaArray, $this_res);
            }

            for ($i=0; $i<count($rentals); $i++){
                if ($i == 0 && $i == count($rentals)-1){
                    //debug($i);

                    // only one rental exists

                    // check this rental's start and end
                    $curStart = $this->FrozenToDate($rentals[$i]->start_date);

                    if ($curStart > $currentDate && $curStart->diffInMonths($currentDate) >= 3){
                        $this_res = array();
                        $this_res[0] = $currentDate; //->addDays(1);
                        $this_res[1] = $curStart->subDays(1);
                        array_push($avaArray, $this_res);
                    }

                    $this_res = array();
                    $curEnd = $this->FrozenToDate($rentals[$i]->end_date);
                    $this_res[0] = $curEnd->addDays(1);
                    $this_res[1] = null;
                    array_push($avaArray, $this_res);
                    //debug($avaArray);
                }
                elseif ($i == count($rentals)-1 && $i != 0){
                    $this_res = array();
                    $curEnd = $this->FrozenToDate($rentals[$i]->end_date);
                    $this_res[0] = $curEnd->addDays(1);
                    $this_res[1] = null;
                    array_push($avaArray, $this_res);
                }
                else{
                    $curEnd = $this->FrozenToDate($rentals[$i]->end_date);
                    $nextStart = $this->FrozenToDate($rentals[$j]->start_date);
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
        else{   // Shared Room
            $currentDate = $this->getCurrent();
            //debug($currentDate);
            $counter = 0;
            // debug($rentals); rental retrieved correctly
            foreach ($rentals as $rental){                                                                                      //  Active Rentals
                $matrix[$counter] = array();
                for($i=0; $i<365; $i++){ $matrix[$counter][$i] = null; }                                                        // add rental column to matrix

                $start = $this->FrozenToDate($rental->start_date);                                                                     // Rent Info
                $end = $this->FrozenToDate($rental->end_date);
                //debug($start);
                //debug($end);
                $rentalRoomBeds = $this->getRentalRoomBeds($rental_room_beds, $rental);

                if ($start <= $currentDate && $end >= $currentDate){                                                             // Start before CurrentDate
                    $startIndex = 0;
                    $endIndex = $currentDate->diffInDays($end);
                    //debug($endIndex);
                    if ($endIndex >= 365){                                                                                       // Start before CurrentDate && Ends after a year
                        $res = $this->getCapacityAndBeds($rentalRoomBeds, $room_beds);
                        $cap = $res[0];
                        $bedArray = $res[1];

                        for ($i=0; $i < 365; $i++){
                            $matrix[$counter][$i][0] = $cap;
                            $matrix[$counter][$i][1] = $bedArray;
                        }
                    }else{                                                                                                       // Start before CurretDate && Ends within a year
                        //debug($counter);
                        $res = $this->getCapacityAndBeds($rentalRoomBeds, $room_beds);
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
                        $res = $this->getCapacityAndBeds($rentalRoomBeds, $room_beds);
                        $cap = $res[0];
                        $bedArray = $res[1];

                        for ($i=$startIndex; $i<365; $i++){
                            $matrix[$counter][$i][0] = $cap;
                            $matrix[$counter][$i][1] = $bedArray;
                        }
                    }else{                                                                                                       // Start after CurrentDate && End within a year
                        $res = $this->getCapacityAndBeds($rentalRoomBeds, $room_beds);
                        $cap = $res[0];
                        $bedArray = $res[1];
                        if ($endIndex == 88){
                           // debug($bedArray);
                            $a = 1;
                        }

                        for ($i=$startIndex; $i <= $endIndex; $i++){
                            $matrix[$counter][$i][0] = $cap;
                            $matrix[$counter][$i][1] = $bedArray;
                        }
                    }
                }
                $counter += 1;
            }

            // CONSTRUCT RES ARRAY
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

            $currentDate = $this->getCurrent();
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
                        $slot_res = $this->generateSlot($i, $j, $slotStart, $currentDate, $resArray);
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
                        $slot_res = $this->generateSlot($i, $j, $slotStart, $currentDate, $resArray);
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
                        //debug("HERE");
                        //debug($avaArray);

                        $nullFlag = 0;
                    }
                    if ($resArray[$i][0] != $lastCap){                                                                          // Changed to number from number                                                                      //
                        $slot_res = $this->generateSlot($i, $j, $slotStart, $currentDate, $resArray);
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

        //debug("HERE");
        //debug($avaArray);

        // GETTING ROOM CAPACITY
        $room_cap = 0;
        $this_room_bed = $this->Beds_rooms->find()->where(['room_id'=>$room_id])->all();
        foreach ($this_room_bed as $trb){
            $room_cap += $trb->capacity;
        }

        //debug($room_cap);
        $room = $this->Rooms->get($room_id);
        // STORE EARLIEST DATE
        if ($room->room_type == 0){
            // THE FIRST ELEMENT'S START DATE
            $earliestDate = $avaArray[0][0];
            if (($earliestDate <= $currentDate) && ($earliestDate->diffInDays($currentDate) <= 7)){
                // IF EARILIEST AVA DATE INCLUDES THE 7 waiting days
                $daysToAdd = 7 - $earliestDate->diffInDays($currentDate);
                $earliestDate->addDays($daysToAdd);
            }
            // convert date to frozen date
            $res_start = $earliestDate->year."-".$earliestDate->month."-".$earliestDate->day;
            // debug($res_start);
            $res_start = $res_start." "."00:00:00";
            // debug($res_start);
            $start_time = new FrozenTime($res_start);
            // debug($start_time);
            // debug($room);
            $room->rental_end_date = $start_time;
            $room->last_rental_end_date = $start_time;
            $this->Rooms->save($room);
            // debug($room);
            // UPDATE EARILIEST AVA DATE DONE
        }
        else{
            // READY TO CALCULATE EARLIEST DATE
            //debug("Ready to calculate earliest date");
            $ever_updated = 0;
            if (count($avaArray) == 0){
                // NO RENTAL ON THIS ROOM, SET NULL
                $room->rental_end_date = null;
                $room->last_rental_end_date = null;
                $this->Rooms->save($room);
                $ever_updated = 1;
                //   debug($room);
                //   debug("NO MORE RENTALS SET NULL");
            }else{
                // CHECK IF NULL IGNORED FROM START
                if ($resArray[0] == null){
                    $i = 1; // the last day of not being null
                    while ($resArray[$i] == null){
                        $i += 1;
                    }
                    /* $addition = array();
                     $addition[0] = $currentDate;
                     $tmp = $this->getCurrent();
                     $addition[1] = $tmp->addDays($i);
                     $addition[2] = null;
                     $addition[3] = null;
                     array_unshift($avaArray, $addition);
                     debug($avaArray);*/
                   // debug("ADDED MISSED NULL DAYS TO AVA ARRAY");
                }
                $counter = 0;
                foreach ($avaArray as $block){
                    // getting room capacity
                    $start = $block[0];
                    $end = $block[1];
                    $cap = $block[2];
                    if ($cap == null){ $cap = 0; }
                    if ($end != null){
                        if (($start->diffInMonths($end) >= 3) &&($room_cap-$cap)){
                            // IF FIRST BLOCK SATISFY, SAVE, CHECK FOR 7 DAYS GAP
                            $currentDate = $this->getCurrent();
                            $currentDate_1 = $this->getCurrent();
                            if (($avaArray[$counter][0] <= $currentDate_1->addDays(7)) && ($avaArray[$counter][0]->diffInDays($currentDate) <= 7)){
                                // IF EARILIEST AVA DATE INCLUDES THE 7 waiting days
                                $new_start = new \Cake\I18n\Time($avaArray[$counter][0]->year."-".$avaArray[$counter][0]->month."-".$avaArray[$counter][0]->day." 00:00:00");
                                $daysToAdd = 7 - $new_start->diffInDays($currentDate);
                                $new_start->addDays($daysToAdd);
                            }

                            // check for if new start satisfy 3 mon constraint
                            if ($new_start->diffInMonths($end) >= 3){
                                $start_time = $this->assigningDate($avaArray[$counter][0]);
                                $room->rental_end_date = $start_time;
                                $room->last_rental_end_date = $start_time;
                                $this->Rooms->save($room);
                                $ever_updated = 1;
                               // debug($room);
                               // debug("START SAVING");
                                break;
                            }
                            // else, go to else
                        }
                        elseif ($room_cap-$cap<1){
                            continue;
                        }else{
                       //     debug("IF GAP < 3 and CAP >= 1");
                            // IF GAP < 3 and CAP >= 1
                            $count = $counter;
                            $cur_start = $start;
                            $capVoliationFlag = 0;
                            $foundFlag = 0;
                            $memoCap = $room_cap - $cap;
                            while ($count+1 < count($avaArray)){
                                $count += 1;
                                $next = $avaArray[$count];
                             //   debug("BELOW IS THE NEXT GAP");
                              //  debug($next);
                                $next_cap = $next[2];
                                if ($next_cap == null){ $next_cap = 0; }
                                $next_end = $next[1];
                                if ($cur_start->diffInMonths($next_end) >= 3 || $next_end == null){
                                    // WHEN GAP AVA, OR, WHEN END IS NULL, CAL CAP
                                    if ($room_cap - $next_cap < $memoCap){
                                        $memoCap = $room_cap - $next_cap;
                                    }
                                    if ($memoCap >= 1){
                                        $start_time = $this->assigningDate($avaArray[$counter][0]);
                                        $room->rental_end_date = $start_time;
                                        $room->last_rental_end_date = $start_time;
                                        $this->Rooms->save($room);
                                        $ever_updated = 1;
                                  //      debug($room);
                                  //      debug("START SAVING");
                                        $foundFlag = 1;
                                        break;
                                    }else{
                                        $capVoliationFlag = 1;
                                        break;
                                    }
                                }
                            }
                            if ($foundFlag == 1){
                                // IF FOUND, BREAK
                                break;
                            }
                            if ($capVoliationFlag == 1){
                                continue;
                            }
                        }
                    }
                    else{
                        if ($cap < $room_cap){
                            // IF END IS NULL, CAP VALID, THIS IS THE CURRENT AVA DATE, ASSIGN
                            // FIRST CHECK FOR 7 WAITING DAYS

                            $start_time = $this->assigningDate($avaArray[$counter][0]); // CHANGED FROM $avaArray[0][0] MIGHT BE WRONG
                            $room->rental_end_date = $start_time;
                            $room->last_rental_end_date = $start_time;
                      //      debug($room);
                      //      debug("START SAVING");
                            $this->Rooms->save($room);
                            $ever_updated = 1;
                            break;
                        }else{
                            // IF END NULL BUT CAP == 0, ASSIGN LASTED END DATE, NO NEED TO CHECK FOR 7 WAITING DAYS
                            $all_rent = $this->Rentals->find()->where(['room_id'=>$room_id, 'rental_status'=>1])->all();
                            $the_end = $this->getCurrent();
                            foreach ($all_rent as $ar){
                                if ($ar->end_date > $the_end){
                                    $the_end = $ar->end;
                                }
                            }
                            $start_time = $this->assigningDate($the_end);
                            $room->rental_end_date = $start_time;
                            $room->last_rental_end_date = $start_time;
                            $this->Rooms->save($room);
                            $ever_updated = 1;
                    //        debug($room);
                    //        debug("START SAVING");
                            break;
                        }
                    }
                    $counter += 1;
                }
                if ($ever_updated == 0){
                    // THE EARLIEST NOT BEING UPDATED
                    // LOOPED TO THE END OF AVA ARRAY, BUT NO AVA TIME FOUND, THE END_TIME OF END OF THE AVA ARRAY + 1 WILL BE STORED
                    $to_update = end($avaArray)[1];
                    // debug($to_update);
                    $to_update = $to_update->addDays(1);
                    $room->rental_end_date = $to_update;
                    $room->last_rental_end_date = $to_update;
                    $this->Rooms->save($room);
                    // debug("BEING UPDATED");
                }
            }
        }
        $debug_room = $this->Rooms->get($room_id);
        //     debug($debug_room);
        //    debug($avaArray);
        //   debug($resArray);
        //  exit;
    }

    function assigningDate($earliestDate){
        // convert date to frozen date
        $res_start = $earliestDate->year."-".$earliestDate->month."-".$earliestDate->day;
        // debug($res_start);
        $res_start = $res_start." "."00:00:00";
        // debug($res_start);
        $start_time = new FrozenTime($res_start);
        // debug($start_time);
        // debug($room);
        return $start_time;
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
        // generateSlot($i, $j, $slotStart, $currentDate, $resArray);
        $this_res = array();
        $gap = $i - $j;
        array_push($this_res, $gap);

        //$this->debug_slot($slotStart, $gap, $i, $j);

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
}