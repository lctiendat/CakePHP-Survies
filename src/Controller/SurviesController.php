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
    public function index()
    {
        $this->paginate = [
            'limit' => 5,
            'order' => [
                'Categories.id' => 'asc'
            ]
        ];
        //    dd($survies = $this->paginate($this->Survies));
        $survies = $this->paginate($this->Survies);

        foreach ($survies as $survi) {

            $survi_cate = TableRegistry::getTableLocator()->get('Categories')->find()->where(['id =' => $survi['category_id']])->all();
            $user_cate = TableRegistry::getTableLocator()->get('Users')->find()->where(['id =' => $survi['user_id']])->all();
            foreach ($survi_cate as $sur) {
                $survi['category_name'] = $sur->name;
            }
            foreach ($user_cate as $user) {
                $survi['user_name'] = $user->email;
            }
        }
        $this->set(compact('survies'));
    }


    // public function getRelasById($table_name, $val)
    // {
    //     TableRegistry::getTableLocator()->get($table_name)->find()->where(['id =' => $val['']])->all();
    // }

    /**
     * View method
     *
     * @param string|null $id Survy id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $survy = $this->Survies->get($id, [
            'contain' => ['Categories', 'Users'],
        ]);

        $this->set(compact('survy'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $survy = $this->Survies->newEntity($this->request->getData());
        // $survy = $this->Survies->patchEntity($survy, $this->request->getData());
        if ($this->Survies->save($survy)) {
            $this->Flash->set('Thêm khảo sát thành công');
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->set('Sửa khảo sát thành công');

        $categories = TableRegistry::getTableLocator()->get('Categories')->find()->all();
        // // $categories1 = $this->Survies->Categories->find('list', ['limit' => 200]);
        // // $categories = $this->Survies->Categories->find('all');
        // // dd($categories->all());die;
        // // $users = $this->Survies->Users->find('list', ['limit' => 200]);
        $this->set(compact('survy', 'categories', 'users'));
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
        $survy = $this->Survies->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $survy = $this->Survies->patchEntity($survy, $this->request->getData());
            if ($this->Survies->save($survy)) {
                $this->Flash->set('Sửa khảo sát thành công');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->set('Sửa khảo sát thành công');
        }
        //  $categories = $this->Survies->Categories->find('list', ['limit' => 200]);
        $categories = TableRegistry::getTableLocator()->get('Categories')->find()->all();

        // $users = $this->Survies->Users->find('list', ['limit' => 200]);
        $this->set(compact('survy', 'categories', 'users'));
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
        $this->request->allowMethod(['post', 'delete']);
        $survy = $this->Survies->get($id);
        if ($this->Survies->delete($survy)) {
            $this->Flash->success(__('The survy has been deleted.'));
        } else {
            $this->Flash->error(__('The survy could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
