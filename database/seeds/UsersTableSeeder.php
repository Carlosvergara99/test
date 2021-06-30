<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name'      => 'Carlos',
            'email'     => 'Carlos_uno@hoy.com',
            'password'     => '1237890',

        ]);

        factory(App\User::class, 7)->create();
    }
}
