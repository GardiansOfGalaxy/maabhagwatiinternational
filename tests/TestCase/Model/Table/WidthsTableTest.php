<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WidthsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WidthsTable Test Case
 */
class WidthsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WidthsTable
     */
    protected $Widths;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Widths',
        'app.Picks',
        'app.Deniers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Widths') ? [] : ['className' => WidthsTable::class];
        $this->Widths = $this->getTableLocator()->get('Widths', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Widths);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\WidthsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\WidthsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
