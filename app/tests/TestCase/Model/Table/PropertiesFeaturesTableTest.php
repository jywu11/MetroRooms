<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PropertiesFeaturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PropertiesFeaturesTable Test Case
 */
class PropertiesFeaturesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PropertiesFeaturesTable
     */
    public $PropertiesFeatures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PropertiesFeatures',
        'app.Properties',
        'app.Features'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PropertiesFeatures') ? [] : ['className' => PropertiesFeaturesTable::class];
        $this->PropertiesFeatures = TableRegistry::getTableLocator()->get('PropertiesFeatures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PropertiesFeatures);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
