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
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Home');
        $this->loadComponent('Auth');
        $this->loadComponent('Survey');
    }
    public function index()
    {
        $survies = $this->paginate($this->{'Home'}->getSurviesHaveInAnswer(), ['limit' => '6']);
        $categories = $this->{'Home'}->getAllCategory();
        $countSurveyInCategory = $this->{'Home'}->countSurveyInCategory();
        if ($this->request->is('POST')) {
            $key = $this->request->getData('key');
            if ($key == '') {
                $this->set(compact(['result', 'categories', 'countSurveyInCategory']));
            } else {
                $result = $this->{'Home'}->search($key, 'Survies', 'question');
                if ($result == []) {
                    $this->Flash->error(__('Dữ liệu bạn tìm kiếm không có sẵn'));
                } else {
                    $this->set(compact(['result', 'categories', 'countSurveyInCategory']));
                }
            }
        }
        $this->set(compact(['survies', 'categories', 'countSurveyInCategory']));
    }

    // lấy survy dựa theo category
    public function getSurviesByCategory($id)
    {
        $survies  = $this->paginate($this->{'Home'}->getSurviesHaveInAnswerByCategoryId($id), ['limit' => 6]);
        $categories = $this->{'Home'}->getAllCategory();
        $getCategoryForId = $this->{'Home'}->getCategoryById($id);
        $countSurveyInCategory = $this->{'Home'}->countSurveyInCategory();
        if (count($getCategoryForId) > 0 || gettype($id) == 'string') {
            $this->set(compact(['survies', 'categories', 'getCategoryForId', 'countSurveyInCategory']));
        } else {
            return $this->redirect('/404page');
        }
    }

    // hiển thị câu hỏi
    public function showQuestion($id_category, $id_question)
    {
        $session = $this->request->getSession();
        $survies = $this->{'Home'}->getSurveyById($id_question);
        if (count($survies)) {
            $answers = $this->{'Home'}->getAnswerBySurveyId($id_question);
            if ($session->check('user_id')) {
                $user_id = $session->read('user_id');
                $getAnswerUser = $this->{'Home'}->getAnswerByUser($user_id, $id_question);
                $this->set(compact(['survies', 'answers', 'getAnswerUser']));
            }
            $this->set(compact(['survies', 'answers']));
        } else {
            return $this->redirect('/404page');
        }
    }

    // xử lí phần lấy dữ liệu người dùng trả lời đã login
    public function getDataSubmit($id_survey)
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $type_select = '';
            $check_survey = $this->{'Survey'}->getSurveyById($id_survey);
            $data = [];
            $user_id = $session->read('user_id');
            $answer_id =  $this->request->getData('answer_id');
            foreach ($check_survey as $item) {
                $type_select = $item->type_select;
            }
            if ($type_select == 2) {
                foreach ($answer_id as $answerID) {
                    array_push($data, [
                        'survey_id' => $id_survey,
                        'answer_id' => $answerID,
                        'user_id' => $user_id,
                        'created' => date('Y-m-d H:m:s'),
                        'modified' => date('Y-m-d H:m:s')
                    ]);
                }
                $check_result = $this->{'Home'}->getResultBySurveyIdAndUserId($id_survey, $user_id);
                if ($answer_id  == '') {
                    $this->Flash->error(__('Vui lòng chọn câu trả lời'));
                    return $this->redirect($this->referer());
                } else {
                    if (count($check_result) > 0) {
                        foreach ($answer_id as $item) {
                            $check_result1 = $this->{'Home'}->checkResult($user_id, $id_survey, $item);
                            if (count($check_result1) == 0) {
                                $this->{'Home'}->updateMoreAnswer($id_survey, $item, $user_id);
                            }
                        }
                        $this->{'Home'}->deleteResultNoChoose($answer_id, $id_survey, $user_id);
                        $this->Flash->success(__('Cập nhật câu trả lời thành công'));
                        return $this->redirect('/');
                    } else {
                        $this->{'Home'}->saveAnswer($data, 2);
                        $this->Flash->success(__('Chọn trả lời thành công'));
                        return $this->redirect('/');
                    }
                }
            } else {
                $check_result = $this->{'Home'}->getResultBySurveyIdAndUserId($id_survey, $user_id);
                if ($answer_id  == '') {
                    $this->Flash->error(__('Vui lòng chọn câu trả lời'));
                    return $this->redirect($this->referer());
                } else {
                    if (count($check_result) > 0) {
                        $data = [
                            'survey_id' => $id_survey, 'answer_id' => $answer_id[0], 'user_id' => $user_id,
                            'modified' => date('Y-m-d H:m:s')
                        ];
                        $this->{'Home'}->updateAnswer($data);
                        $this->Flash->success(__('Cập nhật câu trả lời thành công'));
                        return $this->redirect('/');
                    } else {
                        $data = [
                            'survey_id' => $id_survey, 'answer_id' => $answer_id[0], 'user_id' => $user_id, 'created' => date('Y-m-d H:m:s'),
                            'modified' => date('Y-m-d H:m:s')
                        ];
                        $this->{'Home'}->saveAnswer($data, 1);
                        $this->Flash->success(__('Cám ơn bạn đã bình chọn'));
                        return $this->redirect('/');
                    }
                }
            }
        }
    }

    // xử lí phần lấy dữ liệu chưa login
    public function getResultDontLogin($id_survey)
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $answer_id =  $this->request->getData('answer_id');
            $email =  $this->request->getData('email');
            $phone =  $this->request->getData('phone');
            $password =  $this->request->getData('password');
            $errorpass = '';
            if ($answer_id == '') {
                $this->Flash->error(__('Vui lòng chọn câu trả lời'));
                return $this->redirect($this->referer());
            } else {
                $data = ['email' => $email, 'phone' => $phone, 'password' => $password, 'avatar' => 'default-avatar.png', 'token' => $this->getToken(), 'status' => 2, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')];
                $result = $this->{'Auth'}->handelRegister($data);
                if ($result['status'] == true) {
                    $queryEmail = $this->{'Auth'}->queryUserByEmail($email);
                    foreach ($queryEmail as $user) {
                        $session->write('email', $user->email);
                        $session->write('role', $user->role);
                        $session->write('user_id', $user->id);
                    }
                    $user_id = $session->read('user_id');
                    $check_survey = $this->{'Survey'}->getSurveyById($id_survey);
                    $data = [];
                    foreach ($check_survey as $item) {
                        $type_select = $item->type_select;
                    }
                    if ($type_select == 1) {
                        foreach ($answer_id as $answerID) {
                            array_push($data, [
                                'survey_id' => $id_survey,
                                'answer_id' => $answerID,
                                'user_id' => $user_id,
                                'created' => date('Y-m-d H:m:s'),
                                'modified' => date('Y-m-d H:m:s')
                            ]);
                        }
                        $this->{'Home'}->saveAnswer($data, 1);
                        $this->Flash->success(__('Cám ơn bạn đã bình chọn'));
                        return $this->redirect('/');
                    } else {
                        $data = [
                            'survey_id' => $id_survey, 'answer_id' => $answer_id[0], 'user_id' => $user_id, 'created' => date('Y-m-d H:m:s'),
                            'modified' => date('Y-m-d H:m:s')
                        ];
                        $this->{'Home'}->saveAnswer($data, 2);
                        $this->Flash->success(__('Cám ơn bạn đã bình chọn'));
                        return $this->redirect('/');
                    }
                } else {
                    if (isset($result['data']['email'])) {
                        $session->write('errorEmail', reset($result['data']['email']));
                    }
                    if (isset($result['data']['phone'])) {
                        $session->write('errorPhone',  reset($result['data']['phone']));
                    }
                    if ($password == '') {
                        $session->write('errorPassword', 'Mật khẩu không được để trống');
                    }
                    return $this->redirect($this->referer());
                }
            }
        }
    }

    // để tạo template 404 không bị lỗi
    public function page404()
    {
    }

    // get token
    public function getToken()
    {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $getToken = '';
        for ($i = 0; $i < $length; $i++) {
            $getToken .= $characters[rand(0, $charactersLength - 1)];
        }
        return $getToken;
    }
}
