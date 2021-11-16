<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

class UsersController extends AppController
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
            $users =  $this->paginate($this->{'Auth'}->getAllUser(), ['limit' => PAGE_COUNT_ADMIN]);
            $getQualityUser = count($this->{'Auth'}->getAllUser()->toArray());
            $dataPage = $this->request->getAttribute('paging');
            $dataCount = $dataPage['Users']['count'] - $dataPage['Users']['start'] + 1;
            $pageStart = $dataPage['Users']['start'];
            if ($this->request->is(['GET'])) {
                $key = $this->request->getQuery('key');
                $session->write('valueSearch', $key);
                $sort = $this->request->getQuery('sort');
                $direction = $this->request->getQuery('direction');
                $arrayKey = ["id", 'email', "phone", 'created'];
                if (isset($sort) && isset($direction)) {
                    if (in_array($sort, $arrayKey) == 1 && $direction == 'asc' || in_array($sort, $arrayKey) == 1 && $direction == 'desc') {
                        $result = $this->paginate($this->{'Home'}->sortDataAdmin($key, 'Users', $sort, $direction), ['limit' => PAGE_COUNT_ADMIN]);
                        $countResult = count($this->{'Home'}->sortDataAdmin($key, 'Users', $sort, $direction)->toArray());
                        $this->set(compact(['result', 'countResult', 'dataCount', 'pageStart']));
                    }
                } elseif (isset($sort) && isset($direction) && $key != '') {
                    if (in_array($sort, $arrayKey) == 1 && $direction == 'asc' || in_array($sort, $arrayKey) == 1 && $direction == 'desc') {
                        $result = $this->paginate($this->{'Home'}->sortDataAdmin($key, 'Users', $sort, $direction), ['limit' => PAGE_COUNT_ADMIN]);
                        $countResult = count($this->{'Home'}->sortDataAdmin($key, 'Users', $sort, $direction)->toArray());
                        $this->set(compact(['result', 'countResult', 'dataCount', 'pageStart']));
                    }
                } elseif (isset($key)) {
                    if ($key == '') {
                        $this->set(compact(['users']));
                    } else {
                        $result = $this->{'Home'}->search(trim($key), 'Users', 'email')->toArray();
                        if ($result == []) {
                            $countResult = count($result);
                            $this->set(compact(['result', 'dataCount', 'pageStart', 'countResult']));
                            $this->Flash->error(__(DATA_NOT_FOUND));
                        } else {
                            $countResult = count($result);
                            $result = $this->paginate($this->{'Home'}->search(trim($key), 'Users', 'email'), ['limit' => PAGE_COUNT_ADMIN]);
                            $this->set(compact(['result', 'countResult', 'dataCount', 'pageStart']));
                        }
                    }
                }
            }
            $this->set(compact(['users', 'getQualityUser', 'pageCurrent', 'pageStart']));
        } catch (NotFoundException $e) {
            $attribute = $this->request->getAttribute('paging');
            $requestedPage = $attribute['Users']['requestedPage'];
            $pageCount = $attribute['Users']['pageCount'];
            if ($requestedPage > $pageCount) {
                return $this->redirect("/admin/users?page=" . $pageCount . "");
            }
        }
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $this->isAdmin();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Users');
        $session = $this->request->getSession();
        if (count($errorPage) == 0) {
            return $this->redirect(URL_404_PAGE_ADMIN);
        }
        $user = $this->{'Auth'}->queryUserById($id);
        $arrayValidate = [
            "phone",
            "password",
            "address",
            "status",
            "role"
        ];
        $arrayRequest = [];
        $arrayUser = [];
        $arrayValueRequest = [];
        foreach ($user as $item) {
            array_push($arrayUser, $item->phone);
            array_push($arrayUser, $item->password);
            array_push($arrayUser, $item->address);
            array_push($arrayUser, $item->status);
            array_push($arrayUser, $item->role);
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
                array_push($arrayValueRequest, trim($item));
            }
            if (count(array_diff($arrayValidate, $arrayRequest)) > 0) {
                $this->Flash->error(__(INVALID_DATA));
                return $this->redirect($this->referer());
            }
            $phone = h(trim($this->request->getData('phone')));
            $address = h(trim($this->request->getData('address')));
            $password = h(trim($this->request->getData('password')));
            $status = h(trim($this->request->getData('status')));
            $role = h(trim($this->request->getData('role')));
            if ($status != 1 && $status != 2) {
                $this->Flash->error(__(STATUS_NO_EXIT));
                $arrOldValueSession = [
                    'OldValueAddress' => $address,
                    'OldValuePhone' => $phone,
                ];
                $session->write('arrOldValueSession', $arrOldValueSession);
            } elseif ($role != 0 && $role != 9) {
                $this->Flash->error(__(ROLE_NO_EXIT));
                $arrOldValueSession = [
                    'OldValueAddress' => $address,
                    'OldValuePhone' => $phone,
                ];
                $session->write('arrOldValueSession', $arrOldValueSession);
            } else {
                if ($password == '') {
                    $password = '';
                    $errors = '';
                    $data = [
                        'phone' => $phone,
                        'address' => $address,
                        'password' => $password,
                        'status' => $status,
                        'role' => $role,
                        'modified' => date('Y-m-d H:i:s')
                    ];
                    $result = $this->{'Auth'}->editUser($id, $data);
                    unset($arrayUser[1]);
                    unset($arrayValueRequest[0]);
                    unset($arrayValueRequest[2]);
                    if (count(array_diff($arrayUser, $arrayValueRequest))  == 0) {
                        $this->Flash->warning(__(YOU_HAVENT_CHANGED_ANYTHING));
                        return $this->redirect($this->referer());
                    } else {
                        if ($result['status'] == false) {
                            $session->write('phoneError', $phone);
                            $session->write('addressError', $address);
                            $session->write('passwordError', $password);
                            $errors = $result['data'];
                            $this->set(compact(['errors']));
                        } else {
                            $this->Flash->success(__(EDITING_IS_SUCCESSFULLY));
                            return $this->redirect($oldPage);
                        }
                    }
                } else {
                    $data = ['phone' => $phone, 'address' => $address, 'password' => $password, 'status' => $status, 'role' => $role, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')];
                    $result = $this->{'Auth'}->editUser($id, $data);
                    $errors = '';
                    unset($arrayValueRequest[0]);
                    $arrayValueRequest[2] = md5($arrayValueRequest[2]);
                    if (count(array_diff($arrayUser, $arrayValueRequest))  == 0) {
                        $this->Flash->warning(__(YOU_HAVENT_CHANGED_ANYTHING));
                        return $this->redirect($this->referer());
                    } else {
                        if ($result['result'] == 'invalid') {
                            $session->write('phoneError', $phone);
                            $session->write('addressError', $address);
                            $session->write('passwordError', $password);
                            $errors = $result['data'];
                            $this->set(compact(['errors']));
                        } else {
                            $this->Flash->success(__(EDITING_IS_SUCCESSFULLY));
                            return $this->redirect($oldPage);
                        }
                    }
                }
            }
        }
        $this->set(compact(['user']));
    }
}
