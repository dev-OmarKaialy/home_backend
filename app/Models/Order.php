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
        'house_id',
        'status',
        'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
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
    return $this->belongsToMany(ServiceProvider::class, 'order_service_provider');
}

}
