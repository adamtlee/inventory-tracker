<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Tracker - Asset Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-cube text-white text-2xl"></i>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Inventory Tracker
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Manage your assets, track checkouts, and maintain inventory
                </p>
            </div>

            <!-- Tabs -->
            <div class="flex rounded-lg bg-gray-100 p-1">
                <button id="login-tab" class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 bg-white text-indigo-600 shadow-sm">
                    Sign In
                </button>
                <button id="register-tab" class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700">
                    Create Account
                </button>
            </div>

            <!-- Login Form -->
            <div id="login-form" class="space-y-6">
                <form class="mt-8 space-y-6" method="POST" action="{{ route('landing.login') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                                   placeholder="Enter your email" value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                   class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                                   placeholder="Enter your password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-900">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-sign-in-alt text-indigo-500 group-hover:text-indigo-400"></i>
                            </span>
                            Sign in
                        </button>
                    </div>
                </form>
            </div>

            <!-- Register Form -->
            <div id="register-form" class="space-y-6 hidden">
                <form class="mt-8 space-y-6" method="POST" action="{{ route('landing.register') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="reg_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input id="reg_name" name="name" type="text" autocomplete="name" required 
                                   class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('name') border-red-500 @enderror"
                                   placeholder="Enter your full name" value="{{ old('name') }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="reg_email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input id="reg_email" name="email" type="email" autocomplete="email" required 
                                   class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                                   placeholder="Enter your email" value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="reg_password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input id="reg_password" name="password" type="password" autocomplete="new-password" required 
                                   class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                                   placeholder="Create a password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                   class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                   placeholder="Confirm your password">
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-user-plus text-green-500 group-hover:text-green-400"></i>
                            </span>
                            Create Account
                        </button>
                    </div>
                </form>
            </div>

            <!-- Features -->
            <div class="mt-8">
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">What you can do:</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <i class="fas fa-cube text-indigo-500"></i>
                            <span>Track individual assets with unique IDs</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt text-indigo-500"></i>
                            <span>Manage storage locations and bins</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <i class="fas fa-exchange-alt text-indigo-500"></i>
                            <span>Track checkouts and returns</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                            <i class="fas fa-chart-bar text-indigo-500"></i>
                            <span>View inventory statistics and reports</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.getElementById('login-tab').addEventListener('click', function() {
            document.getElementById('login-form').classList.remove('hidden');
            document.getElementById('register-form').classList.add('hidden');
            document.getElementById('login-tab').classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
            document.getElementById('login-tab').classList.remove('text-gray-500');
            document.getElementById('register-tab').classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
            document.getElementById('register-tab').classList.add('text-gray-500');
        });

        document.getElementById('register-tab').addEventListener('click', function() {
            document.getElementById('register-form').classList.remove('hidden');
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('register-tab').classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
            document.getElementById('register-tab').classList.remove('text-gray-500');
            document.getElementById('login-tab').classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
            document.getElementById('login-tab').classList.add('text-gray-500');
        });

        // Show register form if there are registration errors
        @if($errors->has('name') || $errors->has('password_confirmation'))
            document.getElementById('register-tab').click();
        @endif
    </script>
</body>
</html>
