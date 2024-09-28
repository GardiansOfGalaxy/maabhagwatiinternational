<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WaterjetsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WaterjetsTable Test Case
 */
class WaterjetsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WaterjetsTable
     */
    protected $Waterjets;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Waterjets',
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
        $config = $this->getTableLocator()->exists('Waterjets') ? [] : ['className' => WaterjetsTable::class];
        $this->Waterjets = $this->getTableLocator()->get('Waterjets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Waterjets);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\WaterjetsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\WaterjetsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
