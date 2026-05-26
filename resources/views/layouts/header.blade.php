<header class="bg-gray-900 text-white shadow-lg">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center shadow-md ">
        
        @isset($name)
            <div class="flex items-center space-x-4">
                <button id="toggleSidebar" class="text-white text-2xl focus:outline-none cursor-pointer">
                    ☰
                </button>
        
                <h1 class="text-xl font-bold cursor-pointer">BLOGIFY</h1>
            </div>
        @else
            <h1 class="text-xl font-bold cursor-pointer">BLOGIFY</h1>
        @endisset

        
        <!-- @isset($name)
            <nav>
                <a href="#" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">Logout</a>
            </nav>
        @endisset -->

    </div>
</header>