<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeniersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeniersTable Test Case
 */
class DeniersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DeniersTable
     */
    protected $Deniers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Deniers',
        'app.Picks',
        'app.YarnStocks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Deniers') ? [] : ['className' => DeniersTable::class];
        $this->Deniers = $this->getTableLocator()->get('Deniers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Deniers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DeniersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
