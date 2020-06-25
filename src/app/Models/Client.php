<?php

namespace App\Models;

use App\Models\Scopes\ClientDefaultScope;
use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use FullTextSearch;

    protected $searchable = ['name', 'lastname'];
    protected $fillable = ['name', 'lastname'];
    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new ClientDefaultScope());
    }

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}
