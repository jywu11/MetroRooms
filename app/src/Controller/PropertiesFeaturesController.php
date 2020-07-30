<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PropertiesFeatures Controller
 *
 * @property \App\Model\Table\PropertiesFeaturesTable $PropertiesFeatures
 *
 * @method \App\Model\Entity\PropertiesFeature[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PropertiesFeaturesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Properties', 'Features']
        ];
        $propertiesFeatures = $this->PropertiesFeatures->find()->all();

        $this->set(compact('propertiesFeatures'));
    }

    /**
     * View method
     *
     * @param string|null $id Properties Feature id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $propertiesFeature = $this->PropertiesFeatures->get($id, [
            'contain' => ['Properties', 'Features']
        ]);

        $this->set('propertiesFeature', $propertiesFeature);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $propertiesFeature = $this->PropertiesFeatures->newEntity();
        if ($this->request->is('post')) {
            $propertiesFeature = $this->PropertiesFeatures->patchEntity($propertiesFeature, $this->request->getData());
            if ($this->PropertiesFeatures->save($propertiesFeature)) {
                $this->Flash->success(__('The properties feature has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The properties feature could not be saved. Please, try again.'));
        }
        $properties = $this->PropertiesFeatures->Properties->find('list', ['limit' => 200]);
        $features = $this->PropertiesFeatures->Features->find('list', ['limit' => 200]);
        $this->set(compact('propertiesFeature', 'properties', 'features'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Properties Feature id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $propertiesFeature = $this->PropertiesFeatures->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $propertiesFeature = $this->PropertiesFeatures->patchEntity($propertiesFeature, $this->request->getData());
            if ($this->PropertiesFeatures->save($propertiesFeature)) {
                $this->Flash->success(__('The properties feature has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The properties feature could not be saved. Please, try again.'));
        }
        $properties = $this->PropertiesFeatures->Properties->find('list', ['limit' => 200]);
        $features = $this->PropertiesFeatures->Features->find('list', ['limit' => 200]);
        $this->set(compact('propertiesFeature', 'properties', 'features'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Properties Feature id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $propertiesFeature = $this->PropertiesFeatures->get($id);
        if ($this->PropertiesFeatures->delete($propertiesFeature)) {
            $this->Flash->success(__('The properties feature has been deleted.'));
        } else {
            $this->Flash->error(__('The properties feature could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
