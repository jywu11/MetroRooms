<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;

/**
 * Rentals Controller
 *
 * @property \App\Model\Table\RentalsTable $Rentals
 *
 * @method \App\Model\Entity\Rental[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RentalsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Earliest');
       // $this->loadComponent('Csrf');
    }

    /**
     * View method
     *
     * @param string|null $id Rental id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rental = $this->Rentals->get($id, [
            'contain' => ['Tenants']
        ]);

        $this->loadModel("Properties");
        $properties = $this->Properties->find()->where(['id'=>$rental->property_id])->all();
        $property = null;
        foreach ($properties as $p){
            $property = $p;
            break;
        }
        $this->set('property', $property);

        // room
        $this->loadModel("Rooms");
        $rooms = $this->Rooms->find()->where(['id'=>$rental->room_id])->all();
        $room = null;
        foreach ($rooms as $r){
            $room = $r;
        }
        $this->set('room', $room);

        // applicant
        $this->loadModel("Applicants");
        $applicantss = $this->Applicants->find()->all();
        $applicants = array();
        $i = 0;
        foreach ($applicantss as $a){
            if ($a->application_id == $rental->application_id){
                $applicants[$i] = $a;
                $i += 1;
            }
        }
        $this->set('applicants', $applicants);

        // Rental_Room_Bed
        $this->loadModel('Beds_rooms_rentals');
        $res = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$id])->all();
        $this->set('rental_room_beds', $res);

        // Beds Rooms
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find()->where(['room_id'=>$room->id])->all();
        $this->set('room_beds', $res);

        // Beds
        $this->loadModel('Beds');
        $res = $this->Beds->find()->all();
        $this->set('beds', $res);

        // application_room_beds
        $this->loadModel('Applications_beds_rooms');
        $res = $this->Applications_beds_rooms->find()->where(['application_id' => $rental->application_id])->all();
        $this->set('app_room_beds', $res);

        // rental room beds
        $this->loadModel('Beds_rooms_rentals');
        $res = $this->Beds_rooms_rentals->find()->all();
        $this->set('rent_bed_rooms', $res);

        // rentals
        $ren = $this->Rentals->find('all', ['order'=>'start_date'])->where(['room_id'=>$room->id, 'rental_status'=>1])->all();
        $this->set("rentals", $ren);

        // tenants
        $this->loadModel('Tenants');
        $ren = $this->Tenants->find()->where(['rental_id'=>$rental->id])->all();
        $this->set("tenants", $ren);

        $this->set('rental', $rental);

        // application
        $this->loadModel('Applications');


        $res = $this->Applications->find('all')->where(['id'=> $rental->application_id]);
        $flag = 0;
        foreach ($res as $r){
            $flag = 1;
            $res = $r;
            break;
        }
        if ($flag == 0){
            $res = null;
        }

        $this->set('application', $res);

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($aid=null)
    {
        $this->loadModel('Applications');
        $application = $this->Applications->get($aid);
        //debug($application);

        $rental = $this->Rentals->newEntity();
        //debug($this->request->getMethod());

        if ($this->request->is('post')) {
            $rental = $this->Rentals->patchEntity($rental, $this->request->getData());
            // configure dates
            //debug($this->request->getData());

           //exit;

            // START DATE
            $start_string= $this->request->getData()["start_date"];
            $res_start = "";
            $res_start = strval(explode('/', $start_string)[2])."-".strval(explode('/', $start_string)[1])."-".strval(explode('/', $start_string)[0]);
            $res_start = $res_start." "."00:00:00";
            $start_time = new FrozenTime($res_start);
            $rental->start_date = $start_time;

            $duration = $this->request->getData()["duration"];

            // END DATE
            // Calculate  END DATE
            $end_month = (explode('/', $start_string)[1]+$duration)%12;
            if ($end_month == 0){
                $end_month = 12;
            }
            $start_month = explode('/', $start_string)[1];
            $end_day = explode('/', $start_string)[0];
            if ($end_day == 31){
                if ($end_month == 4 || $end_month == 6 || $end_month == 9 || $end_month == 11){$end_day = 30;}
                if ($end_month == 2){$end_day = 28;}}
            $end_year = 0;
            if (($start_month + $duration) > 12){
                $end_year = explode('/', $start_string)[2]+1;}else{$end_year = explode('/', $start_string)[2];}
            $end_res = strval($end_year)."-".strval($end_month)."-".strval($end_day);
            $end_res = $end_res." "."00:00:00";
            $end_time = new FrozenTime($end_res);
            $rental->end_date = $end_time;

            // RENTAL STATUS
            $cd = $this->request->getData('create_date');
            $create_time = new FrozenTime(explode('/', $cd)[2]."-".explode('/', $cd)[1]."-".explode('/', $cd)[0]);
            $rental->create_date = $create_time;

            if ($end_time <= $create_time){
                $rental->rental_status = 0;
            }else{
                $rental->rental_status = 1;
            }

            // NUMBER OF TENANTS
            //debug(count($this->request->getData('tenants')));
            $rental->number_of_tenant = count($this->request->getData('tenants'));

            // PROPERTY AND ROOM ID
            $rental->property_id = $application->property_id;
            $rental->room_id = $application->room_id;

            // SAVING START -- rental, renal_bed, tenant
            if ($this->Rentals->save($rental)) {
                // save beds

                $this->loadModel("Beds_rooms_rentals");
                $beds_store = $this->request->getData('beds_rooms');
                foreach ($beds_store as $bs){
                    foreach ($bs as $b){
                        if ($b != '0'){
                            $r = $this->Beds_rooms_rentals->newEntity();
                            $r->rental_id = $rental->id;
                            $r->bed_room_id = $b;
                            if (!$this->Beds_rooms_rentals->save($r)){
                                // application status update failed
                                $this->Flash->error(__('An error has occurred!</br>The rental is created, but one or more beds associated with this rental failed to be saved</br>Please delete this newly created rental and accept the application again.'));
                                return $this->redirect(['controller'=>'Admins', 'action' => 'application_manage']);
                            }
                            // then mark it as occupied
                            $this->loadModel('Beds_rooms');
                            $this_b = $this->Beds_rooms->get($r->bed_room_id);
                            $this_b->occupied = 1;
                            $this->Beds_rooms->save($this_b);
                        }
                    }
                }

                // set application status to accept
                $this->loadModel("Applications");
                $application = $this->Applications->get($aid);
                $application->application_status = 'a';
                $application->rental_id = $rental->id;
                if (!$this->Applications->save($application)){
                    // application status update failed
                    $this->Flash->error(__('An error has occurred!</br>The rental is created, but your application is failed to update its status!</br>To avoid confusion please go to your Application Management and Archive it. (or Archive then Delete it if you no longer need to view the application).'));
                }
                // end set application status

                $this->Earliest->updateearliest($rental->room_id);
                $this->redirect(['action' => 'view', $rental->id]);
            }
            //$this->Flash->error(__('The rental could not be created. Please, try again.'));
        }

        // applications
        $this->loadModel("Applications");
        $q = $this->Applications->get($aid);
        $this->set('application', $q);


        $this->loadModel("Properties");
        $properties = $this->Properties->find()->all();
        $property = null;
        //debug($properties);
        foreach ($properties as $p){
            if ($q->property_id == $p->id){
                $property = $p;
                break;
            }
        }
        //debug($property);
        $this->set('property', $property);

        //exit;
        // room
        $this->loadModel("Rooms");
        $rooms = $this->Rooms->find()->all();
        $room = null;
        foreach ($rooms as $r){
            if ($r->id == $q->room_id){
                $room = $r;
            }
        }
       // debug($room);
        $this->set('room', $room);
//exit;
        // applicant
        $this->loadModel("Applicants");
        $applicantss = $this->Applicants->find()->where(['application_id' => $aid])->all();
        //$applicants = array();
        //$i = 0;
        //foreach ($applicantss as $a){
        //    if ($a->application_id == $aid){
        //        $applicants[$i] = $a;
        //        $i += 1;
        //    }
       // }
        //debug($applicantss);
        $this->set('applicants', $applicantss);
       // exit;

        // rentals
        $ren = $this->Rentals->find('all',['order'=>'start_date'])->where(['room_id'=>$room->id, 'rental_status'=>1])->all();
        $this->set("rentals", $ren);

        //debug($ren);
        //exit;

        // Rental_Room_Bed
        $this->loadModel('Beds_rooms_rentals');
        $res = $this->Beds_rooms_rentals->find()->all();
        $this->set('rental_room_beds', $res);

        // Beds Rooms
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find()->where(['room_id'=>$room->id])->all();
        $this->set('room_beds', $res);

        // Beds
        $this->loadModel('Beds');
        $res = $this->Beds->find()->all();
        $this->set('beds', $res);

        // application_room_beds
        $this->loadModel('Applications_beds_rooms');
        $res = $this->Applications_beds_rooms->find()->where(['application_id' => $aid])->all();
        $this->set('app_room_beds', $res);

        // rental room beds
        $this->loadModel('Beds_rooms_rentals');
        $res = $this->Beds_rooms_rentals->find()->all();
        $this->set('rent_bed_rooms', $res);

        $this->set(compact('rental'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rental id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rental = $this->Rentals->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $rental = $this->Rentals->patchEntity($rental, $this->request->getData());

            // START DATE, END DATE, TENANT NUMBER, STATUS
            // START DATE
            $start_string= $this->request->getData()["start_date"];
            $res_start = "";
            $res_start = strval(explode('/', $start_string)[2])."-".strval(explode('/', $start_string)[1])."-".strval(explode('/', $start_string)[0]);
            $res_start = $res_start." "."00:00:00";
            $start_time = new FrozenTime($res_start);
            $rental->start_date = $start_time;

            $duration = $this->request->getData()["duration"];

            // END DATE
            // Calculate  END DATE
            $end_month = (explode('/', $start_string)[1]+$duration)%12;
            if ($end_month == 0){
                $end_month = 12;
            }
            $start_month = explode('/', $start_string)[1];
            $end_day = explode('/', $start_string)[0];
            if ($end_day == 31){
                if ($end_month == 4 || $end_month == 6 || $end_month == 9 || $end_month == 11){$end_day = 30;}
                if ($end_month == 2){$end_day = 28;}}
            $end_year = 0;
            if (($start_month + $duration) > 12){
                $end_year = explode('/', $start_string)[2]+1;}else{$end_year = explode('/', $start_string)[2];}
            $end_res = strval($end_year)."-".strval($end_month)."-".strval($end_day);
            $end_res = $end_res." "."00:00:00";
            $end_time = new FrozenTime($end_res);
            $rental->end_date = $end_time;

            // RENTAL STATUS
            // archived rental cannot be edit, no need to check if it's archived
            $cd = $this->request->getData('current_date');
            $create_time = new FrozenTime(explode('/', $cd)[2]."-".explode('/', $cd)[1]."-".explode('/', $cd)[0]);
            //$rental->create_date = $create_time;
            if ($end_time <= $create_time){
                $rental->rental_status = 0;
            }else{
                $rental->rental_status = 1;
            }

            // NUMBER OF TENANTS
            $rental->number_of_tenant = $this->request->getData('number_of_tenant');

            // TENANTS
            if (array_key_exists('old', $this->request->getData('tenant'))){
                $old = $this->request->getData('tenant')['old'];
            }else{$old=null;}
            if (array_key_exists('rm', $this->request->getData('tenant'))){
                $rm = $this->request->getData('tenant')['rm'];
            }else{$rm=null;}
            if (array_key_exists('new', $this->request->getData('tenant'))){
                $new = $this->request->getData('tenant')['new'];
            }else{$new=null;}

            $this->loadModel('Tenants');
            if ($old != null){
                // if there are old entry being edited
                foreach ($old as $o){
                    //debug($o);
                    $this_t = $this->Tenants->get($o['id']);
                    $this_t->first_name = $o['first_name'];
                    $this_t->last_name = $o['last_name'];
                    if (array_key_exists('preferred_name', $o)){
                        $this_t->preferred_name = $o['preferred_name'];
                    }
                    $this_t->gender = $o['gender'];
                    $this_t->is_aus_citizen = $o['is_aus_citizen'];
                    if (array_key_exists('personal_email', $o)){
                        $this_t->personal_email = $o['personal_email'];
                    }
                    if (array_key_exists('personal_contact_phone', $o)){
                        $this_t->personal_contact_phone = $o['personal_contact_phone'];
                    }

                    $this->Tenants->save($this_t);
                }
            }
            if ($rm != null){
                foreach ($rm as $r){
                    $this_t = $this->Tenants->get($r);
                    $this->Tenants->delete($this_t);
                }
            }
            if ($new != null){
                foreach ($new as $n){
                    $this_t = $this->Tenants->newEntity();

                    $this_t->first_name = $n['first_name'];
                    $this_t->last_name = $n['last_name'];
                    if (array_key_exists('preferred_name', $n)){
                        $this_t->preferred_name = $n['preferred_name'];
                    }
                    $this_t->gender = $n['gender'];
                    $this_t->is_aus_citizen = $n['is_aus_citizen'];
                    if (array_key_exists('personal_email', $n)){
                        $this_t->personal_email = $n['personal_email'];
                    }
                    if (array_key_exists('personal_contact_phone', $n)){
                        $this_t->personal_contact_phone = $n['personal_contact_phone'];
                    }
                    $this_t->rental_id = $rental->id;

                    $this->Tenants->save($this_t);
                }
            }

            // BEDS FOR SHARED ROOM
            $this->loadModel("Rooms");
            $room = $this->Rooms->get($rental->room_id);
            if ($room->room_type == 1){
                $this->loadModel('Beds_rooms_rentals');
                $this_rental_bed = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$rental->id])->all();
                // IF NO BED BEING RECORDED
                if (count($this_rental_bed) == 0){                                                                      // create all beds
                   // debug('NO BED RECORDED');
                    foreach ($this->request->getData('beds_rooms')['_ids'] as $b_id){
                        if ($b_id != 0){
                            $a_bed = $this->Beds_rooms_rentals->newEntity();
                            $a_bed->bed_room_id = $b_id;
                            $a_bed->rental_id = $rental->id;
                            $this->Beds_rooms_rentals->save($a_bed);
                        }
                    }
                }
                else{
                  //  debug("HAS BED RECORDED");
                    // THERE ARE OLD BEDS RECORDED
                    // CHECK FOR PASSED DATA, IF ANY PASSED BED IS ALREADY EXIST
                    $passed_bed = $this->request->getData('beds_rooms')['_ids'];
                    // delete deselected beds
                    foreach ($passed_bed as $key=>$value){
                        if ($value == '0'){
                            $to_remove_id = $key;
                            foreach ($this_rental_bed as $trb){
                                if ($trb->bed_room_id == $to_remove_id){
                                    // IF BED STORED, REMOVE IT
                                 //   debug("DELETE START");
                                 //   debug($trb);
                                    $this->Beds_rooms_rentals->delete($trb);
                                }
                            }
                        }
                    }
                   // debug("DELETE END");
                    $to_be_added = array();
                    // check for already stored beds, construct beds to be added
                  //  debug($passed_bed);
                    foreach ($passed_bed as $pb){
                        if ($pb != 0){
                            $f = 0;
                            foreach ($this_rental_bed as $trb){
                              //  debug($trb->bed_room_id);
                              //  debug($pb);
                                if ($trb->bed_room_id == $pb){
                                   $f = 1;
                                   break;
                                }
                            }
                            if ($f == 0){
                                array_push($to_be_added, $pb);
                            }
                        }
                    }
                    // add beds
                    debug("BEDS TO ADD");
                    debug($to_be_added);

                    foreach ($to_be_added as $tba){
                        $new = $this->Beds_rooms_rentals->newEntity();
                        $new->rental_id = $rental->id;
                        $new->bed_room_id = $tba;
                        $this->Beds_rooms_rentals->save($new);
                    }
                }
            }

            // BEDS FOR PRAVITE ROOM
            $this->loadModel("Beds_rooms_rentals");
            if ($room->room_type == 0){
                foreach ($this->request->getData('beds_rooms')['_ids'] as $b_id){
                    if ($b_id != 0){
                        $old = $this->Beds_rooms_rentals->find()->where(['rental_id' => $rental->id, 'bed_room_id'=>$b_id])->all();
                        if (count($old) == 0){
                            // DOESN'T EXIT BED, ADD
                            $a_bed = $this->Beds_rooms_rentals->newEntity();
                            $a_bed->bed_room_id = $b_id;
                            $a_bed->rental_id = $rental->id;
                            $this->Beds_rooms_rentals->save($a_bed);
                        }
                        // ELSE EXITS KEEP LOOKING FOR NEXT
                    }
                }
            }

            // START SAVE
            if ($this->Rentals->save($rental)) {
                // check if bed occupied flag need to be updated
                if ($rental->rental_status == 0){ // ROOM TYPE????
                    $this->loadModel("Beds_rooms_rentals");
                    $del = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$rental->id])->all();
                    // decide if to set bed not occupied
                    foreach ($del as $d){ // for each bed this expired rental was occupying
                        $bed_id = $d->bed_room_id;

                        $all_r = $this->Rentals->find()->where(['rental_status'=>1, 'room_id'=>$rental->room_id, 'id !='=>$rental->id])->all();

                        $no_more_rental = 0;
                        if (count($all_r) == 0){
                            $no_more_rental = 1;
                        }
                        if ($no_more_rental == 1){
                            $this->loadModel("Beds_rooms");
                            $empty_bed = $this->Beds_rooms->get($bed_id);
                            $empty_bed->occupied = 0;
                            $this->Beds_rooms->save($empty_bed);
                        }
                        // BELOW NOT TESTED
                        foreach ($all_r as $ar){
                            $this->loadModel("Beds_rooms_rentals");
                            $rem_beds = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$ar->id])->all();
                            $flag = 0;
                            foreach ($rem_beds as $rem){
                                if ($rem->bed_room_id == $bed_id){
                                    $flag = 1;
                                }
                            }
                            $this->loadModel("Beds_rooms");
                            if ($flag == 0){
                                $empty_bed = $this->Beds_rooms->get($bed_id);
                                $empty_bed->occupied = 0;
                                $this->Beds_rooms->save($empty_bed);
                            }
                        }
                    }
                }
                if ($rental->rental_status == 1){
                    // mark beds as occupied
                    $this->loadModel('Beds_rooms_rentals');
                    $this->loadModel('Beds_rooms');
                    $rental_beds = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$rental->id])->all();
                    // FIRST SET THIS RENTAL'S BED TO BE OCCUPIED
                    foreach ($rental_beds as $rb){
                        $this_rb = $rb;
                        $this_b = $this->Beds_rooms->get($this_rb->bed_room_id);
                        $this_b->occupied = '1';
                        $this->Beds_rooms->save($this_b);
                    }
                    // THEN CHECK FOR ALL BEDS FOR THIS ROOM, SEE IF EACH BED IS OCCUPIED OR NOT
                    $cur_rents = $this->Rentals->find()->where(['room_id' => $rental->room_id, 'rental_status'=>1])->all();

                    $this->loadModel('Beds_rooms');
                    $this_beds = $this->Beds_rooms->find()->where(['room_id'=>$rental->room_id])->all();
                    $aux = array();
                    foreach ($this_beds as $tb){
                        $aux[$tb->id] = 0;
                    }

                    foreach ($cur_rents as $cr){
                       // debug("=======================================================================================");
                       // debug($cr);

                        $this_rent_beds = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$cr->id])->all();
                       // debug($this_rent_beds);
                        foreach ($this_rent_beds as $trb){
                            $aux[$trb->bed_room_id] += 1;
                        }
                    }

                    foreach ($aux as $key=>$a){
                        $this_bed = $this->Beds_rooms->get($key);
                        if ($a != 0){
                           $this_bed->occupied = 1;
                        }else{
                            $this_bed->occupied = 0;
                        }
                      //  debug($this_bed);
                        $this->Beds_rooms->save($this_bed);
                    }
                }

                $this->Earliest->updateearliest($rental->room_id); // CALL COMPONENT

                $this->Flash->success(__('The rental has been saved.'));

                return $this->redirect(['action' => 'view', $rental->id]);
            }
            $this->Flash->error(__('The rental could not be saved. Please, try again.'));
        }

        $this->loadModel("Applications");
        //$applications = $this->Rentals->Applications->find()->where(['id' => $rental->application_id])->all();

        $applications = $this->Applications->find()->all();
        $f = 0;
        foreach ($applications as $app){
            $f = 1;
            if ($app->id == $rental->application_id){
                $applications = $app;
                break;
            }
        }
        if ($f == 0){
            $applications = null;
        }

        $this->loadModel("Properties");
        $property = $this->Properties->get($rental->property_id);

        //debug($property);
        $this->set('property', $property);

        //exit;
        // room
        $this->loadModel("Rooms");
        $room = $this->Rooms->get($rental->room_id);
        // debug($room);
        $this->set('room', $room);

        // applicant
        $this->loadModel("Applicants");
        $application = null;
        $applicantss = null;
        $res = null;
        $application = $applications;

        if ($f == 1){
            // application exist, find applicant
            $applicantss = $this->Applicants->find()->where(['application_id' => $application->id])->all();
            // application_room_beds
            $this->loadModel('Applications_beds_rooms');
            $res = $this->Applications_beds_rooms->find()->where(['application_id' => $application->id])->all();

        }

        $this->set('applicants', $applicantss);
        $this->set('application', $application);
        $this->set('app_room_beds', $res);

        // rentals
        $ren = $this->Rentals->find('all',['order'=>'start_date'])->where(['room_id'=>$room->id, 'rental_status'=>1])->all();
        $this->set("rentals", $ren);

        //debug($ren)

        // Rental_Room_Bed
        $this->loadModel('Beds_rooms_rentals');
        $res = $this->Beds_rooms_rentals->find()->all();
        $this->set('rental_room_beds', $res);

        // Beds Rooms
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find()->where(['room_id'=>$room->id])->all();
        $this->set('room_beds', $res);

        // Beds
        $this->loadModel('Beds');
        $res = $this->Beds->find()->all();
        $this->set('beds', $res);


        // rental room beds
        $this->loadModel('Beds_rooms_rentals');
        $res = $this->Beds_rooms_rentals->find()->all();
        $this->set('rent_bed_rooms', $res);

        $this->loadModel('Tenants');
        $res = $this->Tenants->find()->where(['rental_id'=>$rental->id])->all();
        $this->set('tenants', $res);

        $this->loadModel('Beds_rooms_rentals');
        $this->set('this_room_bed', $this->Beds_rooms_rentals->find()->where(['rental_id'=>$rental->id])->all());


        $this->set(compact('rental'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rental id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rental = $this->Rentals->get($id);

        // delete beds and tenants first
        $this->loadModel('Beds');
        //$ALL = $this->Beds->find()->all();

        $this->loadModel("Beds_rooms_rentals");
        $del = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$id])->all();
        // decide if to set bed not occupied
        foreach ($del as $d){
            $bed_id = $d->bed_room_id;

            $all_r = $this->Rentals->find()->where(['rental_status'=>1, 'room_id'=>$rental->room_id])->all();

            $no_more_rental = 0;
            if (count($all_r) == 0){
                $no_more_rental = 1;
            }
            if ($no_more_rental == 1){
                $this->loadModel("Beds_rooms");
                $empty_bed = $this->Beds_rooms->get($bed_id);
                $empty_bed->occupied = 0;
                $this->Beds_rooms->save($empty_bed);
            }
            //debug($empty_bed);
            //exit;
            // BELOW NOT TESTED
            $this->Beds_rooms_rentals->delete($d);
            foreach ($all_r as $ar){
                $this->loadModel("Beds_rooms_rentals");
                $rem_beds = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$ar->id])->all();
                $flag = 0;
                foreach ($rem_beds as $rem){
                    if ($rem->bed_room_id == $bed_id){
                        $flag = 1;
                    }
                }
                $this->loadModel("Beds_rooms");
                if ($flag == 0){
                    $empty_bed = $this->Beds_rooms->get($bed_id);
                    $empty_bed->occupied = 0;
                    $this->Beds_rooms->save($empty_bed);
                    debug($empty_bed);
                }
            }
        }

        //exit;

        // delete tenants
        $this->loadModel('Tenants');
        $del = $this->Tenants->find()->where(['rental_id'=>$id])->all();
        foreach ($del as $d){
            $this->Tenants->delete($d);
        }

        if ($this->Rentals->delete($rental)) {
            $this->Flash->success(__('The rental has been deleted.'));
        } else {
            $this->Flash->error(__('The rental could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $a_rental = $this->Rentals->find('all', ['order'=>['Rentals.create_date'=>'DESC']])->contain(['Rooms', 'Properties'])->where(['rental_status'=>1])->all();
        //$a_rental = $this->paginate($q);
        $this->set("a_rentals", $a_rental);

        $a_rental = $this->Rentals->find('all', ['order'=>['Rentals.create_date'=>'DESC']])->contain(['Rooms', 'Properties'])->where(['rental_status'=>0])->all();
        //$a_rental = $this->paginate($q);
        $this->set("e_rentals", $a_rental);

        $a_rental = $this->Rentals->find('all', ['order'=>['Rentals.create_date'=>'DESC']])->contain(['Rooms', 'Properties'])->where(['rental_status'=>2])->all();
        //$a_rental = $this->paginate($q);
        $this->set("d_rentals", $a_rental);

        /* $this->paginate = [
             'contain' => ['Applications', 'Rooms', 'Properties']
         ];
         $rentals = $this->paginate($this->Rentals);

         $this->set(compact('rentals'));*/
    }

    public function setarchive($id){
        $rental = $this->Rentals->get($id);

        $room_id = $rental->room_id;

        $rental->rental_status = 2;

        // set beds occupied to not occupied

        $this->loadModel("Beds_rooms_rentals");
        $del = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$rental->id])->all();
        // decide if to set bed not occupied
        foreach ($del as $d){// for each bed this expired rental was occupying
            $bed_id = $d->bed_room_id;

            $all_r = $this->Rentals->find()->where(['rental_status'=>1, 'room_id'=>$rental->room_id, 'id !='=>$rental->id])->all();

            $no_more_rental = 0;
            if (count($all_r) == 0){
                $no_more_rental = 1;
            }
            if ($no_more_rental == 1){
                $this->loadModel("Beds_rooms");
                $empty_bed = $this->Beds_rooms->get($bed_id);
                $empty_bed->occupied = 0;
                $this->Beds_rooms->save($empty_bed);
            }
            // BELOW NOT TESTED
            foreach ($all_r as $ar){
                $this->loadModel("Beds_rooms_rentals");
                $rem_beds = $this->Beds_rooms_rentals->find()->where(['rental_id'=>$ar->id])->all();
                $flag = 0;
                foreach ($rem_beds as $rem){
                    if ($rem->bed_room_id == $bed_id){
                        $flag = 1;
                    }
                }
                $this->loadModel("Beds_rooms");
                if ($flag == 0){
                    $empty_bed = $this->Beds_rooms->get($bed_id);
                    $empty_bed->occupied = 0;
                    $this->Beds_rooms->save($empty_bed);
                }
            }
        }

        if ($this->Rentals->save($rental)) {
            $this->Earliest->updateearliest($room_id);

            $this->Flash->success(__('The rental has been archived successfully.'));
            return $this->redirect($this->request->referer());

        }
        $this->Flash->error(__('Archive Failed, please try again.'));
    }


    public function setrestore($id){
        $rental = $this->Rentals->get($id);

        $currentDate = new \Cake\I18n\Time();
        $currentDate = new FrozenTime($currentDate->i18nFormat('yyyy-MM-dd'));
        debug($currentDate);
        if ($rental->end_date >= $currentDate){
            $rental->rental_status = 1;
        }else{
            $rental->rental_status = 0;
        }


        if ($this->Rentals->save($rental)) {

            $this->Flash->success(__('The rental has been restored successfully.'));
            return $this->redirect($this->request->referer());

        }
        $this->Flash->error(__('Restore Failed, please try again.'));
    }


}
