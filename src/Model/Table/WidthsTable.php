<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Widths Model
 *
 * @property \App\Model\Table\PicksTable&\Cake\ORM\Association\BelongsTo $Picks
 * @property \App\Model\Table\DeniersTable&\Cake\ORM\Association\BelongsTo $Deniers
 *
 * @method \App\Model\Entity\Width newEmptyEntity()
 * @method \App\Model\Entity\Width newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Width[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Width get($primaryKey, $options = [])
 * @method \App\Model\Entity\Width findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Width patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Width[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Width|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Width saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Width[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Width[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Width[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Width[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WidthsTable extends Table
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

        $this->setTable('widths');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Picks', [
            'foreignKey' => 'pick_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Deniers', [
            'foreignKey' => 'denier_id',
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
            ->maxLength('name', 255)
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
        $rules->add($rules->existsIn(['pick_id'], 'Picks'), ['errorField' => 'pick_id']);
        $rules->add($rules->existsIn(['denier_id'], 'Deniers'), ['errorField' => 'denier_id']);

        return $rules;
    }
}
