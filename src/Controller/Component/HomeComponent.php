<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;
use Cake\Database\Expression\QueryExpression;
use Cake\Database\Query;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class HomeComponent extends CommonComponent
{
    public $controller = null;
    public $session = null;
    public function initialize(array $config): void
    {
        $this->loadModel(['Survies', 'Answers', 'Categories', 'Results', 'Users']);
    }

    // lấy Survies mà có câu hỏi
    public function getSurviesHaveInAnswer()
    {
        return $this->Survies->find()
            ->select(['category' => 'Categories.name', 'question', 'id' => 'Survies.id', 'category_id'])
            ->innerJoinWith('Categories')
            ->where(['Survies.id IN' => $this->Answers->find()->select('survey_id')])->order(['Survies.id' => 'desc']);
    }

    //Lấy tất cả Category
    public function getAllCategory()
    {
        return $this->Categories->find()->where(['DELETE_FLG' => 0])->all();
    }

    //Lấy những Survey phải có Answer dựa id của Category
    public function getSurviesHaveInAnswerByCategoryId($id)
    {
        return $this->Survies->find()
            ->select(['category' => 'Categories.name', 'question', 'id' => 'Survies.id', 'category_id'])
            ->innerJoinWith('Categories')
            ->where(['category_id' => $id])
            ->where(['Survies.id IN' => $this->Answers->find()->select('survey_id')]);
    }

    // lấy category dựa theo id
    public function getCategoryById($id)
    {
        return $this->Categories->find()
            ->where(['id' => $id])
            ->all();
    }

    // lấy survey dựa theo id
    public function getSurveyById($id)
    {
        return $this->Survies->find()->where(['id' => $id])->all();
    }

    // lấy answer dựa theo survey id
    public function getAnswerBySurveyId($id)
    {
        return $this->Answers->find()
            ->where(['survey_id' => $id])->where(['DELETE_FLG' => 0])->all();
    }

    // lấy result dựa theo survey id và user id
    public function getResultBySurveyIdAndUserId($survey_id, $user_id)
    {
        return $this->Results->find()->where(['survey_id' => $survey_id])->where(['user_id' => $user_id])->all();
    }

    // xử lí phần update answer
    public function updateAnswer($data)
    {
        $user_id = $data['user_id'];
        $save_result = $this->Results->query();
        $save_result->update()->set($data)->where(['user_id' => $user_id])->execute();
    }

    // xử lí phần lưu answer
    public function saveAnswer($datas, $type_select)
    {
        if ($type_select == 2) {
            foreach ($datas as $data) {
                $save_result = $this->Results->query();
                $save_result->insert(['survey_id', 'answer_id', 'user_id', 'created', 'modified'])
                    ->values($data)
                    ->execute();
            }
        } else {
            $save_result = $this->Results->query();
            $save_result->insert(['survey_id', 'answer_id', 'user_id', 'created', 'modified'])
                ->values($datas)
                ->execute();
        }
    }

    // xử lí phần lưu user
    public function saveUser($data)
    {
        $save_user = $this->Users->query();
        $save_user->insert(['email', 'phone', 'password', 'created', "modified"])
            ->values($data)
            ->execute();
    }

    //lấy answer dựa theo user
    public function getAnswerByUser($user_id, $survey_id)
    {
        return $this->Results->find()->where(['survey_id' => $survey_id])->where(['user_id' => $user_id])->all();
    }

    // lấy result dựa theo answer id
    public function getResultByAnswerId($user_id, $survey_id, $answer_id)
    {
        return $this->Results->find()->where(['survey_id' => $survey_id])->where(['user_id' => $user_id])->where(['answer_id' => $answer_id])->all();
    }

    // kiểm tra result
    public function checkResult($user_id, $survey_id, $answer_id)
    {
        return $this->Results->find()->where(['survey_id' => $survey_id])->where(['user_id' => $user_id])->where(['answer_id' => $answer_id])->all();
    }

    // xử lí phần cập nhật nhiều answer
    public function updateMoreAnswer($id_survey, $item, $user_id)
    {
        $save_user = $this->Results->query();
        $save_user->insert(['survey_id', 'answer_id', 'user_id', 'created', "modified"])
            ->values([
                'survey_id' => $id_survey, 'answer_id' => $item, 'user_id' => $user_id, 'created' => date('Y-m-d H:m:s'),
                'modified' => date('Y-m-d H:m:s')
            ])
            ->execute();
    }

    // xử lí phần xóa result mà không được chọn
    public function deleteResultNoChoose($answer_id, $survey_id, $user_id)
    {
        $delete_user = $this->Results->query();
        $delete_user->delete()
            ->where(['NOT' => [
                'answer_id IN' => $answer_id,
            ]])
            ->where(['survey_id' => $survey_id])
            ->where(['user_id' => $user_id])->execute();
    }

    // xử lí phần tìm kiếm
    public function search($key, $model, $item)
    {
        switch ($model) {
            case 'Survies':
                return $this->Survies->find()
                    ->select(['category' => 'Categories.name', 'question', 'created', 'Survies.id', 'status'])
                    ->innerJoinWith('Categories')
                    ->where(['' . $item . ' LIKE ' => '%' . $key . '%'])
                    ->toArray();
                break;
            case 'Categories':
                return $this->$model->find()->where(['' . $item . ' LIKE ' => '%' . $key . '%'])->toArray();
                break;
            case 'Answers':
                return $this->$model->find()->select(['question' => 'Survies.question', 'name', 'created', 'Answers.id'])->innerJoinWith('Survies')->where(['' . $item . ' LIKE ' => '%' . $key . '%'])->toArray();
                break;
            case 'Users':
                return $this->$model->find()->where(['' . $item . ' LIKE ' => '%' . $key . '%'])->toArray();
            default:
                break;
        }
    }

    // đếm survey theo category
    public function countSurveyInCategory()
    {
        return $this->Survies->find()->select(['CategoryId' => 'Categories.id', 'CategoryName' => 'Categories.name', 'count' => 'COUNT(*)', 'category_id'])->innerJoinWith('Categories')->group('category_id');
    }

    // đếm tổng số lượng category
    public function countQualityCategory()
    {
        return $this->Categories->find()->select(['count' => 'COUNT(*)']);
    }

    // đếm tổng số lượng survey

    public function countQualitySurvey()
    {
        return $this->Survies->find()->select(['count' => 'COUNT(*)']);
    }

    // đếm tổng số lượng answer

    public function countQualityAnswer()
    {
        return $this->Answers->find()->select(['count' => 'COUNT(*)']);
    }

    // đếm tổng số lượng user

    public function countQualityUser()
    {
        return $this->Users->find()->select(['count' => 'COUNT(*)']);
    }

    // xử lí phần chuyển hướng nếu dữ liệu không tồn tại

    public function checkIdIsset($id, $model)
    {
        return $this->$model->find()->where(['id' => $id])->all();
    }
}
