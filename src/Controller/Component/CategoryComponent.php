<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;


class CategoryComponent extends CommonComponent
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
     * Handle get all category method
     */
    public function getAllCategory()
    {
        $query = $this->Categories->find()
            ->where(['DELETE_FLG' => 0])
            ->order(['id' => 'desc']);
        return $query;
    }

    /**
     * Handle add category method
     */
    public function addCategory($data)
    {
        $category = $this->Categories->newEntity($data);
        $result = $this->Categories->save($category);
        if ($category->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $category->getErrors()
            ];
        }
        return [
            'result' => 'success',
            'data' =>  $result,
        ];
    }

    /**
     * Handle edit category method
     */
    public function editCategory($id, $data)
    {

        $category = $this->Categories->get($id);
        $category = $this->Categories->patchEntity($category, $data);
        $result = $this->Categories->save($category);
        if ($category->hasErrors()) {
            return [
                'result' => 'invalid',
                'data' => $category->getErrors()
            ];
        }
        return [
            'result' => 'success',
            'data' =>  $result
        ];
    }

    /**
     * Handle get category by id method
     */
    public function getCategoryById($id)
    {
        $query = $this->Categories->find()
            ->where([
                'id' => $id,
                'DELETE_FLG' => 0
            ])
            ->all();
        return $query;
    }

    /**
     * Handle get category have survey method
     */
    public function getIssetCategory($id)
    {
        $query = $this->Users->find()
            ->where([
                $id . ' IN' => $this->Survies->find()
                    ->select('category_id')
                    ->where(['DELETE_FLG' => 0])
            ])
            ->all();
        return $query;
    }

    /**
     * Handle delete soft category method
     */
    public function deleteCategory($id)
    {
        $query = $this->Categories->query();
        $query->update()
            ->set(['DELETE_FLG' => 1])
            ->where(['id' => $id])
            ->execute();
        return [
            'status' => true,
        ];
    }

    /**
     * Handle save more answer
     */
    public function saveMoreSurvey($data)
    {
    }

    /**
     * Handle get late id category
     */
    public function getLatestIdCategory()
    {
        $query = $this->Categories->find()
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
