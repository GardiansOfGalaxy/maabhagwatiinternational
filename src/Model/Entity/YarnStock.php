<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * YarnStock Entity
 *
 * @property int $id
 * @property int $denier_id
 * @property int $agent_id
 * @property \Cake\I18n\FrozenDate $date
 * @property int $boxes
 * @property string $kg
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string $customer_name
 *
 * @property \App\Model\Entity\Denier $denier
 * @property \App\Model\Entity\Agent $agent
 */
class YarnStock extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'denier_id' => true,
        'agent_id' => true,
        'date' => true,
        'boxes' => true,
        'kg' => true,
        'created' => true,
        'modified' => true,
        'customer_name' => true,
        'denier' => true,
        'agent' => true,
    ];
}
