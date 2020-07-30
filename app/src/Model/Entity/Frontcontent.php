<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Frontcontent Entity
 *
 * @property int $id
 * @property string|null $top_foot_logo
 * @property string|null $banner_image
 * @property string|null $banner_title
 * @property string|null $home_service_title
 * @property string $home_service_desc
 * @property string|null $home_service_entry1
 * @property string|null $home_service_entry2
 * @property string|null $home_service_entry3
 * @property string|null $home_service_entry4
 * @property string|null $foot_abt_desc
 * @property string|null $abt_title
 * @property string|null $abt_desc
 * @property string|null $abt_person_title
 * @property string|null $abt_person_image
 * @property string|null $abt_person_name
 * @property string|null $abt_person_email
 * @property int|null $abt_person_phonr
 * @property string|null $abt_person_desc
 * @property string|null $house_question
 * @property string|null $house_answer
 */
class Frontcontent extends Entity
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
        'top_foot_logo' => true,
        'banner_image' => true,
        'banner_title' => true,
        'home_service_title' => true,
        'home_service_desc' => true,
        'home_service_entry1' => true,
        'home_service_entry2' => true,
        'home_service_entry3' => true,
        'home_service_entry4' => true,
        'foot_abt_desc' => true,
        'abt_title' => true,
        'abt_desc' => true,
        'abt_person_title' => true,
        'abt_person_image' => true,
        'abt_person_name' => true,
        'abt_person_email' => true,
        'abt_person_phone' => true,
        'abt_person_desc' => true,
        'house_question' => true,
        'house_answer' => true,
        'terms_conditions' => true,
        'abt_person_email_new' => true
    ];
}
