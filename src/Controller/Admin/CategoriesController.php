<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

class CategoriesController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        $this->isAdmin();
        try {
            $getQualityCategories = count($this->{'Category'}->getAllCategory()->toArray());
            $session = $this->request->getSession();
            $session->delete('oldPage');
            $categories = $this->paginate($this->{'Category'}->getAllCategory(), ['limit' => PAGE_COUNT_ADMIN]);
            $getCategories = count($this->paginate($this->{'Category'}->getAllCategory(), ['limit' => PAGE_COUNT_ADMIN])->toArray());
            $dataPage = $this->request->getAttribute('paging');
            $dataCount = $dataPage['Categories']['count'] - $dataPage['Categories']['start'] + 1;
            $pageStart = $dataPage['Categories']['start'];
            if ($this->request->is(['GET'])) {
                $key = $this->request->getQuery('key');
                $session->write('valueSearch', $key);
                $sort = $this->request->getQuery('sort');
                $direction = $this->request->getQuery('direction');
                $arrayKey = ["id", "name", 'created'];
                if (isset($sort) && isset($direction)) {
                    if (in_array($sort, $arrayKey) == 1 && $direction == 'asc' || in_array($sort, $arrayKey) == 1 && $direction == 'desc') {
                        $result = $this->paginate($this->{'Home'}->sortDataAdmin($key, 'Categories', $sort, $direction), ['limit' => PAGE_COUNT_ADMIN]);
                        $countResult = count($this->{'Home'}->sortDataAdmin($key, 'Categories', $sort, $direction)->toArray());
                        $this->set(compact(['result', 'countResult', 'pageStart']));
                    }
                } elseif (isset($sort) && isset($direction) && $key != '') {
                    if (in_array($sort, $arrayKey) == 1 && $direction == 'asc' || in_array($sort, $arrayKey) == 1 && $direction == 'desc') {
                        $result = $this->paginate($this->{'Home'}->sortDataAdmin($key, 'Categories', $sort, $direction), ['limit' => PAGE_COUNT_ADMIN]);
                        $countResult = count($this->{'Home'}->sortDataAdmin($key, 'Categories', $sort, $direction)->toArray());
                        $this->set(compact(['result', 'countResult',  'pageStart']));
                    }
                } elseif (isset($key)) {
                    if ($key == '') {
                        $this->set(compact(['categories']));
                    } else {
                        $result = $this->{'Home'}->search(trim($key), 'Categories', 'name')->toArray();
                        if ($result == []) {
                            $countResult = count($result);
                            $this->set(compact(['result', 'countResult']));
                            $this->Flash->error(__(DATA_NOT_FOUND));
                        } else {
                            $countResult = count($result);
                            $result = $this->paginate($this->{'Home'}->search(trim($key), 'Categories', 'name'), ['limit' => PAGE_COUNT_ADMIN]);
                            $this->set(compact(['result', 'countResult', 'pageStart']));
                        }
                    }
                }
            }
            $this->set(compact(['categories', 'getQualityCategories', 'dataCount', 'pageStart']));
        } catch (NotFoundException $e) {
            $attribute = $this->request->getAttribute('paging');
            $requestedPage = $attribute['Categories']['requestedPage'];
            $pageCount = $attribute['Categories']['pageCount'];
            if ($requestedPage > $pageCount) {
                return $this->redirect("/admin/categories?page=" . $pageCount . "");
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
        if ($this->request->is('POST')) {
            $category = trim(h($this->request->getData('category')));
            $question = $this->request->getData('question');
            $type_select = $this->request->getData('type_select');
            $answer = $this->request->getData('answer');
            if ($category == '') {
                $this->Flash->error(__(CATEGORY_CANNOT_BE_EMPTY));
                return $this->redirect($this->referer());
            } elseif ($question == null) {
                $session->write('nameError', $category);
                $this->Flash->error(__(CATEGORY_MUST_CONTAIN_AT_LEAST_ONE_QUESTION));
                return $this->redirect($this->referer());
            } else {
                if ($answer == null) {
                    $session->write('nameError', $category);
                    $this->Flash->error(__(SURVEY_HAS_AT_LEAST_TWO_ANSWERS));
                    return $this->redirect($this->referer());
                } else {
                    $arr = [];
                    $arrAnswerNull = [];
                    $arrKeyAnswer = [];
                    $arrCheckQuestion = [];
                    $arrCheckAnswer = [];
                    $arrTypeSelect = [];
                    foreach ($answer as $key => $value) {
                        array_push($arrKeyAnswer, $key);
                    }
                    foreach ($question as $key => $value) {
                        if (in_array($key, $arrKeyAnswer)) {
                            array_push($arr, [
                                'question' => $question[$key],
                                'type_select' => $type_select[$key],
                                'answer' =>  $answer[$key]
                            ]);
                        } else {
                            array_push($arrAnswerNull, 1);
                        }
                    }
                    foreach ($question as $item) {
                        if ($item == '') {
                            array_push($arrCheckQuestion, 1);
                        }
                    }
                    foreach ($answer as $item) {
                        foreach ($item as $item1) {
                            if ($item1 == '') {
                                array_push($arrCheckAnswer, 1);
                            }
                        }
                    }
                    foreach ($type_select as $item) {
                        if ($item != 1 && $item != 2) {
                            array_push($arrTypeSelect, 1);
                        }
                    }
                    foreach ($arr as $item) {
                        if ($item['answer'] == null || count($item['answer']) < 2) {
                            array_push($arrAnswerNull, 1);
                        }
                    }
                    if (count($arrCheckQuestion) > 0) {
                        $session->write('nameError', $category);
                        $this->Flash->error(__(SURVEY_CANNOT_BE_EMPTY));
                        return $this->redirect($this->referer());
                    } elseif (count($arrCheckAnswer) > 0) {
                        $session->write('nameError', $category);
                        $this->Flash->error(__(ANSWER_CANNOT_BE_EMPTY));
                        return $this->redirect($this->referer());
                    } elseif (count($arrAnswerNull) > 0) {
                        $session->write('nameError', $category);
                        $this->Flash->error(__(SURVEY_HAS_AT_LEAST_TWO_ANSWERS));
                        return $this->redirect($this->referer());
                    } elseif (count($arrTypeSelect) > 0) {
                        $session->write('nameError', $category);
                        $this->Flash->error(__(TYPE_SELECT_NOT_EXIT));
                        return $this->redirect($this->referer());
                    } else {
                        $arrUserSession = $session->read('arrUserSession');
                        $user_id = $arrUserSession['user_id'];
                        $dataCategory  = ['name' => trim(h($category)), 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')];
                        $this->{'Category'}->addCategory($dataCategory);
                        $latestIdCategory = $this->{'Category'}->getLatestIdCategory();
                        foreach ($arr as $item) {
                            $data = [
                                'question' => trim(h($item['question'])),
                                'description' => 'null',
                                'category_id' => $latestIdCategory,
                                'user_id' => $user_id,
                                'type_select' => $item['type_select'],
                                'created' => date('Y-m-d H:i:s'),
                                'modified' => date('Y-m-d H:i:s')
                            ];
                            $this->{'Survey'}->handelAddSurvey($data);
                            $latestIdSurvey = $this->{'Survey'}->getLatestIdSurvey();
                            foreach ($item['answer'] as $item1) {
                                $data = [
                                    'name' => htmlspecialchars(trim($item1)),
                                    'survey_id' => $latestIdSurvey,
                                    'created' => date('Y-m-d H:i:s'),
                                    'modified' => date('Y-m-d H:i:s')
                                ];
                                $this->{'Answer'}->addSingleAnswer($data);
                            }
                        }
                        $this->Flash->success(__(ADD_SUCCESSFULLY));
                        return $this->redirect(URL_INDEX_CATEGORY);
                    }
                }
            }
        }
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $this->isAdmin();
        $session = $this->request->getSession();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Categories');
        if (count($errorPage) == 0) {
            return $this->redirect(URL_404_PAGE_ADMIN);
        }
        $category = $this->{'Category'}->getCategoryById($id);
        $arrayValidate = [
            "name", 'prePage'
        ];
        $arrayRequest = [];
        $arrayCategory = [];
        $arrayValueRequest = [];
        foreach ($category  as $item) {
            array_push($arrayCategory, trim($item->name));
        }
        if ($this->request->is('POST')) {
            $prePage = trim($this->request->getData('prePage'));
            $allRequest = $this->request->getData();
            if ($session->check('oldPage') == false) {
                $session->write('oldPage', $prePage);
            }
            $oldPage = $session->read('oldPage');
            foreach ($allRequest as $key => $item) {
                array_push($arrayRequest, $key);
            }
            array_push($arrayValueRequest, trim(htmlspecialchars($item)));
            if (count(array_diff($arrayValidate, $arrayRequest)) > 0) {
                $this->Flash->error(__(INVALID_DATA));
                return $this->redirect($this->referer());
            } else if (count(array_diff($arrayCategory, $arrayValueRequest)) == 0) {
                $this->Flash->warning(__(YOU_HAVENT_CHANGED_ANYTHING));
                return $this->redirect($this->referer());
            }
            $name = $name = htmlspecialchars(trim($this->request->getData('name')));
            $data = ['name' => $name, 'modified' => date('Y-m-d H:i:s')];
            $result = $this->{'Category'}->editCategory($id, $data);
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
        $this->set(compact(['category']));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->isAdmin();
        if ($this->request->is(['POST', 'DELETE'])) {
            $getIssetCategory = $this->{'Category'}->getIssetCategory($id);
            if (count($getIssetCategory) > 0) {
                $this->Flash->error(__(DO_NOT_DELETE_CATEGORY));
                return $this->redirect($this->referer());
            } else {
                $result = $this->{'Category'}->deleteCategory($id);
                if ($result == true) {
                    $this->Flash->success(__(DELETE_SUCCESSFULLY));
                } else {
                    $this->Flash->error(__(DELETE_FAILED));
                }
                return $this->redirect($this->referer());
            }
        }
    }
}
