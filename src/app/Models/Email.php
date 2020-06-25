<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use FullTextSearch;
    protected $fillable = ['email'];
    protected $searchable = ['email'];
    protected $hidden = ['client_id'];

    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
