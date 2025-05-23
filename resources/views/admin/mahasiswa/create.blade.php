@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')

@section('content')
    <div class="flex justify-between items-center">
        <h3 class="text-3xl font-medium text-gray-700">Tambah Mahasiswa</h3>
        <a href="{{ route('mahasiswa.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="mt-8">
        <div class="mt-8 bg-white p-6 rounded-md shadow-md">
            <form action="{{ route('mahasiswa.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
    <label for="id" class="block text-sm font-medium text-gray-700">id</label>
    <input type="text" name="id" id="id" value="{{ old('id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="nama" class="block text-sm font-medium text-gray-700">nama</label>
    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('nama')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="nim" class="block text-sm font-medium text-gray-700">nim</label>
    <input type="text" name="nim" id="nim" value="{{ old('nim') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('nim')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="kode_kelas" class="block text-sm font-medium text-gray-700">kode_kelas</label>
    <input type="text" name="kode_kelas" id="kode_kelas" value="{{ old('kode_kelas') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('kode_kelas')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection