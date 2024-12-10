<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'price', 'address',
        'bedrooms', 'bathrooms', 'square_feet', 'status', 'images'
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
