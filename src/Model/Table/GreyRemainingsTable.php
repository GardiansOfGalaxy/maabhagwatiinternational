<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GreyRemainings Model
 *
 * @method \App\Model\Entity\GreyRemaining newEmptyEntity()
 * @method \App\Model\Entity\GreyRemaining newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GreyRemaining[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GreyRemaining get($primaryKey, $options = [])
 * @method \App\Model\Entity\GreyRemaining findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GreyRemaining patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GreyRemaining[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GreyRemaining|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GreyRemaining saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GreyRemaining[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GreyRemaining[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GreyRemaining[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GreyRemaining[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GreyRemainingsTable extends Table
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

        $this->setTable('grey_remainings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('picks')
            ->maxLength('picks', 255)
            ->allowEmptyString('picks');

        $validator
            ->scalar('data')
            ->maxLength('data', 255)
            ->allowEmptyString('data');

        return $validator;
    }
}
