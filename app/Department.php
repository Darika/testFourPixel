<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name', 'description', 'logo',
    ];

    public function user()
    {
        return $this->belongsToMany('App\User', 'user_department');
    }
}
