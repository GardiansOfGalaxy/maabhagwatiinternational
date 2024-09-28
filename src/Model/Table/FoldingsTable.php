<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Foldings Model
 *
 * @property \App\Model\Table\LengthsTable&\Cake\ORM\Association\BelongsTo $Lengths
 * @property \App\Model\Table\DesignsTable&\Cake\ORM\Association\BelongsTo $Designs
 * @property \App\Model\Table\MtrperrollsTable&\Cake\ORM\Association\BelongsTo $Mtrperrolls
 *
 * @method \App\Model\Entity\Folding newEmptyEntity()
 * @method \App\Model\Entity\Folding newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Folding[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Folding get($primaryKey, $options = [])
 * @method \App\Model\Entity\Folding findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Folding patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Folding[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Folding|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Folding saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Folding[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Folding[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Folding[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Folding[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FoldingsTable extends Table
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

        $this->setTable('foldings');
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
        $this->belongsTo('Mtrperrolls', [
            'foreignKey' => 'mtrperroll_id',
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
            ->integer('total_rolls')
            ->requirePresence('total_rolls', 'create')
            ->notEmptyString('total_rolls');

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
        $rules->add($rules->existsIn(['mtrperroll_id'], 'Mtrperrolls'), ['errorField' => 'mtrperroll_id']);

        return $rules;
    }
}
