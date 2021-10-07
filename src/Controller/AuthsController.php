<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Session;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\RedirectRoute;
use Cake\Mailer\Mailer;
use Cake\Validation\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Cake\View\Helper\FormHelper;
use Seld\PharUtils\Timestamps;

require ROOT . '/vendor/phpmailer/phpmailer/src/Exception.php';
require ROOT . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require ROOT . '/vendor/phpmailer/phpmailer/src/SMTP.php';
/**
 * Auths Controller
 *  @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\Auth[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuthsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Auth');
    }
    // đăng ký thành viên
    public function register()
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $errors = '';
            $email =  $this->request->getData('email');
            $phone =  $this->request->getData('phone');
            $password = $this->request->getData('password');
            $data = ['email' => $email, 'phone' => $phone, 'password' => $password, 'avatar' => 'default-avatar.png', 'token' => $this->getToken(), 'status' => 2, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')];
            $result = $this->{'Auth'}->handelRegister($data);
            if ($result['status'] == true) {
                $queryEmail = $this->{'Auth'}->queryUserByEmail($email);
                foreach ($queryEmail as $user) {
                    $session->write('email', $user->email);
                    $session->write('role', $user->role);
                    $session->write('user_id', $user->id);
                }
                return $this->redirect('/');
            } else {
                if ($password == '') {
                    $session->write('errorPassword', 'Mật khẩu không được để trống');
                }
                $errors = $result['data'];
                $this->set(compact('errors'));
            }
        }
    }
    // đăng nhập
    public function login()
    {
        $session = $this->request->getSession();
        if ($session->check('user_id')) {
            return $this->redirect('/');
        } else {
            if ($this->request->is('post')) {
                $email =  $this->request->getData('email');
                $password =  $this->request->getData('password');
                $result = $this->{'Auth'}->handelLogin($email, $password);
                if ($result['status'] == true) {
                    $statusUser = '';
                    $queryEmail = $this->{'Auth'}->queryUserByEmail($email);
                    foreach ($queryEmail as $user) {
                        $statusUser = $user->status;
                    }
                    if ($statusUser == 1) {
                        $this->Flash->error(__('Tài khoản ' . $email . ' đang bị tạm khóa.Vui lòng liên hệ Quản trị viên'));
                        return  $this->redirect('');
                    } else {
                        foreach ($queryEmail as $user) {
                            $session->write('email', $user->email);
                            $session->write('role', $user->role);
                            $session->write('user_id', $user->id);
                        }
                        $this->redirect('/');
                    }
                } else {
                    $this->Flash->error(__($result['message']));
                    return  $this->redirect('');
                }
            }
        }
    }
    //đăng xuất
    public function logout()
    {
        $session = $this->request->getSession();
        $session->destroy();
        return $this->redirect('/Auth/login');
    }
    //thay đổi thông tin
    public function changeinfor()
    {
        $session = $this->request->getSession();
        if ($session->check('user_id')) {
            $user_id = $session->read('user_id');
            $get_user = $this->{'Auth'}->queryUserById($user_id);
            if ($this->request->is('post')) {
                $phone = $this->request->getData('phone');
                $address = $this->request->getData('address');
                if ($phone == '') {
                    $this->Flash->error(__('Số điện thoại không được để trống'));
                } else {
                    $avatar = $this->request->getData('avatar');
                    if (isset($user_id)) {

                        if ($avatar->getClientFilename() != '') {
                            $name = $avatar->getClientFilename() . date_timestamp_get(date_create());
                            $targetPath = WWW_ROOT . 'img/avatar' . DS . $name;
                            $avatar->moveTo($targetPath);
                            $this->{'Auth'}->handelChangeInfor($phone, $address, $user_id, $name);
                        } else {
                            $name = '';
                            $this->{'Auth'}->handelChangeInfor($phone, $address, $user_id, $name);
                        }
                        $this->Flash->success(__('Thay đổi thông tin thành công'));
                        return $this->redirect('');
                    }
                }
            }
            $this->set(compact(['get_user']));
        } else {
            return $this->redirect('/Auth/login');
        }
    }
    // thay đổi mật khẩu của người dùng
    public function changepassword()
    {
        $session = $this->request->getSession();
        if ($session->check('user_id')) {
            $user_id = $session->read('user_id');
            if ($this->request->is('post')) {
                $old_password = $this->request->getData('old_password');
                $new_password = $this->request->getData('new_password');
                $re_password = $this->request->getData('re_password');
                if ($old_password == '' || $new_password == '' || $re_password =  '') {
                    $this->Flash->error(__('Dữ liệu điền vào không được để trống'));
                } elseif ($old_password == $new_password) {
                    $this->Flash->error(__('Mật khẩu cũ và mật khẩu mới không được giống nhau'));
                }  else {
                    if (isset($user_id)) {
                        $old_password = md5($this->request->getData('old_password'));
                        $new_password = md5($this->request->getData('new_password'));
                        $check_user = $this->{'Auth'}->queryOldPassword($user_id, $old_password);
                        if (count($check_user) > 0) {
                            $this->{'Auth'}->handelChangePassword($new_password, $user_id);
                            $this->Flash->success(__('Thay đổi mật khẩu thành công'));
                        } else {
                            $this->Flash->error(__('Mật khẩu cũ không đúng'));
                        }
                    }
                }
            }
            $this->set(compact(['get_user']));
        } else {
            return $this->redirect('/Auth/login');
        }
    }
    // quên mật khẩu của người dùng
    public function forget()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $checkEmail = $this->{'Auth'}->queryUserByEmail($email);
            if (count($checkEmail) > 0) {
                $new_password = $this->getToken();
                $subject = 'Đặt lại mật khẩu mới';
                $message = '
                Xin chào ' . $email . '
                Chúng tôi đã nhận được yêu cầu đặt mật khẩu mới cho tài khoản này:
                Mật khẩu mới của bạn là : <strong>' . $new_password . '</strong>
                Vui lòng nhấn vào <a href="https://lctiendat.vn/Auth/login"><button style="border:none;padding:5px 20px 5px 20px;border-radius: 20px;background:blue;color:white;font-weight:bold;text-transform:uppercase;font-family:Calibri">Verify</button></a> để tiến hành đăng nhập và đổi lại mật khẩu
                ';
                $this->sendMail($email, $subject, $message);
                $this->Flash->success(__('Vui lòng vào email ' . $email . ' và làm theo hướng dẫn'));
                $new_password = md5($new_password);
                $this->{'Auth'}->handelUpdatePasswordByEmail($email, $new_password);
            } else {
                $this->Flash->error(__('Email không tồn tại trong hệ thống'));
            }
        }
    }
    // lấy ngẫu nhiên chuỗi token
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

    // module PHPMailer
    public function sendMail($to, $subject, $message)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $sender = "lctiendat@gmail.com";
        $header = "X-Mailer: PHP/" . phpversion() . "Return-Path: $sender";
        $mail = new PHPMailer();
        $mail->SMTPDebug  = 2;
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username   = "lctiendat@gmail.com";
        $mail->Password   = "Tiendat11082000";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->SMTPOptions = array(
            'tls' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->CharSet = 'UTF-8';
        $mail->From = $sender;
        $mail->FromName = "From Hệ Thống Khảo Sát";
        $mail->AddAddress($to);
        $mail->IsHTML(true);
        $mail->CreateHeader($header);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($message);
        $mail->AltBody = nl2br($message);
        $mail->SMTPDebug = false;
        $mail->do_debug = 0;
        if (!$mail->Send()) {
            return true;
        } else {
            return false;
        }
    }
}
