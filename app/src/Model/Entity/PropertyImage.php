<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PropertyImage Entity
 *
 * @property int $id
 * @property string|null $photo_name
 * @property string $photo_dir
 * @property int|null $property_id
 *
 * @property \App\Model\Entity\Property $property
 */
class PropertyImage extends Entity
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
        'id' => true,
        'photo_name' => true,
        'photo_dir' => true,
        'property_id' => true,
        'property' => true
    ];
}
