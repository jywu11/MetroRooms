<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RoomImages Controller
 *
 * @property \App\Model\Table\RoomImagesTable $RoomImages
 *
 * @method \App\Model\Entity\RoomImage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoomImagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Properties', 'Rooms']
        ];
        $roomImages = $this->paginate($this->RoomImages);

        $this->set(compact('roomImages'));
    }

    /**
     * View method
     *
     * @param string|null $id Room Image id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roomImage = $this->RoomImages->get($id, [
            'contain' => ['Properties', 'Rooms']
        ]);

        $this->set('roomImage', $roomImage);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roomImage = $this->RoomImages->newEntity();
        if ($this->request->is('post')) {
            $roomImage = $this->RoomImages->patchEntity($roomImage, $this->request->getData());
            if ($this->RoomImages->save($roomImage)) {
                $this->Flash->success(__('The room image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The room image could not be saved. Please, try again.'));
        }
        $properties = $this->RoomImages->Properties->find('list', ['limit' => 200]);
        $rooms = $this->RoomImages->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('roomImage', 'properties', 'rooms'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Room Image id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roomImage = $this->RoomImages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roomImage = $this->RoomImages->patchEntity($roomImage, $this->request->getData());
            if ($this->RoomImages->save($roomImage)) {
                $this->Flash->success(__('The room image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The room image could not be saved. Please, try again.'));
        }
        $properties = $this->RoomImages->Properties->find('list', ['limit' => 200]);
        $rooms = $this->RoomImages->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('roomImage', 'properties', 'rooms'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Room Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roomImage = $this->RoomImages->get($id);
        if ($this->RoomImages->delete($roomImage)) {
            $this->Flash->success(__('The room image has been deleted.'));
        } else {
            $this->Flash->error(__('The room image could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
