# CARA MENJALANKAN PROJECT

## PERSYARATAN
- PHP (versi 8.2.x atau lebih baru)
- Composer (versi 2.5.7 atau lebih baru) : untuk mengelola dependensi PHP
- Node.js (versi 20.x atau lebih baru) & NPM (versi 10.x atau lebih baru) : untuk mengelola dependensi front-end
- Database (MySQL 5.7.33 atau lebih baru)

## FITUR
**Fitur Customer**
- Register & Login
- Melihat dan Mencari Produk
- Menambah ke Keranjang 
- Checkout Pesanan & Pembelian
- Riwayat Pesanan
---
**Fitur Owner**
- Manajemen data Kategori
- Manajemen data Produk
- Manajemen data Pesananan

# TECH STACK
- Laravel 11
- Livewire 3
- Filament for Admin Panel
- Library CSS: TailwindCSS & Flowbite
- Database: MySQL

# Default Akun untuk Testing
Pastikan telah menjalan seeder database.
**Owner Account**
Halaman login owner: APP_URL/admin/login
- email: admin@olsop.com
- Password: 123
---
**Customer Account**
Halaman login customer: APP_URL/login
- email: pembeli@email.com
- Password: 123
---

## LANGKAH PERTAMA KALI MENJALANKAN PROJECT
### 1. Download repo ini atau clone. Masuk ke folder directory project laravel
### 2. Install Dependensi Laravel
```
composer install
```
### 3. Install Dependensi Frontend
```
npm install
```
### 4. Salin File .env.example menjadi .env dan Sesuaikan nilai didalam env (khususnya pada Database)
```
DB_DATABASE=laravel_eccomerce_db
DB_USERNAME=root
DB_PASSWORD=
```
### 5. Jalankan Generate Application Key
```
php artisan key:generate
```
### 6. Jalankan migrasi Database
```
php artisan migrate
```
### 7. Jalankan seeder Database
```
php artisan db:seed
```
### 8. Compile Assets Frontend
```
npm run dev
```
atau jika mode produksi
```
npm run build
```
### 9.  Menjalankan Server Lokal
```
php artisan serve
```

## Menjalankan Midtrans
### 1. Pada .env tambahkan clientkey & serverkey midtrans
```
MIDTRANS_SERVER_KEY=your-server-key-here
MIDTRANS_CLIENT_KEY=your-client-key-here
MIDTRANS_PRODUCTION=false
```
### 2. Jalankan ngrok untuk membuat URL public
```
ngrok http 8000
```
### 3. Pada .env juga ubah APP_URL serta tambahkan ASSET_URL
Midtrans memerlukan URL yang dapat diakses dari internet untuk callback. Setelah menjalan ngrok akan mendapatkan semacam url random seperti ini: https://b952-36-65-127-104.ngrok-free.app
### 4.Set Callback URL di Midtrans
Setelah mendapatkan url dari ngrok, perlu set url untuk callback pada Midtrans yang terletak di SETTINGS->PAYMENT->Notification URL. Isikan nilainya dengan url yang dibuat sebagai call back, disini saya menggunakan APP_URL/payment/callback

### 5. Pada .env kembalika sesuaikan APP_URL
```
APP_URL=https://b952-36-65-127-104.ngrok-free.app
ASSET_URL=https://b952-36-65-127-104.ngrok-free.app
```
ASEET_URL ini digunakan menghindari tampilan yang rusak karena tidak dimuat dengan benar.
