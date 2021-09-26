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
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Survies'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $user = $this->Users->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $user = $this->Users->patchEntity($user, $this->request->getData());
    //         if ($this->Users->save($user)) {
    //             $this->Flash->success(__('The user has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The user could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('user'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->set('Sửa người dùng thành công');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->set('Sửa người dùng thất bại thành công');
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
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function register()
    {
        if ($this->request->is('post')) {
            $email =  $this->request->getData('email');
            $phone =  $this->request->getData('phone');
            $password =  md5($this->request->getData('password'));
            $query_email = TableRegistry::getTableLocator()->get('Users')->find()->where(['email' => $email])->all();
            $query_phone = TableRegistry::getTableLocator()->get('Users')->find()->where(['phone' => $phone])->all();
            if (count($query_email) > 0) {
                // $data = array(
                //     'status' => false,
                //     'message' => 'Email đã tồn tại'
                // );
                // return json_decode($data);
            } else if (count($query_phone) > 0) {
                // $data = array(
                //     'status' => false,
                //     'message' => 'Số điện thoại đã tồn tại'
                // );
            } else {
                $save_user = TableRegistry::getTableLocator()->get('Users')->query();
                $save_user->insert(['email', 'phone', 'password', 'created', "modified"])
                    ->values(['email' => $email, 'phone' => $phone, 'password' => $password, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')])
                    ->execute();
                // return  $data = array(
                //     'status' => true,
                //     'message' => 'Đăng ký tài khoản thành công . Chuyển hướng sau 2 giây'
                // );
            }
        }
    }
    public function login()
    {
        $session = $this->request->getSession();
        if ($session->check('user_id')) {
            return $this->redirect('/');
        } else {
            if ($this->request->is('post')) {
                $email =  $this->request->getData('email');
                $password =  md5($this->request->getData('password'));
                $query = $this->Users->find()->where(['email' => $email])->where(['password' => $password])->all();
                if (count($query) > 0) {
                    $queryUser = $this->Users->find()->where(['email' => $email])->all();
                    foreach ($queryUser as $user) {
                        $session->write('user_id', $user->id);
                    }
                    if ($session->read('user_id') == 2) {
                        return $this->redirect('/404');
                    } else {
                        $session->write('email', $email);
                        return $this->redirect('/');
                    }
                }
                return $this->redirect('/Auth/login');
            }
        }
    }
    public function logout()
    {
        $session = $this->request->getSession();
        $session->destroy();
        return $this->redirect('/Auth/login');
    }
    public function changeinfor()
    {
        $session = $this->request->getSession();
        if ($session->check('user_id')) {
            $user_id = $session->read('user_id');
            $get_user = TableRegistry::getTableLocator()->get('Users')->find()->where(['id' => $user_id]);
            if ($this->request->is('post')) {
                $phone = $this->request->getData('phone');
                $address = $this->request->getData('address');
                $old_password =  md5($this->request->getData('old_password'));
                $password = md5($this->request->getData('new_password'));
                if (isset($user_id)) {
                    $check_user = TableRegistry::getTableLocator()->get('Users')->find()->where(['id' => $user_id])->where(['password' => $old_password])->all();
                    if (count($check_user) > 0) {
                        $query_user = TableRegistry::getTableLocator()->get('Users')->query();
                        $query_user->update()->set(['phone' => $phone, 'address' => $address, 'password' => $password])
                            ->where(['id' => $user_id])->execute();
                        echo '<script>alert("Thay đổi thông tin thành công") </script>';
                        return $this->redirect('/');
                    } else {
                        echo '<script>alert("Mật khẩu cũ không đúng") </script>';
                    }
                }
            }
            $this->set(compact(['get_user']));
        } else {
            return $this->redirect('/Auth/login');
        }
    }
}
