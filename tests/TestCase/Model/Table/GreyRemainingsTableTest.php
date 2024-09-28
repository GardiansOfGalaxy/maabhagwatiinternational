<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GreyRemainingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GreyRemainingsTable Test Case
 */
class GreyRemainingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GreyRemainingsTable
     */
    protected $GreyRemainings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GreyRemainings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GreyRemainings') ? [] : ['className' => GreyRemainingsTable::class];
        $this->GreyRemainings = $this->getTableLocator()->get('GreyRemainings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GreyRemainings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GreyRemainingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
