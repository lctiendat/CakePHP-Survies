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
            ->notEmptyString('email', errorEmail)
            ->add('email', 'validFormat', [
                'rule' => array('custom', '/^[a-z0-9.]+@[a-z0-9]+\.[a-z]{2,}$/'),
                'message' => EMAIL_INVALIDATE
            ])
            ->add(
                'email',
                [
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => EMAIL_ALREADY_EXISTS
                    ]
                ]
            );

        $validator
            ->add('phone', 'validFormat', [
                'rule' => array('custom', '/^(((0))[0-9]{9})$/'),
                'message' => PHONE_NUMBER_IS_NOT_IN_THE_CORRECT_FORMAT
            ])
            ->maxLength('phone', 10)
            ->minLength('phone', 9)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone', errorPhone)
            ->add(
                'phone',
                [
                    'unique' => [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => THE_PHONE_NUMBER_ALREADY_EXISTS_IN_THE_SYSTEM
                    ]
                ]
            );

        $validator
            ->scalar('avatar')
            ->maxLength('avatar', 100)
            ->notEmptyString('avatar');

        $validator
            ->add('password', 'validFormat', [
                'rule' => array('custom', '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/'),
                'message' => THE_PASSWORD_IS_NOT_STRONG_ENOUGH
            ])
            ->scalar('password')
            ->maxLength('password', 50)
            ->requirePresence('password', 'create')
            ->notEmptyString('password', errorPassword);

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
        return $rules;
    }
}
