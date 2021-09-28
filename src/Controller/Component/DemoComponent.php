<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;

class DemoComponent extends CommonComponent
{
    public function initialize(array $config): void
    {
        $this->loadModel(['DUser']);
    }

    // ユーザデータ取得
    public function getAllUser($key = null)
    {
        $query = $this->DUser->find()
            ->select([
                'DUser.user_id',
                'DUser.user_name',
                'DUser.office_name',
                'DUser.register_date',
                'DUser.last_login_date',
                'DUser.rank',
                'privilege_name'=>'MPrivilege.privilege_name'
            ])
            ->join([
                'table' => 'm_privilege',
                'alias' => 'MPrivilege' ,
                'type' => 'left',
                'conditions' => ['DUser.rank = MPrivilege.privilege_display_id', 'MPrivilege.delete_flg' => 0]
            ])
            ->where([
                'DUser.delete_flg' => 0,
                'OR' => [
                    'DUser.user_name like' => '%' . $key . '%',
                    'DUser.office_name like' => '%' . $key . '%'
                ]
            ]);
        return $query;
    }

     // アカウント名によるユーザデータ取得
    public function getUserByUserName($user_name): array
    {
        $data = $this->DUser->find()
            ->where([
                'DUser.user_name' => $user_name,
                'DUser.delete_flg' => 0,
            ])->first();

        return $data ? $data->toArray() : [];
    }

    // ユーザIDによるユーザデータ取得
    public function getUserById($user_id): array
    {
        $data = $this->DUser->find()
            ->select([
                'DUser.user_id',
                'DUser.user_name',
                'DUser.office_name',
                'DUser.mail_address',
                'DUser.open_mail_address',
                'str_open_mail_address' => 'CASE
                                            WHEN DUser.open_mail_address = 0 THEN "いいえ"
                                            WHEN DUser.open_mail_address = 1 THEN "はい"
                                            ELSE ""
                                        END',
                'DUser.home_page',
                'DUser.tel_no',
                'DUser.fax_no',
                'DUser.category',
                'DUser.address',
                'DUser.staff_name',
                'DUser.staff_tel_no',
                'DUser.business_hours',
                'DUser.profile',
                'DUser.enter_signature',
                'str_enter_signature' =>    'CASE
                                                WHEN DUser.enter_signature = 0 THEN "いいえ"
                                                WHEN DUser.enter_signature = 1 THEN "はい"
                                                ELSE ""
                                            END',
                'DUser.comment_display_mode',
                'str_comment_display_mode' => 'CASE
                                                    WHEN DUser.comment_display_mode = 0 THEN "ネスト表示"
                                                    WHEN DUser.comment_display_mode = 1 THEN "フラット表示"
                                                    WHEN DUser.comment_display_mode = 2 THEN "スレッド表示"
                                                    ELSE""
                                                END',
                'DUser.comment_sort',
                'str_comment_sort'  => 'CASE
                                            WHEN DUser.comment_sort = 0 THEN "古いものから"
                                            WHEN DUser.comment_sort = 1 THEN "新しいものから"
                                            ELSE ""
                                        END',
                'DUser.notification_method',
                'str_notification_method' =>    'CASE
                                                    WHEN DUser.notification_method = 0 THEN "一時的に中止"
                                                    WHEN DUser.notification_method = 1 THEN "プライベート・メッセージ"
                                                    WHEN DUser.notification_method = 2 THEN "メール"
                                                    ELSE""
                                                END',
                'DUser.notification_timing',
                'str_notification_timing' =>   'CASE
                                                    WHEN DUser.notification_timing = 0 THEN "イベント更新時に必ず通知する"
                                                    WHEN DUser.notification_timing = 1 THEN "一度だけ通知する"
                                                    WHEN DUser.notification_timing = 2 THEN " 一度通知した後、再度ログインするまで通知しない"
                                                    ELSE""
                                                END',
                'DUser.company_holiday',
                'DUser.rank',
                'str_rank'  => 'MPrivilege.privilege_name',
                'DUser.latest_info_receice',
                'str_latest_info_receice'  =>   'CASE
                                                    WHEN DUser.latest_info_receice = 0 THEN "いいえ"
                                                    WHEN DUser.latest_info_receice = 1 THEN "はい"
                                                    ELSE ""
                                                END',
                'DUser.register_date'
            ])
            ->join([
                'table' => 'm_privilege',
                'alias' => 'MPrivilege' ,
                'type' => 'left',
                'conditions' => ['DUser.rank = MPrivilege.privilege_display_id', 'MPrivilege.delete_flg' => 0]
            ])
            ->where([
                'DUser.user_id' => $user_id,
                'DUser.delete_flg' => 0
            ])->first();

        return $data ? $data->toArray() : [];
    }

    // パスワード確認
    public function checkPassword($user_name, $password): bool
    {
        $data = $this->DUser->find()
            ->where([
                'DUser.user_name' => $user_name,
                'DUser.password' => $password,
                'DUser.delete_flg' => 0,
            ])->first();

        return $data ? true : false;
    }

    // DB保存
    public function save($data): array
    {
        if (!empty($data['user_id'])) {
            $ac = $this->DUser->get($data['user_id']);
            $ac = $this->DUser->patchEntity($ac, $data);
        } else {
            $ac = $this->DUser->newEntity($data);
        }
        $result = $this->DUser->save($ac);
        if ($ac->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $ac->getErrors()
            ];
        }
        return [
            'result' => 'success',
            'data' =>  $result,
            'message'=> 'Đăng ký tàu khoản thành công.Vui lòng đăng nhập'
        ];
    }
}
