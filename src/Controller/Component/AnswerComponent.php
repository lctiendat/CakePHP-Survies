<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;
use Cake\ORM\TableRegistry;


class AnswerComponent extends CommonComponent
{
    public function initialize(array $config): void
    {
        $this->loadModel(['Survies', 'Answers', 'Categories', 'Results', 'Users']);
    }
    //lấy tất cả Answer
    public function getAllAnswer()
    {
        return $this->Answers->find()->select(['question' => 'Survies.question', 'name', 'created', 'Answers.id'])->innerJoinWith('Survies')->where(['Answers.DELETE_FLG' => 0])->order(['Answers.id' => 'desc']);
    }

    // Xử lí phần thêm Answer
    public function handelAddAnswer($datas)
    {
        if ($datas[0]['name'] == '') {
            return [
                'status' => false,
                'message' => 'Answer không được để trống'
            ];
        } else {
            foreach ($datas as $data) {
                $query = $this->Answers->query();
                $query->insert(['survey_id', 'name', 'created', 'modified'])
                    ->values($data)
                    ->execute();
            }
            return [
                'status' => true,
                'result' => 'success',
                'message' => 'Thêm Answer thành công'
            ];
        }
    }

    //  Xử lí phần chỉnh sửa Answer
    public function handelEditAnswer($id, $data)
    {
        $answer = $this->Answers->get($id);
        $answer = $this->Answers->patchEntity($answer, $data);
        $result = $this->Answers->save($answer);
        if ($answer->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $answer->getErrors()
            ];
        }
        return [
            'result' => 'success',
            'data' =>  $result,
            'message' => 'Cập nhật Answer thành công'
        ];
    }

    // xử lí phần xóa Answer
    public function handelDeleteAnswer($id)
    {
        $query_answer = $this->Answers->query();
        $query_answer->delete()->where(['id' => $id])->execute();
        return $query_answer ? true : false;
    }

    // Lấy Answer dựa theo Id
    public function getAnswerById($id)
    {
        return $this->Answers->find()->where(['id' => $id])->all();
    }

    // lấy answer dựa theo survey id
    public function getAnswerBySurveyId($id)
    {
        return $this->Answers->find()->where(['survey_id' => $id])->all();
    }

    // Xóa mềm Answer
    public function deleteSoftAnswer($id)
    {
        $query = $this->Answers->query();
        $query->update()->set(['DELETE_FLG' => 1])->where(['id' => $id])->execute();
        return [
            'status' => true,
            'message' => 'Xóa Answer thành công'
        ];
    }
}
