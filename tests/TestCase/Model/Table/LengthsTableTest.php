<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LengthsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LengthsTable Test Case
 */
class LengthsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LengthsTable
     */
    protected $Lengths;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Lengths',
        'app.DispatchStockSales',
        'app.Foldings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Lengths') ? [] : ['className' => LengthsTable::class];
        $this->Lengths = $this->getTableLocator()->get('Lengths', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Lengths);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LengthsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
