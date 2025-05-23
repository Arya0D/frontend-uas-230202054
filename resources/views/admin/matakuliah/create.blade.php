@extends('layouts.admin')

@section('title', 'Tambah Matakuliah')

@section('content')
    <div class="flex justify-between items-center">
        <h3 class="text-3xl font-medium text-gray-700">Tambah Matakuliah</h3>
        <a href="{{ route('matakuliah.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="mt-8">
        <div class="mt-8 bg-white p-6 rounded-md shadow-md">
            <form action="{{ route('matakuliah.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
    <label for="kode_matkul" class="block text-sm font-medium text-gray-700">kode_matkul</label>
    <input type="text" name="kode_matkul" id="kode_matkul" value="{{ old('kode_matkul') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('kode_matkul')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="nama_matkul" class="block text-sm font-medium text-gray-700">nama_matkul</label>
    <input type="text" name="nama_matkul" id="nama_matkul" value="{{ old('nama_matkul') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('nama_matkul')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="semester" class="block text-sm font-medium text-gray-700">semester</label>
    <input type="text" name="semester" id="semester" value="{{ old('semester') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('semester')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="sks" class="block text-sm font-medium text-gray-700">sks</label>
    <input type="text" name="sks" id="sks" value="{{ old('sks') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('sks')
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