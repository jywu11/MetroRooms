<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Property Entity
 *
 * @property int $id
 * @property string $country
 * @property string $state
 * @property string $suburb
 * @property string $street
 * @property int $postcode
 * @property string|null $house_number
 * @property int $number_of_bedroom
 * @property int $number_of_bathroom
 * @property int|null $type_id
 * @property string|null $general_information
 * @property int $number_of_toilet
 *
 * @property \App\Model\Entity\Type $type
 * @property \App\Model\Entity\Feature[] $features
 * @property \App\Model\Entity\PropertiesImage[] $properties_images
 * @property \App\Model\Entity\Room[] $rooms
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\Application[] $applications
 * @property \App\Model\Entity\Booking[] $bookings
 */
class Property extends Entity
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
        'country' => true,
        'state' => true,
        'suburb' => true,
        'street' => true,
        'postcode' => true,
        'house_number' => true,
        'number_of_bedroom' => true,
        'number_of_bathroom' => true,
        'type_id' => true,
        'general_information' => true,
        'number_of_toilet' => true,
        'type' => true,
        'features' => true,
        'properties_images' => true,
        'rooms' => true,
        'items' => true,
        'applications' => true,
        'bookings' => true,
        'property_status' => true,
        'create_date' => true,
        'status_before_archive' => true,
        'parking_taxi' => true,
        'bus_tram' => true,
        'train' => true,
        'surrounding' => true,
        'houserule' => true,
        'map' => true
    ];
}
