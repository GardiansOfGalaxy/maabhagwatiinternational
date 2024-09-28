<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pick Entity
 *
 * @property int $id
 * @property string $name
 * @property int $denier_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Denier $denier
 * @property \App\Model\Entity\DispatchToOwnFactory[] $dispatch_to_own_factories
 * @property \App\Model\Entity\PrintedStockEntry[] $printed_stock_entries
 * @property \App\Model\Entity\Waterjet[] $waterjets
 */
class Pick extends Entity
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
        'denier_id' => true,
        'created' => true,
        'modified' => true,
        'denier' => true,
        'dispatch_to_own_factories' => true,
        'printed_stock_entries' => true,
        'waterjets' => true,
    ];
}
