<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['phone'];

    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
