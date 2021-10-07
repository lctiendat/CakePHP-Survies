<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ResultsTable&\Cake\ORM\Association\HasMany $Results
 * @property \App\Model\Table\SurviesTable&\Cake\ORM\Association\HasMany $Survies
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Results', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Survies', [
            'foreignKey' => 'user_id',
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
            ->email('email')
            ->requirePresence('email', 'create', 'Email đã tồn tại trong hệ thống')
            ->notEmptyString('email', 'Email không được để trống');

        $validator
            ->maxLength('phone', 10, 'Số điện thoại không được quá 10 số')
            ->minLength('phone', 9, 'Số điện thoại ít nhất là 9 số')
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone', 'Số điện thoại không được để trống');

        $validator
            ->scalar('avatar')
            ->maxLength('avatar', 100)
            ->notEmptyString('avatar');

        $validator
            ->scalar('password')
            ->maxLength('password', 50)
            ->requirePresence('password', 'create')
            ->notEmptyString('password', 'Mật khẩu không được để trống');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');
        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->allowEmptyString('token');
        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->integer('role')
            ->notEmptyString('role');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->isUnique(['phone']), ['errorField' => 'phone'], ['message' => 'Số điện thoại đã tồn tại trong hệ thống.']);
        return $rules;
    }
}
