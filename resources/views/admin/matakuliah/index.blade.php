@extends('layouts.admin')

@section('title', 'Daftar ' . ucfirst('matakuliah'))

@section('content')
    <h3 class="text-2xl font-bold">Daftar Matakuliah</h3>
    <a href="{{ route('matakuliah.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">Tambah Matakuliah</a>

    <div class="mt-6">
        <table class="min-w-full" id="myTable" class="display">
            <thead>
                <tr>
                    <th class="px-6 py-3">Kode_Matkul</th>
<th class="px-6 py-3">Nama_Matkul</th>
<th class="px-6 py-3">Semester</th>
<th class="px-6 py-3">Sks</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matakuliah as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $item['kode_matkul'] }}</td>
<td class="px-6 py-4">{{ $item['nama_matkul'] }}</td>
<td class="px-6 py-4">{{ $item['semester'] }}</td>
<td class="px-6 py-4">{{ $item['sks'] }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('matakuliah.edit', $item['kode_matkul']) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('matakuliah.destroy', $item['kode_matkul']) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection