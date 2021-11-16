<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;


class StatisticalComponent extends CommonComponent
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
     * Handle count answer by survey method
     */
    public function countAnswerBySurvey($id)
    {
        $query = count($this->Answers->find()
            ->where([
                'survey_id' => $id,
                'DELETE_FLG' => 0
            ])
            ->all());
        return $query;
    }

    /**
     * Handle count each answer by survey method
     */
    public function countEachAnswerBySurvey($id)
    {
        $query = $this->Results->find()
            ->select(
                [
                    'count' => 'count(*)',
                    'answer_id',
                    'name' => 'Answers.name'
                ]
            )
            ->join([
                'table' => 'answers',
                'alias' => 'Answers',
                'type' => 'left',
                'conditions' =>
                ['Answers.id = Results.answer_id']
            ])
            ->where([
                'Results.survey_id' => $id,
                'Answers.DELETE_FLG' => 0
            ])
            ->group('Results.answer_id');
        return $query;
    }

    /**
     * Handle check isset static method
     */
    public function checkIssetStatic($id)
    {
        $query = $this->Survies->find()
            ->select([
                'category' => 'Categories.name',
                'question',
                'created',
                'Survies.id',
                'status',
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
                'Survies.id' => $id
            ])
            ->order(['Survies.id' => 'desc'])
            ->group('Survies.id');
        return $query;
    }
}
