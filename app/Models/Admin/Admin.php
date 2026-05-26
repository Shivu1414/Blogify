<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'contact',
    ];

    protected $hidden = [
        'password',
    ];
}