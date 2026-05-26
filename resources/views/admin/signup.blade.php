<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen">

    @include('layouts.header')

    <div class="flex items-center justify-center py-2">

        <div class="w-full max-w-sm bg-white rounded-lg shadow-lg p-4">
    
            <div class="text-center mb-4">
                <h1 class="text-xl font-bold text-black">
                    Registration
                </h1>
            </div>
    
            <form method="POST" action="/admin-signup">
                @csrf
    
                <!-- Username -->
                <div class="mb-2">
                    <label class="block text-xs text-gray-800 mb-1">
                        Username
                    </label>
    
                    <input
                        type="text"
                        name="username"
                        placeholder="enter user name"
                        class="w-full border border-gray-300 px-3 py-2 text-xs rounded focus:outline-none focus:ring-1 focus:ring-cyan-500"
                    >
                </div>
    
                <!-- Email -->
                <div class="mb-2">
                    <label class="block text-xs text-gray-800 mb-1">
                        Email
                    </label>
    
                    <input
                        type="email"
                        name="email"
                        placeholder="enter user email"
                        class="w-full border border-gray-300 px-3 py-2 text-xs rounded focus:outline-none focus:ring-1 focus:ring-cyan-500"
                    >
                </div>
    
                <div class="mb-2">
                    <label class="block text-xs text-gray-800 mb-1">
                        Contact
                    </label>
    
                    <input
                        type="text"
                        name="contact"
                        placeholder="enter user phone"
                        class="w-full border border-gray-300 px-3 py-2 text-xs rounded focus:outline-none focus:ring-1 focus:ring-cyan-500"
                    >
                </div>
    
                <div class="mb-2">
                    <label class="block text-xs text-gray-800 mb-1">
                        Password
                    </label>
    
                    <input
                        type="password"
                        name="password"
                        placeholder="enter password"
                        class="w-full border border-gray-300 px-3 py-2 text-xs rounded focus:outline-none focus:ring-1 focus:ring-cyan-500"
                    >
                </div>
    
                <div class="mb-2">
                    <label class="block text-xs text-gray-800 mb-1">
                        Re-Password
                    </label>
    
                    <input
                        type="password"
                        name="confirm_password"
                        placeholder="re-enter password"
                        class="w-full border border-gray-300 px-3 py-2 text-xs rounded focus:outline-none focus:ring-1 focus:ring-cyan-500"
                    >
                </div>
    
                <div class="mb-4">
                    <label class="block text-xs text-gray-800 mb-1">
                        User Type
                    </label>
    
                    <select
                        name="user_type"
                        class="w-full border border-gray-300 px-3 py-2 text-xs rounded focus:outline-none focus:ring-1 focus:ring-cyan-500 bg-white"
                    >
                        <option value="">
                            select user type
                        </option>
    
                        <option value="agent">
                            Agent
                        </option>
    
                        <option value="manager">
                            Manager
                        </option>
                    </select>
                </div>
    
                <button
                    type="submit"
                    class="w-full bg-cyan-500 hover:bg-cyan-600 text-white text-xs py-2 rounded transition duration-300 font-medium"
                >
                    REGISTER
                </button>
    
            </form>
    
            <div class="mt-2 text-xs text-center">
                Existing Agent?

                <a
                    href="/admin-login"
                    class="text-blue-600 hover:underline font-medium"
                >
                    Login
                </a>
            </div>
        </div>
    
    </div>

</body>
</html>