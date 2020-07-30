<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Beds Controller
 *
 * @property \App\Model\Table\BedsTable $Beds
 *
 * @method \App\Model\Entity\Bed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BedsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $beds = $this->Beds->find()->all();

        $this->set(compact('beds'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bed = $this->Beds->newEntity();
        if ($this->request->is('post')) {
            $bed = $this->Beds->patchEntity($bed, $this->request->getData());
            if ($this->Beds->save($bed)) {
                $this->Flash->success(__('The bed has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The bed could not be saved. Please, try again.'));
        }
        $this->set(compact('bed'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bed = $this->Beds->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bed = $this->Beds->patchEntity($bed, $this->request->getData());
            if ($this->Beds->save($bed)) {
                // change all capacity for beds_room
                $this->loadModel('Beds_rooms');
                $res = $this->paginate($this->Beds_rooms->find('all')->where(['bed_id'=> $bed->id]));
                foreach ($res as $r){
                    $r->capacity = $bed->capacity;
                    if ($this->Beds_rooms->save($r)){
                        $a = 0;
                    }else{
                        $this->Flash->error(__('The bed type is saved but there is something wrong updating this nre information for the created beds under the rooms. Please try again.'));
                        $this->redirect($this->referer());
                    }
                }

                $this->Flash->success(__('The bed has been saved.'));

                return $this->redirect(['controller'=>'Types', 'action'=> 'index']);
            }
            $this->Flash->error(__('The bed could not be saved. Please, try again.'));
        }
        $this->set(compact('bed'));

        $this->loadModel('Rooms');
        $res = $this->Rooms->find()->all();
        $this->set('rooms', $res);

        $this->loadModel ('Properties');
        $res = $this->Properties->find()->all();
        $this->set('properties', $res);

        $this->loadModel ('Beds_rooms');
        $res = $this->Beds_rooms->find()->where(['bed_id'=>$id])->all();
        $this->set('brs', $res);


    }

    /**
     * Delete method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bed = $this->Beds->get($id);
        // if there's room's using this bed, cannot delete

        $this->loadModel('Beds_rooms');
        $res = $this->Beds_rooms->find()->where(['bed_id'=>$id])->all();
        foreach ($res as $re){
            if ($re->occupied != 0){
                $this->Flash->error(__('Cannot delete this Bed Type.The Bed Type is currently being used by one or more of your rentals.</br>You will need to expire those rentals first or update the bed type instead of delete.'));
                return $this->redirect($this->referer());
            }

        }

        if ($this->Beds->delete($bed)) {
            $this->Flash->success(__('The bed has been deleted.'));
        } else {
            $this->Flash->error(__('The bed could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
