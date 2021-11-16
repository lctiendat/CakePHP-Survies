<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;

class AnswerComponent extends CommonComponent
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
     * Handle get all answer method
     */
    public function getAllAnswer()
    {
        $query = $this->Answers->find()
            ->select([
                'question' => 'Survies.question',
                'name',
                'created',
                'answers.id'
            ])
            ->join([
                'table' => 'survies',
                'alias' => 'Survies',
                'type' => 'left',
                'conditions' => ['Survies.id = Answers.survey_id']
            ])
            ->where(['answers.DELETE_FLG' => 0])
            ->order(['answers.id' => 'desc']);
        return $query;
    }

    /**
     * Handle add answer method
     */
    public function AddMutiAnswer($datas)
    {
        if ($datas[0]['name'] == '') {
            return [
                'status' => false,
            ];
        } else {
            foreach ($datas as $data) {
                $query = $this->Answers->query();
                $query->insert([
                    'survey_id',
                    'name',
                    'created',
                    'modified'
                ])
                    ->values($data)
                    ->execute();
            }
            return [
                'status' => true,
                'result' => 'success',
            ];
        }
    }

    /**
     * Handle add single answer
     */

    public function addSingleAnswer($data)
    {
        $query = $this->Answers->query();
        $query->insert([
            'survey_id',
            'name',
            'created',
            'modified'
        ])
            ->values($data)
            ->execute();
    }

    /**
     * Handle edit answer method
     */
    public function EditAnswer($id, $data)
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
        ];
    }

    /**
     * Handle get answer by id method
     */
    public function getAnswerById($id)
    {
        $query = $this->Answers->find()
            ->where([
                'id' => $id,
                'DELETE_FLG' => 0
            ])
            ->all();
        return $query;
    }

    /**
     * Handle get all answer by id method
     */
    public function getAllAnswerById($id)
    {
        $query = $this->Answers->find()
            ->where([
                'survey_id' => $id,
                'DELETE_FLG' => 0
            ])
            ->all();
        return $query;
    }

    /**
     * Handle get answer by survey  method
     */
    public function getAnswerBySurveyId($id)
    {
        $query = $this->Answers->find()
            ->select([
                'id' => 'Answers.id',
                'name' => 'Answers.name',
                'survey_id' => 'answers.survey_id',
                'count' => 'COUNT(Results.answer_id)'
            ])
            ->join([
                'table' => 'results',
                'alias' => 'Results',
                'type' => 'left',
                'conditions' => ['Answers.id = Results.answer_id']
            ])
            ->where([
                'Answers.survey_id' => $id,
                'Answers.DELETE_FLG' => 0
            ])
            ->group('Answers.id')
            ->all();
        return $query;
    }

    /**
     * Handle get sort answer by survey  method
     */
    public function getListAnswerBySurveyId($id)
    {
        $query = $this->Answers->find()
            ->where([
                'survey_id' => $id,
                'DELETE_FLG' => 0
            ])
            ->order(['id' => 'DESC']);
        return  $query;
    }

    /**
     * Handle delete soft answer method
     */
    public function deleteAnswer($id)
    {
        $query = $this->Answers->query();
        $query_result = $this->Results->query();
        $query->update()
            ->set(['DELETE_FLG' => 1])
            ->where(['id' => $id])
            ->execute();
        $query_result->delete()
            ->where(['answer_id' => $id])
            ->execute();
        return [
            'status' => true,
        ];
    }
}
