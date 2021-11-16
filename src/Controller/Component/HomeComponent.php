<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;
use App\Model\Entity\Result;
use PHPMailer\PHPMailer\PHPMailer;;

class HomeComponent extends CommonComponent
{
    /**
     * Initialize method
     */
    public function initialize(array $config): void
    {
        $this->loadModel([
            'Survies',
            'Answers',
            'Categories',
            'Results',
            'Users'
        ]);
    }

    /**
     * Handle get survey have answer method
     */
    public function getSortCategoryHaveSurvey($user_id)
    {
        $query = $this->Categories->find()
            ->select([
                'name' => 'Categories.name',
                'id' => 'Categories.id',
                'user_check' => 'Results.user_id'
            ])
            ->join([
                'table' => 'results',
                'alias' => 'Results',
                'type' => 'left',
                'conditions' =>
                [
                    'Categories.id = Results.category_id',
                    'Results.user_id = ' . $user_id
                ]
            ])
            ->where([
                'Categories.id IN' => $this->Survies->find()
                    ->select('category_id')
                    ->where(['Survies.DELETE_FLG' => 0]),
                'Categories.DELETE_FLG' => 0
            ])
            ->order([
                'user_id',
                'Categories.id' => 'DESC'
            ])
            ->group('Categories.id');
        return $query;
    }

    public function getSortAndSearchCategoryHaveSurvey($user_id = '', $key = '')
    {
        $query = $this->Categories->find()
            ->select([
                'name' => 'Categories.name',
                'id' => 'Categories.id',
                'user_check' => 'Results.user_id'
            ])
            ->join([
                'table' => 'results',
                'alias' => 'Results',
                'type' => 'left',
                'conditions' =>
                [
                    'Categories.id = Results.category_id',
                    'Results.user_id = ' . $user_id
                ]
            ])
            ->where([
                'name LIKE ' => '%' . $key . '%',
                'Categories.id IN' => $this->Survies->find()
                    ->select('category_id')
                    ->where(['Survies.DELETE_FLG' => 0]),
                'Categories.DELETE_FLG' => 0
            ])
            ->order([
                'user_id',
                'Categories.id' => 'DESC'
            ])
            ->group('Categories.id');;
        return $query;
    }

    /**
     * Handle get all category method
     */
    public function getAllCategory()
    {
        $query = $this->Categories->find()
            ->where(['DELETE_FLG' => 0])
            ->all();
        return $query;
    }

    public function getCategoryHaveSurvey()
    {
        $query = $this->Categories->find()
            ->select(['id', 'name'])
            ->where([
                'DELETE_FLG' => 0,
                'id IN' => $this->Survies->find()
                    ->select('category_id')
                    ->where(['DELETE_FLG' => 0])
            ])
            ->order(['id' => 'desc']);
        return $query;
    }

    /**
     * Handle get survey have answer by category method
     */
    public function getSurviesHaveAnswerByCategory($id)
    {
        $query = $this->Survies->find()
            ->where([
                'id IN' => $this->Answers->find()
                    ->select('survey_id')
                    ->where(['Answers.DELETE_FLG' => 0]),
                'Survies.DELETE_FLG' => 0,
                'category_id' => $id
            ])
            ->toArray();
        return $query;
    }

    /**
     * Handle get survey by id method
     */
    public function getSurveyById($id)
    {
        $query = $this->Survies->find()
            ->where([
                'id' => $id,
                'DELETE_FLG' => 0
            ])
            ->all();
        return $query;
    }

    /**
     * Handle save voted from user
     */

    public function saveVoted($data)
    {
        foreach ($data as $value) {
            $query = $this->Results->query();
            $query->insert([
                'category_id',
                'survey_id',
                'answer_id',
                'user_id',
                'created',
                'modified'
            ])
                ->values($value)
                ->execute();
        }
    }

    /**
     * Handle get answer by user method
     */
    public function getAnswerByUser($user_id = '')
    {
        $query = $this->Results->find()
            ->select('answer_id')
            ->where([
                'user_id' => $user_id,
            ])
            ->all();

        return $query;
    }

    /**
     * Handle check result method
     */
    public function checkResult($user_id, $category_id)
    {
        $query = $this->Results->find()
            ->where([
                'category_id' => $category_id,
                'user_id' => $user_id,
            ])
            ->toArray();
        return $query;
    }

