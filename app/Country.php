<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    public $timestamps = false;

    protected $guarded = [];

    public function posts()
    {
        return $this->hasManyThrough(Post::class, User::class, 'country_id', 'user_id');
    }
}
