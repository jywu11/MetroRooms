<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PropertiesImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PropertiesImagesTable Test Case
 */
class PropertiesImagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PropertiesImagesTable
     */
    public $PropertiesImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PropertiesImages',
        'app.Properties',
        'app.Rooms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PropertiesImages') ? [] : ['className' => PropertiesImagesTable::class];
        $this->PropertiesImages = TableRegistry::getTableLocator()->get('PropertiesImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PropertiesImages);

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