    /**
     * Handle search in admin method
     */
    public function search($key, $model, $item)
    {
        switch ($model) {
            case 'Survies':
                return $this->$model->find()
                    ->select([
                        'category' => 'Categories.name',
                        'question',
                        'created',
                        'Survies.id',
                        'status',
                        'category_id',
                        'count' => 'Results.survey_id'
                    ])
                    ->join([
                        'table' => 'categories',
                        'alias' => 'Categories',
                        'type' => 'left',
                        'conditions' =>
                        ['Categories.id = Survies.category_id']
                    ])
                    ->join([
                        'table' => 'results',
                        'alias' => 'Results',
                        'type' => 'left',
                        'conditions' =>
                        ['Survies.id = Results.survey_id']
                    ])
                    ->where([
                        'Survies.DELETE_FLG' => 0,
                        'OR' => [
                            '' . $item . ' LIKE ' => '%' . $key . '%',
                            'Categories.name LIKE ' => '%' . $key . '%',
                            'Survies.created LIKE ' => '%' . $key . '%',
                        ]
                    ])
                    ->order(['Survies.id' => 'desc'])
                    ->group('Survies.id');;
                break;
            case 'Categories':
                return $this->$model->find()
                    ->where([
                        'DELETE_FLG' => 0,
                        'OR' => [
                            '' . $item . ' LIKE ' => '%' . $key . '%',
                            'created LIKE ' => '%' . $key . '%',
                        ]
                    ])
                    ->order(['Categories.id' => 'desc']);
                break;
            case 'Answers':
                return $this->$model->find()
                    ->select([
                        'question' => 'Survies.question',
                        'name',
                        'created',
                        'Answers.id'
                    ])
                    ->join([
                        'table' => 'survies',
                        'alias' => 'Survies',
                        'type' => 'left',
                        'conditions' => ['Survies.id = Answers.survey_id']
                    ])
                    ->where([
                        '' . $item . ' LIKE ' => '%' . $key . '%',
                        'Answers.DELETE_FLG' => 0
                    ])
                    ->order(['Answers.id' => 'desc']);
                break;
            case 'Users':
                return $this->$model->find()
                    ->select([
                        'email',
                        'phone',
                        'str_status' => 'CASE WHEN status = 2 THEN "Enable" ELSE"Disable" END',
                        'str_role' => 'CASE WHEN role = 2 THEN "Admin" ELSE"User" END'
                    ])
                    ->where([
                        'DELETE_FLG' => 0,
                        'OR' => [
                            '' . $item . ' LIKE ' => '%' . $key . '%',
                            'phone LIKE ' => '%' . $key . '%',
                        ]
                    ])
                    ->order(['Users.id' => 'desc']);

            default:
                break;
        }
    }

    /**
     * Handle search answer by survey method
     */
    public function searchHistorySurveyUserChoose($user_id, $key)
    {
        $query = $this->Categories->find()
            ->select([
                'name' => 'Categories.name',
                'id' => 'Categories.id'
            ])
            ->join([
                'table' => 'results',
                'alias' => 'Results',
                'type' => 'left',
                'conditions' =>
                ['Categories.id = Results.category_id']
            ])
            ->where([
                'Results.user_id' => $user_id,
                'Categories.name LIKE ' => '%' . $key . '%',
                'Categories.DELETE_FLG' => 0
            ])
            ->group('Categories.id');
        return $query;
    }

    /**
     * Handle search in home method
     */
    public function searchHome($key)
    {
        $query = $this->Categories->find()
            ->select(['id', 'name'])
            ->where([
                'DELETE_FLG' => 0,
                'id IN' => $this->Survies->find()
                    ->select('category_id')
                    ->where(['DELETE_FLG' => 0]),
                'name LIKE ' => '%' . $key . '%',
            ])
            ->order(['id' => 'desc']);
        return $query;
    }

    /**
     * Handle count static method
     */
    public function countQuality($model)
    {
        $query = $this->$model->find()
            ->select(['count' => 'COUNT(*)']);
        return $query;
    }

    /**
     * Handle count static method
     */
    public function countQualityToday($model)
    {
        $query = $this->$model->find()
            ->select(
                ['count' => 'COUNT(*)']
            )
            ->where([
                'created LIKE' => '%' . date('Y-m-d') . '%'
            ]);
        return $query;
    }

