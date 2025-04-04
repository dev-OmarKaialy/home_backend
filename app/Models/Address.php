<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
 protected $fillable =[
     'name', 'phone' ,'note','address'
 ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function house(){
        return $this->belongsTo(House::class);
    }
}
