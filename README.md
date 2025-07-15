# Tentang Project
Project ini adalah Program Kasir dan Inventori sederhana yang dibuat untuk menuntaskan matakuliah, Program ini memakai PHP dengan Laravel, memakai Database Mysql.

## Tata cara menginstall
### 1. Pastikan sudah install PHP, Composer, Nodejs
### 2. Clone Repositorinya dan Masuk kedalam Directory-nya
```
git clone https://github.com/adamwahyuh/mart
cd mart
```
### 3. Konfigurasi .env
- Copy .env.example menjadi .env
  ```
  cp .env.example .env
  ```
- Lalu jalankan mysql server anda,
- dan buat databasenya, secara default di .env adalah 'DB_DATABASE=mart', jadi jika ingin membuat database buatlah dengan nama 'mart', jika tidak, kamu bisa ganti DB_DATABASE=NamaDatabaseKamu
- Buka .env nya dan isikan baris DB_DATABASE=NamaDatabaseKamu

Contoh: isikan baris ini sesuai settingan kamu
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mart
DB_USERNAME=root
DB_PASSWORD=
```
### Install Semua Depedenciesnya, jalankan 2 command berikut:
- npm
  ```
  npm i
  ```
- Composer
  ```
  composer install
  ```
### Generate App key dengan artisan
```
php artisan key:generate
```
### Migrasi dan Seeding Database dengan artisan
```
php artisan migrate:fresh --seed
```
### Jalankan Server dengan artisan
```
php artisan serve
```
### Buka Localhost di browser anda
```
http://127.0.0.1:8000
```
---
# Terimakasih
