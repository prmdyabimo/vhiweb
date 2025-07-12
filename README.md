# 🧪 Software Engineer Test – VhiWEB

## 📋 Deskripsi Singkat

Repository ini merupakan hasil pengerjaan tes untuk posisi Software Engineer. Aplikasi ini merupakan implementasi **API E-Procurement System** yang dibangun menggunakan **Laravel 12** dan **MySQL**.

---

## ✅ Fitur yang Diimplementasikan

### 🔐 User Authentication
- Implementasi endpoint **login** dan **register**
- Menggunakan JWT untuk otentikasi
- Validasi input dan handling error

### 🏢 Vendor Registration
- Endpoint untuk **pendaftaran vendor baru**
- Relasi antara user dan vendor
- Validasi data vendor

### 📦 Product Catalog
- CRUD produk berdasarkan vendor terkait
- Setiap produk memiliki:
  - Nama, deskripsi, kategori, harga, stok, SKU, dan spesifikasi
- Relasi antara produk dan vendor
- Fitur soft delete

---

## 🎯 Tujuan

Mengukur kemampuan praktikal dalam membangun fitur inti dari REST API, seperti:
- Otentikasi
- Manajemen data relasional
- Implementasi prinsip RESTful
- Clean code & modularitas

---

## 🏗️ Stack Teknologi

- **Backend**: Laravel 12
- **Database**: MySQL
- **Authentication**: JWT (JSON Web Token)
- **Arsitektur**: Clean Architecture & Separation of Concerns

---

## 🚀 Cara Menjalankan

### 1. Clone Repository
```bash
git clone https://github.com/username/api-eprocurement-laravel.git
cd api-eprocurement-laravel
