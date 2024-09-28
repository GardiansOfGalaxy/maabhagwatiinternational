<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Length Entity
 *
 * @property int $id
 * @property string $L
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\DispatchStockSale[] $dispatch_stock_sales
 * @property \App\Model\Entity\Folding[] $foldings
 */
class Length extends Entity
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
        'L' => true,
        'created' => true,
        'modified' => true,
        'dispatch_stock_sales' => true,
        'foldings' => true,
    ];
}
