<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;
use Cake\ORM\TableRegistry;


class AuthComponent extends CommonComponent
{
    public function initialize(array $config): void
    {
        $this->loadModel(['Users']);
    }

    // lấy user dựa theo email
    public function queryUserByEmail($email)
    {
        return $this->Users->find()
            ->where(['email' => $email])
            ->all();
    }

    // lấy user dựa theo phone
    public function queryUserByPhone($phone)
    {
        return $this->Users->find()
            ->where(['phone' => $phone])
            ->all();
    }

    // lấy user dựa theo id
    public function queryUserById($id)
    {
        return $this->Users->find()
            ->where(['id' => $id])
            ->all();
    }

    // lấy user dựa theo token
    public function queryUserByToken($token)
    {
        return $this->Users->find()
            ->where(['token' => $token])
            ->all();
    }

    // kiểm tra user dựa theo mật khẩu cũ
    public function queryOldPassword($id, $oldPassword)
    {
        return $this->Users->find()
            ->where(['id' => $id])
            ->where(['password' => $oldPassword])
            ->all();
    }

    // xử lí phần đăng ký
    public function handelRegister($data)
    {
        $data['password'] = md5($data['password']);
        $user = $this->Users->newEntity($data);
        $result = $this->Users->save($user);
        if ($user->hasErrors()) {
            return [
                'status' => false,
                'data' => $user->getErrors()
            ];
        } else {
            return [
                'status' => true,
                'data' =>  $result,
                'message' => 'Đăng ký tài khoản thành công. Vui lòng đăng nhập'
            ];
        }
    }

    // xử lí phần đăng nhập
    public function handelLogin($email, $password)
    {
        if ($email == '') {
            return [
                'status' => false,
                'message' => 'Email không được để trống'
            ];
        } else if ($password == '') {
            return [
                'status' => false,
                'message' => 'Mật khẩu không được để trống'
            ];
        } else {
            $password = md5($password);
            $result = $this->Users->find()->where(['email' => $email])->where(['password' => $password])->all();
            return count($result) > 0 ? [
                'status' => true
            ] : [
                'status' => false,
                'message' => 'Tài khoản hoặc mật khẩu không chính xác'
            ];
        }
    }

    // xử lí phần thay đổi thông tin người dùng
    public function handelChangeInfor($phone, $address, $user_id, $avatar)
    {
        if ($avatar != '') {
            $query_user =  $this->Users->query();
            $query_user->update()->set(['phone' => $phone, 'address' => $address, 'avatar' => $avatar])
                ->where(['id' => $user_id])->execute();
        } else {
            $query_user =  $this->Users->query();
            $query_user->update()->set(['phone' => $phone, 'address' => $address])
                ->where(['id' => $user_id])->execute();
        }
    }

    //xử lí phần thay đổi mật khẩu
    public function handelChangePassword($password, $user_id)
    {
        $query_user =  $this->Users->query();
        $query_user->update()->set(['password' => $password])
            ->where(['id' => $user_id])->execute();
    }

    // thay đổi mật khẩu dựa theo token
    public function changePasswordByToken($new_password, $token)
    {
        $query_user = $this->Users->query();
        $query_user->update()->set(['password' => $new_password, 'modified' => date('Y-m-d H:m:s')])
            ->where(['token' => $token])->execute();
    }

    // đổi mật khẩu dựa theo email và token
    public function renewTokenByEmail($email)
    {
        $query_user = $this->Users->query();
        $query_user->update()->set(['token' => $this->getToken()])
            ->where(['email' => $email])->execute();
    }

    //lấy token
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

    // lấy tất cả usre
    public function getAllUser()
    {
        return $this->Users->find();
    }

    //Xử lí phần edit user
    public function handelEditUser($id, $data)
    {
        $user = $this->Users->get($id);
        $data['password'] = md5($data['password']);
        $user = $this->Users->patchEntity($user, $data);
        $result = $this->Users->save($user);
        if ($user->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $user->getErrors()
            ];
        }
        return [
            'result' => 'success',
            'data' =>  $result
        ];
    }

    //Xử lí phần xóa User
    public function handelDeleteUser($id)
    {
        $query_user = $this->Users->query();
        $query_user->delete()->where(['id' => $id])->execute();
        return $query_user ? true : false;
    }

    // xử lí phần đổi mật khẩu dựa theo email
    public function handelUpdatePasswordByEmail($email, $new_password)
    {
        $query_user = $this->Users->query();
        $query_user->update()->set(['password' => $new_password, 'modified' => date('Y-m-d H:m:s')])
            ->where(['email' => $email])->execute();
    }
}
