<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DispatchStockSales Model
 *
 * @property \App\Model\Table\LengthsTable&\Cake\ORM\Association\BelongsTo $Lengths
 * @property \App\Model\Table\DesignsTable&\Cake\ORM\Association\BelongsTo $Designs
 *
 * @method \App\Model\Entity\DispatchStockSale newEmptyEntity()
 * @method \App\Model\Entity\DispatchStockSale newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DispatchStockSale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DispatchStockSale get($primaryKey, $options = [])
 * @method \App\Model\Entity\DispatchStockSale findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DispatchStockSale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DispatchStockSale[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DispatchStockSale|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DispatchStockSale saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DispatchStockSale[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DispatchStockSale[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DispatchStockSale[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DispatchStockSale[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DispatchStockSalesTable extends Table
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

        $this->setTable('dispatch_stock_sales');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lengths', [
            'foreignKey' => 'length_id',
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
            ->integer('total_no_rolls')
            ->requirePresence('total_no_rolls', 'create')
            ->notEmptyString('total_no_rolls');

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
        $rules->add($rules->existsIn(['length_id'], 'Lengths'), ['errorField' => 'length_id']);
        $rules->add($rules->existsIn(['design_id'], 'Designs'), ['errorField' => 'design_id']);

        return $rules;
    }
}
