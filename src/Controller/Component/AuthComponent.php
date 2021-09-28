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
    public function queryUserByEmail($email)
    {
        return $this->Users->find()
            ->where(['email' => $email])
            ->all();
    }
    public function queryUserByPhone($phone)
    {
        return $this->Users->find()
            ->where(['phone' => $phone])
            ->all();
    }
    public function queryUserById($id)
    {
        return $this->Users->find()
            ->where(['id' => $id])
            ->all();
    }
    public function queryUserByToken($token)
    {
        return $this->Users->find()
            ->where(['token' => $token])
            ->all();
    }
    public function queryOldPassword($id, $oldPassword)
    {
        return $this->Users->find()
            ->where(['id' => $id])
            ->where(['password' => $oldPassword])
            ->all();
    }

    public function handelRegister($data)
    {
        // $user = ['email' => $email, 'phone' => $phone, 'password' => $password, 'token' => $this->getToken(), 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')];
        // $save_user = $this->Users->query();
        // $save_user->insert(['email', 'phone', 'password', 'token', 'created', "modified"])
        //     ->values($data)
        //     ->execute();
        $user = $this->Users->newEntity($data);
        $result = $this->Users->save($user);
        

        if ($user->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $user->getErrors()
            ];
        }
        return [
            'result' => 'success',
            'data' =>  $result,
            'message' => 'Đăng ký tài khoản thành công.Vui lòng đăng nhập'
        ];
    }
    public function handelLogin($email, $password)
    {
        $result = $this->Users->find()->where(['email' => $email])->where(['password' => $password])->all();
        return count($result) > 0 ? true : false;
    }
    public function handelChangeInfor($phone, $address, $password, $user_id)
    {
        $query_user =  $this->Users->query();
        $query_user->update()->set(['phone' => $phone, 'address' => $address, 'password' => $password])
            ->where(['id' => $user_id])->execute();
    }
    public function changePasswordByToken($new_password, $token)
    {
        $query_user = TableRegistry::getTableLocator()->get('Users')->query();
        $query_user->update()->set(['password' => $new_password, 'modified' => date('Y-m-d H:m:s')])
            ->where(['token' => $token])->execute();
    }
    public function renewTokenByEmail($email)
    {
        $query_user = TableRegistry::getTableLocator()->get('Users')->query();
        $query_user->update()->set(['token' => $this->getToken()])
            ->where(['email' =>$email])->execute();
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
}
