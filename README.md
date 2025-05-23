# 🚀 Project Laravel

Ini adalah proyek berbasis [Laravel](https://laravel.com/) — PHP framework untuk web artisan.

## 🛠️ Persyaratan

Pastikan sudah terinstal di sistem Anda:

- PHP >= 8.1
- Composer
- MySQL / PostgreSQL / SQLite
- Node.js & npm (jika menggunakan Vite atau frontend build)
- Laravel CLI (opsional)

## 📦 Instalasi

1. **Clone repository:**

   ```bash
   git clone https://github.com/Arya0D/frontend-uas-230202054.git
   cd nama-proyek
   ```

2. **Install dependensi PHP:**
   ```
   composer install
   ```
   
3. **Salin file konfigurasi .env:**
   ```
   cp .env.example .env
   ```
4. **Generate application key:**
   ```
   php artisan key:generate
   ```
## ⚙️ Menjalankan Project Laravel
```
php artisan serve
```
Aplikasi akan berjalan di:``` http://localhost:8000```

- usernamane untuk login : ```admin```
- password untuk login : ```password```

## 🤖 Konfigurasi Backend
1. **Clone repository:**
   Untuk repository backend ada di: https://github.com/Arfilal/backend_sinilai.git
   
   ```bash
   git clone https://github.com/username/nama-proyek.git
   cd nama-proyek
   ```
3. **Buka file .env dan sesuaikan bagian berikut:**
   ```
   database.default.hostname = localhost
   database.default.database = db_uas_230202054
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```
4. **Atur Controller Mahasiswa di /App/Controllers/Mahasiswa.php**
```
   <?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelMahasiswa;

class Mahasiswa extends BaseController
{
    use ResponseTrait;
    protected $model;

    function __construct()
    {
        $this->model = new ModelMahasiswa();
    }

    public function index()
    {
        $data = $this->model->orderBy('nama', 'asc')->findAll();
        return $this->respond($data, 200);
    }

    public function create()
    {
        // Ambil data dari request
        // $npm = $this->request->getVar('npm');
        // $nama_mhs = $this->request->getVar('nama_mhs');
        // $kode_kelas = $this->request->getVar('kode_kelas');
        // $id_prodi = $this->request->getVar('id_prodi');


        $npm = $this->request->getVar('nim');
        $nama_mhs = $this->request->getVar('nama');
        $kode_kelas = $this->request->getVar('kode_kelas');

        // Pastikan data valid
        if (empty($npm) || empty($nama_mhs)) {
            return $this->response->setJSON(['error' => 'Data tidak lengkap']);
        }

        // Masukkan data ke dalam model
        $data = [
            'nim' => $npm,
            'nama' => $nama_mhs,
            'kode_kelas' => $kode_kelas,
        ];

        // Insert data ke database
        if ($this->model->insert($data)) {
            return $this->response->setJSON(['message' => 'Aspirasi berhasil dikirim']);
        } else {
            return $this->response->setJSON(['error' => 'Gagal mengirim aspirasi']);
        }
    }

    public function edit($npm)
    {
        $mahasiswa = $this->model->find($npm);
        if (!$mahasiswa) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON($mahasiswa);
    }

    public function update($npm)
    {
        // Ambil data dari request
        $nama_mhs = $this->request->getVar('nama');
        $kode_kelas = $this->request->getVar('kode_kelas');

        // Validasi data
        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'kode_kelas' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Cek apakah data mahasiswa dengan npm tersebut ada
        $existing = $this->model->where('nim', $npm)->first();
        if (!$existing) {
            return $this->failNotFound("Data tidak ditemukan untuk NPM $npm");
        }

        // Data yang akan diperbarui
        $data = [
            'nama' => $nama_mhs,
            'kode_kelas' => $kode_kelas,
        ];

        // Update data
        $updated = $this->model->update($npm, $data);

        if ($updated) {
            return $this->respond([
                'status' => 200,
                'messages' => ['success' => "Data berhasil diperbarui"]
            ]);
        }

        return $this->fail("Gagal memperbarui data.");
    }

    public function delete($npm)
    {
        // Cari data mahasiswa berdasarkan npm
        $data = $this->model->where('nim', $npm)->first();

        // Cek apakah data mahasiswa ditemukan
        if ($data) {
            // Hapus data mahasiswa berdasarkan npm
            $this->model->where('nim', $npm)->delete();

            // Response sukses jika data berhasil dihapus
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => "Data mahasiswa dengan NPM $npm berhasil dihapus"
                ]
            ];
            return $this->respond($response);
        } else {
            // Jika data mahasiswa tidak ditemukan
            return $this->failNotFound("Data mahasiswa dengan NPM $npm tidak ditemukan");
        }
    }

    // 🔥 Menambahkan fungsi untuk mendapatkan data mahasiswa dengan prodi dan kelas
    public function getMahasiswaWithProdi()
    {
        $data = $this->model->getMahasiswaWithProdi();

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data mahasiswa tidak ditemukan.");
        }
    }

    public function show($id = null)
    {
        $data = $this->model->where('nim', $id)->findAll();
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk kode_matkul $kode_matkul");
        }
    }
}
```

4. **Atur Model Mahasisiswa di /App/Models/MahasiswaModel.php**
```
<?php
namespace App\Models;

use CodeIgniter\Model;

class ModelMahasiswa extends Model
{
    protected $table = "mahasiswa";
    protected $primaryKey = "id";
    protected $allowedFields = ['nim','nama','kode_kelas'];

    protected $validationRules = [
        'nim' => 'required',
        'nama' => 'required',
        'kode_kelas' => 'required',
    ];

    protected $validationMessages = [
        'nim' => ['required' => 'Silahkan masukkan NPM'],
        'nama' => ['required' => 'Silahkan masukkan nama mahasiswa'],
        'kode_kelas' => ['required' => 'Silahkan masukkan kode kelas'],    ];

    // 🔥 Fungsi untuk mendapatkan data mahasiswa dengan informasi prodi dan kelas
    public function getMahasiswaWithProdi()
    {
        return $this->db->table('mahasiswa m')
            ->select([
                'm.npm',
                'm.nama_mhs',
                'm.kode_kelas',
                'p.id_prodi',
                'p.nama_prodi'
            ])
            ->join('prodi p', 'm.id_prodi = p.id_prodi')
            ->join('kelas k', 'm.kode_kelas = k.kode_kelas')
            ->distinct()
            ->orderBy('m.npm', 'ASC')
            ->get()
            ->getResultArray();
    }
}

```

## ⚙️ Menjalankan Backend
```
php artisan serve
```
Aplikasi akan berjalan di:``` http://localhost:8080```

## 🛬 Endpoint API
```
php artisan serve
```
### Endpoint API Mahasiswa
- GET: ``` http://localhost:8080/mahasiswa```
- POST: ``` http://localhost:8080/mahasiswa```
- PUT: ``` http://localhost:8080/mahasiswa/{nim}```
- DEL: ``` http://localhost:8080/mahasiswa/{nim}```

### Endpoint API Matakuliah
- GET: ``` http://localhost:8080/matakuliah```
- POST: ``` http://localhost:8080/matakuliah```
- PUT: ``` http://localhost:8080/matakuliah/{kode_matkul}```
- DEL: ``` http://localhost:8080/matakuliah/{kode_matkul}```







