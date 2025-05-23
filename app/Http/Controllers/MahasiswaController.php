<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MahasiswaController extends Controller
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'http://localhost:8080';
    }

    public function index()
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/mahasiswa");
            $data = json_decode($response->getBody(), true);

            return view('admin.mahasiswa.index', ['mahasiswa' => $data]);
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'nama' => 'required|string',
            'nim' => 'required|string',
            'kode_kelas' => 'required|string'
        ]);

        try {
            $this->client->post("{$this->baseUrl}/mahasiswa", [
                'json' => $request->only(['id', 'nama', 'nim', 'kode_kelas']),
            ]);

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to add data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/mahasiswa/{$id}");
            $data = json_decode($response->getBody(), true);
             $data = $data[0];

            return view('admin.mahasiswa.edit', ['mahasiswa' => $data]);
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|string',
            'nama' => 'required|string',
            'nim' => 'required|string',
            'kode_kelas' => 'required|string'
        ]);

        try {
            $this->client->put("{$this->baseUrl}/mahasiswa/{$id}", [
                'json' => $request->only(['id', 'nama', 'nim', 'kode_kelas']),
            ]);

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to update data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->client->delete("{$this->baseUrl}/mahasiswa/{$id}");

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to delete data: ' . $e->getMessage());
        }
    }
}
