<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Types Controller
 *
 * @property \App\Model\Table\TypesTable $Types
 *
 * @method \App\Model\Entity\Type[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $types = $this->Types->find()->all();
        $this->loadModel('Beds');
        $beds = $this->Beds->find()->all();
        $this->set(compact('types'));
        $this->set('beds', $beds);
    }

    /**
     * View method
     *
     * @param string|null $id Type id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $type = $this->Types->get($id, [
            'contain' => ['Properties']
        ]);

        $this->set('type', $type);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $type = $this->Types->newEntity();
        if ($this->request->is('post')) {
            $type = $this->Types->patchEntity($type, $this->request->getData());
            if ($this->Types->save($type)) {
                $this->Flash->success(__('The type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type could not be saved. Please, try again.'));
        }
        $this->set(compact('type'));
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
        $type = $this->Types->get($id, [
            'contain' => ['Properties']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $type = $this->Types->patchEntity($type, $this->request->getData());
            if ($this->Types->save($type)) {
                $this->Flash->success(__('The type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The type could not be saved. Please, try again.'));
        }
        $this->set(compact('type'));
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
        $type = $this->Types->get($id);
        if ($this->Types->delete($type)) {
            // if type deleted, null types will be set to no type
            $q = $this->Types->find()->where(["name" => "No Type"])->all();
          //$q = $this->paginate($q);
            $null_id = null;
            foreach ($q as $a){
                $null_id = $a->id;
            }
            $this->loadModel("Properties");
            $q = $this->Properties->find()->where(["type_id IS" => null])->all();
          //  $q = $this->paginate($q);
            foreach ($q as $p){
                $p->type_id = $null_id;
                $this->Properties->save($p);
            }
            $this->Flash->success(__('The type has been deleted.'));
        } else {
            $this->Flash->error(__('The type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function feature(){
        $this->redirect("/features/index");
    }
}
