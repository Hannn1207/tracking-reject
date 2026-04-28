# Tracking Reject — Sistem Monitoring Produksi & Reject

Aplikasi web berbasis **Laravel 12** + **Filament 4** untuk memantau laporan produksi, reject, dan repair di lini manufaktur secara real-time.

---

## Fitur Utama

- **Dashboard** — Statistik harian (total produksi, reject, repair, pendapatan) beserta grafik tren 7 hari terakhir
- **Monitoring Meja** — Tampilan real-time pendapatan per meja Visual Inspection (polling setiap 5 detik)
- **Laporan Reject** — Pencatatan reject per lot, meja, line, dan shift; mendukung status NG & REP
- **Laporan Produksi** — Pencatatan hasil scan produksi per meja dan line
- **Total Produksi** — Rekap otomatis total reject, repair, dan qty proses per laporan
- **Guiden Part Visual** — Galeri visual referensi nama part beserta gambar
- **Manajemen Target** — Pengaturan target produksi per jam dan jenis
- **Manajemen Operator** — CRUD user operator (terpisah dari akun admin)
- **Manajemen Tipe Reject** — Konfigurasi jenis-jenis reject beserta asal reject

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Admin Panel | Filament 4 |
| Frontend | Tailwind CSS 4, Vite 7 |
| Database | SQLite (default) / MySQL |
| Testing | PHPUnit 11 |

---

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js >= 18 & npm
- SQLite atau MySQL/MariaDB

---

## Instalasi

### 1. Clone repositori

```bash
git clone https://github.com/Hannn1207/tracking-reject.git
cd tracking-reject
```

### 2. Setup otomatis (rekomendasi)

```bash
composer run setup
```

Perintah ini akan menjalankan secara berurutan:
- `composer install`
- Menyalin `.env.example` ke `.env`
- Generate application key
- Menjalankan migrasi database
- `npm install`
- Build aset frontend

### 3. Setup manual (opsional)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

### 4. Buat akun admin

```bash
php artisan make:filament-user
```

---

## Menjalankan Aplikasi

```bash
composer run dev
```

Perintah ini menjalankan secara bersamaan:
- PHP development server (`php artisan serve`)
- Queue listener
- Log viewer (`php artisan pail`)
- Vite dev server

Akses aplikasi di: **http://localhost:8000**

---

## Konfigurasi Database

Secara default aplikasi menggunakan **SQLite**. Untuk beralih ke MySQL, ubah `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tracking_reject
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

## Struktur Database

| Tabel | Deskripsi |
|---|---|
| `users` | Akun admin dan operator |
| `name_parts` | Master data nama part beserta gambar |
| `reject_types` | Master tipe reject dan asal reject |
| `reject_reports` | Header laporan reject per lot |
| `reject_report_details` | Detail item reject per laporan |
| `reject_report_processes` | Data qty proses per laporan reject |
| `total_produksi` | Rekap total produksi & reject per laporan |
| `production_reports` | Header laporan produksi per meja/line |
| `production_report_details` | Detail scan produksi |
| `targets` | Target produksi per jam dan jenis |

---

## Menjalankan Test

```bash
composer run test
```

---

## Struktur Direktori

```
app/
├── Filament/
│   ├── Pages/          # Dashboard, Monitoring, Guiden
│   ├── Resources/      # CRUD resources (Reject, Produksi, User, dll)
│   └── Widgets/        # Chart & stats widgets
├── Models/             # Eloquent models
└── Policies/           # Authorization policies
database/
├── migrations/         # Skema database
└── seeders/            # Data awal
resources/
└── views/              # Blade templates
```

---

## Lisensi

Proyek ini bersifat privat dan dikembangkan untuk keperluan internal.
