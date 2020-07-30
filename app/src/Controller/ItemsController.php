<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $items = $this->Items->find()->all();

        $this->set(compact('items'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Categories', 'Properties', 'Rooms']
        ]);

        $this->set('item', $item);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            // format location
            if ($item->location == '0'){
                $item->location = 'b';
            }else if ($item->location == '1'){
                $item->location = 'p';
            }else{
                $item->location = 'a';
            }

            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
       /* $categories = $this->Items->Categories->find('list', ['limit' => 200]);*/
        $properties = $this->Items->Properties->find('list', ['limit' => 200]);
        $rooms = $this->Items->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('item', 'properties', 'rooms'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Properties', 'Rooms']
        ]);
        $old_loc = $item->location;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($item->location == '0'){
                $item->location = 'b';
            }else if ($item->location == '1'){
                $item->location = 'p';
            }else{
                $item->location = 'a';
            }

            // save item information
            if ($this->Items->save($item)) {
                // AFTER item info saved when item's location changed, remove records for property_item and room_item accordingly
                $new_loc = $item->location;
                if ($old_loc == 'b' && $new_loc == 'p'){
                    // delete all bedroom record
                    //debug("here");
                    //exit;
                    $this->loadModel("Items_rooms");
                    $r = $this->Items_rooms->find()->where(['item_id' => $item->id])->all();
                   // $r = $this->paginate($r);
                    foreach ($r as $to_delete){
                        //debug("will delete");
                        $this->Items_rooms->delete($to_delete);
                    }
                    //exit;
                }else if ($old_loc == 'p' && $new_loc == 'b'){
                    // delete all public record
                    $this->loadModel("Properties_items");
                    $p = $this->Properties_items->find()->where(['item_id' => $item->id])->all();
                 // $p = $this->paginate($p);
                    foreach ($p as $to_delete){
                        $this->Properties_items->delete($to_delete);
                    }
                }else if ($old_loc == 'a' && $new_loc == 'b'){
                    // delete all public record
                    $this->loadModel("Properties_items");
                    $p = $this->Properties_items->find()->where(['item_id' => $item->id])->all();
              //    $p = $this->paginate($p);
                    foreach ($p as $to_delete){
                        $this->Properties_items->delete($to_delete);
                    }
                } else if ($old_loc == 'a' && $new_loc == 'p'){
                    // delete all bedroom record
                    $this->loadModel("Items_rooms");
                    $r = $this->Items_rooms->find()->where(['item_id' => $item->id])->all();
          //        $r = $this->paginate($r);
                    foreach ($r as $to_delete){
                        $this->Items_rooms->delete($to_delete);
                    }
                }




                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        /*$categories = $this->Items->Categories->find('list', ['limit' => 200]);*/
        $this->loadModel("Properties");
        $properties_all = $this->Properties->find()->all();
       //$properties_all = $this->paginate($properties_all_q);
        $this->set('properties_all', $properties_all);
        $properties = $this->Items->Properties->find('list', ['limit' => 200]);
        $rooms = $this->Items->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('item',  'properties', 'rooms'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function feature()
    {
        $this->redirect(['controller' => 'Features', 'action' => 'index']);
    }

    public function faq()
    {
        $this->redirect(['controller' => 'Faqs', 'action' => 'view']);
    }

    public function frontend(){
        $this->redirect(['controller' => 'Frontends', 'action' => 'index']);
    }

    public function others(){
        $this->redirect(['controller' => 'Types', 'action' => 'index']);
    }
}
