<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS -->
     
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Data Table -->

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.tailwindcss.js"></script>
    
    @yield('styles')
</head>

<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
        
        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <span class="mx-2 text-2xl font-semibold text-white">Admin Dashboard</span>
                </div>
            </div>

            <nav class="mt-10">
                <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('dashboard') ? 'text-gray-100 bg-gray-700' : 'text-gray-500 hover:bg-gray-700 hover:text-gray-100' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home mr-3"></i>
                    <span class="mx-3">Dashboard</span>
                </a>

                <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('matakuliah.*') ? 'text-gray-100 bg-gray-700' : 'text-gray-500 hover:bg-gray-700 hover:text-gray-100' }}" href="{{ route('matakuliah.index') }}">
                    <i class="fas fa-user-tie mr-3"></i>
                    <span class="mx-3">Matakuliah</span>
                </a>

                <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('mahasiswa.*') ? 'text-gray-100 bg-gray-700' : 'text-gray-500 hover:bg-gray-700 hover:text-gray-100' }}" href="{{ route('mahasiswa.index') }}">
                    <i class="fas fa-user-graduate mr-3"></i>
                    <span class="mx-3">Mahasiswa</span>
                </a>
            </nav>
        </div>

        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>

                <div class="flex items-center">
                    <div x-data="{ dropdownOpen: false }" class="relative flex gap-3 items-center">
                        <button @click="dropdownOpen = ! dropdownOpen" class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                            <i class="fas fa-user-circle text-2xl text-gray-700"></i>
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

                        <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                <div class="font-medium">{{ session('user')['name'] ?? 'Administrator' }}</div>
                                <div class="text-xs text-gray-500">{{ session('user')['username'] ?? 'admin' }}</div>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
                                    Logout
                                </button>
                            </form>
                        </div>
                        <h1 class="text-xl font-bold">{{ session('user')['username'] ?? 'admin' }}</h1>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container px-6 py-8 mx-auto">
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

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @yield('scripts')
      <script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>
</body>
</html>
