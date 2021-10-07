<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;
use Cake\ORM\TableRegistry;


class SurveyComponent extends CommonComponent
{
    public function initialize(array $config): void
    {
        $this->loadModel(['Survies', 'Answers', 'Categories', 'Results', 'Users']);
    }

    // xử lí phần thêm survey
    public function handelAddSurvey($data)
    {
        $survey = $this->Survies->newEntity($data);
        $result = $this->Survies->save($survey);

        if ($survey->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $survey->getErrors()
            ];
        }
        return [
            'result' => 'success',
            'data' =>  $result,
            'message' => 'Thêm Survey thành công'
        ];
    }

    // lấy survey dựa theo id
    public function getSurveyById($id)
    {
        return $this->Survies->find()->select(['Survies.id', 'question', 'description', 'category_id', 'type_select', 'created', 'modified'])->where(['Survies.id' => $id])->all();
    }

    // xử lí phần chỉnh sửa survey
    public function handelEditSurvey($id, $data)
    {

        $survey = $this->Survies->get($id);
        $survey = $this->Survies->patchEntity($survey, $data);
        $result = $this->Survies->save($survey);
        if ($survey->hasErrors()) {
            return [
                'status' => false,
                'data' => $survey->getErrors()
            ];
        }
        return [
            'status' => true,
            'message' => 'Chỉnh sửa Suurvey thành công'
        ];
    }

    // xử lí phần xóa survey
    public function handelDeleteSurvey($id)
    {
        $query_survey = $this->Survies->query();
        $query_survey->delete()->where(['id' => $id])->execute();
        return $query_survey ? true : false;
    }

    // lấy tất cả survey
    public function getAllSurvey()
    {
        return $this->Survies->find()->where(['DELETE_FLG' => 0])->all();
    }

    // lấy tất cả survey cùng với category
    public function getAllSurveyWithCategory()
    {
        return $this->Survies->find()->select(['category' => 'Categories.name', 'question', 'created', 'Survies.id', 'status'])
            ->innerJoinWith('Categories')
            ->where(['Survies.DELETE_FLG' => 0])
            ->order(['Survies.id' => 'desc']);
    }

    // xử lí phần xóa mềm survey
    public function deleteSoftSurvey($id)
    {
        $query_survey = $this->Survies->query();
        $query_survey->update()->set(['DELETE_FLG' => 1])->where(['id' => $id])->execute();
        $query_answer = $this->Answers->query();
        $query_answer->update()->set(['DELETE_FLG' => 1])->where(['survey_id' => $id])->execute();
        return [
            'status' => true,
            'message' => 'Xóa Survey thành công'
        ];
    }
}
