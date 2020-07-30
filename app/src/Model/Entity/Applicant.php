<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Applicant Entity
 *
 * @property int $id
 * @property int $application_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $preferred_name
 * @property string $gender
 * @property string|null $australian_citizen
 * @property int|null $contact_number
 *
 * @property \App\Model\Entity\Application $application
 */
class Applicant extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'preferred_name' => true,
        'gender' => true,
        'australian_citizen' => true,
        'application' => true,
        'personal_contact_phone' => true
    ];
}
