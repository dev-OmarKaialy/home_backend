<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    //
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name'];

    // One to many relationship with services
    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
