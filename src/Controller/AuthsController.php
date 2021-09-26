<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Auths Controller
 *  @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\Auth[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuthsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function register()
    {
        $user = $this->Users->newEntity($this->request->getData());
        // $survy = $this->Survies->patchEntity($survy, $this->request->getData());
        if ($this->Users->save($user)) {
            $this->Flash->success('The user has been saved', [
                'key' => 'positive',
            ]);
            return $this->redirect('/Auth/login');
        }
        $this->Flash->success('The user has been dont saved', [
            'key' => 'positive',
        ]);
    }
    public function login()
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $email =  $this->request->getData('email');
            $password =  $this->request->getData('password');
            $query = $this->Users->find()->where(['email' => $email])->where(['password' => $password])->all();
            if (count($query) > 0) {
                $session->write('email', $email);
                return $this->redirect('/');
            }
            return $this->redirect('/Auth/login');
        }
    }
}
