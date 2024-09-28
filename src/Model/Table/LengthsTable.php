<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lengths Model
 *
 * @property \App\Model\Table\DispatchStockSalesTable&\Cake\ORM\Association\HasMany $DispatchStockSales
 * @property \App\Model\Table\FoldingsTable&\Cake\ORM\Association\HasMany $Foldings
 *
 * @method \App\Model\Entity\Length newEmptyEntity()
 * @method \App\Model\Entity\Length newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Length[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Length get($primaryKey, $options = [])
 * @method \App\Model\Entity\Length findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Length patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Length[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Length|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Length saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Length[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Length[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Length[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Length[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LengthsTable extends Table
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

        $this->setTable('lengths');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('DispatchStockSales', [
            'foreignKey' => 'length_id',
        ]);
        $this->hasMany('Foldings', [
            'foreignKey' => 'length_id',
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
            ->scalar('L')
            ->maxLength('L', 100)
            ->requirePresence('L', 'create')
            ->notEmptyString('L');

        return $validator;
    }
}
