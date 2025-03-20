<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public $fillable  = [
        'title',
        'description',
        'blog_category_id',
        'author',
    ];

    public function media()
    {
        return $this->hasMany(BlogMedia::class, 'blog_id');
    }
}
