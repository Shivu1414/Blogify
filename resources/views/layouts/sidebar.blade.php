@isset($name)

<div class="flex">

    <div id="sidebar" class="w-64 bg-gray-800 text-white p-5 transition-all duration-300">

        <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
        
        <ul class="space-y-3">
        
            <li>
                <div class="flex items-center justify-between p-2 rounded hover:bg-gray-700 
                    {{ $panel === 'dashboard' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">

                    <a href="/dashboard" class="flex items-center gap-3 flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 10l9-7 9 7v11a1 1 0 01-1 1h-6v-6H10v6H4a1 1 0 01-1-1V10z" />
                        </svg>
                        Dashboard
                    </a>

                    @if($panel === 'dashboard')
                        <div id="dashboardArrow"
                             class="p-1 rounded cursor-pointer transition-all duration-200 hover:bg-white/20">
                        
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-4 h-4 transition-transform duration-300 {{ $panel === 'dashboard' ? 'rotate-180' : '' }}"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    @else
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 cursor-not-allowed transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    @endif
                </div>

                <div id="dashboardDropdown" class="ml-6 mt-1 space-y-1 {{ $panel !== 'dashboard' ? 'hidden' : '' }}">

                    <div class="bg-gray-700 rounded-lg p-3 shadow-md">

                        <div class="flex items-center gap-2 mb-2 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5.121 17.804A8 8 0 1118.879 6.196 8 8 0 015.121 17.804z" />
                            </svg>
                            Blog Actions
                        </div>

                        <div class="flex gap-2">
                            <button
                                class="flex items-center gap-1 bg-red-500 hover:bg-red-600 px-2 py-1 rounded text-xs font-medium shadow cursor-pointer bulk_disable_btn">
                                Bulk Delete
                            </button>
                            <!-- <button
                                class="flex items-center gap-1 bg-green-500 hover:bg-green-600 px-2 py-1 rounded text-xs font-medium shadow cursor-pointer bulk_enable_btn">
                                ✔ Enable
                            </button> -->

                            <!-- <button
                                class="flex items-center gap-1 bg-red-500 hover:bg-red-600 px-2 py-1 rounded text-xs font-medium shadow cursor-pointer bulk_disable_btn">
                                🔒 Disable
                            </button> -->
                        </div>
                    </div>

                    <div id="openCreateBlogModal" class="bg-gray-700 rounded-lg p-3 shadow-md 
                                hover:bg-gray-600 hover:shadow-xl 
                                transition-all duration-300 cursor-pointer">
                        <div class="flex items-center gap-2 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5.121 17.804A8 8 0 1118.879 6.196 8 8 0 015.121 17.804z" />
                            </svg>
                            Create Blog
                        </div>
                    </div>

                    <div id="openCreateCategoryModal" class="bg-gray-700 rounded-lg p-3 shadow-md 
                                hover:bg-gray-600 hover:shadow-xl 
                                transition-all duration-300 cursor-pointer">
                        <div class="flex items-center gap-2 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5.121 17.804A8 8 0 1118.879 6.196 8 8 0 015.121 17.804z" />
                            </svg>
                            Create Category
                        </div>
                    </div>

                    <div id="openCreateTagModal" class="bg-gray-700 rounded-lg p-3 shadow-md 
                                hover:bg-gray-600 hover:shadow-xl 
                                transition-all duration-300 cursor-pointer">
                        <div class="flex items-center gap-2 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5.121 17.804A8 8 0 1118.879 6.196 8 8 0 015.121 17.804z" />
                            </svg>
                            Create Tag
                        </div>
                    </div>

                </div>
            </li>
        
            <li>
                <form method="GET" action="/admin-logout">
                    @csrf
                    <button class="flex items-center gap-3 w-full text-left p-2 rounded hover:bg-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V7" />
                        </svg>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div id="mainContent" class="flex-1 transition-all duration-300">
        @yield('content')
    </div>

</div>

@endisset