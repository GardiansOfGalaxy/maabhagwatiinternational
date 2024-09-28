<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Designs Model
 *
 * @property \App\Model\Table\DispatchStockSalesTable&\Cake\ORM\Association\HasMany $DispatchStockSales
 * @property \App\Model\Table\FoldingsTable&\Cake\ORM\Association\HasMany $Foldings
 *
 * @method \App\Model\Entity\Design newEmptyEntity()
 * @method \App\Model\Entity\Design newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Design[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Design get($primaryKey, $options = [])
 * @method \App\Model\Entity\Design findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Design patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Design[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Design|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Design saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Design[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Design[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Design[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Design[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DesignsTable extends Table
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

        $this->setTable('designs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('DispatchStockSales', [
            'foreignKey' => 'design_id',
        ]);
        $this->hasMany('Foldings', [
            'foreignKey' => 'design_id',
        ]);
        $this->DispatchStockSales->belongsTo('Lengths', [
            'foreignKey' => 'length_id',
            'joinType' => 'INNER',
        ]);
        $this->DispatchStockSales->belongsTo('Designs', [
            'foreignKey' => 'design_id',
            'joinType' => 'INNER',
        ]);
        $this->DispatchStockSales->belongsTo('Mtrperrolls', [
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
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
