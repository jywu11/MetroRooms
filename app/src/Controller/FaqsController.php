<?php
namespace App\Controller;

use App\Controller\AppController;
/**
 * Faqs Controller
 *
 * @property \App\Model\Table\FaqsTable $Faqs
 *
 * @method \App\Model\Entity\Faq[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FaqsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $faqs = $this->Faqs->find()->all();

        $this->set(compact('faqs'));


        $this->loadModel('Frontcontents');
        $f = $this->Frontcontents->find()->all();
        $a = null;
        foreach ($f as $ah){
            $a = $ah;
            break;
        }
        $this->set('frontcontent', $ah);

    }

    /**
     * View method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view()
    {
        $faqs = $this->Faqs->find()->all();

        $this->set('faqs', $faqs);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $faq = $this->Faqs->newEntity();
        if ($this->request->is('post')) {
            $faq = $this->Faqs->patchEntity($faq, $this->request->getData());
            if ($this->Faqs->save($faq)) {
                $this->Flash->success(__('The faq has been saved.'));

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error(__('The faq could not be saved. Please, try again.'));
        }
        $this->set(compact('faq'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $faq = $this->Faqs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $faq = $this->Faqs->patchEntity($faq, $this->request->getData());

            if ($this->Faqs->save($faq)) {
                $this->Flash->success(__('The faq has been saved.'));

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error(__('The Faq could not be saved. Please, try again.'));
        }
        $this->set(compact('faq'));

    }

    /**
     * Delete method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $faq = $this->Faqs->get($id);
        if ($this->Faqs->delete($faq)) {
            $this->Flash->success(__('The faq has been deleted.'));
        } else {
            $this->Flash->error(__('The faq could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'view']);
    }

    public function frontcontents()
    {
        $this->redirect(['controller' => 'Frontcontents', 'action' => 'index']);
    }

    public function aboutus()
    {
        $this->loadModel('Frontcontents');
        $f = $this->Frontcontents->find()->all();
        $a = null;
        foreach ($f as $ah){
            $a = $ah;
            break;
        }
        $this->set('frontcontent', $ah);
    }

    public function contactus()
    {
        $this->loadModel('Frontcontents');
        $f = $this->Frontcontents->find()->all();
        $a = null;
        foreach ($f as $ah){
            $a = $ah;
            break;
        }
        $this->set('frontcontent', $ah);
    }
}
