<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Denier Entity
 *
 * @property int $id
 * @property int $den
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Pick[] $picks
 * @property \App\Model\Entity\YarnStock[] $yarn_stocks
 */
class Denier extends Entity
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
        'den' => true,
        'created' => true,
        'modified' => true,
        'picks' => true,
        'yarn_stocks' => true,
    ];
}
