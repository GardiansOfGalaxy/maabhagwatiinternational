<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrintedStockEntriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrintedStockEntriesTable Test Case
 */
class PrintedStockEntriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PrintedStockEntriesTable
     */
    protected $PrintedStockEntries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PrintedStockEntries',
        'app.Picks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PrintedStockEntries') ? [] : ['className' => PrintedStockEntriesTable::class];
        $this->PrintedStockEntries = $this->getTableLocator()->get('PrintedStockEntries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PrintedStockEntries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PrintedStockEntriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PrintedStockEntriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
