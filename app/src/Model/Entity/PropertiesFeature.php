<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PropertiesFeature Entity
 *
 * @property int $id
 * @property int $property_id
 * @property int $feature_id
 *
 * @property \App\Model\Entity\Property $property
 * @property \App\Model\Entity\Feature $feature
 */
class PropertiesFeature extends Entity
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
        'feature_id' => true,
        'property' => true,
        'feature' => true
    ];
}
