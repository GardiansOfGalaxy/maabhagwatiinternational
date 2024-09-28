<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MtrperrollsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MtrperrollsTable Test Case
 */
class MtrperrollsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MtrperrollsTable
     */
    protected $Mtrperrolls;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Mtrperrolls',
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
        $config = $this->getTableLocator()->exists('Mtrperrolls') ? [] : ['className' => MtrperrollsTable::class];
        $this->Mtrperrolls = $this->getTableLocator()->get('Mtrperrolls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Mtrperrolls);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MtrperrollsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
