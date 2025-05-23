@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700">Dashboard</h3>
    
    <div class="mt-4">
        <div class="flex flex-wrap -mx-6">
            <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
                    <div class="p-3 bg-indigo-600 bg-opacity-75 rounded-full">
                        <i class="fas fa-user-tie text-white text-2xl"></i>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $dosenCount ?? 0 }}</h4>
                        <div class="text-gray-500">Total Mata Kuliah</div>
                    </div>
                </div>
            </div>

            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
                <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
                    <div class="p-3 bg-green-600 bg-opacity-75 rounded-full">
                        <i class="fas fa-user-graduate text-white text-2xl"></i>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $mahasiswaCount ?? 0 }}</h4>
                        <div class="text-gray-500">Total Mahasiswa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <div class="flex flex-col mt-8">
            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h2 class="text-xl font-semibold text-gray-700">Selamat Datang di Admin Dashboard</h2>
                        <p class="mt-2 text-gray-600">
                            Dashboard ini menyediakan akses untuk mengelola data Dosen dan Mahasiswa.
                            Gunakan menu di sidebar untuk navigasi ke halaman yang diinginkan.
                        </p>
                        
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <a href="{{ route('matakuliah.index') }}" class="block p-6 bg-indigo-100 rounded-lg hover:bg-indigo-200 transition">
                                <h3 class="text-lg font-semibold text-indigo-700">Kelola Data Matakuliah</h3>
                                <p class="mt-2 text-indigo-600">Lihat, tambah, edit, dan hapus data Matakuliah</p>
                            </a>
                            
                            <a href="{{ route('mahasiswa.index') }}" class="block p-6 bg-green-100 rounded-lg hover:bg-green-200 transition">
                                <h3 class="text-lg font-semibold text-green-700">Kelola Data Mahasiswa</h3>
                                <p class="mt-2 text-green-600">Lihat, tambah, edit, dan hapus data mahasiswa</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
