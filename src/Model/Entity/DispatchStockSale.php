<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DispatchStockSale Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $date
 * @property int $length_id
 * @property int $design_id
 * @property int $total_no_rolls
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Length $length
 * @property \App\Model\Entity\Design $design
 */
class DispatchStockSale extends Entity
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
        'length_id' => true,
        'design_id' => true,
        'total_no_rolls' => true,
        'created' => true,
        'modified' => true,
        'length' => true,
        'design' => true,
    ];
}
