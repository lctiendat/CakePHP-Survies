<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Categories seed.
 */
class CategoriesSeed extends AbstractSeed
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
               'name'=> 'lctiendat'.$i,
               'created'=>  date('Y-m-d H:i:s'),
               'modified'=>  date('Y-m-d H:i:s'),
            ];
            $table = $this->table('categories');
            $table->insert($data)->save();
        }
    }
}
