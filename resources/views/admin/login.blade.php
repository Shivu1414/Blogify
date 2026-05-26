<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin Login</title>

    @vite(['resources/css/app.css', 'resources/js/common/login.js', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen">

    <div id="topLoader" class="top-loader"></div>

    @include('layouts.header')

    <div class="flex items-center justify-center h-[89vh]">

        <div class="flex flex-col items-center w-full max-w-md">
        
            <div class="bg-white p-8 rounded-2xl shadow-2xl w-full">
        
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">
                        Admin Login
                    </h1>
                </div>
        
                <form method="POST" action="/admin-login">
                    @csrf
        
                    @error('user')
                        <div class="text-red-500 mb-4">{{$message}}</div>
                    @enderror
        
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-2">
                            Email
                        </label>
        
                        <input
                            type="email"
                            name="email"
                            placeholder="Enter your email"
                            class="w-full px-4 py-3 border rounded-xl bg-slate-100 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        >
        
                        @error('email')
                            <div class="text-red-500 mt-1">{{$message}}</div>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-2">
                            Password
                        </label>
        
                        <input
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            class="w-full px-4 py-3 border rounded-xl bg-slate-100 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        >
        
                        @error('password')
                            <div class="text-red-500 mt-1">{{$message}}</div>
                        @enderror
                    </div>
        
                    <div class="flex justify-between items-center mb-6 text-sm">
                        
                        <label class="flex items-center text-gray-600">
                            <input type="checkbox" name="remember" class="mr-2">
                            Remember me
                        </label>
        
                        <div 
                            id="forgotPasswordBtn"
                            class="text-purple-600 hover:underline whitespace-nowrap cursor-pointer"
                        >
                            Forgot Password?
                        </div>
        
                    </div>
        
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 to-fuchsia-500 text-white py-3 rounded-xl hover:opacity-90 transition duration-300 text-lg font-medium"
                    >
                        Login
                    </button>
        
                </form>
        
            </div>
        
            <!-- Bottom Signup -->
            <div class="text-center mt-3 text-white text-lg">
                Don’t have an account?
        
                <a href="/admin-signup" class="font-semibold underline hover:text-green-500 ml-1">
                    Sign Up
                </a>
            </div>
        
        </div>

        <div 
            id="forgotModal"
            class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50"
        >
        
            <!-- Modal Box -->
            <div class="bg-white w-[90%] max-w-md rounded-2xl shadow-2xl p-8 relative">
        
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">
                        Reset Password
                    </h2>
                </div>
        
                <div class="">
                    @csrf

                    <div class="mb-5" id="emailSection">
                        <input
                            id="forgetEmail"
                            type="email"
                            name="forgot_email"
                            placeholder="Enter Registered Email"
                            class="w-full px-4 py-3 border rounded-xl bg-slate-100 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        >
                    </div>
                    
                    <div class="mb-5 hidden" id="passwordSection">
                        <input
                            id="newPassword"
                            type="password"
                            placeholder="Enter New Password"
                            class="w-full px-4 py-3 border rounded-xl bg-slate-100 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        >
                    </div>

                    <div class="mb-5 hidden" id="otpSection">
                        <input
                            id="otp"
                            type="text"
                            maxlength="6"
                            placeholder="Enter OTP"
                            class="w-full px-4 py-3 border rounded-xl bg-slate-100 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        >
                    
                        <div class="mt-2 text-sm text-red-500">
                            OTP expires in <span id="otpTimer">05:00</span>
                        </div>
                    </div>

                    <input type="hidden" id="hidden_email">

                    <button
                        id="sendOtp"
                        type="button"
                        class="w-full cursor-pointer bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl text-lg font-medium transition duration-300"
                    >
                        Send OTP
                    </button>

                    <button
                        type="button"
                        id="closeModal"
                        class="w-full mt-3 cursor-pointer bg-gray-300 hover:bg-gray-400 text-gray-800 py-3 rounded-xl text-lg transition duration-300"
                    >
                        Close
                    </button>
                </div>
        
            </div>
        
        </div>

    </div>

</body>
</html>