<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Answers Controller
 *
 * @property \App\Model\Table\AnswersTable $Answers
 * @method \App\Model\Entity\Answer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnswersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    // CRUD ANSWER

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Answer');
        $this->loadComponent('Survey');
        $this->loadComponent('Auth');
        $this->loadComponent('Home');
    }
    public function index()
    {
        $this->isAdmin();
        $answers = $this->paginate($this->{'Answer'}->getAllAnswer(), ['limit' => '10']);
        if ($this->request->is('POST')) {
            $key = $this->request->getData('key');
            if ($key == '') {
                $this->set(compact('answers'));
            } else {
                $result = $this->{'Home'}->search($key, 'Answers', 'name');
                if ($result == []) {
                    $this->Flash->error(__('Dữ liệu bạn tìm kiếm không có sẵn'));
                } else {
                    $this->set(compact('result'));
                }
            }
        }
        $this->set(compact('answers'));
    }

    /**
     * View method
     *
     * @param string|null $id Answer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $answer = $this->Answers->get($id, [
    //         'contain' => ['Surveys', 'Results'],
    //     ]);

    //     $this->set(compact('answer'));
    // }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    public function add()
    {
        $this->isAdmin();
        $survies = $this->{'Survey'}->getAllSurvey();
        if ($this->request->is('post')) {
            $data = [];
            $name = $this->request->getData('name');
            $survey_id = $this->request->getData('survey_id');
            $created = date('Y-m-d h:m:s');
            $modified = date('Y-m-d h:m:s');
            foreach ($name as $item) {
                array_push($data, ['name' => $item, 'survey_id' => $survey_id, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')]);
            }
            $result = $this->{'Answer'}->handelAddAnswer($data);
            if ($result['status'] == false) {
                $this->Flash->error(__($result['message']));
            } else {
                $this->Flash->success(__($result['message']));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact(['survies']));
    }
    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->isAdmin();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Answers');
        if (count($errorPage) == 0) {
            return $this->redirect('404page');
        }
        $answer = $this->{'Answer'}->getAnswerById($id);
        $survies = $this->{'Survey'}->getAllSurvey();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $name = $this->request->getData('name');
            $survey_id = $this->request->getData('survey_id');
            $modified = date('Y-m-d h:m:s');
            $data = ['name' => $name, 'survey_id' => $survey_id, 'modified' => date('Y-m-d H:m:s')];
            $result = $this->{'Answer'}->handelEditAnswer($id, $data);
            $errors = '';
            if ($result['result'] == 'invalid') {
                $errors = $result['data'];
                $this->set(compact('errors'));
            } else {
                $this->Flash->success(__($result['message']));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact(['survies', 'answer']));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->isAdmin();
        if ($this->request->is(['POST', 'DELETE'])) {
            $result = $this->{'Answer'}->deleteSoftAnswer($id);
            if ($result == true) {
                $this->Flash->success(__('Xóa Answer thành công'));
            } else {
                $this->Flash->error(__('Xóa Answer thất bại, vui lòng thử lại sau'));
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
