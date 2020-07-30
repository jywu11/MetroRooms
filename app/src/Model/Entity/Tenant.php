<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tenant Entity
 *
 * @property int $id
 * @property int|null $rental_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $preferred_name
 * @property int $gender
 * @property int $is_aus_citizen
 * @property string|null $email
 * @property string|null $phone
 *
 * @property \App\Model\Entity\Rental $rental
 */
class Tenant extends Entity
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
        'rental_id' => true,
        'first_name' => true,
        'last_name' => true,
        'preferred_name' => true,
        'gender' => true,
        'is_aus_citizen' => true,
        'personal_email' => true,
        'personal_contact_phone' => true,
        'rental' => true
    ];
}
