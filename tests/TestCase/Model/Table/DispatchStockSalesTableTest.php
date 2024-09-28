<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DispatchStockSalesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DispatchStockSalesTable Test Case
 */
class DispatchStockSalesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DispatchStockSalesTable
     */
    protected $DispatchStockSales;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DispatchStockSales',
        'app.Lengths',
        'app.Designs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DispatchStockSales') ? [] : ['className' => DispatchStockSalesTable::class];
        $this->DispatchStockSales = $this->getTableLocator()->get('DispatchStockSales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DispatchStockSales);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DispatchStockSalesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DispatchStockSalesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
