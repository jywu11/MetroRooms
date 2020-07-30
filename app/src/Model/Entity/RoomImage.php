<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RoomImage Entity
 *
 * @property int $id
 * @property int $property_id
 * @property int $room_id
 * @property string $photo_name
 * @property string $photo_dir
 *
 * @property \App\Model\Entity\Property $property
 * @property \App\Model\Entity\Room $room
 */
class RoomImage extends Entity
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
        'property_id' => true,
        'room_id' => true,
        'photo_name' => true,
        'photo_dir' => true,
        'property' => true,
        'room' => true
    ];
}
