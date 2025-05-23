@extends('layouts.admin')

@section('title', 'Daftar ' . ucfirst('mahasiswa'))

@section('content')
    <h3 class="text-2xl font-bold">Daftar Mahasiswa</h3>
    <a href="{{ route('mahasiswa.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">Tambah Mahasiswa</a>

    <div class="mt-6">
        <table class="min-w-full" id="myTable" class="display">
            <thead>
                <tr>
                    <th class="px-6 py-3">Id</th>
<th class="px-6 py-3">Nama</th>
<th class="px-6 py-3">Nim</th>
<th class="px-6 py-3">Kode_Kelas</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswa as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $item['id'] }}</td>
<td class="px-6 py-4">{{ $item['nama'] }}</td>
<td class="px-6 py-4">{{ $item['nim'] }}</td>
<td class="px-6 py-4">{{ $item['kode_kelas'] }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('mahasiswa.edit', $item['nim']) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('mahasiswa.destroy', $item['nim']) }}" method="POST" class="inline">
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