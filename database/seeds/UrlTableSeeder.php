<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Url\Url;

class UrlTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Url::insert([
            ['title' => 'login', 'url' => '/api/login', 'operation' => 'login', 'action_type' => 'POST'],
            ['title' => 'signup', 'url' => '/api/signup', 'operation' => 'signup', 'action_type' => 'POST'],
            ['title' => 'url', 'url' => '/api/url', 'operation' => 'view', 'action_type' => 'GET'],
            ['title' => 'url', 'url' => '/api/url', 'operation' => 'store-edit-update', 'action_type' => 'POST'],
            ['title' => 'url', 'url' => '/api/url', 'operation' => 'delete', 'action_type' => 'DELETE'],
            ['title' => 'role', 'url' => '/api/role', 'operation' => 'view', 'action_type' => 'GET'],
            ['title' => 'role', 'url' => '/api/role', 'operation' => 'store-edit-update', 'action_type' => 'POST'],
            ['title' => 'role', 'url' => '/api/role', 'operation' => 'delete', 'action_type' => 'DELETE'],
            ['title' => 'url-to-role', 'url' => '/api/url-role', 'operation' => 'store-edit-update', 'action_type' => 'POST'],
            ['title' => 'url-to-role', 'url' => '/api/url-role', 'operation' => 'view', 'action_type' => 'GET'],
            ['title' => 'url-to-role', 'url' => '/api/url-role', 'operation' => 'delete', 'action_type' => 'DELETE'],
            ['title' => 'role-to-user', 'url' => '/api/role-user', 'operation' => 'store-edit-update', 'action_type' => 'POST'],
            ['title' => 'role-to-user', 'url' => '/api/role-user', 'operation' => 'view', 'action_type' => 'GET'],
            ['title' => 'role-to-user', 'url' => '/api/role-user', 'operation' => 'delete', 'action_type' => 'DELETE']
        ]);
    }
}
