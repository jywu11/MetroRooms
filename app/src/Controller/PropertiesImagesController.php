<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PropertiesImages Controller
 *
 * @property \App\Model\Table\PropertiesImagesTable $PropertiesImages
 *
 * @method \App\Model\Entity\PropertiesImage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PropertiesImagesController extends AppController
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
        $propertiesImages = $this->PropertiesImages->find()->all();

        $this->set(compact('propertiesImages'));
    }

    /**
     * View method
     *
     * @param string|null $id Properties Image id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $propertiesImage = $this->PropertiesImages->get($id, [
            'contain' => ['Properties', 'Rooms']
        ]);

        $this->set('propertiesImage', $propertiesImage);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $propertiesImage = $this->PropertiesImages->newEntity();
        if ($this->request->is('post')) {
            $propertiesImage = $this->PropertiesImages->patchEntity($propertiesImage, $this->request->getData());
            if ($this->PropertiesImages->save($propertiesImage)) {
                $this->Flash->success(__('The properties image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The properties image could not be saved. Please, try again.'));
        }
        $properties = $this->PropertiesImages->Properties->find('list', ['limit' => 200]);
        $rooms = $this->PropertiesImages->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('propertiesImage', 'properties', 'rooms'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Properties Image id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $propertiesImage = $this->PropertiesImages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $propertiesImage = $this->PropertiesImages->patchEntity($propertiesImage, $this->request->getData());
            if ($this->PropertiesImages->save($propertiesImage)) {
                $this->Flash->success(__('The properties image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The properties image could not be saved. Please, try again.'));
        }
        $properties = $this->PropertiesImages->Properties->find('list', ['limit' => 200]);
        $rooms = $this->PropertiesImages->Rooms->find('list', ['limit' => 200]);
        $this->set(compact('propertiesImage', 'properties', 'rooms'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Properties Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $propertyImage = $this->PropertiesImages->get($id);
        $img_name = $propertyImage->photo_name;
        if ($this->PropertiesImages->delete($propertyImage)) {

            // remove the image from webroot/img folder
            if ($propertyImage->room_id == null){
                $directory = WWW_ROOT."/img/property/".$propertyImage->property_id."/";
            }else{
                $directory = WWW_ROOT."/img/property/".$propertyImage->property_id."/room/".$propertyImage->room_id."/";
            }

            if (unlink($directory.DIRECTORY_SEPARATOR.$img_name)){
                $this->Flash->success(__('The photo has been deleted.'));
            }else{
                $this->Flash->error(__('The photo could not be found, and it is removed from the database.'));
            }
            // end of removing image
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }


    public function adminEdit($pid=null){
        if ($pid==null){
            $this->viewBuilder()->setTemplate('\Error\my_error');
        }
        else{
            $photo = '';
            // $my_room_id = null;
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

                    // file extension validation
                    $file_parts = pathinfo($filename);
                    //debug($file_parts);
                    //debug($file_parts['extension']);
                    $flag = 0;
                    switch($file_parts['extension'])
                    {
                        case "jpg":
                            $flag = 1;
                            break;

                        case "png":
                            $flag = 1;
                            break;

                        case "jfif":
                            $flag = 1;
                            break;

                        case "jpeg":
                            $flag = 1;
                            break;

                        case "": // Handle file extension for files ending in '.'
                        case NULL: // Handle no file extension
                            $this->Flash->error(__('Please choose a file before submit'));
                            return $this->redirect(['action' => 'adminEdit', $pid]);
                    }
                    if ($flag == 0){
                        $this->Flash->error(__('Please choose a valid file type. We accept .jpg and .png.'));
                        return $this->redirect(['action' => 'adminEdit', $pid]);
                    }

                    $tmp_name = $_FILES["file"]["tmp_name"];
                    $target_dir_new = $randString.$_FILES["file"]['name'];
                    // end og apply random prefix

                    if ($this->request->getData('room_id') != ''){
                        // webroot/img/property/p_id/room/r_id - ROOM IMAGE
                        if (!file_exists(WWW_ROOT.'img/property/'.$pid.'/room/'.$this->request->getData('room_id')."/")) {
                            mkdir(WWW_ROOT.'img/property/'.$pid.'/room/'.$this->request->getData('room_id')."/", 0777, true);
                        }
                        $url = '/webroot/img/property/'.$pid.'/room/'.$this->request->getData('room_id')."/";
                        if (move_uploaded_file($tmp_name, WWW_ROOT."img/property/".$pid.'/room/'.$this->request->getData('room_id').'/'.$target_dir_new)){
                            $photo = $this->PropertiesImages->newEntity();
                            $photo->photo_name = $filename;
                            $photo->photo_dir = $url;
                            $photo->property_id = $pid;
                            $photo->room_id = $this->request->getData('room_id');
                            // save photo info to db
                            if ($this->PropertiesImages->save($photo)){
                                $this->Flash->success(__('Photo uploaded successfully'));
                                return $this->redirect(['action' => 'adminEdit', $pid]);
                            }else{
                                $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                                return $this->redirect(['action' => 'adminEdit', $pid]);
                            }
                        }else{
                            $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                            return $this->redirect(['action' => 'adminEdit', $pid]);
                        }
                    }else{
                        /*debug($this->request->getData());
                        debug("property image");
                        exit;*/
                        // move file to webroot directory, webroot/img/property/p_id/ - PROPERTY IMAGE
                        if (!file_exists(WWW_ROOT.'img/property/'.$pid."/")) {
                            // debug("creating new direc");
                            mkdir(WWW_ROOT.'img/property/'.$pid."/", 0777, true);
                        }
                        $url = '/webroot/img/property/'.$pid."/";
                        if (move_uploaded_file($tmp_name, WWW_ROOT."img/property/".$pid.'/'.$target_dir_new)){
                            $photo = $this->PropertiesImages->newEntity();
                            $photo->photo_name = $filename;
                            $photo->photo_dir = $url;
                            $photo->property_id = $pid;
                            // debug($this->request->getData('room_id'));
                            // save photo info to db
                            if ($this->PropertiesImages->save($photo)){
                                $this->Flash->success(__('Photo uploaded successfully'));
                                return $this->redirect(['action' => 'adminEdit', $pid]);
                            }else{
                                $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                                return $this->redirect(['action' => 'adminEdit', $pid]);
                            }
                        }else {
                            $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                            return $this->redirect(['action' => 'adminEdit', $pid]);
                        }
                    }
                }
            }
        }

        // room
        $this->loadModel('Rooms');
        $q = $this->Rooms->find()->where(['property_id' => $pid])->all();
        //$my_rooms = $this->paginate($q);
        $this->set('rooms', $q);

        // build query for retrieving photo belongs to the property
        $query = $this->PropertiesImages->find()->where(['property_id' => $pid, 'room_id IS' => null])->all();
        //debug($query);
        //debug($this->paginate($query));
        $this->set('propertyImages', $query);

        $query = $this->PropertiesImages->find()->where(['property_id' => $pid])->all();
        $this->set('propertiesImages', $query);

        /*$my_list = array();
        $count = 0;
        foreach($my_rooms as $r){
            $q = $this->PropertiesImages->find()->where(['room_id' => $r->id]);
            $room_image = $this->paginate($q);
            $my_list[$count] = $room_image;
            $count += 1;
        }
        //debug($my_list);
        //exit;*/

        // for property info
        $this->loadModel('Properties');
        $query_2 = $this->Properties->find()->where(['id' => $pid])->all();
        $this->set('property', $query_2);

        // pass new record to view
        $this->set('photo', $photo);
        $this->set('pid', $pid);
        // $this->set('room_id', $my_room_id);
    }
}
