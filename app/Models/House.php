<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class House extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['user_id', 'title', 'description', 'price', 'status', 'views_count', 'period', 'owner_name', 'owner_phone', 'directions', 'rooms', 'space'];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');  // العلاقة مع المستخدم
    }
}
