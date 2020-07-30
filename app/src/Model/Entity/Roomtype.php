<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Roomtype Entity
 *
 * @property int $id
 * @property string|null $name
 *
 * @property \App\Model\Entity\Room[] $rooms
 */
class Roomtype extends Entity
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
        'rooms' => true
    ];
}
