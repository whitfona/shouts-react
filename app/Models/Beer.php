<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
      'has_lactose' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

//    public function user()
//{
//    return $this->belongsToMany(User::class);
//}

    public function rating(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
