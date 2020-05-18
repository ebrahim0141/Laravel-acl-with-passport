<?php

namespace App\Model\UrlToRole;

use Illuminate\Database\Eloquent\Model;

class UrlToRole extends Model
{
    protected $table = "url_to_roles";
    protected $fillable = ['url_id', 'role_id'];
}
