<?php

use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds to insert the admin user.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Perdo-admin-2222',
            'email' => 'pedro@admin.com',
            'cpf' => '113.345.555-55',
            'phone' => '(82)99899-9888',
            'admin' => 1
        ]);
    }
}
