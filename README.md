# 🐾 Tugas Besar Sistem Basis Data Petcare Clinic

Aplikasi berbasis web untuk pengelolaan data pemilik hewan dan pasien klinik. Dibangun menggunakan framework **Laravel** dengan fokus pada optimalisasi performa untuk menangani data dalam jumlah besar.

---

## 👥 Anggota Kelompok
**Nama Kelompok:** John Family

| No | NIM | Nama Lengkap | Peran |
|----|-----|--------------|-------|
| 1. | 103072400097 | Nayyara Aurelia Putri | Stress Test |
| 2. | 103072400121 | Jingga Jil Carissa | Backend & RBAC|
| 3. | 103072430016 | Bethari Nevyta Amaries | Frontend |

---

## 🚀 Fitur Unggulan & Optimasi Teknis

Project ini dirancang untuk menangani dataset skala besar (Big Data) dengan optimasi berikut:

### 1. Handling Large Dataset (Pagination 5.000 Data)
Karena total data mencapai **1.000.000 baris**, menampilkan seluruh data sekaligus ("Show All") menyebabkan *Memory Exhausted* pada server.
* **Solusi:** Kami menerapkan teknik **High-Volume Pagination**.
* **Konfigurasi:** Data dipecah menjadi **5.000 baris per halaman**.
* **Hasil:** Terdapat total **200 halaman** pagination, menjaga penggunaan RAM server tetap rendah dan stabil.

### 2. Database Indexing
Tabel `tb_pemilik` telah dioptimasi menggunakan **Database Indexing**.
* **Penerapan:** Index diterapkan pada kolom yang sering dicari dan diurutkan (`nama_lengkap`, `alamat`, `nomor_telepon`).
* **Dampak:** Mempercepat proses pencarian (Search) dan pengurutan (Sorting) hingga 10x lipat dibandingkan *full-table scan*.

---

## 🔐 Daftar Akun & User Role

Berikut adalah kredensial akun untuk pengujian aplikasi berdasarkan hak akses (Role):

| Role | Email | Password | Hak Akses / Deskripsi |
| :--- | :--- | :--- | :--- |
| **ADMIN** | `admin@test.com` | `admin123` | **Full Akses:**<br>✅ Melihat Data<br>✅ Menambah Data<br>✅ Mengedit Data<br>✅ Menghapus Data |
| **EDITOR** | `editor@test.com` | `editor1213` | **Akses Edit:**<br>✅ Melihat Data<br>✅ Menambah Data<br>✅ Mengedit Data<br>❌ *Tidak bisa Menghapus* |
| **VIEWER** | `viewer@test.com` | `viewer123` | **Akses Baca:**<br>✅ Hanya Melihat Data<br>❌ *Tidak ada tombol Aksi* |

---

## ⚙️ Cara Instalasi (Localhost)
**📊 Unduh Database & Setup disini :** https://drive.google.com/drive/folders/16D1tTAsx0BV0Fep6obHcYGBlHVELgguS
1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username/project-petcare.git](https://github.com/username/project-petcare.git)
    ```
2.  **Install Dependency**
    ```bash
    composer install
    npm install && npm run build
    ```
3.  **Setup Environment**
    * Copy file `.env.example` menjadi `.env`.
    * Atur konfigurasi database di file `.env`.
4.  **Generate Key**
    ```bash
    php artisan key:generate
    ```
5.  **Migrasi & Seeding Database** (Penting untuk membuat akun di atas)
    ```bash
    php artisan migrate:fresh --seed
    ```
6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
