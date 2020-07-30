<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;

/**
 * Rooms Controller
 *
 * @property \App\Model\Table\RoomsTable $Rooms
 *
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoomsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($pid=null)
    {
        // ADMIN SHOW ALL ROOMS FOR PID
        if ($pid==null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }

        // Item
        $this->loadModel('Items');
        $this->set('items', $this->Items->find('all')->where(['location !=' => 'p']));

        // for property info
        $this->loadModel('Properties');
        $query_2 = $this->Properties->find()->where(['id' => $pid])->all();
        $this->set('property', $query_2);

        // build query for retrieving photo belongs to the property
        $query = $this->Rooms->find('all',['contain' => 'Items', 'Beds'])->where(['property_id' => $pid])->all();
        $this->set('rooms', $query);
        $this->set('pid', $pid);


        // BEDS
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find('all')->all();
        $this->set('brs', $res);

        $this->loadModel('Beds');
        $res = $this->Beds->find()->all();
        $this->set('beds', $res);

        // RENTALS
        $this->loadModel('Rentals');
        $res = $this->Rentals->find()->where(['property_id'=>$pid, 'rental_status'=>1])->all();
        $this->set('rentals', $res);

        // Rental_Room_Bed
        $this->loadModel('Beds_rooms_rentals');
        $res = $this->Beds_rooms_rentals->find()->all();
        $this->set('rent_bed_rooms', $res);

        // Beds Rooms
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find()->all();
        $this->set('room_beds', $res);

     /*   $this->paginate = [
            'contain' => ['Properties']
        ];
        $rooms = $this->paginate($this->Rooms);

        $this->set(compact('rooms'));*/
    }

    public function detail($id=null){
        if ($id===null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        else{
            $room = $this->Rooms->get($id, ['contain' => ['Items', 'PropertiesImages']]);
        }

        $this->loadModel('Properties');
        $pid = $room->property_id;
        $property = $this->Properties->get($pid, ['contain' => ['Features', 'Items', 'Rooms', 'PropertiesImages']]);
        // debug($property);

        $this->set('room', $room);
        $this->set('property', $property);

        /*// retrieve photos belong to this property
        $this->loadModel('PropertiesImages');
        $query = $this->PropertiesImages->find()->where(['property_id' => $property->id]);
        $this->set('propertyImages', $this->paginate($query));*/


        // get types
        $this->loadModel('Properties');
        $types = $this->Properties->Types->find('list');
        $this->set('features', $this->Properties->Features->find('list'));
        $this->set(compact('property', 'types'));

        //Frontend info
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

        // all beds rooms
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find()->all();
        $this->set('all_room_beds', $res);

        // Beds
        $this->loadModel('Beds');
        $res = $this->Beds->find()->all();
        $this->set('beds', $res);
    }

    public function adminAdd($pid=null){
        // validator: room number cannot bigger than number_of_room in property
        $this->loadModel('Properties');
        $p = $this->Properties->find()->where(['id' => $pid])->all();
        //$p = $this->paginate($query_3);
        $r_n = 0;
        foreach ($p as $pro){
            $r_n = $pro->number_of_bedroom;
        }
        // get current number of room from room table
        $res = $this->Rooms->find()->where(['property_id' => $pid])->all();
       // $res = $this->paginate($query_4);
        $count = 0;
        foreach($res as $cur){
            $count += 1;
        }
        if ($count >= $r_n){
            $this->Flash->error(__('Reach room capacity given by the property bedroom number, cannot add more room.'));
            return $this->redirect(['action' => 'index', $pid]);
        }
        // validator end


        $room = $this->Rooms->newEntity();
        if ($pid==null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        else{
            $my_items = $this->request->getData('items');
            $br = $this->request->getData('beds');
            if ($this->request->is('post')) {
                /*debug($this->request->getData());
                exit;*/
                $room = $this->Rooms->patchEntity($room, $this->request->getData());
                if ($room->room_name == null){
                    $room->room_name = "Bedroom ".strval($count);
                }
                // validate num_of_people_stay < room cap
                if ($room->current_number_of_people_staying > $room->room_capacity){
                    $this->Flash->error(__('Number of people Currently staying in the room CANNOT be bigger than the room capacity, please, try again'));
                }else{
                    if ($this->Rooms->save($room)) {
                        // ITEM
                        // update quantity separably
                        $quan_list = $my_items['_joinData'];
                        $item_list = $my_items['_ids'];
                        //debug($quan_list);

                        // first retrieve, get items belongs to this property
                        $this->loadModel('ItemsRooms');
                        $res = $this->ItemsRooms->find()->where(['room_id' => $room->id])->all();
                        //$res = $this->paginate($q);

                        // check if it needs to be updated
                        foreach ($item_list as $item_fk){
                            if ($item_fk != '0'){
                                // it has a new quan assigned, update
                                $index = intval($item_fk);
                                $new_quan = $quan_list[$index]['quantity'];
                                $new_quan = intval($new_quan);
                                $RoomsItemsTable = TableRegistry::getTableLocator()->get('ItemsRooms');
                                $my_id = null;
                                foreach ($res as $r){
                                    if ($r->item_id == $index){
                                        $my_id = $r->id;
                                    }
                                }

                                $my_p_item = $RoomsItemsTable->get($my_id);
                                $my_p_item->quantity = $new_quan;
                                $RoomsItemsTable->save($my_p_item);
                            }
                        }

                        // BED
                        $this->loadModel('Beds_rooms');
                        //$res = $this->paginate($this->Beds_rooms->find('all')->where(['room_id'=>$room->id]));

                        foreach ($this->request->getData()['beds']['_ids'] as $bed_id){
                            $rb = $this->Beds_rooms->newEntity();
                            $rb->bed_id = $bed_id;
                            $rb->property_id = $room->property_id;
                            $rb->room_id = $room->id;
                            $this->loadModel('Beds');
                            $beds = $this->Beds->find()->all();
                            foreach ($beds as $bed){
                                if ($bed->id == $rb->bed_id){
                                    $rb->capacity = $bed->capacity;
                                }
                            }
                            if ($this->Beds_rooms->save($rb)){
                                $a = 0;
                            }else{
                                $this->Flash->error(__('The room is saved but there is something wrong saving the beds. Please delete the newly created room, then try again.'));
                                $this->redirect($this->referer());
                            }

                        }

                        /*foreach ($res as $r){
                            $r->property_id = $room->property_id;
                            $this->loadModel('Beds');
                            $beds = $this->paginate($this->Beds->find('all'));
                            foreach ($beds as $bed){
                                if ($bed->id == $r->bed_id){
                                    $r->capacity = $bed->capacity;
                                }
                            }
                            if ($this->Beds_rooms->save($r)){
                                $a = 0;
                            }else{
                                $this->Flash->error(__('The room is saved but there is something wrong saving the beds. Please delete the newly created room, then try again.'));
                                $this->redirect($this->referer());
                            }
                        }*/
                        /*$br_list = $br['_ids'];
                        foreach ($br_list as $br_entry){
                            $bri = $this->Beds_rooms->newEntity();
                            $bri->bed_id = $br_entry;
                            $bri->room_id = $room->id;
                            $bri->property_id = $room->property_id;
                            $this->loadModel('Beds');
                            $beds = $this->paginate($this->Beds->find('all'));
                            foreach ($beds as $bed){
                                if ($bed->id == $br_entry){
                                    $bri->capacity = $bed->capacity;
                                }
                            }
                            if ($this->Beds_rooms->save($bri)){
                                $a = 0;
                            }else{
                                $this->Flash->error(__('The room could not be saved. Please, try again.'));
                                $this->redirect($this->referer());
                            }
                        }*/

                        $this->Flash->success(__('The room has been saved.'));

                        return $this->redirect(['action' => 'index', $pid]);
                    }
                    $this->Flash->error(__('The room could not be saved. Please, try again.'));
                }

            }
        }

        /*$property = $this->Rooms->Properties->find('list', ['limit' => 200]);
        $items = $this->Rooms->Items->find('list', ['limit' => 200]);
        $this->set(compact('room', 'property', 'items'));*/

        # Item
        //$items = $this->Rooms->Items->find('list', ['limit' => 200]);
        $this->loadModel('Items');
        $this->set('items', $this->Items->find('list')->where(['location !=' => 'p']));


        // for property info
        $this->loadModel('Properties');
        $query_2 = $this->Properties->find()->where(['id' => $pid])->all();
        $this->set('property', $query_2);

        // build query for retrieving photo belongs to the property
        $query = $this->Rooms->find()->where(['property_id' => $pid])->all();
        $this->set('rooms', $query);
        $this->set('pid', $pid);

        $this->set('room', $room);

        # Item Details
        $this->loadModel('Items');
        $q = $this->Items->find()->where(['location !=' => 'p'])->all();
        $this->set('itemDetails',  $q);

        # property
        $this->loadModel('Properties');
        $property = $this->Properties->get($pid);

        # stored Items
        $this->loadModel('ItemsRooms');
        $res = $this->ItemsRooms->find()->where(['room_id' => $room->id])->all();
        //$res = $this->paginate($q);
        $this->set('my_items', $res);

        # bed types
        $this->loadModel('Beds');
        $beds = $this->Beds->find()->all();
        $this->set('beds', $beds);
    }

    public function adminEdit($id = null)
    {
        # room beds reference for delete
        $this->loadModel('Beds_rooms');
        $m = $this->Beds_rooms->find()->where(['room_id'=>$id])->all();

        # room beds reference for delete
        $this->loadModel('Beds');
        $beds =$this->Beds->find()->all();

        if ($id == null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        // get property id
        $res = $this->Rooms->find()->where(['id' => $id])->all();
       // $res = $this->paginate($query_2);
        $pid = null;
        foreach($res as $r) {
            $pid = $r->property_id;
        }

        $room = $this->Rooms->get($id, ['contain' => ['Items']]);
       /* $old_date = $this->request->getData("rental_end_date");
        debug($old_date);
        $date_str = "";
        if ($old_date != null){
            $date_str = strval($old_date["year"])."-".strval($old_date["month"])."-".strval($old_date["day"]);
            $old_date = new FrozenDate($date_str);
            echo "Date NOT NULL";
        }*/


        if ($this->request->is(['patch', 'post', 'put'])) {
            //debug($this->request->getData());
            //exit;

            $update_flag = $this->request->getData("UPDATE_FLAG");
            $room = $this->Rooms->patchEntity($room, $this->request->getData(), ['associated' => ['Items._joinData']]);
            $my_items = $this->request->getData('items');
            if ($update_flag == null){
                $room->rental_end_date = $room->last_rental_end_date;
            }elseif ($update_flag != null){
                $room->last_rental_end_date = $room->rental_end_date;
            }
            if ($room->current_number_of_people_staying > $room->room_capacity){
                $this->Flash->error(__('Number of people Currently staying in the room CANNOT be bigger than the room capacity, please, try again'));
            }else{
                if ($this->Rooms->save($room)) {

                    // update quantity separably
                    $quan_list = $my_items['_joinData'];
                    $item_list = $my_items['_ids'];
                    //debug($quan_list);

                    // first retrieve, get items belongs to this property
                    $this->loadModel('ItemsRooms');
                    $res = $this->ItemsRooms->find()->where(['room_id' => $room->id])->all();
                    //$res = $this->paginate($q);

                    // check if it needs to be updated
                    foreach ($item_list as $item_fk){
                        if ($item_fk != '0'){
                            // it has a new quan assigned, update
                            $index = intval($item_fk);
                            $new_quan = $quan_list[$index]['quantity'];
                            $new_quan = intval($new_quan);
                            $RoomsItemsTable = TableRegistry::getTableLocator()->get('ItemsRooms');
                            $my_id = null;
                            foreach ($res as $r){
                                if ($r->item_id == $index){
                                    $my_id = $r->id;
                                }
                            }

                            $my_p_item = $RoomsItemsTable->get($my_id);
                            $my_p_item->quantity = $new_quan;
                            $RoomsItemsTable->save($my_p_item);
                        }
                    }

                    // BEDS

                    // NOT FINISHED
                    // CHECK FOR DELETED BED
                    // VALIDE DELETE BED
                    // SAVE NEWLY ADDED BED

                    //debug($a);
                    //debug($this->request->getData());
                    //exit;
                    $this->loadModel('Beds_rooms');
                    if (array_key_exists('add', $this->request->getData()['beds'])){
                        $add = $this->request->getData()['beds']['add'];
                    }else{$add=null;}
                    if (array_key_exists('old', $this->request->getData()['beds'])){
                        $old = $this->request->getData()['beds']['old'];
                    }else{$old=null;}
                    if (array_key_exists('delete', $this->request->getData()['beds'])){
                        $delete = $this->request->getData()['beds']['delete'];
                    }else{$delete=null;}


                    // add new beds in
                    if ($add !=null){
                        foreach ($add as $a){
                            $rb = $this->Beds_rooms->newEntity();
                            $rb->bed_id = $a;
                            $rb->property_id = $room->property_id;
                            $rb->room_id = $room->id;
                            $this->loadModel('Beds');
                            $beds = $this->Beds->find()->all();
                            foreach ($beds as $bed){
                                if ($bed->id == $rb->bed_id){
                                    $rb->capacity = $bed->capacity;
                                }
                            }
                            if ($this->Beds_rooms->save($rb)){
                                $q = 0;
                            }else{
                                $this->Flash->error(__('The room is saved but there is something wrong saving the beds. Please, try again.'));
                            }
                        }
                    }

                    /*debug($delete);
                    exit;*/

                    // delete old removed beds
                    if ($delete !=null){
                        foreach ($delete as $d){
                            //debug($d);
                            $cur = $this->Beds_rooms->get($d);
                            if ($this->Beds_rooms->delete($cur)){
                                $q=0;
                            }else{
                                $this->Flash->error(__('The room is saved but there is something wrong deleting the beds. Please, try again.'));
                            }
                        }
                    }

                    // alter old room
                    if ($old !=null){
                        foreach ($old as $o){
                            foreach ($m as $s){
                                if ($s->id == $o[1]){
                                    if ($s->bed_id != $o[0]){
                                        $s->bed_id = $o[0];
                                        foreach ($beds as $bed){
                                            if ($bed->id == $s->bed_id){
                                                $s->capacity = $bed->capacity;
                                            }
                                        }
                                        //$s->capacity = $bed->capacity;
                                        if ($this->Beds_rooms->save($s)){
                                            $q = 0;
                                        }else{
                                            $this->Flash->error(__('The room is saved but there is something wrong saving the beds you altered. Please, try again.'));
                                        }
                                    }
                                }
                            }
                        }
                    }




                    /*$res = $this->paginate($this->Beds_rooms->find('all')->where(['room_id'=>$room->id]));
                    foreach ($res as $r){
                        $r->property_id = $room->property_id;
                        $this->loadModel('Beds');
                        $beds = $this->paginate($this->Beds->find('all'));
                        foreach ($beds as $bed){
                            if ($bed->id == $r->bed_id){
                                $r->capacity = $bed->capacity;
                            }
                        }
                        if ($this->Beds_rooms->save($r)){
                            $a = 0;
                        }else{
                            $this->Flash->error(__('The room is saved but there is something wrong saving the beds. Please delete the newly created room, then try again.'));
                            $this->redirect($this->referer());
                        }
                    }*/



                    $this->Flash->success(__('The room has been saved.'));
                    // debug($room);
                    // exit;
                    return $this->redirect(['action' => 'index', $pid]);
                }
                $this->Flash->error(__('The room could not be saved. Please, try again.'));
            }

        }


       /* $this->loadModel('Properties');

        $q = $this->Rooms->Properties->find()->where(['id' => $pid]);
        $this->set('property', $this->paginate($q));
        // debug($property);
        $this->set(compact('room'));
        $this->set('pid', $pid);*/


        # Item
        //$items = $this->Rooms->Items->find('list', ['limit' => 200]);
        $this->loadModel('Items');
        $this->set('items', $this->Items->find('list')->where(['location !=' => 'p']));
        $res = $this->Items->find()->where(['location !=' => 'p'])->all();
        // debug($res);

        // for property info
        $this->loadModel('Properties');
        $query_2 = $this->Properties->find()->where(['id' => $pid])->all();
        $this->set('property', $query_2);

        // build query for retrieving photo belongs to the property
        $query = $this->Rooms->find()->where(['property_id' => $pid])->all();
        $this->set('rooms', $query);
        $this->set('pid', $pid);

        $this->set('room', $room);

        # Item Details
        $this->loadModel('Items');
        $q = $this->Items->find()->where(['location !=' => 'p'])->all();
        $this->set('itemDetails',  $q);

        # property
        $this->loadModel('Properties');
        $property = $this->Properties->get($pid);

        # stored Items
        $this->loadModel('ItemsRooms');
        $q = $this->ItemsRooms->find()->where(['room_id' => $id])->all();
        $res = $q;
        // debug($res);
        $this->set('my_items', $res);

        # bed types
        $this->loadModel('Beds');
        $beds = $this->Beds->find()->all();
        $this->set('beds', $beds);

        # room beds
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find()->where(['room_id'=>$id])->all();
        $this->set('room_beds', $res);

    }

    /**
     * Delete method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $res = $this->Rooms->find()->where(['id' => $id])->all();
        //$res = $this->paginate($query_2);
        $pid = null;
        foreach($res as $r) {
            $pid = $r->property_id;
        }

        $this->request->allowMethod(['post', 'delete']);
        $room = $this->Rooms->get($id);

        // check active rental on this room
        $this->loadModel('Rentals');
        $res = $this->Rentals->find()->where(['room_id'=>$room->id])->all();
        $flag = 0;
        foreach ($res as $r){
            $flag = 1;
        }
        if ($flag == 1){
            $this->Flash->error(__('The room still have rentals recorded (including Active, Expired, and Archived Rentals) thus could not be deleted. Please delete all its rentals first.'));
            //  (to totally remove it by archive then delete the rental if it is active, or delete if it is already archived or expired), then try again.
            return $this->redirect(['action' => 'index', $pid]);
        }

        // deletion
        if ($this->Rooms->delete($room)) {
            $this->Flash->success(__('The room has been deleted.'));
        } else {
            $this->Flash->error(__('The room could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', $pid]);
    }
}
