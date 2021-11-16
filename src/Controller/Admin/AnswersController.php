<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class AnswersController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        $this->isAdmin();
        $session = $this->request->getSession();
        $session->delete('oldPage');
        $answers = $this->paginate($this->{'Answer'}->getAllAnswer(), ['limit' => '10']);
        $countQualityAnswers = count($this->{'Answer'}->getAllAnswer()->toArray());
        if ($this->request->is(['GET'])) {
            $key = $this->request->getQuery('key');
            $session->write('valueSearch', $key);
            if ($key == '') {
                $this->set(compact(['answers']));
            } else {
                $result = $this->{'Home'}->search(trim($key), 'Answers', 'name')->toArray();
                if ($result == []) {
                    $this->Flash->error(__(DATA_NOT_FOUND));
                    $this->set(compact(['result']));
                } else {
                    $result = $this->paginate($this->{'Home'}->search(trim($key), 'Answers', 'name'), ['limit' => PAGE_COUNT_ADMIN]);
                    $this->set(compact(['result']));
                }
            }
        }
        $this->set(compact(['answers', 'countQualityAnswers']));
    }

    /**
     * Add method
     */
    public function add()
    {
        $this->isAdmin();
        $session = $this->request->getSession();
        $survies = $this->{'Survey'}->getAllSurvey();
        $arrayValidate = [
            "name", 'survey_id'
        ];
        $arrayRequest = [];
        if ($this->request->is('POST')) {
            $allRequest = $this->request->getData();
            $prePage = trim($this->request->getData('prePage'));
            if ($session->check('oldPage') == false) {
                $session->write('oldPage', $prePage);
            }
            $oldPage = $session->read('oldPage');
            foreach ($allRequest as $key => $item) {
                array_push($arrayRequest, $key);
            }
            if (count(array_diff($arrayValidate, $arrayRequest)) > 0) {
                $this->Flash->error(__(INVALID_DATA));
                return $this->redirect($this->referer());
            }
            $data = [];
            if ($this->request->getData('name')[0] == '') {
                $this->Flash->error(__(ANSWER_NOT_EMPTY));
                return $this->redirect($this->referer());
            }
            $name = $this->request->getData('name');
            $survey_id = h(trim($this->request->getData('survey_id')));
            $check_survey = $this->{'Survey'}->getSurveyById($survey_id);
            if (count($check_survey) == 0) {
                $this->Flash->error(__(SURVEY_NOT_EXIT));
                return $this->redirect($this->referer());
            } else {
                foreach ($name as $item) {
                    array_push($data, ['name' => htmlspecialchars(trim($item)), 'survey_id' => $survey_id, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')]);
                }
                $result = $this->{'Answer'}->AddMutiAnswer($data);
                if ($result['status'] == false) {
                    $this->Flash->error(__($result['message']));
                } else {
                    $this->Flash->success(__(ADD_SUCCESSFULLY));
                    return $this->redirect(URL_INDEX_ANSWER);
                }
            }
        }
        $this->set(compact(['survies']));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $this->isAdmin();
        $session = $this->request->getSession();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Answers');
        if (count($errorPage) == 0) {
            return $this->redirect(URL_404_PAGE_ADMIN);
        }
        $answer = $this->{'Answer'}->getAnswerById($id);
        $arrayValidate = [
            "name"
        ];
        $arrayRequest = [];
        $arrayAnswer = [];
        $arrayValueRequest = [];
        foreach ($answer as $item) {
            array_push($arrayAnswer, $item->name);
        }
        if ($this->request->is('POST')) {
            $allRequest = $this->request->getData();
            $prePage = trim($this->request->getData('prePage'));
            if ($session->check('oldPage') == false) {
                $session->write('oldPage', $prePage);
            }
            $oldPage = $session->read('oldPage');
            foreach ($allRequest as $key => $item) {
                array_push($arrayRequest, $key);
                array_push($arrayValueRequest, $item);
            }
            unset($arrayValueRequest[0]);
            if (count(array_diff($arrayValidate, $arrayRequest)) > 0) {
                $this->Flash->error(__(INVALID_DATA));
                return $this->redirect($this->referer());
            } else if (count(array_diff($arrayAnswer, $arrayValueRequest)) == 0) {
                $this->Flash->warning(__(YOU_HAVENT_CHANGED_ANYTHING));
                return $this->redirect($this->referer());
            }
            $name = htmlspecialchars(trim($this->request->getData('name')));
            $data = ['name' => $name, 'modified' => date('Y-m-d H:i:s')];
            $result = $this->{'Answer'}->EditAnswer($id, $data);
            $errors = '';
            if ($result['result'] == 'invalid') {
                $session->write('nameError', $name);
                $errors = $result['data'];
                $this->set(compact(['errors']));
            } else {
                $this->Flash->success(__(EDITING_IS_SUCCESSFULLY));
                return $this->redirect($oldPage);
            }
        }
        $this->set(compact(['answer']));
    }

    /**
     * Delete method
     */
    public function delete($survey_id, $answer_id)
    {
        $this->isAdmin();
        if ($this->request->is(['POST', 'DELETE'])) {
            $result = $this->{'Answer'}->deleteAnswer($answer_id);
            if ($result == true) {
                $this->Flash->success(__(DELETE_SUCCESSFULLY));
            } else {
                $this->Flash->error(__(DELETE_FAILED));
            }
            return $this->redirect($this->referer());
        }
    }
}
