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
class StatisticalsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Statistical');
        $this->loadComponent('Category');
        $this->loadComponent('Survey');
        $this->loadComponent('Answer');
        $this->loadComponent('Auth');
        $this->loadComponent('Home');

    }

    // Thống kê Survey
    public function survey($id)
    {
        $this->isAdmin();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Survies');
        if (count($errorPage) == 0) {
            return $this->redirect('404page');
        }
        $survey = $this->{'Survey'}->getSurveyById($id);
        $result = $this->{'Statistical'}->countAnswerBySurvey($id);
        $countEachAnswerBySurvey =  $this->{'Statistical'}->countEachAnswerBySurvey($id);
        $getAnswerBySurveyId = $this->{'Answer'}->getAnswerBySurveyId($id);
        $this->set(compact(['result', 'survey', 'countEachAnswerBySurvey', 'getAnswerBySurveyId']));
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
