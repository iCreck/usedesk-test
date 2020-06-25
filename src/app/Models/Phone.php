<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use FullTextSearch;

    protected $fillable = ['phone'];
    protected $hidden = ['client_id'];
    protected $searchable = ['phone'];

    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
