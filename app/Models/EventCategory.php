<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'slug',
        'description',
        'image_url',
        'public_id',
        'status',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
