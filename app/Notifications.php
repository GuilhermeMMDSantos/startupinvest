<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = "notifications";

    protected $fillable = [
        'message',
        'fk_user_distination',
        'status',
        'fk_user_origin',
        'tipo'
    ];

    public function userdeorigem()
    {
        return $this->belongsTo('App\User','fk_user_origin','id');
    }
}
