<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

/**
 * Properties Controller
 *
 * @property \App\Model\Table\PropertiesTable $Properties
 *
 * @method \App\Model\Entity\Property[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PropertiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // property info + property images
        $query_1 = $this->Properties->find()
            ->contain(
                [
                    'propertiesImages' => function($q){
                        return $q;
                    }, 'Rooms'
                ]
            )->all();

        //debug($this->paginate($query_1));
        //exit;
        $this->set('properties', $query_1);

        $this->loadModel('Frontcontents');
        $f = $this->Frontcontents->find()->all();
        $a = null;
        foreach ($f as $ah){
            $a = $ah;
            break;
        }
        $this->set('frontcontent', $ah);

        $this->viewBuilder()->setTemplate('/Pages/home');
        /*$this->paginate = [
            'contain' => ['Types']
        ];
        $properties = $this->paginate($this->Properties);

        $this->set(compact('properties'));*/


    }

    /*
     * Detail method
     *
     * @param string|null $id Property id.
     * @return null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     *
     * Display details of a property on front end, hiding full address
     */


    public function detail($id=null)
    {
        if ($id===null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        else{
            $property = $this->Properties->get($id, ['contain' => ['Features', 'Items', 'Rooms', 'Types']]);
        }

        // retrieve photos belong to this property
        $this->loadModel('PropertiesImages');
        $query = $this->PropertiesImages->find()->where(['property_id' => $property->id])->all();
        $this->set('propertyImages', $query);


        // get types
        $types = $this->Properties->Types->find('list');
        $this->set('features', $this->Properties->Features->find('list'));
        $this->set(compact('property', 'types'));

        $this->loadModel('Frontcontents');
        $f = $this->Frontcontents->find()->all();
        $a = null;
        foreach ($f as $ah){
            $a = $ah;
            break;
        }

        $this->set('frontcontent', $ah);

        // all beds rooms
        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find()->all();
        $this->set('all_room_beds', $res);
    }

    /**
     * View method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     *
     * Redirected from Admin v_p, for admin to view full details of the property
     */
    public function adminView($id=null)
    {
        if ($id===null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        else{
            /*$property = $this->Properties->get($id, [
                'contain' => ['Features', 'Types']
            ]);*/
            $property = $this->Properties->get($id, [
                'contain' => ['Types', 'Features', 'Items', 'PropertiesImages', 'Rooms', 'Applications']
            ]);
            $this->set('property', $property);
        }
    }


    /**
     * View method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $property = $this->Properties->get($id, [
            'contain' => ['Types', 'Features', 'Items', 'PropertiesImages', 'Rooms', 'Applications', 'Bookings']
        ]);

        $this->set('property', $property);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     *
     * Redirected from Admins/c_p, for admin to create a new property
     */
    public function adminAdd()
    {
        $property = $this->Properties->newEntity();
        if ($this->request->is('post')) {
            // debug($this->request->getData());
            $my_items = $this->request->getData('items');
            // debug($my_items);
            $property = $this->Properties->patchEntity($property, $this->request->getData());
            $property->property_status = 0;
            // CREATE TIME
            $date = date('m/d/Y H:i:s');
            $create_time = new FrozenTime($date);
            $property["create_date"] = $create_time;

            if ($this->Properties->save($property)) {
                // echo "<script>alert('here');</script>";

                // update quantity separably
                $quan_list = $my_items['_joinData'];
                $item_list = $my_items['_ids'];
                //debug($quan_list);

                // first retrieve, get items belongs to this property
                $this->loadModel('PropertiesItems');
                $res = $this->PropertiesItems->find()->where(['property_id' => $property->id])->all();
                 //$res = $this->paginate($q);

                // check if it needs to be updated
                foreach ($item_list as $item_fk){
                    if ($item_fk != '0'){
                        // it has a new quan assigned, update
                        $index = intval($item_fk);
                        $new_quan = $quan_list[$index]['quantity'];
                        $new_quan = intval($new_quan);
                        $propertiesItemsTable = TableRegistry::getTableLocator()->get('PropertiesItems');
                        $my_id = null;
                        foreach ($res as $r){
                            if ($r->item_id == $index){
                                $my_id = $r->id;
                            }
                        }

                        $my_p_item = $propertiesItemsTable->get($my_id);
                        $my_p_item->quantity = $new_quan;
                        $propertiesItemsTable->save($my_p_item);
                    }
                }


                //exit;
                $this->Flash->success(__('The property has been saved.'));

                // exit;
                return $this->redirect(['action' => 'adminView', $property->id]);
            }
            $this->Flash->error(__('The property could not be saved. Please, try again.'));
        }

        $types = $this->Properties->Types->find('list', ['limit' => 200]);
        $features = $this->Properties->Features->find('list', ['limit' => 200]);
        $items = $this->Properties->Items->find('list', ['limit' => 200])->where(['location !=' => 'b']);
        $this->set(compact('property', 'types', 'features', 'items'));
        # Item Details
        $this->loadModel('Items');


        $q = $this->Items->find()->where(['location !=' => 'b'])->all();
        $this->set('itemDetails',  $q);
        /*# Type
        $types = $this->Properties->Types->find('list');
        # Feature
        $this->set('features', $this->Properties->Features->find('list'));
        # Item
        $this->loadModel('Items');
        $this->set('items', $this->Items->find('list')->where(['location !=' => 'b']));

        $this->set(compact('property', 'types'));*/
        /*
        $types = $this->Properties->Types->find('list');
        $this->set('features', $this->Properties->Features->find('list'));
        $this->set(compact('property', 'types'));
        */
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $property = $this->Properties->newEntity();
        if ($this->request->is('post')) {
            $property = $this->Properties->patchEntity($property, $this->request->getData());
            if ($this->Properties->save($property)) {
                $this->Flash->success(__('The property has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The property could not be saved. Please, try again.'));
        }
        $types = $this->Properties->Types->find('list', ['limit' => 200]);
        $features = $this->Properties->Features->find('list', ['limit' => 200]);
        $items = $this->Properties->Items->find('list', ['limit' => 200]);
        $this->set(compact('property', 'types', 'features', 'items'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     *
     * Redirected from Admins/e_p, for admin to update existing property
     */
    public function adminEdit($id = null)
    {
        if ($id===null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        else{
            $property = $this->Properties->get($id, [
                'contain' => ['Features', 'Items']
            ]);
            // check room count when update bedroom number
            $this->loadModel('Rooms');
            $res = $this->Rooms->find()->where(['property_id' => $id])->all();
          //$res = $this->paginate($q);
            $count = 0;
            foreach($res as $r){
                $count += 1;
            }

            if ($this->request->is(['patch', 'post', 'put'])) {
                $property = $this->Properties->patchEntity($property, $this->request->getData());
                if ($property->number_of_bedroom < $count){
                    $this->Flash->error(__('Your new bedroom number is smaller than the number of rooms you recorded in room management. Please delete them first and try again.'));
                }else{
                    $my_items = $this->request->getData('items');
                    if ($this->Properties->save($property)) {

                        // update quantity separably
                        $quan_list = $my_items['_joinData'];
                        $item_list = $my_items['_ids'];
                        //debug($quan_list);

                        // first retrieve, get items belongs to this property
                        $this->loadModel('PropertiesItems');
                        $res = $this->PropertiesItems->find()->where(['property_id' => $property->id])->all();
                   //   $res = $this->paginate($q);

                        // check if it needs to be updated
                        foreach ($item_list as $item_fk){
                            if ($item_fk != '0'){
                                // it has a new quan assigned, update
                                $index = intval($item_fk);
                                $new_quan = $quan_list[$index]['quantity'];
                                $new_quan = intval($new_quan);
                                $propertiesItemsTable = TableRegistry::getTableLocator()->get('PropertiesItems');
                                $my_id = null;
                                foreach ($res as $r){
                                    if ($r->item_id == $index){
                                        $my_id = $r->id;
                                    }
                                }

                                $my_p_item = $propertiesItemsTable->get($my_id);
                                $my_p_item->quantity = $new_quan;
                                $propertiesItemsTable->save($my_p_item);
                            }
                        }


                        $this->Flash->success(__('The property has been saved.'));

                        //return $this->redirect(['action' => 'adminView'], $id);
                        return $this->redirect(['action' => 'adminView', $property->id]);
                    }
                    $this->Flash->error(__('The property could not be saved. Please, try again.'));
                }
            }

            //$types = $this->Properties->Types->find('list', ['limit' => 200]);
            //$features = $this->Properties->Features->find('list', ['limit' => 200]);
            //$items = $this->Properties->Items->find('list', ['limit' => 200]);
            //$this->set(compact('property', 'types', 'features', 'items'));

            # Type
            $types = $this->Properties->Types->find('list')->all();

            # Feature
            $this->set('features', $this->Properties->Features->find('list')->all());

            # Item
            $this->loadModel('Items');
            $this->set('items', $this->Items->find()->where(['location !=' => 'b'])->all());
            $this->set(compact('property', 'types'));

            # Item Details
            $this->loadModel('Items');
            $q = $this->Items->find()->where(['location !=' => 'b'])->all();
            $this->set('itemDetails',  $q);

            # stored Items
            $this->loadModel('PropertiesItems');
            $res = $this->PropertiesItems->find()->where(['property_id' => $property->id])->all();
            //$res = $this->paginate($q);
            $this->set('my_items', $res);


            /*
            $types = $this->Properties->Types->find('list');
            $this->set('features', $this->Properties->Features->find('list'));
            $this->set(compact('property', 'types'));
            */
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $property = $this->Properties->get($id, [
            'contain' => ['Features', 'Items']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $property = $this->Properties->patchEntity($property, $this->request->getData());
            if ($this->Properties->save($property)) {
                $this->Flash->success(__('The property has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The property could not be saved. Please, try again.'));
        }
        $types = $this->Properties->Types->find('list', ['limit' => 200]);
        $features = $this->Properties->Features->find('list', ['limit' => 200]);
        $items = $this->Properties->Items->find('list', ['limit' => 200]);
        $this->set(compact('property', 'types', 'features', 'items'));
    }

    public function archive($id=null){
        $property = $this->Properties->get($id);
        // NO NEED TO CHECK ACTIVE WHEN ARCHIVE

        $property->status_before_archive = $property->property_status;
        $property->property_status = 1;
        if ($this->Properties->save($property)){
            $this->Flash->success(__('The Property has been archived successfully.'));
            return $this->redirect($this->request->referer());
        }
        $this->Flash->error(__('Archive Failed, please try again.'));
        return $this->redirect($this->request->referer());
    }

    public function restore($id=null){
        $property = $this->Properties->get($id);
        $property->property_status = $property->status_before_archive;
        if ($this->Properties->save($property)){
            $this->Flash->success(__('The Property has been restored successfully.'));
            return $this->redirect($this->request->referer());
        }
        $this->Flash->error(__('Restore Failed, please try again.'));
        return $this->redirect($this->request->referer());
    }


    /**
     * Delete method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     *
     * Redirect from Admins/d_p, for admin to delete property
     */
    public function adminDelete($id = null)
    {
        if ($id===null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        else{
            $this->request->allowMethod(['post', 'delete']);
            $property = $this->Properties->get($id);

            // RENTALS DELETION
            $this->loadModel('Rentals');
            $rents = $this->Rentals->find()->where(['property_id'=>$property->id])->all();
            $count = 0;
            foreach ($rents as $r){
               // debug("ACTIVE RENTAL EXISTS");
                $count = 1;
            }
            if ($count != 0){
                $this->Flash->error(__('The property still have rentals recorded (include Active, Expired, and Archived rentals) thus could not be deleted. Please delete all its rentals first.'));
                return $this->redirect($this->referer());
            }

            // RENTALS
            $this->loadModel('Rentals');
            $rentals = $this->Rentals->find()->where(['property_id'=>$id])->all();
            debug($rentals);
            foreach ($rentals as $r){
                $this->Rentals->delete($r);
            }

            // IMAGES
            $this->loadModel('Properties_images');
            $images = $this->Properties_images->find()->where(['property_id'=>$id])->all();
            foreach ($images as $i){
                $this->Properties_images->delete($i);
            }

            // ROOMS
            $this->loadModel('Rooms');
            $rooms = $this->Rooms->find()->where(['property_id'=>$id])->all();
            foreach ($rooms as $r){
                $this->Rooms->delete($r);
            }

            // APPLICATION DELETION
            $this->loadModel('Applications');
            $apps = $this->Applications->find()->where(['property_id'=>$id])->all();
            foreach ($apps as $a){
                // delete applicant
                $this->loadModel('Applicants');
                $applicants = $this->Applicants->find()->where(['application_id'=>$a->id])->all();
                foreach ($applicants as $applicant){
                    $this->Applicants->delete($applicant);
                }
                // delete app_bed
                $this->loadModel('Applications_beds_rooms');
                $app_beds = $this->Applications_beds_rooms->find()->where(['application_id'=>$a->id])->all();
                foreach ($app_beds as $ab){
                    $this->Applications_beds_rooms->delete($ab);
                }
                $this->Applications->delete($a);
            }

            if ($this->Properties->delete($property)) {

                $this->Flash->success(__('The property has been deleted.'));
            } else {
                $this->Flash->error(__('The property could not be deleted. Please, try again.'));
            }

            return $this->redirect(['controller' => 'Admins', 'action' => 'property_manage']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $property = $this->Properties->get($id);



     //   debug($rents);
     //   debug($count);
      //  debug("DELETION BEGIN");
      //  exit;

        if ($this->Properties->delete($property)) {


            $this->Flash->success(__('The property has been deleted.'));
        } else {
            $this->Flash->error(__('The property could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
