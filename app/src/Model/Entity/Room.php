<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Room Entity
 *
 * @property int $id
 * @property int $property_id
 * @property string|null $room_type
 * @property string|null $room_general_information
 *
 * @property \App\Model\Entity\Property $property
 * @property \App\Model\Entity\Application[] $applications
 * @property \App\Model\Entity\Booking[] $bookings
 * @property \App\Model\Entity\PropertiesImage[] $properties_images
 * @property \App\Model\Entity\Item[] $items
 */
class Room extends Entity
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
        'room_general_information' => true,
        'room_type' => true,
        'room_type_desc' => true,
        'room_name' => true,
        'property' => true,
        'applications' => true,
        'bookings' => true,
        'properties_images' => true,
        'items' => true,
        'rental_end_date' => true,
        'current_number_of_people_staying' => true,
        'last_rental_end_date' => true,
        'beds' => true
    ];
}