    /**
     * Handle check id isset method
     */
    public function checkIdIsset($id, $model)
    {
        $query = $this->$model->find()
            ->where([
                'id' => $id,
                'DELETE_FLG' => 0
            ])
            ->all();
        return $query;
    }

    /**
     * Handle get all survey user voted method
     */
    public function getSurveyUserChoosed($user_id)
    {
        $query = $this->Survies->find()
            ->select([
                'question',
                'SurveyId' => 'Survies.id',
                'categoryName' => 'Categories.name',
                'categoryId' => 'Categories.id'
            ])
            ->join([
                'table' => 'results',
                'alias' => 'Results',
                'type' => 'left',
                'conditions' =>
                ['Survies.id = Results.survey_id']
            ])->join([
                'table' => 'categories',
                'alias' => 'Categories',
                'type' => 'left',
                'conditions' =>
                ['Categories.id = Survies.category_id']
            ])
            ->where([
                'Results.user_id' => $user_id,
                'Survies.DELETE_FLG' => 0
            ])
            ->group('Survies.id');
        return $query;
    }

    /**
     * Handle get most answer voted method
     */
    public function ranking()
    {
        $query = $this->Results->find()
            ->select([
                'quanlity' => 'COUNT(*)',
                'question' => 'Survies.question',
                'survey_id'
            ])
            ->join([
                'table' => 'survies',
                'alias' => 'Survies',
                'type' => 'left',
                'conditions' =>
                ['Survies.id = Results.survey_id']
            ])
            ->where(['Survies.DELETE_FLG' => 0])
            ->group('survey_id')
            ->order(['quanlity' => 'DESC'])
            ->limit(10);
        return $query;
    }

    /**
     * Handle sort data at admin
     */
    public function sortDataAdmin($key, $model, $sort, $direction)
    {
        if ($key == '') {
            switch ($model) {
                case 'Survies':
                    return $this->$model->find()
                        ->select([
                            'category' => 'Categories.name',
                            'question',
                            'created',
                            'Survies.id',
                            'status',
                            'category_id',
                            'count' => 'Results.survey_id'
                        ])
                        ->join([
                            'table' => 'categories',
                            'alias' => 'Categories',
                            'type' => 'left',
                            'conditions' =>
                            ['Categories.id = Survies.category_id']
                        ])
                        ->join([
                            'table' => 'results',
                            'alias' => 'Results',
                            'type' => 'left',
                            'conditions' =>
                            ['Survies.id = Results.survey_id']
                        ])
                        ->where([
                            'Survies.DELETE_FLG' => 0,
                        ])
                        ->order([$sort => $direction])
                        ->group('Survies.id');
                    break;
                case 'Categories':
                    return $this->$model->find()
                        ->where([
                            'DELETE_FLG' => 0,
                        ])
                        ->order([$sort  => $direction]);
                    break;
                case 'Answers':
                    return $this->$model->find()
                        ->select([
                            'question' => 'Survies.question',
                            'name',
                            'created',
                            'Answers.id'
                        ])
                        ->join([
                            'table' => 'survies',
                            'alias' => 'Survies',
                            'type' => 'left',
                            'conditions' => ['Survies.id = Answers.survey_id']
                        ])
                        ->where([
                            'Answers.DELETE_FLG' => 0
                        ])
                        ->order([$sort => $direction]);
                    break;
                case 'Users':
                    return $this->$model->find()
                        ->select([
                            'email',
                            'phone',
                            'str_status' => 'CASE WHEN status = 2 THEN "Enable" ELSE"Disable" END',
                            'str_role' => 'CASE WHEN role = 2 THEN "Admin" ELSE"User" END'
                        ])
                        ->where([
                            'DELETE_FLG' => 0,
                        ])
                        ->order(['Users.' . $sort => $direction]);

                default:
                    break;
            }
        } else {
            switch ($model) {
                case 'Survies':
                    return $this->$model->find()
                        ->select([
                            'category' => 'Categories.name',
                            'question',
                            'created',
                            'Survies.id',
                            'status',
                            'category_id',
                            'count' => 'Results.survey_id'
                        ])
                        ->join([
                            'table' => 'categories',
                            'alias' => 'Categories',
                            'type' => 'left',
                            'conditions' =>
                            ['Categories.id = Survies.category_id']
                        ])
                        ->join([
                            'table' => 'results',
                            'alias' => 'Results',
                            'type' => 'left',
                            'conditions' =>
                            ['Survies.id = Results.survey_id']
                        ])
                        ->where([
                            'Survies.DELETE_FLG' => 0,
                            'OR' => [
                                'question LIKE ' => '%' . $key . '%',
                                'Categories.name LIKE ' => '%' . $key . '%',
                                'Survies.created LIKE ' => '%' . $key . '%',
                            ]
                        ])
                        ->order([$sort => $direction])
                        ->group('Survies.id');;
                    break;
                case 'Categories':
                    return $this->$model->find()
                        ->where([
                            'DELETE_FLG' => 0,
                            'OR' => [
                                'name LIKE ' => '%' . $key . '%',
                                'created LIKE ' => '%' . $key . '%',
                            ]
                        ])
                        ->order([$sort  => $direction]);
                    break;
                case 'Answers':
                    return $this->$model->find()
                        ->select([
                            'question' => 'Survies.question',
                            'name',
                            'created',
                            'Answers.id'
                        ])
                        ->join([
                            'table' => 'survies',
                            'alias' => 'Survies',
                            'type' => 'left',
                            'conditions' => ['Survies.id = Answers.survey_id']
                        ])
                        ->where([
                            'Answers.DELETE_FLG' => 0
                        ])
                        ->order([$sort => $direction]);
                    break;
                case 'Users':
                    return $this->$model->find()
                        ->select([
                            'email',
                            'phone',
                            'str_status' => 'CASE WHEN status = 2 THEN "Enable" ELSE"Disable" END',
                            'str_role' => 'CASE WHEN role = 2 THEN "Admin" ELSE"User" END'
                        ])
                        ->where([
                            'DELETE_FLG' => 0,
                            'OR' => [
                                'email LIKE ' => '%' . $key . '%',
                                'phone LIKE ' => '%' . $key . '%',
                            ]
                        ])
                        ->order(['Users.' . $sort => $direction]);

                default:
                    break;
            }
        }
    }

