<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rental Entity
 *
 * @property int $id
 * @property int|null $application_id
 * @property \Cake\I18n\FrozenDate $start_date
 * @property int $duration
 * @property \Cake\I18n\FrozenDate $end_date
 * @property int $rental_status
 * @property string $contact_name
 * @property string $contact_email
 * @property int $contact_phone
 *
 * @property \App\Model\Entity\Application $application
 * @property \App\Model\Entity\Tenant[] $tenants
 */
class Rental extends Entity
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
        'application_id' => true,
        'start_date' => true,
        'duration' => true,
        'end_date' => true,
        'rental_status' => true,
        'contact_name' => true,
        'contact_email' => true,
        'contact_phone' => true,
        'application' => true,
        'tenants' => true,
        'create_date' => true,
        'room' => true,
        'property' => true,
        'number_of_tenant'=>true
    ];
}
