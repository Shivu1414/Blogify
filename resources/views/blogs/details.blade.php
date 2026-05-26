<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-black shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

            <a href="/" class="text-2xl font-bold text-white">
                Blogify
            </a>

            <nav class="flex gap-6">
                <a href="/" class="text-white hover:text-blue-600">
                    Home
                </a>

                <a href="/blogs" class="text-white hover:text-blue-600">
                    Blogs
                </a>
            </nav>

        </div>
    </header>

    <!-- Blog Content -->
    <main class="max-w-4xl mx-auto px-4 py-10">

        @if($blog->featured_image)
            <img
                src="{{ asset($blog->featured_image) }}"
                class="w-full rounded-xl mb-8"
                alt="{{ $blog->title }}"
            >
        @endif

        <div class="mb-3">

            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                {{ $blog->category->name ?? 'General' }}
            </span>

        </div>

        <h1 class="text-5xl font-bold mb-4">
            {{ $blog->title }}
        </h1>

        <p class="text-gray-500 mb-6">
            {{ $blog->created_at->format('d M Y') }}
        </p>

        <div class="prose max-w-none">

            {!! nl2br(e($blog->description)) !!}

        </div>

        @if($blog->tags->count())
            <div class="mt-8">

                @foreach($blog->tags as $tag)

                    <span class="bg-gray-100 px-3 py-1 rounded-full text-sm mr-2">
                        #{{ $tag->name }}
                    </span>

                @endforeach

            </div>
        @endif

        <div class="mt-10">
            <a
                href="/blogs"
                class="inline-flex items-center text-blue-600 hover:text-blue-800"
            >
                ← Back to Blogs
            </a>
        </div>

    </main>

</body>
</html>