    /**
     * Handle get answer by survey
     */
    public function getAnswerBySurvey($id)
    {
        $query = $this->Answers->find()
            ->where([
                'DELETE_FLG' => 0,
                'survey_id' => $id
            ])
            ->toArray();
        return $query;
    }

    /**
     *Handle update voted from user
     */
    public function updateVoted($data)
    {
        $query = $this->Results->query();
        $query->update()
            ->set(['answer_id' => $data['answer_id']])
            ->where([
                'user_id' => $data['user_id'],
                'survey_id' => $data['survey_id'],
                'category_id' => $data['category_id']
            ])
            ->execute();
    }

    /**
     *Handle check isset voted from user
     */
    public function checkVoted($data)
    {
        $query = $this->Results->find()
            ->where([
                'category_id' => $data['category_id'],
                'survey_id' => $data['survey_id'],
                'answer_id' => $data['answer_id'],
                'user_id' => $data['user_id']
            ])
            ->toArray();
        return $query;
    }

    /**
     *Handle save voted from user
     */
    public function insertVoted($data)
    {
        $query = $this->Results->query();
        $query->insert([
            'category_id',
            'survey_id',
            'answer_id',
            'user_id',
            'created',
            'modified'
        ])
            ->values($data)
            ->execute();
    }

    /**
     * Handle delete voted user rechoose
     */
    public function deleteVoted($data)
    {
        $query = $this->Results->query();
        $query->delete()
            ->where([
                'NOT' => [
                    'answer_id IN' => $data['answer_id'],
                ],
                'category_id' => $data['category_id'],
                'survey_id' => $data['survey_id'],
                'user_id' => $data['user_id']
            ])
            ->execute();
    }

    /**
     *Handle check category have survey
     */
    public function checkCategoryHaveSurvey($id)
    {
        $query = $this->Survies->find()
            ->where([
                'category_id' => $id,
                'DELETE_FLG' => 0
            ])
            ->toArray();
        return $query;
    }

    /**
     * Handle get voted by user
     */
    public function getVotedByUser($category_id, $user_id)
    {
        $query = $this->Results->find()
            ->where([
                'category_id' => $category_id,
                'user_id' => $user_id
            ])
            ->toArray();
        return $query;
    }

    /**
     * Module PHPMailer method
     */
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
