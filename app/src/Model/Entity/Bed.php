<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bed Entity
 *
 * @property int $id
 * @property string $bed_name
 *
 *
 */
class Bed extends Entity
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
        'bed_name' => true,
        'capacity' => true,
        'room' => true,
        'property' => true
    ];
}
