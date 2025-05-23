<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AuthController extends Controller
{
    protected $client;
    protected $apiBaseUrl;

    public function __construct()
    {
        // Initialize Guzzle client
        $this->client = new Client();
        // Define the base URL of the external API
        $this->apiBaseUrl = env('API_BASE_URL', 'https://api.example.com'); // Set in .env
    }

    public function showLoginForm()
    {
        if (Session::has('authenticated') && Session::get('authenticated') === true) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            // Make a POST request to the external API
            $response = $this->client->post("{$this->apiBaseUrl}/login", [
                'json' => [
                    'username' => $request->username,
                    'password' => $request->password,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Check if the API returned a successful response
            if (isset($data['success']) && $data['success']) {
                Session::put('authenticated', true);
                Session::put('user', [
                    'name' => $data['user']['name'] ?? 'Administrator',
                    'username' => $request->username,
                    'token' => $data['token'] ?? null, // Store token if provided
                ]);

                return redirect()->route('dashboard')->with('success', 'Login berhasil!');
            }

            return back()->withErrors([
                'login' => 'Username atau password salah.',
            ])->withInput($request->except('password'));

        } catch (RequestException $e) {
            // Handle API errors
            $errorMessage = 'Terjadi kesalahan saat menghubungi server.';
            if ($e->hasResponse()) {
                $errorData = json_decode($e->getResponse()->getBody(), true);
                $errorMessage = $errorData['message'] ?? $errorMessage;
            }

            return back()->withErrors([
                'login' => $errorMessage,
            ])->withInput($request->except('password'));
        }
    }

    public function logout()
    {
        try {
            // Optionally call the API to invalidate the token
            $token = Session::get('user.token');
            if ($token) {
                $this->client->post("{$this->apiBaseUrl}/logout", [
                    'headers' => [
                        'Authorization' => "Bearer {$token}",
                    ],
                ]);
            }
        } catch (RequestException $e) {
            // Log error if needed, but proceed with session cleanup
        }

        Session::forget('authenticated');
        Session::forget('user');

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}