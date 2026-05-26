<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'featured_image',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id'
        );
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'blog_tag',
            'blog_id',
            'tag_id'
        );
    }
}