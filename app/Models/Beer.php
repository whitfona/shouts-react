<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function photo() : Attribute {
        return Attribute::make(
            get: fn ($value) => isset($value) ? asset('/storage/beers/' . $value) : null,
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function rating(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
