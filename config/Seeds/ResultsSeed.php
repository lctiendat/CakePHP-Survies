<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Results seed.
 */
class ResultsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'survey_id' => rand(1, 10),
                'answer_id' => rand(1, 10),
                'user_id' => rand(1, 10),
                'created'=>  date('Y-m-d h:m:s'),
                'modified'=>  date('Y-m-d h:m:s'),
            ];
            $table = $this->table('results');
            $table->insert($data)->save();
        }
    }
}
