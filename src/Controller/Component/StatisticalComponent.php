<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;
use Cake\ORM\TableRegistry;


class StatisticalComponent extends CommonComponent
{
    public function initialize(array $config): void
    {
        $this->loadModel(['Survies', 'Answers', 'Categories', 'Results', 'Users']);
    }

    // đếm Survey dựa theo category

    public function countSurveyByCategory($id)
    {
        return count($this->Survies->find()->where(['category_id' => $id])->all());
    }

    // đếm answer dựa theo survey

    public function countAnswerBySurvey($id)
    {
        return count($this->Answers->find()->where(['survey_id' => $id])->all());
    }

    // đếm từng answer dựa theo survey
    public function countEachAnswerBySurvey($id)
    {
        return $this->Results->find()
            ->select(['count' => 'count(*)', 'answer_id', 'name' => 'Answers.name'])
            ->leftJoinWith('Answers')
            ->where(['Results.survey_id' => $id])
            ->group('Results.answer_id');
    }
}
