<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name', 'email', 'homepage', 'text', 'IP', 'file', 'browser'
    ];
}
