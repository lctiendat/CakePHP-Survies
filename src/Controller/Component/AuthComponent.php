<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;

class AuthComponent extends CommonComponent
{
    /**
     * Initialize method
     */
    public function initialize(array $config): void
    {
        $this->loadModel([
            'Users',
            'Categories',
            'Results'
        ]);
    }

    /**
     * Handle get user by email method
     */
    public function queryUserByEmail($email)
    {
        $query = $this->Users->find()
            ->where(['email' => $email])
            ->all();;
        return $query;
    }

    /**
     * Handle get user by id method
     */
    public function queryUserById($id)
    {
        $query = $this->Users->find()
            ->where(['id' => $id])
            ->all();
        return $query;
    }

    /**
     * Handle check old password method
     */
    public function queryOldPassword($id, $oldPassword)
    {
        $query = $this->Users->find()
            ->where([
                'id' => $id,
                'password' => $oldPassword
            ])
            ->all();
        return $query;
    }

    /**
     * Handle register method
     */
    public function register($data)
    {
        $user = $this->Users->newEntity($data);
        if ($user->hasErrors()) {
            return [
                'status' => false,
                'data' => $user->getErrors()
            ];
        } else {
            $user['password'] = md5($data['password']);
            $result = $this->Users->save($user);
            return [
                'status' => true,
                'data' =>  $result,
                'message' => REGISTER_SUCCESS
            ];
        }
    }

    /**
     * Handle login method
     */
    public function login($email, $password)
    {
        if ($email == '') {
            return [
                'status' => false,
                'message' => errorEmail
            ];
        } else if ($password == '') {
            return [
                'status' => false,
                'message' => errorPassword
            ];
        } else {
            $password = md5($password);
            $result = $this->Users->find()
                ->where([
                    'email' => $email,
                    'password' => $password

                ])->toArray();
            return count($result) > 0 ? [
                'status' => true
            ] : [
                'status' => false,
                'message' => EMAIL_OR_PASSWORD_INCORRECT
            ];
        }
    }

    /**
     * Handle change infor method
     */
    public function changeinfor($phone, $address, $user_id, $avatar)
    {

        if ($avatar != '') {
            if ($phone == '') {
                return [
                    'status' => false,
                    'message' => errorPhone
                ];
            } elseif (!preg_match('/^(((0))[0-9]{9})$/', $phone)) {
                return [
                    'status' => false,
                    'message' => errorPhone
                ];
            }
            $query_user =  $this->Users->query();
            $query_user->update()
                ->set([
                    'phone' => $phone,
                    'address' => $address,
                    'avatar' => $avatar
                ])
                ->where(['id' => $user_id])
                ->execute();

            return [
                'status' => true,
                'message' => CHANGE_INFOR_SUCCESS
            ];
        } else {
            if ($phone == '') {
                return [
                    'status' => false,
                    'message' => errorPhone
                ];
            } elseif (!preg_match('/^(((0))[0-9]{9})$/', $phone)) {
                return [
                    'status' => false,
                    'message' => errorPhone
                ];
            }
            $query_user =  $this->Users->query();
            $query_user->update()
                ->set([
                    'phone' => $phone,
                    'address' => $address
                ])
                ->where(['id' => $user_id])
                ->execute();
            return [
                'status' => true,
                'message' => CHANGE_INFOR_SUCCESS
            ];
        }
    }

    /**
     * Handle change password method
     */
    public function changePassword($password, $user_id)
    {
        $query =  $this->Users->query();
        $query->update()
            ->set(['password' => $password])
            ->where(['id' => $user_id])
            ->execute();
    }

    /**
     * Get token method
     */
    public function getToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $getToken = '';
        for ($i = 0; $i < 10; $i++) {
            $getToken .= $characters[rand(0, $charactersLength - 1)];
        }
        return $getToken;
    }

    /**
     * Handle get all user method
     */
    public function getAllUser()
    {
        $query = $this->Users->find()
            ->select([
                'id',
                'email',
                'phone',
                'str_status' => 'CASE WHEN status = 2 THEN "Enable" ELSE"Disable" END',
                'str_role' => 'CASE WHEN role = 9 THEN "Admin" ELSE"User" END'
            ]);
        return  $query;
    }

    /**
     * Handle edit user method
     */
    public function editUser($id, $data)
    {
        if ($data['password'] == '') {
            unset($data['password']);
            $user = $this->Users->get($id);
            $user = $this->Users->patchEntity($user, $data);
            $result = $this->Users->save($user);
            if ($user->hasErrors()) {
                return [
                    'status' => false,
                    'data' => $user->getErrors()
                ];
            }
            return [
                'status' => true,
                'data' =>  $result
            ];
        } else {
            $user = $this->Users->get($id);
            $user = $this->Users->patchEntity($user, $data);
            $data['password'] = md5($data['password']);
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
    }

    /**
     * Handle update password by email method
     */
    public function updatePasswordByEmail($email, $new_password)
    {
        $query = $this->Users->query();
        $query->update()
            ->set([
                'password' => $new_password,
                'modified' => date('Y-m-d H:i:s')
            ])
            ->where(['email' => $email])
            ->execute();
    }

    /**
     * Handle show history voted from user
     */
    public function historyVoted($user_id)
    {
        $query = $this->Categories->find()
            ->where([
                'id IN' => $this->Results->find()
                    ->select(['category_id'])
                    ->where(['user_id' => $user_id]),
                'DELETE_FLG' => 0
            ]);
        return $query;
    }
}
