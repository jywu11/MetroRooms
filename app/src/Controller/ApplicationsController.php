<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Applications Controller
 *
 * @property \App\Model\Table\ApplicationsTable $Applications
 *
 * @method \App\Model\Entity\Application[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApplicationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function setinterview($aid){
        // set application status to 'i'
        $application = $this->Applications->get($aid);
        $application->application_status = 'i';
        if ($this->Applications->save($application)) {

                $this->Flash->success(__('The application status has been set to "interviewing" successfully.'));
                return $this->redirect($this->request->referer());

        }
        $this->Flash->error(__('Update Status Failed, please try again.'));
    }

    public function archive($aid){
        $application = $this->Applications->get($aid);
        $application->status_before_archive = $application->application_status;
        $application->application_status = 'd';
        if ($this->Applications->save($application)) {

            $this->Flash->success(__('The application has been archived successfully.'));
            return $this->redirect($this->request->referer());

        }
        $this->Flash->error(__('Archive Failed, please try again.'));
    }

    public function accept($aid){
        $application = $this->Applications->get($aid);
        $application->application_status = 'a';
        if ($this->Applications->save($application)) {
            $this->Flash->success(__('The application has been accepted successfully.'));
            return $this->redirect(['controller'=>'Admins', 'action' => 'application_manage']);
        }
        $this->Flash->error(__('Accept Failed, please try again.'));
    }

    public function adminRestore($aid)
    {
        $application = $this->Applications->get($aid);
        $application->application_status = $application->status_before_archive;
        if ($this->Applications->save($application)) {

            $this->Flash->success(__('The application status has been restored successfully.'));
            return $this->redirect($this->request->referer());

        }
        $this->Flash->error(__('Restore Failed, please try again.'));
    }

    /**
     * View method
     *
     * @param string|null $id Application id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function frontview($id = null)
    {
        $application = $this->Applications->get($id, [
            'contain' => ['Properties', 'Rooms', 'Applicants']
        ]);
        $this->loadModel("Rooms");
        $res = $this->Rooms->find()->where(['property_id' => $application->property_id])->contain(["PropertiesImages"])->all();
       // $res = $q->all();

        $r = null;
        foreach ($res as $room){
            if ($room->id != $application->room_id){
                $r = $room;
                break;
            }
        }
        $p = null;
        if ($r == null){
            $this->loadModel("Properties");
            $res = $this->Properties->find()->where(['suburb' => $application->property->suburb])->contain(["PropertiesImages"])->all();
           // $res = $this->paginate($q);
            if ($res == null){
                $res = $this->Properties->find()->contain(["PropertiesImages"])->all();
                //$res = $this->paginate($q);
                foreach ($res as $cur){
                    if ($cur->id != $application->property_id){
                        $p = $cur;
                        break;
                    }
                }
            }
            else{
                foreach ($res as $cur){
                    $p = $cur;
                    break;
                }
            }
        }

        $this->loadModel("Frontcontents");
        $frontcontents = $this->paginate($this->Frontcontents->find("all"));
        $frontcontent = null;
        foreach ($frontcontents as $f){
            $frontcontent = $f;
            break;
        }
        $this->set("frontcontent", $frontcontent);
        $this->set("other_p", $p);
        $this->set("other_r", $r);
        $this->set('application', $application);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function frontadd($rid)
    {
        $application = $this->Applications->newEntity();
        if ($this->request->is('post')) {
            debug($this->request->getData());
            //exit;
            $start_string= $this->request->getData()["start_date"];
            //debug($this->request->getData());
            $duration = $this->request->getData()["duration"];
            // create Date objects for Start/end/create date
            // START DATE
            $res_start = "";
            //debug($start_string);
            $res_start = strval(explode('/', $start_string)[2])."-".strval(explode('/', $start_string)[1])."-".strval(explode('/', $start_string)[0]);
            //debug($res_start);
            $res_start = $res_start." "."00:00:00";

            $start_time = new FrozenTime($res_start);

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
         //   debug($this->request->getData());
        //    debug($end_res);
            $end_res = $end_res." "."00:00:00";
            $end_time = new FrozenTime($end_res);
          //  debug($end_time);
            // CREATE TIME
            $date = date('m/d/Y H:i:s');
            $create_time = new FrozenTime($date);

            $application = $this->Applications->patchEntity($application, $this->request->getData(),
                ['associated' => ['Applicants']]);
            $application["start_date"] = $start_time;
            $application["end_date"] = $end_time;
            $application["create_date"] = $create_time;
            debug($start_time);
            debug($end_time);
            debug($create_time);

            $application['number_of_people'] = $this->request->getData()['num_ppl'];

            $applicant_id = array();
            $flag = 0;

            if ($this->Applications->save($application)) {
                //$num_of_applicant = count($application["applicants"]);
                // debug($num_of_applicant);
                $this->loadModel('Applications_beds_rooms');
                foreach ($this->request->getData()['beds_rooms'] as $a){
                    foreach ($a as $appliedBed){
                        if ($appliedBed != '0'){
                            $thisBed = $this->Applications_beds_rooms->newEntity();
                            $thisBed['application_id'] = $application->id;
                            $thisBed['bed_room_id'] = intval($appliedBed);
                            $this->Applications_beds_rooms->save($thisBed);
                        }
                    }
                }



                if ($flag == 0){
                    // $this->Flash->success(__('The application has been submitted.'));
                    return $this->redirect(['controller' => 'Applications', 'action' => 'frontview', $application->id]);
                }
            }
            // DELETE ALL CREATED ROW IF ANY OF THE OPERATION FAILS
            // To be added

            $this->Flash->error(__('The application could not be submitted. Please, try again.'));
        }

        $properties = $this->Applications->Properties->find('list', ['limit' => 200]);

        # Room info
        $this->loadModel('Rooms');
        $res = $this->Rooms->find()->where(['id' => $rid])->all();
        //$res = $this->paginate($query_4);
        $room = null;
        $pid = null;
        foreach ($res as $r){
            $room = $r;
            $pid = $room->property_id;
        }
        $this->set('room', $room);

        # Property info
        $this->loadModel('Properties');
        $res_2 = $this->Properties->find()->where(['id' => $pid])->all();
        //$res_2 = $this->paginate($query_3);
        $property = null;
        foreach ($res_2 as $r){
            $property = $r;
        }
        $this->set('property', $property);

        $this->set(compact('application'));

        # Frontend info
        $this->loadModel('Frontcontents');
        $f = $this->paginate($this->Frontcontents->find("all"));
        $a = null;
        foreach ($f as $ah){
            $a = $ah;
            break;
        }
        $this->set('frontcontent', $ah);

        // Active Rental
        $this->loadModel('Rentals');
        $res = $this->Rentals->find()->where(['rental_status'=>1, 'room_id'=>$room->id])->all();
        $this->set('rentals', $res);

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
    }



    /**
     * Delete method
     *
     * @param string|null $id Application id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $application = $this->Applications->get($id);
        if ($this->Applications->delete($application)) {
            // delete applicants
            $this->loadModel('Applicants');
            $res = $this->Applicants->find()->where(['application_id'=>$id])->all();
            foreach ($res as $r){
                $this->Applicants->delete($r);
            }

            // delete application_room_beds
            $this->loadModel('Applications_beds_rooms');
            $res = $this->Applications_beds_rooms->find()->where(['application_id'=>$id])->all();
            foreach ($res as $r){
                $this->Applications_beds_rooms->delete($r);
            }

            $this->Flash->success(__('The application has been deleted.'));
        } else {
            $this->Flash->error(__('The application could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Admins', 'action' => 'application_manage']);
    }


    public function adminView($id = null)
    {
        $application = $this->Applications->get($id, [
            'contain' => ['Properties', 'Rooms', 'Applicants']
        ]);

        $this->set('application', $application);

        // application_room_beds
        $this->loadModel('Applications_beds_rooms');
        $res = $this->Applications_beds_rooms->find()->where(['application_id' => $application->id])->all();
        $this->set('app_room_beds', $res);

        // room_beds
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find('all')->where(['room_id' => $application->room_id])->all();
        $this->set('room_beds', $res);

        // beds
        $this->loadModel('Beds');
        $res = $this->Beds->find('all')->all();
        $this->set('beds', $res);
    }
}
