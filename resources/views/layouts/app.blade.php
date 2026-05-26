<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Icons + jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <div id="topLoader" class="top-loader"></div>

    <div
        id="createBlogModal"
        class="fixed inset-0 z-50 hidden bg-black/20 backdrop-blur-sm"
    >
    
        <div class="fixed inset-0 flex items-center justify-center p-4">
    
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col">
    
                <!-- HEADER -->
                <div class="flex items-center justify-between px-5 py-3 border-b shrink-0">
    
                    <h2 class="text-xl font-semibold text-gray-800">
                        Create Blog
                    </h2>
    
                    <button
                        type="button"
                        id="closeCreateBlogModal"
                        class="text-2xl leading-none text-gray-500 hover:text-red-500 transition"
                    >
                        &times;
                    </button>
    
                </div>
    
                <!-- FORM -->
                <form
                    id="createBlogForm"
                    enctype="multipart/form-data"
                    class="flex flex-col flex-1 overflow-hidden"
                >
    
                    <!-- SCROLLABLE BODY -->
                    <div class="flex-1 overflow-y-auto px-5 py-4">
    
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Title
                                </label>
    
                                <input
                                    type="text"
                                    name="title"
                                    placeholder="Enter blog title"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
    
                            <!-- Slug -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Slug URL
                                </label>
    
                                <input
                                    type="text"
                                    name="slug"
                                    placeholder="blog-title"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
    
                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Category
                                </label>
    
                                <select
                                    name="category_id"
                                    id="category_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                                >
                                    <option value="">Select Category</option>
                                </select>
                            </div>
    
                            <!-- Tags -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Tags
                                </label>
    
                                <select
                                    id="tag_ids"
                                    name="tags[]"
                                    multiple
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm h-28"
                                >
                                    @foreach($tags ?? [] as $tag)
                                        <option value="{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
    
                            <!-- Featured Image -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Featured Image
                                </label>
    
                                <input
                                    type="file"
                                    name="featured_image"
                                    accept="image/*"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                                >
    
                                <div id="imagePreviewContainer" class="hidden mt-3">
                                    <img
                                        id="imagePreview"
                                        src=""
                                        alt="Preview"
                                        class="w-28 h-28 rounded-lg object-cover border"
                                    >
                                </div>
                            </div>
    
                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Description
                                </label>
    
                                <textarea
                                    name="description"
                                    rows="8"
                                    placeholder="Write blog description..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                                ></textarea>
                            </div>
    
                        </div>
    
                    </div>
    
                    <!-- FOOTER -->
                    <div class="border-t px-5 py-3 bg-white flex justify-end gap-3 shrink-0 rounded-b-xl">
    
                        <button
                            type="button"
                            id="cancelCreateBlog"
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-100 transition"
                        >
                            Cancel
                        </button>
    
                        <button
                            type="submit"
                            class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        >
                            Save Blog
                        </button>
    
                    </div>
    
                </form>
    
            </div>
    
        </div>
    
    </div>

    <!-- CREATE CATEGORY MODAL -->
    <div
        id="createCategoryModal"
        class="fixed inset-0 z-50 hidden bg-black/20 backdrop-blur-sm"
    >
    
        <div class="fixed inset-0 flex items-center justify-center p-4">
    
            <!-- MODAL -->
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col">
    
                <!-- HEADER -->
                <div class="flex items-center justify-between px-5 py-3 border-b shrink-0">
    
                    <h2 class="text-xl font-semibold text-gray-800">
                        Create Category
                    </h2>
    
                    <button
                        type="button"
                        id="closeCreateCategoryModal"
                        class="text-2xl leading-none text-gray-500 hover:text-red-500 transition"
                    >
                        &times;
                    </button>
    
                </div>
    
                <!-- FORM -->
                <form
                    id="createCategoryForm"
                    class="flex flex-col flex-1 overflow-hidden"
                >
    
                    <!-- BODY -->
                    <div class="flex-1 overflow-y-auto px-5 py-4">
    
                        <div class="space-y-5">
    
                            <!-- Category Name -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Category Name
                                </label>
    
                                <input
                                    type="text"
                                    name="name"
                                    placeholder="Enter category name"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
    
                            <!-- Slug -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Slug URL
                                </label>
    
                                <input
                                    type="text"
                                    name="slug"
                                    placeholder="category-slug"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
    
                            <!-- Description -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    Description
                                </label>
    
                                <textarea
                                    name="description"
                                    rows="4"
                                    placeholder="Write category description..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                                ></textarea>
                            </div>
    
                        </div>
    
                    </div>
    
                    <!-- FOOTER -->
                    <div class="border-t px-5 py-3 bg-white flex justify-end gap-3 shrink-0 rounded-b-xl">
    
                        <button
                            type="button"
                            id="cancelCreateCategory"
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-100 transition"
                        >
                            Cancel
                        </button>
    
                        <button
                            type="submit"
                            class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        >
                            Save Category
                        </button>
    
                    </div>
    
                </form>
    
            </div>
    
        </div>
    
    </div>

    <!-- CREATE Tag MODAL -->
    <div
        id="createTagModal"
        class="fixed inset-0 z-50 hidden bg-black/20 backdrop-blur-sm"
    >
    
        <div class="fixed inset-0 flex items-center justify-center p-4">
    
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg">
    
                <!-- Header -->
                <div class="flex items-center justify-between px-5 py-3 border-b">
    
                    <h2 class="text-xl font-semibold">
                        Create Tag
                    </h2>
    
                    <button
                        type="button"
                        id="closeCreateTagModal"
                        class="text-2xl text-gray-500 hover:text-red-500"
                    >
                        &times;
                    </button>
    
                </div>
    
                <!-- Form -->
                <form id="createTagForm">
    
                    <div class="p-5 space-y-4">
    
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Tag Name
                            </label>
    
                            <input
                                type="text"
                                name="name"
                                placeholder="Laravel"
                                class="w-full border rounded-lg px-3 py-2"
                            >
                        </div>
    
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Slug
                            </label>
    
                            <input
                                type="text"
                                name="slug"
                                placeholder="laravel"
                                class="w-full border rounded-lg px-3 py-2"
                            >
                        </div>
    
                    </div>
    
                    <div class="border-t p-4 flex justify-end gap-2">
    
                        <button
                            type="button"
                            id="cancelCreateTag"
                            class="px-4 py-2 border rounded-lg"
                        >
                            Cancel
                        </button>
    
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg"
                        >
                            Save Tag
                        </button>
    
                    </div>
    
                </form>
    
            </div>
    
        </div>
    
    </div>

    <!-- Header & Sidebar -->
    @include('layouts.header')
    @include('layouts.sidebar')

    <!-- Page Content -->
    <!-- @yield('content') -->

    <!-- Page Scripts -->
    @stack('scripts')

</body>
</html>