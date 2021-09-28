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
    public function register()
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $email =  $this->request->getData('email');
            $phone =  $this->request->getData('phone');
            $password = md5($this->request->getData('password'));
            $data = ['email' => $email, 'phone' => $phone, 'password' => $password, 'token' => $this->getToken(), 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')];
            $result = $this->{'Auth'}->handelRegister($data);
            $errors = '';
            if ($result['result'] == 'invalid') {
                $errors = $result['data'];
                $this->set(compact('errors'));
            } else {
                $session->write('success', $result['message']);
            }
            //dd($errors);
        }
    }
    public function login()
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $email =  $this->request->getData('email');
            $password =  md5($this->request->getData('password'));
            $result = $this->{'Auth'}->handelLogin($email, $password);
            if ($result == true) {
                $queryEmail = $this->{'Auth'}->queryUserByEmail($email);
                foreach ($queryEmail as $user) {
                    $session->write('email', $user->email);
                    $session->write('role', $user->role);
                    $session->write('user_id', $user->id);
                }
                $this->redirect('/');
            }
            $this->redirect('/Auth/login');
        }
    }
    public function logout()
    {
        $session = $this->request->getSession();
        $session->destroy();
        return $this->redirect('/Auth/login');
    }
    public function changeinfor()
    {
        $session = $this->request->getSession();
        if ($session->check('user_id')) {
            $user_id = $session->read('user_id');
            $get_user = $this->{'Auth'}->queryUserById($user_id);
            if ($this->request->is('post')) {
                $phone = $this->request->getData('phone');
                $address = $this->request->getData('address');
                $old_password =  md5($this->request->getData('old_password'));
                $password = md5($this->request->getData('new_password'));
                if (isset($user_id)) {
                    $check_user = $this->{'Auth'}->queryOldPassword($user_id, $old_password);
                    if (count($check_user) > 0) {
                        $this->{'Auth'}->handelChangeInfor($phone, $address, $password, $user_id);
                        echo '<script>alert("Thay đổi thông tin thành công") </script>';
                        return $this->redirect('/');
                    } else {
                        echo '<script>alert("Mật khẩu cũ không đúng") </script>';
                    }
                }
            }
            $this->set(compact(['get_user']));
        } else {
            return $this->redirect('/Auth/login');
        }
    }
    public function forget()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $checkEmail = $this->{'Auth'}->queryUserByEmail($email);
            if (count($checkEmail) > 0) {
                $getToken = $this->{'Auth'}->queryUserByEmail($email);
                foreach ($getToken as $user) {
                    $token = $user->token;
                }
                $subject = 'Renew Password';
                $message = 'Can you renew password to link : <a href="localhost/Auth/renew?token=' . $token . '">Link </a>';
                $this->send_mail($email, $subject, $message);
                echo '<script>alert("Vui lòng check mail để lấy lại mật khẩu");window.location.href="" </script>';
            } else {
                echo '<script>alert("Email không tồn tại trong hệ thống") </script>';
            }
        }
    }
    public function getToken()
    {
        $length = 30;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $getToken = '';
        for ($i = 0; $i < $length; $i++) {
            $getToken .= $characters[rand(0, $charactersLength - 1)];
        }
        return $getToken;
    }
    public function renewPassword()
    {
        $session = $this->request->getSession();
        if ($this->request->is('post')) {
            $token = $_GET['token'];
            $new_password = md5($this->request->getData('password'));
            $checkToken = $this->{'Auth'}->queryUserByToken($token);
            if (count($checkToken) > 0) {
                $this->{'Auth'}->changePasswordByToken($new_password, $token);
                $getUser =  $this->{'Auth'}->queryUserByToken($token);
                foreach ($getUser as $user) {
                    $session->write('email', $user->email);
                    $session->write('role', $user->role);
                    $session->write('user_id', $user->id);
                }
                $email = $session->read('email');
                $this->{'Auth'}->renewTokenByEmail($email);
                echo '<script>alert("Lấy lại mật khẩu thành công"); window.location.href="/"; </script>';
            } else {
                echo '<script>alert("Đường dẫn không hợp lệ") </script>';
            }
        }
    }
    public function testmail()
    {
        $to = 'lctiendat@gmail.com';
        $subject = 'Hi buddy, i got a message for you.';
        $message = 'Nothing much. Just test out my Email Component using PHPMailer.';

        try {
            $mail = $this->send_mail($to, $subject, $message);
            print_r($mail);
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ';
        }
        exit;
    }
    public function send_mail($to, $subject, $message)
    {
        // date_default_timezone_set('Asia/Calcutta');

        $sender = "lctiendat@gmail.com"; // this will be overwritten by GMail

        $header = "X-Mailer: PHP/" . phpversion() . "Return-Path: $sender";

        $mail = new PHPMailer();

        $mail->SMTPDebug  = 2; // turn it off in production
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username   = "lctiendat@gmail.com";
        $mail->Password   = "Tiendat11082000";
        $mail->SMTPSecure = "ssl"; // ssl and tls
        $mail->Port = 465; // 465 and 587

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

        $mail->From = $sender;
        $mail->FromName = "From Me";

        $mail->AddAddress($to);

        $mail->IsHTML(true);
        $mail->CreateHeader($header);

        $mail->Subject = $subject;
        $mail->Body    = nl2br($message);
        $mail->AltBody = nl2br($message);

        // return an array with two keys: error & message
        if (!$mail->Send()) {
            // return array('error' => true, 'message' => 'Mailer Error: ' . $mail->ErrorInfo);
            return true;
        } else {
            // return array('error' => false, 'message' =>  "Message sent!");
            return false;
        }
    }
}
