<?php

declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'email' => 'email' . $i . '@gmail.com',
                'phone' => '076666702' . $i,
                'password' => '123',
                'token' => $this->generateRandomString(),
                'address' => 'o mot minh',
                'created' =>  date('Y-m-d h:m:s'),
                'modified' =>  date('Y-m-d h:m:s'),
            ];
            $table = $this->table('users');
            $table->insert($data)->save();
        }
    }
    function generateRandomString()
    {
        $length = 30;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
