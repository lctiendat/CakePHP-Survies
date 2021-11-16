<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class HomesController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        try {
            $session = $this->request->getSession();
            $session->delete('oldPage');
            $categories = $this->paginate($this->{'Home'}->getCategoryHaveSurvey(), ['limit' => PAGE_COUNT_CLIENT]);
            $countCategory = count($this->{'Home'}->getCategoryHaveSurvey()->toArray());
            if ($session->check('arrUserSession')) {
                $arrUserSession = $session->read('arrUserSession');
                $user_id = $arrUserSession['user_id'];
                $categories = $this->paginate($this->{'Home'}->getSortCategoryHaveSurvey($user_id), ['limit' => PAGE_COUNT_CLIENT]);
                $this->set(compact(['categories', 'countCategory', 'user_check']));
            }
            if ($this->request->is(['GET'])) {
                $key = $this->request->getQuery('key');
                $session->write('valueSearch', $key);
                if ($key == '') {
                    $this->set(compact(['categories', 'countCategory']));
                } else {
                    $result = $this->{'Home'}->searchHome(trim($key))->toArray();
                    if ($result == []) {
                        $this->set(compact(['result']));
                        $session->write('searchError', DATA_NOT_FOUND);
                    } else {
                        if ($session->check('arrUserSession')) {
                            $arrUserSession = $session->read('arrUserSession');
                            $user_id = $arrUserSession['user_id'];
                            $countResult = count($result);
                            $result = $this->paginate($this->{'Home'}->getSortAndSearchCategoryHaveSurvey($user_id, trim($key)), ['limit' => PAGE_COUNT_CLIENT]);
                            $this->set(compact(['result', 'countResult']));
                        } else {
                            $countResult = count($result);
                            $result = $this->paginate($this->{'Home'}->searchHome(trim($key)), ['limit' => PAGE_COUNT_CLIENT]);
                            $this->set(compact(['result', 'countResult']));
                        }
                    }
                }
            }
            $this->set(compact(['categories', 'countCategory']));
        } catch (NotFoundException $e) {
            $attribute = $this->request->getAttribute('paging');
            $requestedPage = $attribute['Categories']['requestedPage'];
            $pageCount = $attribute['Categories']['pageCount'];
            if ($requestedPage > $pageCount) {
                return $this->redirect("/?page=" . $pageCount . "");
            }
        }
    }

    /**
     * Get data from user not logged in method
     */
    public function showSurveyByCategory($id)
    {
        $session = $this->request->getSession();
        $issetCategory = $this->{'Home'}->checkCategoryHaveSurvey($id);
        if (count($issetCategory) > 0) {
            $survies = $this->{'Home'}->getSurviesHaveAnswerByCategory($id);
            $category = $this->{'Category'}->getCategoryById($id);
            $nameCategory = '';
            $idCategory = $id;
            foreach ($category as $key => $value) {
                $nameCategory = $value->name;
            }
            if ($session->check('arrUserSession')) {
                $arrUserSession = $session->read('arrUserSession');
                $user_id = $arrUserSession['user_id'];
                $check_result  =  $this->{'Home'}->checkResult($user_id, $id);
                $getAnswerUser = $this->{'Home'}->getAnswerByUser($user_id);
                $this->set(compact(['survies', 'answers', 'getAnswerUser', 'check_result']));
            }
            $this->set(compact(['survies', 'nameCategory', 'idCategory']));
        } else {
            return $this->redirect(URL_404_PAGE);
        }
    }

    /**
     * Show answer by survey
     */
    public function getAnswerBySurvey($id)
    {
        $answer = $this->{'Home'}->getAnswerBySurvey($id);
        return $answer;
    }

    /**
     * Get data from user not logged in method
     */
    public function saveVotedLogin($id)
    {
        $session = $this->request->getSession();
        if ($this->request->is('POST')) {
            $question = $this->request->getData('question');
            $answer = $this->request->getData('answer');
            $type_select = $this->request->getData('type_select');
            $arrUserSession = $session->read('arrUserSession');
            $user_id = $arrUserSession['user_id'];
            $arrOldAnswer = [];
            $check_result  =  $this->{'Home'}->checkResult($user_id, $id);
            $prePage = trim($this->request->getData('prePage'));
            if ($session->check('oldPage') == false) {
                $session->write('oldPage', $prePage);
            }
            if ($answer == null) {
                $this->Flash->error(__(ANSWER_NOT_EMPTY));
                return $this->redirect($this->referer());
            } else if (count($question) > count($answer)) {
                foreach ($answer as $value) {
                    foreach ($value as $item) {
                        array_push($arrOldAnswer, $item);
                    }
                }
                $session->write('arrOldAnswer', $arrOldAnswer);
                $this->Flash->error(__(PLEASE_SELECT_ALL_ANSWERS));
                return $this->redirect($this->referer());
            } else {
                if (count($check_result) > 0) {
                    $arrDataSame = [];
                    $arrData = [];
                    foreach ($question as $key => $value) {
                        array_push($arrData, [
                            'question' => $question[$key],
                            'answer' => $answer[$key],
                            'type_select' => $type_select[$key]
                        ]);
                    }
                    foreach ($question as $key => $value) {
                        array_push($arrDataSame, [
                            'question' => $question[$key],
                            'answer' => $answer[$key],
                        ]);
                    }
                    $answerCheck = $this->{'Home'}->getVotedByUser($id, $user_id);
                    $arrResult = [];
                    foreach ($answerCheck as $item) {
                        array_push(
                            $arrResult,
                            $item['answer_id']
                        );
                    }
                    $arrDataSameCheck = [];
                    foreach ($arrDataSame as $item) {
                        foreach ($item['answer'] as $item1) {
                            array_push(
                                $arrDataSameCheck,
                                $item1
                            );
                        }
                    }
                    if ($arrResult == $arrDataSameCheck) {
                        $this->Flash->warning(__('Phần này em chưa xử lí ... '));
                        return $this->redirect($this->referer());
                    } else {
                        $arrTypeSelectOnly = [];
                        $arrTypeSelectMuti = [];
                        foreach ($arrData as $item) {
                            if ($item['type_select'] == 1) {
                                array_push($arrTypeSelectOnly, $item);
                            } else {
                                array_push($arrTypeSelectMuti, $item);
                            }
                        }
                        foreach ($arrTypeSelectOnly as $item) {
                            $data = [
                                'category_id' => $id,
                                'survey_id' => $item['question'],
                                'answer_id' => $item['answer'][0],
                                'user_id' => $user_id,
                                'modified' => date('Y-m-d H:i:s')
                            ];
                            $this->{'Home'}->updateVoted($data);
                        }
                        $arrAnswer = [];
                        foreach ($arrTypeSelectMuti as $item) {
                            foreach ($item['answer'] as $item1) {
                                array_push($arrAnswer, $item1);
                                $data = [
                                    'category_id' => $id,
                                    'survey_id' => $item['question'],
                                    'answer_id' => $item1,
                                    'user_id' => $user_id,
                                ];
                                $result = $this->{'Home'}->checkVoted($data);
                                if (count($result) == 0) {
                                    $data = [
                                        'category_id' => $id,
                                        'survey_id' => $item['question'],
                                        'answer_id' => $item1,
                                        'user_id' => $user_id,
                                        'created' => date('Y-m-d H:i:s'),
                                        'modified' => date('Y-m-d H:i:s')
                                    ];
                                    $this->{'Home'}->insertVoted($data);
                                }
                                $data = [
                                    'category_id' => $id,
                                    'survey_id' => $item['question'],
                                    'answer_id' => $arrAnswer,
                                    'user_id' => $user_id,
                                ];
                                $this->{'Home'}->deleteVoted($data);
                            }
                        }
                        $this->Flash->success(__(UPDATED_ANSWER_SUCCESSFULLY));
                        return $this->redirect(URL_INDEX);
                    }
                } else {
                    $arrData = [];
                    foreach ($question as $key => $value) {
                        array_push($arrData, [
                            'question' => $question[$key],
                            'answer' => $answer[$key]
                        ]);
                    }
                    $data = [];
                    foreach ($arrData as $value) {
                        foreach ($value['answer'] as $value1) {
                            array_push(
                                $data,
                                [
                                    'category_id' => $id,
                                    'survey_id' => $value['question'],
                                    'answer_id' => $value1,
                                    'user_id' => $user_id,
                                    'created' => date('Y-m-d H:i:s'),
                                    'modified' => date('Y-m-d H:i:s')
                                ]
                            );
                        }
                    }
                    $this->{'Home'}->saveVoted($data);
                    $session->delete('arrOldAnswer');
                    $this->Flash->success(__(THANKS_YOU_FOR_VOTING));
                    return $this->redirect(URL_INDEX);
                }
            }
        }
    }

    /**
     * Get data from user not login
     */
    public function saveVotedNotLogin($id)
    {
        $session = $this->request->getSession();
        if ($this->request->is('POST')) {
            $question = $this->request->getData('question');
            $answer = $this->request->getData('answer');
            $email = $this->request->getData('email');
            $phone = $this->request->getData('phone');
            $password = $this->request->getData('password');
            $arrOldAnswer = [];
            if ($answer == null) {
                $arrOldValueSession = [
                    'OldValueEmail' => $email,
                    'OldValuePhone' => $phone,
                    'OldValuePassword' => $password,
                ];
                $session->write('arrOldValueSession', $arrOldValueSession);
                $this->Flash->error(__(ANSWER_NOT_EMPTY));
                return $this->redirect($this->referer());
            } else if (count($question) > count($answer)) {
                $arrOldValueSession = [
                    'OldValueEmail' => $email,
                    'OldValuePhone' => $phone,
                    'OldValuePassword' => $password,
                ];
                $session->write('arrOldValueSession', $arrOldValueSession);
                foreach ($answer as $value) {
                    foreach ($value as $item) {
                        array_push($arrOldAnswer, $item);
                    }
                }
                $session->write('arrOldAnswer', $arrOldAnswer);
                $this->Flash->error(__(PLEASE_SELECT_ALL_ANSWERS));
                return $this->redirect($this->referer());
            } else {
                $data = [
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $password,
                    'avatar' => 'default-avatar.png',
                    'token' => $this->{'Auth'}->getToken(),
                    'status' => 0,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                ];
                $result = $this->{'Auth'}->register($data);
                if ($result['status'] ==  true) {
                    $queryEmail = $this->{'Auth'}->queryUserByEmail($email);
                    $arrUserSession = [];
                    foreach ($queryEmail as $user) {
                        $arrUserSession = [
                            'email' => $user->email,
                            'role' => $user->role,
                            'user_id' => $user->id,
                        ];
                    }
                    $session->write('arrUserSession', $arrUserSession);
                    $arrUserSession = $session->read('arrUserSession');
                    $user_id = $arrUserSession['user_id'];
                    $arrData = [];
                    foreach ($question as $key => $value) {
                        array_push($arrData, [
                            'question' => $question[$key],
                            'answer' => $answer[$key]
                        ]);
                    }
                    $data = [];
                    foreach ($arrData as $value) {
                        foreach ($value['answer'] as $value1) {
                            array_push(
                                $data,
                                [
                                    'category_id' => $id,
                                    'survey_id' => $value['question'],
                                    'answer_id' => $value1,
                                    'user_id' => $user_id,
                                    'created' => date('Y-m-d H:i:s'),
                                    'modified' => date('Y-m-d H:i:s')
                                ]
                            );
                        }
                    }
                    $this->{'Home'}->saveVoted($data);
                    $session->delete('arrOldAnswer');
                    $this->Flash->success(__(THANKS_YOU_FOR_VOTING));
                    return $this->redirect(URL_INDEX);
                } else {
                    $arrOldValueSession = [
                        'OldValueEmail' => $email,
                        'OldValuePhone' => $phone,
                        'OldValuePassword' => $password,
                    ];
                    $session->write('arrOldValueSession', $arrOldValueSession);
                    foreach ($answer as $value) {
                        foreach ($value as $item) {
                            array_push($arrOldAnswer, $item);
                        }
                    }
                    $session->write('arrOldAnswer', $arrOldAnswer);
                    if (isset($result['data']['email'])) {
                        $session->write('errorEmail', reset($result['data']['email']));
                    }
                    if (isset($result['data']['phone'])) {
                        $session->write('errorPhone',  reset($result['data']['phone']));
                    }
                    if (isset($result['data']['password'])) {
                        $session->write('errorPassword',  reset($result['data']['password']));
                    }
                    return $this->redirect($this->referer());
                }
            }
        }
    }
}
