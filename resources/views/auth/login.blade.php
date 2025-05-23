<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Dashboard</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-indigo-600 p-6">
                <h2 class="text-white text-2xl font-bold text-center">Admin Dashboard</h2>
            </div>
            
            <div class="p-6">
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @error('login')
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-user text-gray-400"></i>
                            </span>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your username" required>
                        </div>
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </span>
                            <input type="password" name="password" id="password" class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your password" required>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="bg-gray-50 px-6 py-4">
                <div class="text-center text-xs text-gray-500">
                    <p>Demo credentials: admin / password</p>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-center text-sm text-gray-600">
            &copy; {{ date('Y') }} Admin Dashboard. All rights reserved.
        </div>
    </div>
</body>
</html>
