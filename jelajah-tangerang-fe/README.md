# Frontend - Jelajah Tangerang 🎨

Bagian frontend dari aplikasi **Jelajah Tangerang** berfungsi sebagai antarmuka pengguna (user interface) yang menampilkan informasi destinasi wisata, artikel, dan peta lokasi. Frontend dikembangkan menggunakan **ReactJS** dengan pendekatan komponen modular.

## ⚙️ Teknologi yang Digunakan

- ReactJS
- Tailwind CSS
- React Router
- Axios
- Leaflet & React-Leaflet (Peta)

## 📂 Struktur Folder (Umum)

```text
fe/
│
├── src/
│ ├── components/
│ ├── pages/
│ ├── services/
│ ├── routes/
│ └── assets/
├── public/
└── package.json
```

## 🚀 Fitur Utama

- Halaman beranda
- Daftar dan detail destinasi wisata
- Artikel dan detail artikel
- Peta interaktif destinasi
- Navigasi responsif

## ▶️ Menjalankan Aplikasi

1. Masuk ke folder frontend

```bash
cd jelajah-tangerang-fe
```

2. Install dependencies

```bash
npm install
```

3. Jalankan aplikasi

```bash
npm run dev
```

Aplikasi akan berjalan di: http://localhost:5173

🔗 Integrasi API
Frontend terhubung dengan backend melalui REST API menggunakan Axios. Endpoint API disesuaikan dengan service yang tersedia di backend Laravel.
