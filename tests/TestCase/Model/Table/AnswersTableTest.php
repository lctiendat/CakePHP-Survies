<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnswersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnswersTable Test Case
 */
class AnswersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AnswersTable
     */
    protected $Answers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Answers',
        'app.Survies',
        'app.Results',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Answers') ? [] : ['className' => AnswersTable::class];
        $this->Answers = $this->getTableLocator()->get('Answers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Answers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AnswersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AnswersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
