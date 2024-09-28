<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DesignsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DesignsTable Test Case
 */
class DesignsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DesignsTable
     */
    protected $Designs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Designs',
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
        $config = $this->getTableLocator()->exists('Designs') ? [] : ['className' => DesignsTable::class];
        $this->Designs = $this->getTableLocator()->get('Designs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Designs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DesignsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
