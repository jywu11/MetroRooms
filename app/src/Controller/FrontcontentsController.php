<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * Frontcontents Controller
 *
 * @property \App\Model\Table\FrontcontentsTable $Frontcontents
 *
 * @method \App\Model\Entity\Frontcontent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FrontcontentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $frontcontents = $this->paginate($this->Frontcontents);
        $frontcontent = null;
        foreach ($frontcontents as $fc){
            $frontcontent = $fc;
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $frontcontent = $this->Frontcontents->patchEntity($frontcontent, $this->request->getData());
            // see if this is a delete request
            if ($this->request->getData("DELETE_FLAG")!= null){
                $flag = $this->request->getData("DELETE_FLAG");
                if ($flag == 'display_photo'){
                    $old_name = $frontcontent->abt_person_image;
                    // remove image
                    $directory = WWW_ROOT."/img/";
                    if (unlink($directory.DIRECTORY_SEPARATOR.$old_name)){
                        $frontcontent->abt_person_image = null;
                        if ($this->Frontcontents->save($frontcontent)){
                            $this->Flash->success(__('The photo has been cleared out.'));
                            $this->redirect($this->referer());
                        }else{
                            $this->Flash->error(__('The photo has been removed but the photo record was unable to be deleted from the system. Please contact an IT consultant.'));
                            $this->redirect($this->referer());
                        }
                    }else{
                        $this->Flash->error(__('The photo could not be cleared. Please, try again.'));
                        $this->redirect($this->referer());
                    }
                }
                elseif ($flag == 'business_logo'){
                    $old_name = $frontcontent->top_foot_logo;
                    // remove image
                    $directory = WWW_ROOT."/img/";
                    if (unlink($directory.DIRECTORY_SEPARATOR.$old_name)){
                        $frontcontent->top_foot_logo = null;
                        if ($this->Frontcontents->save($frontcontent)){
                            $this->Flash->success(__('The photo has been cleared out.'));
                            $this->redirect($this->referer());
                        }else{
                            $this->Flash->error(__('The photo has been removed but the photo record was unable to be deleted from the system. Please contact an IT consultant.'));
                            $this->redirect($this->referer());
                        }
                    }else{
                        $this->Flash->error(__('The photo could not be cleared. Please, try again.'));
                        $this->redirect($this->referer());
                    }
                }
                elseif ($flag == 'banner_image'){
                    $old_name = $frontcontent->banner_image;
                    // remove image
                    $directory = WWW_ROOT."/img/";
                    if (unlink($directory.DIRECTORY_SEPARATOR.$old_name)){
                        $frontcontent->banner_image = null;
                        if ($this->Frontcontents->save($frontcontent)){
                            $this->Flash->success(__('The photo has been cleared out.'));
                            $this->redirect($this->referer());
                        }else{
                            $this->Flash->error(__('The photo has been removed but the photo record was unable to be deleted from the system. Please contact an IT consultant.'));
                            $this->redirect($this->referer());
                        }
                    }else{
                        $this->Flash->error(__('The photo could not be cleared. Please, try again.'));
                        $this->redirect($this->referer());
                    }
                }
            }

            else{
                // check which image is it storing
                if ($this->request->getData()['file']['tmp_name'] != ''){
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
                        $flag = 0;
                        switch($file_parts['extension'])
                        {
                            case "jpg":
                                $flag = 1;
                                break;

                            case "png":
                                $flag = 1;
                                break;

                            case "jpeg":
                                $flag = 1;
                                break;

                            case "": // Handle file extension for files ending in '.'
                            case NULL: // Handle no file extension
                                $this->Flash->error(__('Please choose a file before submit'));
                                return $this->redirect(['action' => 'index']);
                        }
                        if ($flag == 0){
                            $this->Flash->error(__('Please choose a valid file type. We accept .jpg and .png.'));
                            return $this->redirect(['action' => 'index']);
                        }

                        // after passing validation
                        $tmp_name = $_FILES["file"]["tmp_name"];
                        $target_dir_new = $randString.$_FILES["file"]['name'];
                        if ($this->request->getData('IMG_FLAG') == 'display_photo'){
                            if (move_uploaded_file($tmp_name, WWW_ROOT."img/".$target_dir_new)){
                                $frontcontent->abt_person_image = $filename;
                                if ($this->Frontcontents->save($frontcontent)){
                                    $this->Flash->success(__('Photo uploaded successfully'));
                                    return $this->redirect(['action' => 'index#about_us']);
                                }else{
                                    $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                                    return $this->redirect(['action' => 'index#about_us']);
                                }
                            }else{
                                $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                                return $this->redirect(['controller' => 'Frontcontents']);
                            }
                        }
                        elseif ($this->request->getData('IMG_FLAG') == 'business_logo'){
                            if (move_uploaded_file($tmp_name, WWW_ROOT."img/".$target_dir_new)){
                                $frontcontent->top_foot_logo = $filename;
                                if ($this->Frontcontents->save($frontcontent)){
                                    $this->Flash->success(__('Photo uploaded successfully'));
                                    return $this->redirect(['action' => 'index#general_site_content']);
                                }else{
                                    $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                                    return $this->redirect(['action' => 'index#general_site_content']);
                                }
                            }else{
                                $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                                return $this->redirect(['controller' => 'Frontcontents']);
                            }
                        }elseif ($this->request->getData('IMG_FLAG') == 'banner_image'){
                            if (move_uploaded_file($tmp_name, WWW_ROOT."img/".$target_dir_new)){
                                $frontcontent->banner_image = $filename;
                                if ($this->Frontcontents->save($frontcontent)){
                                    $this->Flash->success(__('Photo uploaded successfully'));
                                    return $this->redirect(['action' => 'index#general_site_content']);
                                }else{
                                    $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                                    return $this->redirect(['action' => 'index#general_site_content']);
                                }
                            }else{
                                $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                                return $this->redirect(['controller' => 'Frontcontents']);
                            }
                        }
                    }
                }
                else{
                    $this->Flash->error(__('Fail to upload, keep your photo size under 2M'));
                    return $this->redirect(['controller' => 'Frontcontents']);
                }
            }
        }

        $this->set(compact('frontcontent'));
    }

    /**
     * View method
     *
     * @param string|null $id Frontcontent id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $frontcontent = $this->Frontcontents->get($id, [
            'contain' => []
        ]);

        $this->set('frontcontent', $frontcontent);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $frontcontent = $this->Frontcontents->newEntity();
        if ($this->request->is('post')) {
            $frontcontent = $this->Frontcontents->patchEntity($frontcontent, $this->request->getData());
            if ($this->Frontcontents->save($frontcontent)) {
                $this->Flash->success(__('The frontcontent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The frontcontent could not be saved. Please, try again.'));
        }
        $this->set(compact('frontcontent'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Frontcontent id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $frontcontent = $this->Frontcontents->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $frontcontent = $this->Frontcontents->patchEntity($frontcontent, $this->request->getData());

            if ($this->Frontcontents->save($frontcontent)) {
                $this->Flash->success(__('The Frontend Content has been updated.'));

                return $this->redirect(['controller' => 'Frontcontents', 'action' => 'index']);
            }
            $this->Flash->error(__('The Frontend Content could not be saved. Please, try again.'));
            return $this->redirect(['controller' => 'Frontcontents',  'action' => 'index']);
        }

        $this->set(compact('frontcontent'));

    }

    /**
     * Delete method
     *
     * @param string|null $id Frontcontent id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $frontcontent = $this->Frontcontents->get($id);
        if ($this->Frontcontents->delete($frontcontent)) {
            $this->Flash->success(__('The frontcontent has been deleted.'));
        } else {
            $this->Flash->error(__('The frontcontent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function faqs(){
        $this->redirect('/faqs/view');
    }

}
