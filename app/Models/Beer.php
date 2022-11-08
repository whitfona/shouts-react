<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
      'has_lactose' => 'boolean'
    ];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

//    public function user()
//{
//    return $this->belongsToMany(User::class);
//}

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
