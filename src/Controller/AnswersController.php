<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Answers Controller
 *
 * @property \App\Model\Table\AnswersTable $Answers
 * @method \App\Model\Entity\Answer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnswersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    // public function index()
    // {
    //     $this->paginate = [
    //         'contain' => ['Surveys'],
    //     ];
    //     $answers = $this->paginate($this->Answers);

    //     $this->set(compact('answers'));
    // }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id Answer id.
    //  * @return \Cake\Http\Response|null|void Renders view
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $answer = $this->Answers->get($id, [
    //         'contain' => ['Surveys', 'Results'],
    //     ]);

    //     $this->set(compact('answer'));
    // }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
    //  */
    // public function add()
    // {
    //     $answer = $this->Answers->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $answer = $this->Answers->patchEntity($answer, $this->request->getData());
    //         if ($this->Answers->save($answer)) {
    //             $this->Flash->success(__('The answer has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The answer could not be saved. Please, try again.'));
    //     }
    //     $surveys = $this->Answers->Surveys->find('list', ['limit' => 200]);
    //     $this->set(compact('answer', 'surveys'));
    // }

    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id Answer id.
    //  * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function edit($id = null)
    // {
    //     $answer = $this->Answers->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $answer = $this->Answers->patchEntity($answer, $this->request->getData());
    //         if ($this->Answers->save($answer)) {
    //             $this->Flash->success(__('The answer has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The answer could not be saved. Please, try again.'));
    //     }
    //     $surveys = $this->Answers->Surveys->find('list', ['limit' => 200]);
    //     $this->set(compact('answer', 'surveys'));
    // }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Answer id.
    //  * @return \Cake\Http\Response|null|void Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $answer = $this->Answers->get($id);
    //     if ($this->Answers->delete($answer)) {
    //         $this->Flash->success(__('The answer has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The answer could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
    public function saveAnswer()
    {
        $save_result = TableRegistry::getTableLocator()->get('Results')->query();
        if ($this->request->is('post')) {
            $survey_id = $this->request->getData('survey_id');
            $answer_id = $this->request->getData('answer_id');
            $save_result->insert(['survey_id', 'answer_id', 'user_id', 'created', 'modified'])
                ->values(['survey_id' => 1, 'answer_id' => 1, 'user_id' => 1, 'created' => date('Y-m-d H:m:s'), 'modified' => date('Y-m-d H:m:s')])
                ->execute();
            $this->redirect('/');
        }
        // dd($save_result);
    }
}
