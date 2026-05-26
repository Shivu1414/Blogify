<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="bg-black shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

            <a href="/" class="text-2xl font-bold text-white">
                Blogify
            </a>

            <nav class="flex gap-6">
                <a href="/" class="text-white hover:text-blue-600">
                    Home
                </a>

                <a href="/blogs" class="text-blue-600 font-medium">
                    Blogs
                </a>
            </nav>

        </div>
    </header>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 py-10">

        <h1 class="text-4xl font-bold mb-8">
            Latest Blogs
        </h1>

        <div class="grid md:grid-cols-3 gap-6">
    
            @foreach($blogs as $blog)
    
                <div class="bg-white rounded-xl shadow overflow-hidden">
    
                    <img
                        src="{{ asset($blog->featured_image) }}"
                        class="w-full h-52 object-cover"
                        alt="{{ $blog->title }}"
                    >
    
                    <div class="p-5">
    
                        <span class="text-sm text-blue-600">
                            {{ $blog->category->name ?? 'General' }}
                        </span>
    
                        <h2 class="text-xl font-semibold mt-2">
                            {{ $blog->title }}
                        </h2>
    
                        <p class="text-gray-600 mt-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 120) }}
                        </p>
    
                        <a
                            href="{{ url('/blogs/'.$blog->slug) }}"
                            class="inline-block mt-4 text-blue-600 font-medium"
                        >
                            Read More →
                        </a>
    
                    </div>
    
                </div>
    
            @endforeach
    
        </div>

    </main>

</body>
</html>
