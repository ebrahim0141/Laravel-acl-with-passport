<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Role\Role;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Role::insert([
            ['title' => 'Admin'],
            ['title' => 'Manager'],
            ['title' => 'Assistant Manager'],
            ['title' => 'Editor'],
            ['title' => 'User']
        ]);
    }
}
