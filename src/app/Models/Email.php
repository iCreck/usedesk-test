<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['email'];
    protected $hidden = ['client_id'];

    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
