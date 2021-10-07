<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Session;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\RedirectRoute;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    // CRUD USER

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Auth');
        $this->loadComponent('Home');
    }
    public function index()
    {
        $this->isAdmin();
        $users =  $this->paginate($this->{'Auth'}->getAllUser(), ['limit' => '10']);
        if ($this->request->is('POST')) {
            $key = $this->request->getData('key');
            if ($key == '') {
                $this->set(compact('users'));
            } else {
                $result = $this->{'Home'}->search($key, 'Users', 'email');
                if ($result == []) {
                    $this->Flash->error(__('Dữ liệu bạn tìm kiếm không có sẵn'));
                } else {
                    $this->set(compact('result'));
                }
            }
        }
        $this->set(compact('users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->isAdmin();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Users');
        if (count($errorPage) == 0) {
            return $this->redirect('404page');
        }
        $user = $this->{'Auth'}->queryUserById($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $phone = $this->request->getData('phone');
            $address = $this->request->getData('address');
            $password = $this->request->getData('password');
            $status = $this->request->getData('status');
            $role = $this->request->getData('role');
            $data = ['phone' => $phone, 'address' => $address, 'password' => $password, 'status' => $status, 'role' => $role, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')];
            $result = $this->{'Auth'}->handelEditUser($id, $data);
            $errors = '';
            if ($result['result'] == 'invalid') {
                $errors = $result['data'];
                $this->set(compact('errors'));
            } else {
                $this->Flash->success(__('Cập nhật User thành công'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->isAdmin();
        if ($this->request->is(['POST', 'DELETE'])) {
            $result = $this->{'Auth'}->handelDeleteUser($id);
            if ($result == true) {
                $this->Flash->success(__('Xóa User thành công'));
            } else {
                $this->Flash->error(__('Xóa User thất bại'));
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
