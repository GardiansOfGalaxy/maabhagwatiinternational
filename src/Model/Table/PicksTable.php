<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Picks Model
 *
 * @property \App\Model\Table\DeniersTable&\Cake\ORM\Association\BelongsTo $Deniers
 * @property \App\Model\Table\DispatchToOwnFactoriesTable&\Cake\ORM\Association\HasMany $DispatchToOwnFactories
 * @property \App\Model\Table\PrintedStockEntriesTable&\Cake\ORM\Association\HasMany $PrintedStockEntries
 * @property \App\Model\Table\WaterjetsTable&\Cake\ORM\Association\HasMany $Waterjets
 *
 * @method \App\Model\Entity\Pick newEmptyEntity()
 * @method \App\Model\Entity\Pick newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Pick[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pick get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pick findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Pick patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pick[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pick|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pick saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pick[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pick[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pick[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pick[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PicksTable extends Table
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

        $this->setTable('picks');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Deniers', [
            'foreignKey' => 'denier_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DispatchToOwnFactories', [
            'foreignKey' => 'pick_id',
        ]);
        $this->hasMany('PrintedStockEntries', [
            'foreignKey' => 'pick_id',
        ]);
        $this->hasMany('Waterjets', [
            'foreignKey' => 'pick_id',
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

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

        return $rules;
    }
}
