<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FoldingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FoldingsTable Test Case
 */
class FoldingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FoldingsTable
     */
    protected $Foldings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Foldings',
        'app.Lengths',
        'app.Designs',
        'app.Mtrperrolls',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Foldings') ? [] : ['className' => FoldingsTable::class];
        $this->Foldings = $this->getTableLocator()->get('Foldings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Foldings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FoldingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\FoldingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
