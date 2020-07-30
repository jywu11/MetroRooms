<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PropertiesFeaturesFixture
 */
class PropertiesFeaturesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'property_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'feature_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'properties_features_features_id_fk' => ['type' => 'index', 'columns' => ['feature_id'], 'length' => []],
            'properties_features_properties_id_fk' => ['type' => 'index', 'columns' => ['property_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'properties_features_features_id_fk' => ['type' => 'foreign', 'columns' => ['feature_id'], 'references' => ['features', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'properties_features_properties_id_fk' => ['type' => 'foreign', 'columns' => ['property_id'], 'references' => ['properties', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'property_id' => 1,
                'feature_id' => 1
            ],
        ];
        parent::init();
    }
}
