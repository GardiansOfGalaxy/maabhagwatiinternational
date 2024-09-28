<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PicksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PicksTable Test Case
 */
class PicksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PicksTable
     */
    protected $Picks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Picks',
        'app.Deniers',
        'app.DispatchToOwnFactories',
        'app.PrintedStockEntries',
        'app.Waterjets',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Picks') ? [] : ['className' => PicksTable::class];
        $this->Picks = $this->getTableLocator()->get('Picks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Picks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PicksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PicksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
