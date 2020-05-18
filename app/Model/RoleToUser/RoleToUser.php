<?php

namespace App\Model\RoleToUser;

use Illuminate\Database\Eloquent\Model;

class RoleToUser extends Model
{
    protected $table = "role_to_users";
    protected $fillable = ['role_id', 'user_id'];
}
