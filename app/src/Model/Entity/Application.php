<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Application Entity
 *
 * @property int $id
 * @property int $property_id
 * @property int $room_id
 * @property int $number_of_people
 * @property string $contact_name
 * @property int $contact_number
 * @property string $email
 * @property \Cake\I18n\FrozenTime $start_date
 * @property \Cake\I18n\FrozenTime $end_date
 * @property string|null $additional_comment
 * @property string $application_status
 * @property \Cake\I18n\FrozenTime $create_date
 *
 * @property \App\Model\Entity\Property $property
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\Applicant[] $applicants
 */
class Application extends Entity
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
        'number_of_people' => true,
        'contact_name' => true,
        'contact_number' => true,
        'contact_email' => true,
        'start_date' => true,
        'end_date' => true,
        'additional_comment' => true,
        'application_status' => true,
        'create_date' => true,
        'property' => true,
        'status_before_archive' => true,
        'room' => true,
        'duration' => true,
        'applicants' => true,
        'applications_beds_rooms'=>true,
        'rental_id' => true,
        'rental' => true
    ];
}
