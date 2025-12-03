# E-Kost - Sistem Manajemen Kos Modern

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

## 🚀 Live Demo

**✨ [View Live Demo](http://daddykos.web.id/) ✨**

### Demo Credentials:

-   **Superadmin Login:** `superadmin@ekost.com` / `password`
-   **Admin Login:** `admin@ekost.com` / `password`
-   **User Login:** `pengguna@ekost.com` / `password`

---

Sistem manajemen kos berbasis web yang komprehensif untuk mempermudah pengelolaan properti kos, booking online, dan pembayaran. Proyek ini dikembangkan sebagai bagian dari tugas akhir di Universitas Negeri Malang.

## 🏢 Project Overview

**Developer:**

-   Imron
-   Muhammad Faiz Alfarisi
-   Muhammad Naufal Rio Ramadhan
-   Muhammad Nizar Joenantama

**Institusi:** Universitas Negeri Malang  
**Fakultas:** Fakultas MIPA  
**Periode:** November 2024 (1 bulan)  
**Dosen Pembimbing:** Denis Eka Cahyani, S.Kom., M.Kom.

## 📋 Table of Contents

-   [Live Demo](#-live-demo)
-   [Fitur](#-fitur)
-   [Technology Stack](#️-technology-stack)
-   [Arsitektur Sistem](#️-arsitektur-sistem)
-   [Prerequisites](#-prerequisites)
-   [Instalasi](#-instalasi)
-   [User Roles & Akses](#-user-roles--akses)
-   [Testing](#-testing)
-   [Security Features](#-security-features)
-   [Future Enhancements](#-future-enhancements)
-   [Contact](#-contact)

## ✨ Fitur

### 🔐 Authentication & Authorization

-   Sistem autentikasi yang aman dengan Laravel Breeze
-   Role-based access control (Superadmin, Admin, User)
-   Password reset dan email verification
-   Session management dengan timeout

### 🏠 Manajemen Properti Kos

-   CRUD kos dan kamar oleh Admin
-   Upload gambar kos dan kamar
-   Pengelolaan tipe kos (Putra, Putri, Campur)
-   Sistem verifikasi kos oleh Superadmin
-   Pengelolaan fasilitas kamar
-   Real-time tracking ketersediaan kamar

### 📅 Sistem Booking Online

-   Pencarian dan filtering kos berdasarkan lokasi, tipe, dan harga
-   Detail properti dengan informasi lengkap kamar
-   Pengajuan booking oleh User
-   Sistem approval booking oleh Admin
-   Validasi ketersediaan kamar otomatis
-   Perhitungan otomatis durasi dan total harga
-   Notifikasi status booking via email

### 💳 Manajemen Pembayaran

-   Upload bukti pembayaran oleh User
-   Verifikasi pembayaran oleh Admin
-   Generate invoice otomatis
-   Tracking history pembayaran
-   Update status booking berdasarkan pembayaran

### 👥 Manajemen Pengguna

-   Registrasi multi-role (Admin dan User)
-   Profil pengguna dengan foto dan informasi kontak
-   Manajemen data pribadi

### 📊 Dashboard & Reporting

-   **Dashboard Admin:**
    -   Statistik booking pending
    -   Laporan okupansi kamar
    -   Monitoring pembayaran
-   **Dashboard Superadmin:**
    -   Total kos menunggu verifikasi
    -   Total user platform
    -   Statistik booking aktif
    -   Overview data platform

### 🎫 Sistem Ticketing

-   Pengajuan tiket bantuan oleh User
-   Manajemen tiket oleh Admin
-   Status tracking tiket
-   Response dan resolusi tiket

## 🛠️ Technology Stack

### Backend

-   **Framework:** Laravel 11.x
-   **Language:** PHP 8.2+
-   **Database:** MySQL 5.7+
-   **ORM:** Eloquent
-   **Authentication:** Laravel Breeze

### Frontend

-   **Markup:** HTML5, Blade Templates
-   **Styling:** Tailwind CSS
-   **Scripting:** JavaScript, Alpine.js
-   **Build Tool:** Vite
-   **Responsive Design:** Mobile-first approach

### Development Tools

-   **Dependency Management:** Composer, npm
-   **Version Control:** Git
-   **Testing:** PHPUnit/Pest
-   **Code Standards:** PSR-12

## 🏗️ Arsitektur Sistem

Sistem E-Kost mengikuti arsitektur MVC (Model-View-Controller):

-   **Model Layer:** Interaksi database dan business logic menggunakan Eloquent ORM
-   **View Layer:** Blade templates dengan komponen Tailwind CSS responsif
-   **Controller Layer:** RESTful controllers untuk handling request

### Key Design Patterns

-   MVC (Model-View-Controller)
-   Repository Pattern melalui Eloquent
-   Middleware Pattern untuk autentikasi dan otorisasi
-   Role-Based Access Control (RBAC)
-   Soft Delete untuk data integrity

### Database Schema (MVP)

Sistem menggunakan 12 tabel utama:

-   `users` - Data pengguna multi-role
-   `user_profiles` - Profil detail pengguna
-   `kos` - Data properti kos
-   `kamar` - Data kamar kos
-   `bookings` - Data booking
-   `payments` - Data pembayaran
-   `invoices` - Invoice pembayaran
-   `tickets` - Tiket support
-   `district` - Data kecamatan
-   `fasilitas` - Master data fasilitas
-   `kamar_fasilitas` - Relasi kamar dan fasilitas

## 📋 Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & npm
-   MySQL >= 5.7
-   Web server (Apache/Nginx)

## 🚀 Instalasi

1. **Clone repository**

    ```bash
    git clone https://github.com/NizarJoo/kos-makmur.git
    cd kos-makmur
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies**

    ```bash
    npm install
    ```

4. **Setup environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Konfigurasi database**

    Edit file `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ekost_db
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

6. **Jalankan migration dan seeder**

    ```bash
    php artisan migrate --seed
    ```

7. **Build frontend assets**

    ```bash
    npm run build
    ```

8. **Jalankan development server**
    ```bash
    php artisan serve
    ```

Buka browser dan akses `http://localhost:8000`

## 👤 User Roles & Akses

### 🔴 Superadmin

-   Manajemen master data (fasilitas, kecamatan)
-   Verifikasi properti kos yang didaftarkan Admin
-   Monitoring kesehatan sistem
-   Akses penuh ke seluruh data platform
-   Dashboard statistik global

### 🟡 Admin (Pemilik Kos)

-   CRUD properti kos dan kamar milik sendiri
-   Approval/reject booking
-   Verifikasi pembayaran
-   Generate invoice
-   Response tiket support
-   Dashboard statistik properti

### 🟢 User (Pencari/Penghuni Kos)

-   Pencarian dan filtering kos
-   Pengajuan booking
-   Upload bukti pembayaran
-   Manajemen profil
-   Submit tiket bantuan
-   View riwayat booking dan pembayaran

## 🧪 Testing

Jalankan test suite:

```bash
php artisan test
```

### Test Coverage

-   Authentication testing
-   Room management operations
-   Booking system functionality
-   Payment processing
-   RBAC authorization

## 🔒 Security Features

-   XSS protection
-   CSRF token verification
-   SQL injection prevention via Eloquent ORM
-   Role-Based Access Control (RBAC)
-   Password hashing dengan bcrypt/argon2
-   Email verification
-   Session security dengan timeout
-   Input validation dan sanitization
-   Soft delete untuk data integrity

## 🚧 Future Enhancements

### Technical Improvements

-   [ ] Mobile application (Flutter/React Native)
-   [ ] Payment gateway integration (Midtrans/Xendit)
-   [ ] Real-time notification menggunakan WebSocket
-   [ ] Advanced search dengan filter kompleks
-   [ ] Export laporan ke PDF/Excel
-   [ ] Integration dengan Google Maps API
-   [ ] Chat system antara User dan Admin

### Business Features

-   [ ] Review dan rating sistem
-   [ ] Wishlist properti kos
-   [ ] Reminder pembayaran otomatis
-   [ ] Loyalty program untuk penghuni setia
-   [ ] Multi-language support
-   [ ] Sistem rekomendasi kos berbasis AI

## 📝 License

Proyek ini dikembangkan untuk keperluan akademik. Untuk penggunaan lebih lanjut, silakan hubungi pengembang.

## 📞 Contact

<div align="center">

### 👨‍💻 **Tim Pengembang**

**Imron**  
🔗 GitHub: [@imronbro](https://github.com/imronbro)

**Muhammad Faiz Alfarisi**  
🔗 GitHub: [@FaizAlfarisi](https://github.com/FaizAlfarisi)

**Muhammad Naufal Rio Ramadhan**  
🔗 GitHub: [@nfalrio](https://github.com/nfalrio)

**Muhammad Nizar Joenantama**  
🔗 GitHub: [@NizarJoo](https://github.com/NizarJoo)

---

### 👨‍🏫 **Dosen Pembimbing**

**Denis Eka Cahyani, S.Kom., M.Kom.**  
Universitas Negeri Malang - Fakultas MIPA

---

</div>

## 🙏 Acknowledgments

-   **Universitas Negeri Malang - Fakultas MIPA** untuk dukungan akademik
-   **Denis Eka Cahyani, S.Kom., M.Kom.** untuk bimbingan dan arahan
-   **Fakultas MIPA** untuk fasilitas dan resources
-   Seluruh pihak yang telah membantu penyelesaian proyek ini

---

<div align="center">

**⭐ Star repository ini jika bermanfaat!**

_Sistem ini dikembangkan sebagai bagian dari tugas akhir dan mendemonstrasikan penerapan praktis teknologi web development modern dalam menyelesaikan permasalahan bisnis nyata._

**© 2024 E-Kost Team - Universitas Negeri Malang**

</div>
