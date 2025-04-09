<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    //
    use HasFactory,InteractsWithMedia;

    protected $fillable = ['name', 'category_id', 'description'];

    // Inverse of one to many relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
