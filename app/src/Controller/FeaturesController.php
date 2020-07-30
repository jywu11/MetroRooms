<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Features Controller
 *
 * @property \App\Model\Table\FeaturesTable $Features
 *
 * @method \App\Model\Entity\Feature[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeaturesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $features = $this->Features->find()->all();

        $this->set(compact('features'));

        $this->loadModel('faqs');

        $faqs = $this->faqs->find()->all();

        $this->set('faqs', $faqs);

        $this->loadModel('items');

        $items = $this->items->find()->contain(['Categories']);

        $this->set('items', $items);
    }

    public function item()
    {
        $this->redirect(['controller' => 'Items', 'action' => 'index']);
    }

    public function faq()
    {
        $this->redirect(['controller' => 'Faqs', 'action' => 'view']);
    }

    public function frontend(){
        $this->redirect(['controller' => 'Frontends', 'action' => 'index']);
    }
    /**
     * View method
     *
     * @param string|null $id Feature id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        /*
         * NOT USED
         */
        $feature = $this->Features->get($id, [
            'contain' => ['Properties']
        ]);

        $this->set('feature', $feature);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $feature = $this->Features->newEntity();
        if ($this->request->is('post')) {
            $feature = $this->Features->patchEntity($feature, $this->request->getData());
            if ($this->Features->save($feature)) {
                $this->Flash->success(__('The feature has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feature could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
        $properties = $this->Features->Properties->find('list', ['limit' => 200]);
        $this->set(compact('feature', 'properties'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Feature id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        //debug($id);
    //exit;
        $feature = $this->Features->get($id, [
            'contain' => ['Properties']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $feature = $this->Features->patchEntity($feature, $this->request->getData());

            if ($this->Features->save($feature)) {
                $this->Flash->success(__('The feature has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feature could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
        $properties = $this->Features->Properties->find('list', ['limit' => 200]);
        $this->set(compact('feature', 'properties'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Feature id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $feature = $this->Features->get($id);
        if ($this->Features->delete($feature)) {
            $this->Flash->success(__('The feature has been deleted.'));
        } else {
            $this->Flash->error(__('The feature could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function others (){
        $this->redirect(['controller' => 'Types', 'action' => 'index']);
    }
}
