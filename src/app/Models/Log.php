<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['user', 'action', 'method', 'request_payload'];
    protected $guarded = ['id'];
}
