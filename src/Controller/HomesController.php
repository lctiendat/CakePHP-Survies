<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Homes Controller
 *
 * @method \App\Model\Entity\Home[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $topposts = TableRegistry::getTableLocator()->get('Survies')->find('all')->order(['id DESC'])->limit(5);
        $survies = $this->paginate(TableRegistry::getTableLocator()->get('Survies')->find()
            ->where(['id IN' => TableRegistry::getTableLocator()
                ->get('Answers')->find()->select('survey_id')]), ['limit' => '6']);
        $categories = $this->getTable('Categories');
        //  $survies =  $this->getTable('Survies');
        $answers =   $this->getTable('Answers');
        $this->set(compact(['survies', 'answers', 'categories', 'topposts']));
    }
    public function getSurviesByCategory($id)
    {
        //  dd( TableRegistry::getTableLocator()->get('Answers')->find()->select('survey_id')->all());
        $get_Survies = TableRegistry::getTableLocator()->get('Survies');
        $survies  = $this->paginate($get_Survies->find()->where(['category_id' => $id])
            ->where(['id IN' => TableRegistry::getTableLocator()->get('Answers')->find()
                ->select('survey_id')]), ['limit' => 6]);
        $categories = $this->getTable('Categories');
        $topposts = TableRegistry::getTableLocator()->get('Survies')->find('all')->order(['id DESC'])->limit(5);
        $getCategoryForId = TableRegistry::getTableLocator()->get('Categories')->find()->where(['id' => $id]);
        $this->set(compact(['survies', 'topposts', 'categories', 'getCategoryForId']));
    }
    // public function getAnswersInSurvy($id)
    // {

    //     $get_Answer = TableRegistry::getTableLocator()->get('Answers');
    //     $answer  = $get_Answer->find()->where(['survey_id' => $id])->all();
    //     return $answer->toArray();
    //     // $this->set(compact(['answer']));
    // }
    public function getTable($table)
    {
        return TableRegistry::getTableLocator()->get($table)->find()->all();
    }
    public function showQuestion($id_category, $id_question)
    {
        $survies = TableRegistry::getTableLocator()->get('Survies')->find()->where(['id' => $id_question])->all();
        $answers = TableRegistry::getTableLocator()->get('Answers')->find()->where(['survey_id' => $id_question]);
        $this->set(compact(['survies', 'answers']));
    }
    public function getDataSubmit($id_survey)
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $user_id = $session->read('user_id');
            $answer_id =  $this->request->getData('answer_id');
            $check_result = TableRegistry::getTableLocator()->get('Results')->find()->where(['survey_id' => $id_survey])->where(['user_id' => $user_id])->all();
            if (count($check_result) > 0) {
                $save_result = TableRegistry::getTableLocator()->get('Results')->query();
                $save_result->update()->set(['answer_id' => $answer_id])->where(['survey_id' => $id_survey])->where(['user_id' => $user_id])->execute();
                echo '<script>alert("Cập nhật câu trả lời thành công") </script>';
            } else {
                $save_result1 = TableRegistry::getTableLocator()->get('Results')->query();
                $save_result1->insert(['survey_id', 'answer_id', 'user_id', 'created', 'modified'])
                    ->values(['survey_id' => $id_survey, 'answer_id' => $answer_id, 'user_id' => $user_id, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')])
                    ->execute();
                echo '<script>alert("Chọn câu trả lời thành công") </script>';
            }
        }
    }
    public function getResultDontLogin($id_survey)
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $email =  $this->request->getData('email');
            $phone =  $this->request->getData('phone');
            $password =  md5($this->request->getData('password'));
            $query_email = TableRegistry::getTableLocator()->get('Users')->find()->where(['email' => $email])->all();
            $query_phone = TableRegistry::getTableLocator()->get('Users')->find()->where(['phone' => $phone])->all();
            if (count($query_email) > 0) {
                echo '<script>alert("Email đã tồn tại") </script>';
                return $this->redirect($this->referer());
            } else if (count($query_phone) > 0) {
                echo '<script>alert("Số điện thoại đã tồn tại") </script>';
                return $this->redirect($this->referer());
            } else {
                $save_user = TableRegistry::getTableLocator()->get('Users')->query();
                $save_user->insert(['email', 'phone', 'password', 'created', "modified"])
                    ->values(['email' => $email, 'phone' => $phone, 'password' => $password, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')])
                    ->execute();
                $query_email = TableRegistry::getTableLocator()->get('Users')->find()->where(['email' => $email])->all();
                foreach ($query_email as $user) {
                    $session->write('user_id', $user->id);
                };
                $session->write('email', $email);
                $survy_id = $id_survey;
                $answer_id =  $this->request->getData('answer_id');
                $user_id = $session->read('user_id');
                $save_result = TableRegistry::getTableLocator()->get('Results')->query();
                $save_result->insert(['survey_id', 'answer_id', 'user_id', 'created', 'modified'])
                    ->values(['survey_id' => $survy_id, 'answer_id' => $answer_id, 'user_id' => $user_id, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')])
                    ->execute();
                $this->redirect('/');
            }
        }
    }
}
