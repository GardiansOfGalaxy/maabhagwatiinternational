<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PrintedStockEntries Model
 *
 * @property \App\Model\Table\PicksTable&\Cake\ORM\Association\BelongsTo $Picks
 *
 * @method \App\Model\Entity\PrintedStockEntry newEmptyEntity()
 * @method \App\Model\Entity\PrintedStockEntry newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PrintedStockEntry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PrintedStockEntry get($primaryKey, $options = [])
 * @method \App\Model\Entity\PrintedStockEntry findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PrintedStockEntry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PrintedStockEntry[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PrintedStockEntry|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrintedStockEntry saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrintedStockEntry[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintedStockEntry[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintedStockEntry[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PrintedStockEntry[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PrintedStockEntriesTable extends Table
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

        $this->setTable('printed_stock_entries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Picks', [
            'foreignKey' => 'pick_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Designs', [
            'foreignKey' => 'design_id',
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
        $rules->add($rules->existsIn(['design_id'], 'Designs'), ['errorField' => 'design_id']);

        return $rules;
    }
}
