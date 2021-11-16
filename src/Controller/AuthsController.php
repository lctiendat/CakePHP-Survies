<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;

class authsController extends AppController
{
    /**
     * Register method
     */
    public function register()
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $errors = '';
            $email =  trim($this->request->getData('email'));
            $phone =  trim($this->request->getData('phone'));
            $password = trim($this->request->getData('password'));
            $data = ['email' => $email, 'phone' => $phone, 'password' => $password, 'avatar' => 'default-avatar.png', 'token' => $this->{'Auth'}->getToken(), 'status' => 2, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')];
            $result = $this->{'Auth'}->register($data);
            if ($result['status'] == true) {
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
                return $this->redirect(URL_INDEX);
            } else {
                $arrOldValueSession = [
                    'OldValueEmail' => $email,
                    'OldValuePhone' => $phone,
                ];
                $session->write('arrOldValueSession', $arrOldValueSession);
                $errors = $result['data'];
                $this->set(compact(['errors']));
            }
        }
    }

    /**
     * Login method
     */
    public function login()
    {
        $session = $this->request->getSession();
        if ($session->check('arrUserSession')) {
            return $this->redirect(URL_INDEX);
        } else {
            if ($this->request->is('post')) {
                $email =  $this->request->getData('email');
                $password =  $this->request->getData('password');
                $result = $this->{'Auth'}->login($email, $password);
                if ($result['status'] == true) {
                    $statusUser = '';
                    $queryEmail = $this->{'Auth'}->queryUserByEmail($email);
                    foreach ($queryEmail as $user) {
                        $statusUser = $user->status;
                    }
                    if ($statusUser == 1) {
                        $this->Flash->error(__('Tài khoản ' . $email . ' đang bị tạm khóa.Vui lòng liên hệ Quản trị viên'));
                        $arrOldValueSession = [
                            'OldValueEmail' => $email,
                        ];
                        $session->write('arrOldValueSession', $arrOldValueSession);
                        return  $this->redirect('');
                    } else {
                        $session->delete('OldValue');
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
                        $arrOldValueSession = [];
                        $session->write('arrOldValueSession', $arrOldValueSession);
                        if ($arrUserSession['role'] == 9) {
                            $this->redirect(URL_ADMIN);
                        }
                        $this->redirect(URL_INDEX);
                    }
                } else {
                    $arrOldValueSession = [
                        'OldValueEmail' => $email,
                    ];
                    $session->write('arrOldValueSession', $arrOldValueSession);
                    $this->Flash->error(__($result['message']));
                    return  $this->redirect('');
                }
            }
        }
    }

    /**
     * Logout method
     */
    public function logout()
    {
        $session = $this->request->getSession();
        $session->destroy();
        return $this->redirect(URL_INDEX);
    }

    /**
     * Change infor method
     */
    public function changeinfor()
    {
        $session = $this->request->getSession();
        if ($session->check('arrUserSession')) {
            $arrUserSession = $session->read('arrUserSession');
            $user_id = $arrUserSession['user_id'];
            $get_user = $this->{'Auth'}->queryUserById($user_id);
            $arrayRequest = [];
            $arrayUser = [];
            $arrayValueRequest = [];
            foreach ($get_user as $item) {
                array_push($arrayUser, $item->phone);
                array_push($arrayUser, $item->address);
                array_push($arrayUser, $item->avatar);
            }
            if ($this->request->is('post')) {
                $avatar = $this->request->getData('avatar');
                $prePage = trim($this->request->getData('prePage'));
                if ($session->check('oldPage') == false) {
                    $session->write('oldPage', $prePage);
                }
                $oldPage = $session->read('oldPage');
                $allRequest = h($this->request->getData());
                if (count(array_diff($arrayUser, $arrayValueRequest))  == 0) {
                    $this->Flash->warning(__(YOU_HAVENT_CHANGED_ANYTHING));
                    return $this->redirect($this->referer());
                }
                $phone = h(trim($this->request->getData('phone')));
                $address = h(trim($this->request->getData('address')));
                if (isset($user_id)) {
                    if ($avatar->getClientFilename() != '') {
                        foreach ($allRequest as $key => $item) {
                            array_push($arrayRequest, $key);
                            array_push($arrayValueRequest, h(trim($item)));
                        }
                        array_push($arrayValueRequest, $name = $avatar->getClientFilename());
                        unset($arrayValueRequest[0]);
                        unset($arrayValueRequest[3]);
                        $get_timestamp_avartar = substr($arrayUser[2], -10);
                        $arrayUser[2] = str_replace($get_timestamp_avartar, '', $arrayUser[2]);
                        $arrayValueRequest[2] = h($arrayValueRequest[2]);
                        if (count(array_diff($arrayUser, $arrayValueRequest))  == 0) {
                            $this->Flash->warning(__(YOU_HAVENT_CHANGED_ANYTHING));
                            return $this->redirect($this->referer());
                        } else {
                            $name = $avatar->getClientFilename() . date_timestamp_get(date_create());
                            $targetPath = WWW_ROOT . 'img/avatar' . DS . $name;
                            $avatar->moveTo($targetPath);
                            $result = $this->{'Auth'}->changeinfor($phone, h($address), $user_id, $name);
                            if ($result['status'] == true) {
                                $this->Flash->success(__($result['message']));
                                return $this->redirect($this->referer());
                            } else {
                                $arrOldValueSession = [
                                    'OldValueAddress' => $address,
                                    'OldValuePhone' => $phone,
                                ];
                                $session->write('arrOldValueSession', $arrOldValueSession);
                                $this->Flash->error(__($result['message']));
                                return $this->redirect('');
                            }
                        }
                    } else {
                        foreach ($allRequest as $key => $item) {
                            array_push($arrayRequest, $key);
                            array_push($arrayValueRequest, h(trim($item)));
                        }
                        unset($arrayValueRequest[0]);
                        unset($arrayValueRequest[3]);
                        $name = '';
                        unset($arrayUser[2]);
                        $arrayValueRequest['2'] = h($arrayValueRequest['2']);
                        if (count(array_diff($arrayUser, $arrayValueRequest))  == 0) {
                            $this->Flash->warning(__(YOU_HAVENT_CHANGED_ANYTHING));
                            return $this->redirect($this->referer());
                        } else {
                            $result = $this->{'Auth'}->changeinfor($phone, h($address), $user_id, h($name));
                            if ($result['status'] == true) {
                                $this->Flash->success(__($result['message']));
                                return $this->redirect($this->referer());
                            } else {
                                $arrOldValueSession = [
                                    'OldValueAddress' => h($address),
                                    'OldValuePhone' => h($phone),
                                ];
                                $session->write('arrOldValueSession', $arrOldValueSession);
                                $this->Flash->error(__($result['message']));
                                return $this->redirect('');
                            }
                        }
                    }
                }
            }
            $this->set(compact(['get_user']));
        } else {
            return $this->redirect(URL_AUTH_LOGIN);
        }
    }

    /**
     * Change password method
     */
    public function changepass()
    {
        $session = $this->request->getSession();
        if ($session->check('arrUserSession')) {
            $arrUserSession = $session->read('arrUserSession');
            $user_id = $arrUserSession['user_id'];
            if ($this->request->is('post')) {
                $old_password = $this->request->getData('old_password');
                $new_password = $this->request->getData('new_password');
                $renew_password = $this->request->getData('renew_password');
                if ($old_password == '' || $new_password == '' || $renew_password == '') {
                    $arrOldValueSession = [
                        'OldValueOldPassword' => $old_password,
                        'OldValueNewPassword' => $new_password,
                        'OldValueReNewPassword' => $renew_password,
                    ];
                    $session->write('arrOldValueSession', $arrOldValueSession);
                    $this->Flash->error(__(INPUT_DATA_CANNOT_BE_LEFT_BLANK));
                } elseif ($old_password == $new_password) {
                    $arrOldValueSession = [
                        'OldValueOldPassword' => $old_password,
                        'OldValueNewPassword' => $new_password,
                        'OldValueReNewPassword' => $renew_password,
                    ];
                    $session->write('arrOldValueSession', $arrOldValueSession);
                    $this->Flash->error(__(OLD_PASSWORD_AND_NEW_PASSWORD_MUST_NOT_BE_THE_SAME));
                } elseif ($new_password != $renew_password) {
                    $this->Flash->error(__(RE_ENTERED_PASSWORD_IS_NOT_THE_SAME));
                    $arrOldValueSession = [
                        'OldValueOldPassword' => $old_password,
                        'OldValueNewPassword' => $new_password,
                        'OldValueReNewPassword' => $renew_password,
                    ];
                    $session->write('arrOldValueSession', $arrOldValueSession);
                } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $new_password)) {
                    $arrOldValueSession = [
                        'OldValueOldPassword' => $old_password,
                        'OldValueNewPassword' => $new_password,
                        'OldValueReNewPassword' => $renew_password,
                    ];
                    $session->write('arrOldValueSession', $arrOldValueSession);
                    $this->Flash->error(__(PASSWORD_IS_NOT_STRONG_ENOUGH));
                } else {
                    if (isset($user_id)) {
                        $old_password = md5($this->request->getData('old_password'));
                        $new_password = md5($this->request->getData('new_password'));
                        $check_user = $this->{'Auth'}->queryOldPassword($user_id, $old_password);
                        if (count($check_user) > 0) {
                            $this->{'Auth'}->changePassword($new_password, $user_id);
                            $this->Flash->success(__(CHANGE_PASSWORD_SUCCESSFULLY));
                            $arrOldValueSession = [];
                            $session->write('arrOldValueSession', $arrOldValueSession);
                            $this->redirect(URL_INDEX);
                        } else {
                            $old_password = $this->request->getData('old_password');
                            $new_password = $this->request->getData('new_password');
                            $renew_password = $this->request->getData('renew_password');
                            $arrOldValueSession = [
                                'OldValueOldPassword' => $old_password,
                                'OldValueNewPassword' => $new_password,
                                'OldValueReNewPassword' => $renew_password,
                            ];
                            $session->write('arrOldValueSession', $arrOldValueSession);
                            $this->Flash->error(__(OLD_PASSWORD_IS_INCORRECT));
                        }
                    }
                }
            }
        } else {
            return $this->redirect(URL_AUTH_LOGIN);
        }
    }

    /**
     * Forget password method
     */
    public function forget()
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $checkEmail = $this->{'Auth'}->queryUserByEmail($email);
            if (count($checkEmail) > 0) {
                $new_password = $this->{'Auth'}->getToken();
                $subject = 'Đặt lại mật khẩu mới';
                $message = '
                Hi ' . $email . '
                We have received a request to set a new password for this account :
                    Your new password is: <strong>' . $new_password . '</strong>
                    Please click <a href="' . URL_DOMAIN_NAME . '"><button style="border:none;padding:5px 20px 5px 20px;border-radius: 20px;background:blue;color:white;font-weight:bold;text-transform:uppercase;font-family:Calibri">Verify</button></a> to proceed to login and change password.
                ';
                $this->{'Home'}->sendMail($email, $subject, $message);
                $this->Flash->success(__('Please go to email ' . $email . ' and follow the instructions'));
                $new_password = md5($new_password);
                $this->{'Auth'}->updatePasswordByEmail($email, $new_password);
                $arrOldValueSession = [];
                $session->write('arrOldValueSession', $arrOldValueSession);
            } else if ($email == '') {
                $this->Flash->error(__(errorEmail));
            } else if (!preg_match('/^[a-z0-9.]+@[a-z0-9]+\.[a-z]{2,}$/', $email)) {
                $this->Flash->error(__(EMAIL_INVALIDATE));
                $arrOldValueSession = [
                    'OldValueEmail' => $email
                ];
                $session->write('arrOldValueSession', $arrOldValueSession);
            } else {
                $arrOldValueSession = [
                    'OldValueEmail' => $email
                ];
                $session->write('arrOldValueSession', $arrOldValueSession);
                $this->Flash->error(__(EMAIL_DOES_NOT_EXIST_IN_THE_SYSTEM));
            }
        }
    }

    /**
     * History voted method
     */
    public function history()
    {
        $session = $this->request->getSession();
        if ($session->check('arrUserSession')) {
            $arrUserSession = $session->read('arrUserSession');
            $user_id = $arrUserSession['user_id'];
            $categories = $this->paginate($this->{'Auth'}->historyVoted($user_id), ['limit' => PAGE_COUNT_CLIENT]);
            $countCategoryChoose = count($this->{'Auth'}->historyVoted($user_id)->toArray());
            $this->set(compact(['categories', 'countCategoryChoose']));
            if ($this->request->is(['GET'])) {
                $key = $this->request->getQuery('key');
                $session->write('valueSearch', $key);
                if ($key == '') {
                    $this->set(compact(['survies']));
                } else {
                    $result = $this->{'Home'}->searchHistorySurveyUserChoose($user_id, $key)->toArray();
                    if ($result == []) {
                        $this->set(compact(['result']));
                        $session->write('searchError', DATA_NOT_FOUND);
                    } else {
                        $countResult = count($result);
                        $result = $this->paginate($this->{'Home'}->searchHistorySurveyUserChoose($user_id, $key), ['limit' => PAGE_COUNT_CLIENT]);
                        $this->set(compact(['result', 'countResult']));
                    }
                }
            }
        } else {
            return $this->redirect(URL_AUTH_LOGIN);
        }
    }
}
