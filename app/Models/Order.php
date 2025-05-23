<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'notes',
        'user_id',
        'service_provider_id',
        'service_date',
        'house_id',
        'status',
        'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function serviceProviders()
{
    return $this->belongsTo(User::class,'service_provider_id');
}

}
