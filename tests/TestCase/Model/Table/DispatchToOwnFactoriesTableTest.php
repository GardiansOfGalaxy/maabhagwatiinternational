<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DispatchToOwnFactoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DispatchToOwnFactoriesTable Test Case
 */
class DispatchToOwnFactoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DispatchToOwnFactoriesTable
     */
    protected $DispatchToOwnFactories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DispatchToOwnFactories',
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
        $config = $this->getTableLocator()->exists('DispatchToOwnFactories') ? [] : ['className' => DispatchToOwnFactoriesTable::class];
        $this->DispatchToOwnFactories = $this->getTableLocator()->get('DispatchToOwnFactories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DispatchToOwnFactories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DispatchToOwnFactoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DispatchToOwnFactoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
