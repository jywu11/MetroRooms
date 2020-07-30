<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PropertyImages Controller
 *
 * @property \App\Model\Table\PropertyImagesTable $PropertyImages
 *
 * @method \App\Model\Entity\PropertyImage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PropertyImagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function initialize(){
        parent::initialize();
        $this->loadModel('PropertyImages');
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Properties']
        ];
        $propertyImages = $this->paginate($this->PropertyImages);

        $this->set(compact('propertyImages'));
    }

    /**
     * View method
     *
     * @param string|null $id Property Image id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $propertyImage = $this->PropertyImages->get($id, [
            'contain' => ['Properties']
        ]);

        $this->set('propertyImage', $propertyImage);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $propertyImage = $this->PropertyImages->newEntity();
        if ($this->request->is('post')) {
            $propertyImage = $this->PropertyImages->patchEntity($propertyImage, $this->request->getData());
            if ($this->PropertyImages->save($propertyImage)) {
                $this->Flash->success(__('The property image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The property image could not be saved. Please, try again.'));
        }
        $properties = $this->PropertyImages->Properties->find('list', ['limit' => 200]);
        $this->set(compact('propertyImage', 'properties'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Property Image id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $propertyImage = $this->PropertyImages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $propertyImage = $this->PropertyImages->patchEntity($propertyImage, $this->request->getData());
            if ($this->PropertyImages->save($propertyImage)) {
                $this->Flash->success(__('The property image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The property image could not be saved. Please, try again.'));
        }
        $properties = $this->PropertyImages->Properties->find('list', ['limit' => 200]);
        $this->set(compact('propertyImage', 'properties'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Property Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $propertyImage = $this->PropertyImages->get($id);
        $img_name = $propertyImage->photo_name;
        if ($this->PropertyImages->delete($propertyImage)) {

            // remove the image from webroot/img folder
            $directory = WWW_ROOT . "img/";
            if (unlink($directory.DIRECTORY_SEPARATOR.$img_name)){
                debug("unlinked");
                exit;
                $this->Flash->success(__('The photo has been deleted.'));
            }else{
                $a = 1;
            }
            // end of removing image
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
        //return $this->redirect(['action' => 'index']);
    }

    public function adminEdit($pid=null){
        if ($pid==null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        else{
            $photo = '';
            if ($this->request->is('post')) {
                if (!empty($this->request->getData('file.name'))) {
                    // generate random photo prefix
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randString = '';
                    for ($i = 0; $i < 5; $i++) {
                        $randString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    // end of generate random photo name prefix

                    // apply random prefix
                    $filename = $randString.$this->request->getData('file.name');
                    $url = WWW_ROOT."img/".$filename;
                    $tmp_name = $_FILES["file"]["tmp_name"];
                    $target_dir_new = $randString.$_FILES["file"]['name'];

                    // move file to webroot directory
                    if (move_uploaded_file($tmp_name, WWW_ROOT."img/".$target_dir_new)){
                        $photo = $this->PropertyImages->newEntity();
                        $photo->photo_name = $filename;
                        $photo->photo_dir = $url;
                        $photo->property_id = $pid;
                        $this->PropertyImages->save($photo);
                        $this->room_id = $room_id;

                        // save photo info to db
                        if ($this->PropertyImages->save($photo)){
                            $this->Flash->success(__('Photo uploaded successfully'));
                            return $this->redirect(['action' => 'adminEdit', $pid]);
                        }else{
                            $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                        }
                    }else {
                        $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                    }
                }
            }
        }
        # Room Id
        $room_id = null;
        $this->set('room_id', $room_id);

        // build query for retrieving photo belongs to the property
        $query = $this->PropertyImages->find()->where(['property_id' => $pid]);
        $this->set('propertyImages', $this->paginate($query));

        // for property info
        $this->loadModel('Properties');
        $query_2 = $this->Properties->find()->where(['id' => $pid]);
        $this->set('property', $this->paginate($query_2));

        // pass new record to view
        $this->set('photo', $photo);
        $this->set('pid', $pid);
    }
}
























