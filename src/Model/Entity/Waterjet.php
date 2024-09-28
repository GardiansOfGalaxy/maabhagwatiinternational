<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Waterjet Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $date
 * @property int $pick_id
 * @property int $quantity
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Pick $pick
 */
class Waterjet extends Entity
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
        'date' => true,
        'pick_id' => true,
        'quantity' => true,
        'created' => true,
        'modified' => true,
        'pick' => true,
    ];
}
