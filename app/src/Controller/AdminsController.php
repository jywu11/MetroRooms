<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     *
     * Admin panel home page: listing all properties with operation options
     */


    public function cpanel()
    {
        /*
         * ADMIN DASHBOARD
         */
        // retrieve all properties and passed to Admins/cpanel.ctp
        $this->loadModel('Properties');
        $properties = $this->Properties->find('all')->where(['property_status' => 0]);

        $this->loadModel('Applications');
        $applications = $this->Applications->find('all', ['order'=>'create_date'])->where(['application_status' => 'p']);


        $this->loadModel('Rentals');
        $rentals = $this->Rentals->find('all')->where(['rental_status' => 1]);


        $this->set('properties', $properties);
        $this->set('applications', $applications);
        $this->set('rentals', $rentals);
        //$admins = $this->paginate($this->Admins);
        //$this->set(compact('admins'));
    }

    public function applicationManage()
    {
        /*
         * APPLICATION MANAGEMENT LISTINGS
         */
        // retrieve all properties and passed to Admins/cpanel.ctp
        $this->loadModel('Applications');
        $processing_applications = $this->Applications->find('all', ['order'=> 'Applications.create_date DESC'])->contain(['Properties', 'Rooms'])->where(['application_status'=>'p']);

        $interviewing_applications =  $this->Applications->find('all', ['order'=> 'Applications.create_date DESC'])->contain(['Properties', 'Rooms'])->where(['application_status' => 'i']);

        $accepted_applications = $this->Applications->find('all', ['order'=> 'Applications.create_date DESC'])->contain(['Properties', 'Rooms'])->where(['application_status' => 'a']);

        $archived_applications = $this->Applications->find('all', ['order'=> 'Applications.create_date DESC'])->contain(['Properties', 'Rooms'])->where(['application_status' => 'd']);

        $applications = $this->Applications->find('all', ['order'=> 'Applications.create_date DESC'])->contain(['Properties', 'Rooms']);
        // order'=>array('FIELD(Login.profile_type, "basic", "premium") DESC')

        //debug($applications);

        // retrieve property and room
       /*
        $this->loadModel('Items');
        $q = $this->Items->find('all')->where(['location !=' => 'b']);
        $this->set('itemDetails',  $this->paginate($q));*/


        $this->set('processing_applications', $processing_applications);
        $this->set('interviewing_applications', $interviewing_applications);
        $this->set('accepted_applications', $accepted_applications);
        $this->set('archived_applications', $archived_applications);
        $this->set('applications', $applications);
        //$admins = $this->paginate($this->Admins);
        //$this->set(compact('admins'));
    }

    public function propertyManage(){
        /*
         * PROPERTY MANAGEMENT LISTINGS
         */
        // retrieve all properties and passed to proeprty managment.ctp
        $this->loadModel('Properties');
        $properties = $this->Properties->find('all', ['order'=>'create_date'])->contain(['Rooms'])->where(['property_status' => 0]);
        $a_properties = $this->Properties->find('all', ['order'=>'create_date'])->contain(['Rooms'])->where(['property_status'=> 1]);


        $this->set('properties', $properties);
        $this->set('a_properties', $a_properties);
        //$admins = $this->paginate($this->Admins);
        //$this->set(compact('admins'));
    }

    public function vp($id=null)
    {
        /*
         * NOT USED
         */
        // redirect to property. a_v_p (admin view property)
        $this->redirect(['controller' => 'Properties', 'action' => 'adminView'], $id);
    }

    public function ep($id=null)
    {
        /*
         * NOT USED
         */
        // redirect to property
        $this->redirect(['controller' => 'Properties', 'action' => 'adminEdit', $id]);
    }

    public function dp($id=null)
    {
        // redirect to property
        $this->redirect(['controller' => 'Properties', 'action' => 'adminDelete', $id]);
    }

    public function cp()
    {
        /*
         * NOT USED
         */
        // redirect to property
        $this->redirect(['controller' => 'Properties', 'action' => 'adminAdd']);
    }

    /**
     * View method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        /*
         * NOT USED
         */
        $admin = $this->Admins->get($id, [
            'contain' => []
        ]);

        $this->set('admin', $admin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $admin = $this->Admins->newEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'cpanel']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $admin = $this->Admins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['controller' => 'Admins','action' => 'cpanel']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admins->get($id);
        if ($this->Admins->delete($admin)) {
            $this->Flash->success(__('The admin has been deleted.'));
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'cpanel']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
//                return $this->redirect(['action' => 'cpanel']);
                return $this->redirect(['controller' => 'Admins', 'action' => 'cpanel']);
            }else{
                $this->Flash->error('Your username or password is incorrect.');
            }
        }
    }
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['logout']);
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());

    }

    public function featureManage(){
        $this->redirect(['controller' => 'Features', 'action' => 'index']);
    }
}
