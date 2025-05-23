<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DashboardController extends Controller
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
            $dosenResponse = $this->client->request('GET', $this->baseUrl . '/dosen');
            $mahasiswaResponse = $this->client->request('GET', $this->baseUrl . '/mahasiswa');
            
            $dosen = json_decode($dosenResponse->getBody()->getContents(), true);
            $mahasiswa = json_decode($mahasiswaResponse->getBody()->getContents(), true);
           dd($mahasiswa);
            
            $dosenCount = is_array($dosen) ? count($dosen) : 0;
            $mahasiswaCount = is_array($mahasiswa) ? count($mahasiswa) : 0;
            
            return view('admin.dashboard', compact('dosenCount', 'mahasiswaCount'));
        } catch (RequestException $e) {
            return view('admin.dashboard')->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }
}
