**Langkah-langkah membuat backend CodeIgniter 4 untuk studi kasus Rumah Sakit**

---

````markdown
# 🏥 Backend Rumah Sakit - CodeIgniter 4

Repositori ini berisi proyek backend REST API menggunakan **CodeIgniter 4** untuk sistem informasi rumah sakit dengan dua entitas utama: `pasien` dan `obat`.

---

## 📌 Studi Kasus

Sistem ini digunakan untuk mencatat data **pasien** dan **obat** di rumah sakit. Backend menyediakan endpoint RESTful untuk melakukan CRUD (Create, Read, Update, Delete) terhadap kedua tabel tersebut.

---

## ⚙️ LANGKAH-LANGKAH PEMBUATAN BACKEND

### 1. Persiapan Awal

Pastikan perangkat Anda telah terinstall:
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Git

### 2. Buat Proyek CodeIgniter 4 Baru

```bash
composer create-project codeigniter4/appstarter backend_rumahsakit
cd backend_rumahsakit
````

### 3. Konfigurasi Database

#### a. Buat file `.env`:

```bash
cp env .env
```

#### b. Edit konfigurasi di `.env`:

```dotenv
database.default.hostname = localhost
database.default.database = db_rumahsakit_[NIM_ANDA]
database.default.username = root
database.default.password =
```

### 4. Buat Database dan Tabel

Login ke phpMyAdmin atau terminal SQL, lalu jalankan query berikut:

```sql
CREATE DATABASE db_rumahsakit_[NIM_ANDA];
USE db_rumahsakit_[NIM_ANDA];

CREATE TABLE pasien (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  alamat TEXT,
  tanggal_lahir DATE,
  jenis_kelamin ENUM('L', 'P')
);

CREATE TABLE obat (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_obat VARCHAR(100),
  kategori VARCHAR(50),
  stok INT,
  harga DECIMAL(10,2)
);
```

---

## 🛠️ Pembuatan Model

### 📁 app/Models/PasienModel.php

```php
<?php namespace App\Models;
use CodeIgniter\Model;

class PasienModel extends Model {
    protected $table = 'pasien';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'alamat', 'tanggal_lahir', 'jenis_kelamin'];
    protected $useTimestamps = false;
}
```

### 📁 app/Models/ObatModel.php

```php
<?php namespace App\Models;
use CodeIgniter\Model;

class ObatModel extends Model {
    protected $table = 'obat';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_obat', 'kategori', 'stok', 'harga'];
    protected $useTimestamps = false;
}
```

---

## 🎮 Pembuatan Controller (REST API)

Gunakan ResourceController bawaan CI4 untuk RESTful API.

### 📁 app/Controllers/Pasien.php

```php
<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Pasien extends ResourceController {
    protected $modelName = 'App\\Models\\PasienModel';
    protected $format    = 'json';
}
```

### 📁 app/Controllers/Obat.php

```php
<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Obat extends ResourceController {
    protected $modelName = 'App\\Models\\ObatModel';
    protected $format    = 'json';
}
```

---

## 🛣️ Routing

Tambahkan routing ke `app/Config/Routes.php`:

```php
$routes->resource('pasien');
$routes->resource('obat');
```

---

## 🚀 Menjalankan Server

```bash
php spark serve
```

Akses melalui browser atau Postman:

* [http://localhost:8080/pasien](http://localhost:8080/pasien)
* [http://localhost:8080/obat](http://localhost:8080/obat)

---

## 🧪 Pengujian dengan Postman

Buat Collection Postman:

* Nama: `uas_pasien` dan `uas_obat`
* Tambahkan endpoint:

  * GET `/pasien` – ambil semua data
  * POST `/pasien` – tambah data pasien
  * PUT `/pasien/{id}` – ubah data
  * DELETE `/pasien/{id}` – hapus data
  * (sama untuk `obat`)

Gunakan body JSON saat POST dan PUT. Contoh:

```json
{
  "nama": "Siti Aisyah",
  "alamat": "Jl. Mawar No. 10",
  "tanggal_lahir": "1995-05-12",
  "jenis_kelamin": "P"
}
```

---

## 📮 Endpoint API Lengkap

### 🔹 Pasien

| Method | Endpoint       | Deskripsi              |
| ------ | -------------- | ---------------------- |
| GET    | `/pasien`      | Ambil semua pasien     |
| GET    | `/pasien/{id}` | Detail pasien tertentu |
| POST   | `/pasien`      | Tambah pasien baru     |
| PUT    | `/pasien/{id}` | Ubah data pasien       |
| DELETE | `/pasien/{id}` | Hapus pasien           |

### 🔹 Obat

| Method | Endpoint     | Deskripsi            |
| ------ | ------------ | -------------------- |
| GET    | `/obat`      | Ambil semua obat     |
| GET    | `/obat/{id}` | Detail obat tertentu |
| POST   | `/obat`      | Tambah data obat     |
| PUT    | `/obat/{id}` | Ubah data obat       |
| DELETE | `/obat/{id}` | Hapus data obat      |

---

## 🗂️ Struktur Folder Utama

```
backend_rumahsakit/
├── app/
│   ├── Controllers/
│   │   ├── Pasien.php
│   │   └── Obat.php
│   ├── Models/
│   │   ├── PasienModel.php
│   │   └── ObatModel.php
│   └── Config/
│       └── Routes.php
├── public/
├── .env
├── composer.json
└── README.md
```

---

## 💡 Catatan Tambahan

* Pastikan MySQL berjalan saat uji API
* Gunakan `php spark routes` untuk melihat route aktif

---

## 👨‍💻 Dibuat oleh

**Prih Diantono Abda’u, M.Kom**
UAS Praktikum Pemrograman Berbasis Framework – Genap 2024/2025
Politeknik Negeri Cilacap