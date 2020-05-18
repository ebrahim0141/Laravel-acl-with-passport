<?php

namespace App\Model\Url;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = "urls";
    protected $fillable = ['title','url', 'operation', 'action_type'];

    public function role(){
        return $this->hasMany('App\Model\UrlToRole\UrlToRole');
    }
}
