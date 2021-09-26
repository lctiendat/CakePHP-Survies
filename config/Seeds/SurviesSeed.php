<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Survies seed.
 */
class SurviesSeed extends AbstractSeed
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
                'question' => 'question' . $i,
                'description' => 'description',
                'category_id' => 1,
                'user_id' => 1,
                'created'=>  date('Y-m-d h:m:s'),
                'modified'=>  date('Y-m-d h:m:s'),
            ];
            $table = $this->table('survies');
            $table->insert($data)->save();
        }
    }
}
