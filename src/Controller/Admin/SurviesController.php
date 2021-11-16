<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

class SurviesController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        $this->isAdmin();
        try {
            $session = $this->request->getSession();
            $session->delete('oldPage');
            $countQualitySurvies = count($this->{'Survey'}->getAllSurveyWithCategory()->toArray());
            $survies = $this->paginate($this->{'Survey'}->getAllSurveyWithCategory(), ['limit' => PAGE_COUNT_ADMIN]);
            $dataPage = $this->request->getAttribute('paging');
            $dataCount = $dataPage['Survies']['count'] - $dataPage['Survies']['start'] + 1;
            $pageStart = $dataPage['Survies']['start'];
            if ($this->request->is(['GET'])) {
                $key = $this->request->getQuery('key');
                $session->write('valueSearch', $key);
                $sort = $this->request->getQuery('sort');
                $direction = $this->request->getQuery('direction');
                $arrayKey = ["Survies.id", 'question', "Categories.name", 'Survies.created'];
                if (isset($sort) && isset($direction)) {
                    if (in_array($sort, $arrayKey) == 1 && $direction == 'asc' || in_array($sort, $arrayKey) == 1 && $direction == 'desc') {
                        $result = $this->paginate($this->{'Home'}->sortDataAdmin($key, 'Survies', $sort, $direction), ['limit' => PAGE_COUNT_ADMIN]);
                        $countResult = count($this->{'Home'}->sortDataAdmin($key, 'Survies', $sort, $direction)->toArray());
                        $this->set(compact(['result', 'countResult', 'dataCount', 'pageStart']));
                    }
                } elseif (isset($sort) && isset($direction) && $key != '') {
                    if (in_array($sort, $arrayKey) == 1 && $direction == 'asc' || in_array($sort, $arrayKey) == 1 && $direction == 'desc') {
                        $result = $this->paginate($this->{'Home'}->sortDataAdmin($key, 'Survies', $sort, $direction), ['limit' => PAGE_COUNT_ADMIN]);
                        $countResult = count($this->{'Home'}->sortDataAdmin($key, 'Survies', $sort, $direction)->toArray());
                        $this->set(compact(['result', 'countResult', 'dataCount', 'pageStart']));
                    }
                } elseif (isset($key)) {
                    if ($key == '') {
                        $this->set(compact(['survies']));
                    } else {
                        $result = $this->{'Home'}->search(trim($key), 'Survies', 'question')->toArray();
                        if ($result == []) {
                            $this->Flash->error(__(DATA_NOT_FOUND));
                            $countResult = count($result);
                            $this->set(compact(['result','countResult']));
                        } else {
                            $countResult = count($result);
                            $result = $this->paginate($this->{'Home'}->search(trim($key), 'Survies', 'question'), ['limit' => PAGE_COUNT_ADMIN]);
                            $this->set(compact(['result', 'countResult', 'dataCount', 'pageStart']));
                        }
                    }
                }
            }
            $this->set(compact(['survies', 'countQualitySurvies', 'pageStart', 'dataCount']));
        } catch (NotFoundException $e) {
            $attribute = $this->request->getAttribute('paging');
            $requestedPage = $attribute['Survies']['requestedPage'];
            $pageCount = $attribute['Survies']['pageCount'];
            if ($requestedPage > $pageCount) {
                return $this->redirect("/admin/survies?page=" . $pageCount . "");
            }
        }
    }

    /**
     * Add method
     */
    public function add()
    {
        $this->isAdmin();
        $session = $this->request->getSession();
        $categories = $this->{'Category'}->getAllCategory();
        $arrayValidate = [
            "question",
            "description",
            "category_id",
            "type_select",
        ];
        $arrayRequest = [];
        if ($this->request->is('POST')) {
            $allRequest = $this->request->getData();
            $prePage = trim($this->request->getData('prePage'));
            if ($session->check('oldPage') == false) {
                $session->write('oldPage', $prePage);
            }
            $oldPage = $session->read('oldPage');
            unset($allRequest['prePage']);
            unset($allRequest['key']);
            $allRequest['category_id'] = '';
            foreach ($allRequest as $key => $item) {
                array_push($arrayRequest, $key);
            }
            if (count(array_diff($arrayValidate, $arrayRequest)) > 0) {
                $this->Flash->error(__(INVALID_DATA));
                return $this->redirect($this->referer());
            }
            $question = htmlspecialchars(trim($this->request->getData('question')));
            $description = htmlspecialchars(trim($this->request->getData('description')));
            $category_id = h(trim($this->request->getData('category_id')));
            $type_select = h(trim($this->request->getData('type_select')));
            $arrUserSession = $session->read('arrUserSession');
            $user_id = $arrUserSession['user_id'];
            $created = date('Y-m-d H:i:s');
            $modified = date('Y-m-d H:i:s');
            $check_category = $this->{'Category'}->getCategoryById($category_id);
            if (count($check_category) == 0) {
                $this->Flash->error(__(CATEGORY_NOT_FOUND));
                return $this->redirect($this->referer());
            } elseif ($type_select != 1 && $type_select != 2) {
                $this->Flash->error(__(TYPE_SELECT_NOT_EXIT));
                return $this->redirect($this->referer());
            } else {
                $data = [
                    'question' => $question,
                    'description' => $description,
                    'category_id' => $category_id,
                    'user_id' => $user_id,
                    'type_select' => $type_select,
                    'created' => $created,
                    'modified' => $modified
                ];
                $result = $this->{'Survey'}->handelAddSurvey($data);
                $errors = '';
                if ($result['result'] == 'invalid') {
                    $session->write('questionError', $question);
                    $session->write('descriptionError', $description);
                    $errors = $result['data'];
                    $this->set(compact(['errors']));
                } else {
                    $this->Flash->success(__(ADD_SUCCESSFULLY));
                    return $this->redirect(URL_INDEX_SURVEY);
                    unset($_SESSION['oldPage']);
                }
            }
        }
        $this->set(compact(['categories']));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $this->isAdmin();
        $session = $this->request->getSession();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Survies');
        if (count($errorPage) == 0) {
            return $this->redirect(URL_404_PAGE_ADMIN);
        }
        $survey = $this->{'Survey'}->getSurveyById($id);
        $arrayValidate = [
            "question",
            "description",
            "category_id",
        ];
        $arrayRequest = [];
        $arraySurvies = [];
        $arrayValueRequest = [];
        foreach ($survey as $item) {
            array_push($arraySurvies, $item->question);
            array_push($arraySurvies, $item->description);
            array_push($arraySurvies, $item->category_id);
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
                array_push($arrayValueRequest, htmlspecialchars($item));
            }
            unset($arrayValueRequest[0]);
            if (count(array_diff($arrayValidate, $arrayRequest)) > 0) {
                $this->Flash->error(__(INVALID_DATA));
                return $this->redirect($this->referer());
            } else if (
                $arraySurvies[0] == $arrayValueRequest[1]  &&
                $arraySurvies[1] == $arrayValueRequest[2] &&
                $arraySurvies[2] == $arrayValueRequest[4]
            ) {
                $this->Flash->warning(__(YOU_HAVENT_CHANGED_ANYTHING));
                return $this->redirect($this->referer());
            }
            $question = htmlspecialchars(trim($this->request->getData('question')));
            $description = htmlspecialchars(trim($this->request->getData('description')));
            $category_id = htmlspecialchars(trim($this->request->getData('category_id')));
            $modified = date('Y-m-d H:i:s');
            $check_category = $this->{'Category'}->getCategoryById($category_id);
            if (count($check_category) == 0) {
                $this->Flash->error(__(CATEGORY_NOT_FOUND));
                return $this->redirect($this->referer());
            } else {
                $data = ['question' => $question, 'description' => $description, 'category_id' => $category_id, 'modified' => $modified];
                $result = $this->{'Survey'}->editSurvey($id, $data);
                $errors = '';
                if ($result['status'] == false) {
                    $session->write('questionError', $question);
                    $session->write('descriptionError', $description);
                    $errors = $result['data'];
                    $this->set(compact(['errors']));
                } else {
                    $this->Flash->success(__(EDITING_IS_SUCCESSFULLY));
                    return $this->redirect($oldPage);
                }
            }
        }
        $categories = $this->{'Category'}->getAllCategory();
        $this->set(compact(['survey', 'categories']));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->isAdmin();
        if ($this->request->is(['POST', 'DELETE'])) {
            $result = $this->{'Survey'}->deleteSurvey($id);
            if ($result == true) {
                $this->Flash->success(__(DELETE_SUCCESSFULLY));
            } else {
                $this->Flash->error(__(DELETE_FAILED));
            }
            return $this->redirect($this->referer());
        }
    }

    /**
     * Add answer method
     */
    public function addAnswer($id)
    {
        $this->isAdmin();
        $session = $this->request->getSession();
        $survey = $this->{'Survey'}->getSurveyById($id);
        $arrayValidate = [
            "name"
        ];
        $arrayRequest = [];
        $arrayAnswer = [];
        $survey_id = $id;
        $check_survey = $this->{'Survey'}->getSurveyById($survey_id);
        $answers = $this->{'Answer'}->getListAnswerBySurveyId($id);
        $countAnswer = count($this->{'Answer'}->getListAnswerBySurveyId($id)->toArray());
        foreach ($answers as $item) {
            array_push($arrayAnswer, $item->name);
        }
        if (count($check_survey) == 0) {
            return $this->redirect(URL_404_PAGE_ADMIN);
        }
        if ($this->request->is('POST')) {
            $arrayRequestAnswer = [];
            $arrayCheckIssetAnswer = [];
            $allRequest = $this->request->getData();
            foreach ($allRequest['name'] as $item) {
                array_push($arrayRequestAnswer, trim($item));
            }
            foreach ($arrayRequestAnswer as $item1) {
                if (in_array($item1, $arrayAnswer)) {
                    array_push($arrayCheckIssetAnswer, 1);
                }
            }
            $prePage = trim($this->request->getData('prePage'));
            if ($session->check('oldPage') == false) {
                $session->write('oldPage', $prePage);
            }
            $oldPage = $session->read('oldPage');
            foreach ($allRequest as $key => $item) {
                array_push($arrayRequest, $key);
            }
            unset($arrayRequest[0]);
            if (count(array_diff($arrayValidate, $arrayRequest)) > 0) {
                $this->Flash->error(__(INVALID_DATA));
                return $this->redirect($this->referer());
            }
            if (count($arrayCheckIssetAnswer) > 0) {
                $this->Flash->error(__(VALUE_ALREADY_EXITS));
                return $this->redirect($this->referer());
            }
            $data = [];
            $arrayName = [];
            foreach ($this->request->getData('name') as $item) {
                array_push($arrayName, $item);
            }
            if (in_array('', $arrayName)) {
                $this->Flash->error(__(ANSWER_NOT_EMPTY));
                return $this->redirect($this->referer());
            }
            $name = $this->request->getData('name');
            foreach ($name as $item) {
                array_push($data, ['name' => htmlspecialchars(trim($item)), 'survey_id' => $survey_id, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')]);
            }
            $result = $this->{'Answer'}->AddMutiAnswer($data);
            if ($result['status'] == false) {
                $this->Flash->error(__($result['message']));
            } else {
                $this->Flash->success(__(ADD_SUCCESSFULLY));
                return $this->redirect('');
            }
        }
        $this->set(compact(['survey', 'answers', 'countAnswer']));
    }
}
