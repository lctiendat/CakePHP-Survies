<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

         // CRUD CATEGORY


    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Category');
        $this->loadComponent('Home');
        $this->loadComponent('Auth');
    }
    public function index()
    {
        $this->isAdmin();
        $categories = $this->paginate($this->{'Category'}->getAllCategory(), ['limit' => '10']);
        if ($this->request->is('POST')) {
            $key = $this->request->getData('key');
            if ($key == '') {
                $this->set(compact('categories'));
            } else {
                $result = $this->{'Home'}->search($key, 'Categories', 'name');
                if ($result == []) {
                    $this->Flash->error(__('Dữ liệu bạn tìm kiếm không có sẵn'));
                } else {
                    $this->set(compact('result'));
                }
            }
        }
        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $category = $this->Categories->get($id, [
    //         'contain' => ['Survies'],
    //     ]);

    //     $this->set(compact('category'));
    // }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->isAdmin();
        if ($this->request->is('post')) {
            $name = $this->request->getData('name');
            $created = date('Y-m-d h:m:s');
            $modified = date('Y-m-d h:m:s');
            $data = ['name' => $name, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')];
            $result = $this->{'Category'}->handelAddCategory($data);
            $errors = '';
            if ($result['result'] == 'invalid') {
                $errors = $result['data'];
                $this->set(compact('errors'));
            } else {
                $this->Flash->success(__($result['message']));
                return $this->redirect(['action' => 'index']);
            }
        }
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
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Categories');
        if (count($errorPage) == 0) {
            return $this->redirect('404page');
        }
        $category = $this->{'Category'}->getCategoryById($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $name = $this->request->getData('name');
            $modified = date('Y-m-d h:m:s');
            $data = ['name' => $name, 'modified' => date('Y-m-d H:m:s')];
            $result = $this->{'Category'}->handelEditCategory($id, $data);
            $errors = '';
            if ($result['result'] == 'invalid') {
                $errors = $result['data'];
                $this->set(compact('errors'));
            } else {
                $this->Flash->success(__('Chỉnh sửa Category thành công'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('category'));
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
            $getIssetCategory = $this->{'Category'}->getIssetCategory($id);
            if (count($getIssetCategory) > 0) {
                $this->Flash->error(__('Category này đang có Survey, không được phép xóa'));
                return $this->redirect(['action' => 'index']);
            } else {
                $result = $this->{'Category'}->deleteSoftCategory($id);
                if ($result == true) {
                    $this->Flash->success(__('Xóa Category thành công'));
                } else {
                    $this->Flash->error(__('Có lỗi xảy ra'));
                }
                return $this->redirect(['action' => 'index']);
            }
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
