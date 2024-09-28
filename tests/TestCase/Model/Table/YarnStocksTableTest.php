<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\YarnStocksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\YarnStocksTable Test Case
 */
class YarnStocksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\YarnStocksTable
     */
    protected $YarnStocks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.YarnStocks',
        'app.Deniers',
        'app.Agents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('YarnStocks') ? [] : ['className' => YarnStocksTable::class];
        $this->YarnStocks = $this->getTableLocator()->get('YarnStocks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->YarnStocks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\YarnStocksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\YarnStocksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
