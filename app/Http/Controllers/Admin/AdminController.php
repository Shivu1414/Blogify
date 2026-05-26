<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\GeneralOperations;
use App\GoogleAdsApi\Utils\GoogleAdsHelper;
use Illuminate\Support\Facades\Hash;
use App\Services\PhpMailerOperations;
use App\Models\Blog\Category;
use App\Models\Blog\Tag;
use App\Models\Blog\Blog;

class AdminController extends Controller
{
    protected $generalOps;

    public function __construct(GeneralOperations $generalOps)
    {
        $this->generalOps = $generalOps;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $admin = $this->generalOps->getAdminByEmail(
            $request->email
        );
    
        if (!$admin) {
    
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'user' => 'User does not exist!'
                ]);
        }
    
        if (!Hash::check($request->password, $admin->password)) {
    
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'password' => 'Incorrect password!'
                ]);
        }
    
        Session::put('admin', $admin);
    
        return redirect('dashboard');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'contact' => 'required|digits_between:10,15',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'user_type' => 'required'
        ]);

        $response = $this->generalOps->createUser(
            $request->username,
            $request->email,
            $request->contact,
            $request->password,
            $request->user_type
        );

        if ($response) {
            return redirect('/admin-login')
                ->with('success', 'Account created successfully');
    
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while signup');
        }
    }

    public function verifyOtp(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;
        $password = $request->password;
    
        $otpRecord = DB::table('password_reset_otps')->where('email', $email)->where('otp', $otp)->first();
    
        if (!$otpRecord) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ]);
        }
    
        if (now()->gt($otpRecord->expires_at)) {
    
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();
    
            return response()->json([
                'status' => false,
                'message' => 'OTP has expired'
            ]);
        }
    
        $admin = Admin::where('email', $email)->first();
    
        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Account not found'
            ]);
        }
    
        $admin->password = Hash::make($password);
        $admin->save();
    
        DB::table('password_reset_otps')
            ->where('email', $email)
            ->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully'
        ]);
    }

    public function forgetPassword(Request $request)
    {
        $email = $request->email;
    
        $admin = Admin::where('email', $email)->first();
    
        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Email not found'
            ]);
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_otps')->where('email', $email)->delete();

        DB::table('password_reset_otps')->insert([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $mailResponse = PhpMailerOperations::sendOtp($email, $otp);

        return response()->json($mailResponse);
    }

    public function dashboard(){
        $admin = Session::get('admin');

        if($admin){
            return view('admin.dashboard', [
                "name" => $admin['name'],
                "panel" => "dashboard",
                "heading" => "Blogs"
            ]);
        } else {
            return redirect('admin-login');
        }
    }

    public function getBlogDetails(Request $request)
    {
        try {
    
            $blogs = $this->generalOps->getBlogDetails(
                $request->get('page', 1)
            );
    
            return response()->json([
                'status' => true,
                'data' => $blogs
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(){
        Session::forget('admin');
        return redirect('admin-login');
    }

    public function setCategoryDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);
    
        if ($validator->fails()) {
    
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $category = $this->generalOps->createCategory(
            $request->name,
            $request->slug,
            $request->description
        );
    
        if (!$category) {
    
            return response()->json([
                'status' => false,
                'message' => 'Unable to create category'
            ], 500);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'category' => $category
        ]);
    }

    public function setBlogDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'description'     => 'required|string',
            'featured_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags'            => 'nullable|array',
            'tags.*'          => 'exists:tags,id',
        ]);
    
        if ($validator->fails()) {
    
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $blog = $this->generalOps->createBlog([
            'title'          => $request->title,
            'slug'           => $request->slug,
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'featured_image' => $request->file('featured_image'),
            'tags'           => $request->tags ?? []
        ]);
    
        if (!$blog) {
    
            return response()->json([
                'status' => false,
                'message' => 'Unable to create blog'
            ], 500);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Blog created successfully',
            'blog' => $blog
        ]);
    }

    public function getCategoryDetails(Request $request)
    {
        try {
    
            $categories = Category::select(
                'id',
                'name'
            )
            ->orderBy('name', 'ASC')
            ->get();
    
            return response()->json([
                'status' => true,
                'data' => $categories
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTagDetails(Request $request)
    {
        try {
    
            $tags = Tag::select(
                'id',
                'name'
            )
            ->orderBy('name', 'ASC')
            ->get();
    
            return response()->json([
                'status' => true,
                'data' => $tags
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function setTagDetails(Request $request)
    {
        try {
    
            $request->validate([
                'name' => 'required|max:255',
                'slug' => 'nullable|max:255'
            ]);
    
            $slug = $request->slug;
    
            if (empty($slug)) {
                $slug = Str::slug($request->name);
            }
    
            $originalSlug = $slug;
            $counter = 1;
    
            while (Tag::where('slug', $slug)->exists()) {
    
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
    
            $tag = Tag::create([
                'name' => $request->name,
                'slug' => $slug
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Tag created successfully',
                'tag' => $tag
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteBlog(Request $request)
    {
        return $this->generalOps->deleteBlog(
            $request->id
        );
    }

    public function getBlogById(Request $request)
    {
        try {
    
            $blog = Blog::with([
                'category',
                'tags'
            ])->find($request->id);
    
            if (!$blog) {
    
                return response()->json([
                    'status' => false,
                    'message' => 'Blog not found'
                ]);
            }
    
            return response()->json([
                'status' => true,
                'blog' => $blog
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateBlogDetails(Request $request)
    {
        try {
    
            $blog = Blog::find($request->id);
    
            if (!$blog) {
    
                return response()->json([
                    'status' => false,
                    'message' => 'Blog not found'
                ]);
            }
    
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'category_id' => 'required'
                ]
            );
    
            if ($validator->fails()) {
    
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $slug = $request->slug
                ?: Str::slug($request->title);
    
            if (
                Blog::where('slug', $slug)
                    ->where('id', '!=', $blog->id)
                    ->exists()
            ) {
    
                $slug .= '-' . time();
            }
    
            $imagePath = $blog->featured_image;
    
            if ($request->hasFile('featured_image')) {
    
                if (
                    $imagePath &&
                    file_exists(
                        public_path($imagePath)
                    )
                ) {
                    unlink(
                        public_path($imagePath)
                    );
                }
    
                $file = $request->file(
                    'featured_image'
                );
    
                $fileName =
                    time() . '_' .
                    $file->getClientOriginalName();
    
                $file->move(
                    public_path('uploads/blogs'),
                    $fileName
                );
    
                $imagePath =
                    'uploads/blogs/' .
                    $fileName;
            }
    
            $blog->update([
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'featured_image' => $imagePath
            ]);
    
            $blog->tags()->sync(
                $request->tags ?? []
            );
    
            return response()->json([
                'status' => true,
                'message' => 'Blog updated successfully'
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}