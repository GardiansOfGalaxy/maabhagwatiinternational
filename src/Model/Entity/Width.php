<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Width Entity
 *
 * @property int $id
 * @property string $name
 * @property int $pick_id
 * @property int $denier_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Pick $pick
 * @property \App\Model\Entity\Denier $denier
 */
class Width extends Entity
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
        'name' => true,
        'pick_id' => true,
        'denier_id' => true,
        'created' => true,
        'modified' => true,
        'pick' => true,
        'denier' => true,
    ];
}
