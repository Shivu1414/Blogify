<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Admin;
use App\Models\Blog\Category;
use Illuminate\Support\Str;
use App\Models\Blog\Blog;
use App\Models\Blog\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GeneralOperations
{
    public function createUser($username, $email, $contact, $password, $user_type) 
    {
        return DB::table('admins')->insert([
            'name' => $username,
            'email' => $email,
            'contact' => $contact,
            'password' => Hash::make($password),
            'user_type' => $user_type,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function getAdminByEmail($email)
    {
        return DB::table('admins')
            ->where('email', $email)
            ->first();
    }

    public function createCategory(string $name,?string $slug = null,?string $description = null) {

        $slug = !empty($slug)
            ? Str::slug($slug)
            : Str::slug($name);
    
        $originalSlug = $slug;
        $counter = 1;
    
        while (
            Category::where('slug', $slug)->exists()
        ) {
    
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return Category::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description
        ]);
    }

    public function createBlog(array $data)
    {
        $slug = !empty($data['slug'])
            ? Str::slug($data['slug'])
            : Str::slug($data['title']);
    
        $originalSlug = $slug;
        $counter = 1;
    
        while (Blog::where('slug', $slug)->exists()) {
    
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        $imagePath = null;
    
        if (!empty($data['featured_image'])) {
    
            $imageName = time() . '_' . $data['featured_image']->getClientOriginalName();
    
            $data['featured_image']->move(
                public_path('uploads/blogs'),
                $imageName
            );
    
            $imagePath = 'uploads/blogs/' . $imageName;
        }
    
        $blog = Blog::create([
            'title' => $data['title'],
            'slug' => $slug,
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'featured_image' => $imagePath
        ]);
    
        if (!empty($data['tags'])) {
    
            $blog->tags()->sync($data['tags']);
        }
    
        return $blog;
    }

    public function getBlogDetails($page = 1)
    {
        return Blog::with([
                'category:id,name',
                'tags:id,name'
            ])
            ->latest()
            ->paginate(10, ['*'], 'page', $page);
    }

    public function deleteBlog($id)
    {
        try {
    
            $blog = Blog::find($id);
    
            if (!$blog) {
    
                return response()->json([
                    'status' => false,
                    'message' => 'Blog not found'
                ]);
            }
    
            if (
                !empty($blog->featured_image)
                && File::exists(public_path($blog->featured_image))
            ) {
    
                File::delete(
                    public_path($blog->featured_image)
                );
            }
    
            $blog->tags()->detach();
    
            $blog->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Blog deleted successfully'
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}