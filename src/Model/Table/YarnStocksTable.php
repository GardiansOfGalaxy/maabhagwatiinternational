<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * YarnStocks Model
 *
 * @property \App\Model\Table\DeniersTable&\Cake\ORM\Association\BelongsTo $Deniers
 * @property \App\Model\Table\AgentsTable&\Cake\ORM\Association\BelongsTo $Agents
 *
 * @method \App\Model\Entity\YarnStock newEmptyEntity()
 * @method \App\Model\Entity\YarnStock newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\YarnStock[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\YarnStock get($primaryKey, $options = [])
 * @method \App\Model\Entity\YarnStock findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\YarnStock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\YarnStock[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\YarnStock|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\YarnStock saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\YarnStock[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\YarnStock[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\YarnStock[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\YarnStock[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class YarnStocksTable extends Table
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

        $this->setTable('yarn_stocks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Deniers', [
            'foreignKey' => 'denier_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Agents', [
            'foreignKey' => 'agent_id',
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->integer('boxes')
            ->requirePresence('boxes', 'create')
            ->notEmptyString('boxes');

        $validator
            ->decimal('kg')
            ->requirePresence('kg', 'create')
            ->notEmptyString('kg');

        $validator
            ->scalar('customer_name')
            ->maxLength('customer_name', 255)
            ->requirePresence('customer_name', 'create')
            ->notEmptyString('customer_name');

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
        $rules->add($rules->existsIn(['denier_id'], 'Deniers'), ['errorField' => 'denier_id']);
        $rules->add($rules->existsIn(['agent_id'], 'Agents'), ['errorField' => 'agent_id']);

        return $rules;
    }
}
