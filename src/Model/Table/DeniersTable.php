<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Deniers Model
 *
 * @property \App\Model\Table\PicksTable&\Cake\ORM\Association\HasMany $Picks
 * @property \App\Model\Table\YarnStocksTable&\Cake\ORM\Association\HasMany $YarnStocks
 *
 * @method \App\Model\Entity\Denier newEmptyEntity()
 * @method \App\Model\Entity\Denier newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Denier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Denier get($primaryKey, $options = [])
 * @method \App\Model\Entity\Denier findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Denier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Denier[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Denier|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Denier saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Denier[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Denier[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Denier[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Denier[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DeniersTable extends Table
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

        $this->setTable('deniers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Picks', [
            'foreignKey' => 'denier_id',
        ]);
        $this->hasMany('YarnStocks', [
            'foreignKey' => 'denier_id',
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
            ->integer('den')
            ->requirePresence('den', 'create')
            ->notEmptyString('den');

        return $validator;
    }
}
