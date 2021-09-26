<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSurvies extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('survies');
        $table->addColumn('question', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('description', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('status', 'integer', [
            'default' => 1,
            'limit' => 1,
            'null' => false,
        ]);
        $table->addColumn('category_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('type_select', 'integer', [
            'default' => 1,
            'limit' => 1,
            'null' => false,
        ]);
        $table->addColumn('DELETE_FLG', 'integer', [
            'default' => 0,
            'limit' => 1,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('time_end', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
