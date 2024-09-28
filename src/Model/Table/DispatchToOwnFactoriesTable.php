<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DispatchToOwnFactories Model
 *
 * @property \App\Model\Table\PicksTable&\Cake\ORM\Association\BelongsTo $Picks
 *
 * @method \App\Model\Entity\DispatchToOwnFactory newEmptyEntity()
 * @method \App\Model\Entity\DispatchToOwnFactory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory get($primaryKey, $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DispatchToOwnFactory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DispatchToOwnFactoriesTable extends Table
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

        $this->setTable('dispatch_to_own_factories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Picks', [
            'foreignKey' => 'pick_id',
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
            ->scalar('factory_name')
            ->maxLength('factory_name', 100)
            ->requirePresence('factory_name', 'create')
            ->notEmptyString('factory_name');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

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
        $rules->add($rules->existsIn(['pick_id'], 'Picks'), ['errorField' => 'pick_id']);

        return $rules;
    }
}
