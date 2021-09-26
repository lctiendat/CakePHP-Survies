<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Results Model
 *
 * @property \App\Model\Table\SurveysTable&\Cake\ORM\Association\BelongsTo $Surveys
 * @property \App\Model\Table\AnswersTable&\Cake\ORM\Association\BelongsTo $Answers
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Result newEmptyEntity()
 * @method \App\Model\Entity\Result newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Result[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Result get($primaryKey, $options = [])
 * @method \App\Model\Entity\Result findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Result patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Result[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Result|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Result saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Result[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Result[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Result[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Result[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ResultsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('results');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Surveys', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Answers', [
            'foreignKey' => 'answer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('DELETE_FLG')
            ->notEmptyString('DELETE_FLG');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['survey_id'], 'Surveys'), ['errorField' => 'survey_id']);
        $rules->add($rules->existsIn(['answer_id'], 'Answers'), ['errorField' => 'answer_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
