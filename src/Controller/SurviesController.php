<?php

declare(strict_types=1);

namespace App\Controller;


use Cake\ORM\TableRegistry;

/**
 * Survies Controller
 *
 * @property \App\Model\Table\SurviesTable $Survies
 * @method \App\Model\Entity\Survy[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SurviesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    // CRUD SURVEY


    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Survey');
        $this->loadComponent('Category');
        $this->loadComponent('Auth');
        $this->loadComponent('Home');
    }
    public function index()
    {
        $this->isAdmin();
        $survies = $this->paginate($this->{'Survey'}->getAllSurveyWithCategory(), ['limit' => '10']);
        if ($this->request->is('POST')) {
            $key = $this->request->getData('key');
            if ($key == '') {
                $this->set(compact('survies'));
            } else {
                $result = $this->{'Home'}->search($key, 'Survies', 'question');
                if ($result == []) {
                    $this->Flash->error(__('Dữ liệu bạn tìm kiếm không có sẵn'));
                } else {
                    $this->set(compact('result'));
                }
            }
        }
        $this->set(compact('survies'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->isAdmin();
        $session = $this->request->getSession();
        $categories = $this->{'Category'}->getAllCategory();
        $users = $this->Survies->Users->find('list', ['limit' => 200]);
        if ($this->request->is('POST')) {
            $question = $this->request->getData('question');
            $description = $this->request->getData('description');
            $category_id = $this->request->getData('category_id');
            $type_select = $this->request->getData('type_select');
            $user_id = $session->read('user_id');
            $created = date('Y-m-d h:m:s');
            $modified = date('Y-m-d h:m:s');
            $data = ['question' => $question, 'description' => $description, 'category_id' => $category_id, 'user_id' => $user_id, 'type_select' => $type_select, 'created' => $created, 'modified' => $modified];
            $result = $this->{'Survey'}->handelAddSurvey($data);
            $errors = '';
            if ($result['result'] == 'invalid') {
                $errors = $result['data'];
                $this->set(compact('errors'));
            } else {
                $this->Flash->success(__($result['message']));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('categories', 'users'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Survy id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->isAdmin();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Survies');
        if (count($errorPage) == 0) {
            return $this->redirect('404page');
        }
        $survey = $this->{'Survey'}->getSurveyById($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $question = $this->request->getData('question');
            $description = $this->request->getData('description');
            $category_id = $this->request->getData('category_id');
            $modified = date('Y-m-d h:m:s');
            $data = ['question' => $question, 'description' => $description, 'category_id' => $category_id, 'modified' => $modified];
            $result = $this->{'Survey'}->handelEditSurvey($id, $data);
            if ($result['status'] == true) {
                $this->Flash->success(__($result['message']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Chỉnh sửa không thành công'));
            }
        }
        $categories = $this->{'Category'}->getAllCategory();
        $this->set(compact('survey', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Survy id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->isAdmin();
        if ($this->request->is(['POST', 'DELETE'])) {
            //  $result = $this->{'Survey'}->handelDeleteSurvey($id);
            $result = $this->{'Survey'}->deleteSoftSurvey($id);
            if ($result == true) {
                $this->Flash->success(__($result['message']));
            } else {
                $this->Flash->error(__('Xóa Survey thất bại. Vui lòng thử lại sau.'));
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    // phân quyền admin và user
    public function isAdmin()
    {
        $session = $this->request->getSession();
        if ($session->check('role')) {
            $email = $session->read('email');
            $check_role = $this->{'Auth'}->queryUserByEmail($email);
            $role = '';
            foreach ($check_role as $item) {
                $role = $item->role;
            }
            if ($role != 2) {
                $this->Flash->error(__('Bạn không phải Quản trị viên, bạn không có quyền truy cập'));
                return $this->redirect($this->referer());
            }
        } else {
            $this->Flash->error(__('Bạn chưa đăng nhập'));
            return $this->redirect('/Auth/login');
        }
    }
}
