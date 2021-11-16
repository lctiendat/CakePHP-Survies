<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;


class SurveyComponent extends CommonComponent
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
     * Handle add survey method
     */
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
        ];
    }

    /**
     * Handle get survey by id method
     */
    public function getSurveyById($id)
    {
        $query = $this->Survies->find()
            ->select([
                'Survies.id',
                'question',
                'description',
                'category_id',
                'type_select',
                'created',
                'modified'
            ])
            ->where([
                'Survies.id' => $id,
                'DELETE_FLG' => 0
            ])
            ->all();
        return $query;
    }

    /**
     * Handle edit survey method
     */
    public function editSurvey($id, $data)
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
        ];
    }

    /**
     * Handle get all survey method
     */
    public function getAllSurvey()
    {
        $query = $this->Survies->find()
            ->where(['DELETE_FLG' => 0])
            ->all();
        return $query;
    }

    /**
     * Handle get all survey by category method
     */
    public function getAllSurveyWithCategory()
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
            ->where(['Survies.DELETE_FLG' => 0])
            ->order(['Survies.id' => 'desc'])
            ->group('Survies.id');
        return $query;
    }

    /**
     * Handle delete soft survey method
     */
    public function deleteSurvey($id)
    {
        $query_survey = $this->Survies->query();
        $query_survey->update()
            ->set(['DELETE_FLG' => 1])
            ->where(['id' => $id])
            ->execute();
        $query_answer = $this->Answers->query();
        $query_answer->update()
            ->set(['DELETE_FLG' => 1])
            ->where(['survey_id' => $id])
            ->execute();
        return [
            'status' => true,
        ];
    }

    /**
     * Handle get late id survey
     */
    public function getLatestIdSurvey()
    {
        $query = $this->Survies->find()
            ->order(['id' => 'desc'])
            ->limit(1)
            ->all();
        $id = '';
        foreach ($query as $item) {
            $id = $item->id;
        }
        return $id;
    }
}
