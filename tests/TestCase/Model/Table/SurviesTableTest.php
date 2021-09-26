<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SurviesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SurviesTable Test Case
 */
class SurviesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SurviesTable
     */
    protected $Survies;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Survies',
        'app.Categories',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Survies') ? [] : ['className' => SurviesTable::class];
        $this->Survies = $this->getTableLocator()->get('Survies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Survies);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SurviesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SurviesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
