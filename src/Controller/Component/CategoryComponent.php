<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;
use Cake\ORM\TableRegistry;


class CategoryComponent extends CommonComponent
{
    public function initialize(array $config): void
    {
        $this->loadModel(['Survies', 'Answers', 'Categories', 'Results', 'Users']);
    }

    // lấy tất cả category
    public function getAllCategory()
    {
        return $this->Categories->find()->order(['id' => 'desc'])->where(['DELETE_FLG' => 0]);
    }

    // xử lí phần thêm category
    public function handelAddCategory($data)
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
            'message' => 'Thêm Category thành công'
        ];
    }

    // xử lí phần chỉnh sửa category
    public function handelEditCategory($id, $data)
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

    //xử lí phần xóa category
    public function handelDeleteCategory($id)
    {
        $query_category = $this->Categories->query();
        $query_category->delete()->where(['id' => $id])->execute();
        return $query_category ? true : false;
    }

    // lấy category dựa theo id
    public function getCategoryById($id)
    {
        return $this->Categories->find()->where(['id' => $id])->all();
    }

    // lấy các category mà có survey
    public function getIssetCategory($id)
    {
        return $this->Users->find()->where([$id . ' IN' => $this->Survies->find()->select('category_id')])->all();
    }

    // xóa mềm category
    public function deleteSoftCategory($id)
    {
        $query = $this->Categories->query();
        $query->update()->set(['DELETE_FLG' => 1])->where(['id' => $id])->execute();
        return [
            'status' => true,
            'message' => 'Xóa Category thành công'
        ];
    }
}
