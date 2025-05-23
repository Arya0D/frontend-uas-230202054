<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MatakuliahController extends Controller
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
            $response = $this->client->get("{$this->baseUrl}/matakuliah");
            $data = json_decode($response->getBody(), true);

            return view('admin.matakuliah.index', ['matakuliah' => $data]);
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.matakuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matkul' => 'required|string',
            'nama_matkul' => 'required|string',
            'semester' => 'required|string',
            'sks' => 'required|string'
        ]);

        try {
            $this->client->post("{$this->baseUrl}/matakuliah", [
                'json' => $request->only(['kode_matkul', 'nama_matkul', 'semester', 'sks']),
            ]);

            return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil ditambahkan');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to add data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/matakuliah/{$id}");
            $data = json_decode($response->getBody(), true);
            $data = $data[0];

            return view('admin.matakuliah.edit', ['matakuliah' => $data]);
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_matkul' => 'required|string',
            'nama_matkul' => 'required|string',
            'semester' => 'required|string',
            'sks' => 'required|string'
        ]);

        try {
            $this->client->put("{$this->baseUrl}/matakuliah/{$id}", [
                'json' => $request->only(['kode_matkul', 'nama_matkul', 'semester', 'sks']),
            ]);

            return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil diperbarui');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to update data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->client->delete("{$this->baseUrl}/matakuliah/{$id}");

            return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil dihapus');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to delete data: ' . $e->getMessage());
        }
    }
}
