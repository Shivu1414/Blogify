<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function blogs()
    {
        return $this->belongsToMany(
            Blog::class,
            'blog_tag',
            'tag_id',
            'blog_id'
        );
    }
}