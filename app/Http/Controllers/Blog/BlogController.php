<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog\Blog;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')
            ->latest()
            ->paginate(9);


        return view('blogs.index', compact('blogs'));
    }

    public function details($slug)
    {
        $blog = Blog::with([
            'category',
            'tags'
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        return view('blogs.details', compact('blog'));
    }
}