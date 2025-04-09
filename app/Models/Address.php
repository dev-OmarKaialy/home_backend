<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'city',
        'region',
        'street',
        'building'
    ];

    public function addressable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
