<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'event_category_id',
        'country',
        'description',
        'image_url',
        'image_public_id',
        'status',
        'start_date',
        'end_date',
        'total_space',
        'price'
    ];


    protected static function booted()
    {
        static::creating(function ($model) {
            $model->slug = static::createUniqueSlug($model->title);
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = static::createUniqueSlug($model->title);
            }
        });
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    protected static function createUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
    
}
