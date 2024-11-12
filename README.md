# 📁 Final Project BDL Hebat

Semangat teman-teman

## 📝 Prerequisites

Sebelum Anda mulai, pastikan Anda memiliki hal-hal berikut:

- **XAMPP**: Pastikan Anda telah menginstal XAMPP di komputer Anda.
- **Git**: Pastikan Anda memiliki Git terinstal untuk meng-clone repository.

## ⚙️ Clone Repository

Untuk meng-clone repository ini, buka terminal/command prompt Anda dan jalankan perintah berikut:

```bash
git clone https://github.com/UrayMR/bdl.git
```

Setelah meng-clone, masuk ke direktori proyek Anda:

```bash
cd bdl
```

Lalu buka code editor:

```bash
code .
```

## 🚀 Menjalankan Proyek di Localhost
Setelah Anda meng-clone repository, ikuti langkah-langkah berikut untuk menjalankan proyek di localhost menggunakan XAMPP:

1. Salin Folder Proyek ke htdocs
Buka folder XAMPP Anda, biasanya terletak di C:\xampp\htdocs (Windows) atau /Applications/XAMPP/htdocs (macOS).
Salin folder proyek Anda ke dalam folder htdocs.

3. Buat Database
Buka phpMyAdmin dengan mengakses http://localhost/phpmyadmin di browser Anda.
Buat database baru dengan nama yang sesuai dengan proyek Anda.
Jika ada file SQL untuk struktur database, impor file tersebut ke dalam database yang baru saja Anda buat.

4. Konfigurasi Koneksi Database
Buka file konfigurasi database (connection.php) di dalam folder proyek Anda.
Sesuaikan pengaturan koneksi database sesuai dengan database yang telah Anda buat. Pastikan untuk mengatur nama database, username, dan password yang sesuai.

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdlhebat";
```

5. Jalankan Server
Pastikan Apache dan MySQL berjalan di XAMPP Control Panel.
Akses proyek Anda di browser dengan mengunjungi

[http://localhost/bdl](http://localhost/bdl)


## 🎯 Troubleshooting
- Masalah Koneksi Database? Pastikan pengaturan di file konfigurasi database sudah benar dan database sudah dibuat di phpMyAdmin.
- Server Tidak Berjalan? Pastikan Apache dan MySQL sudah diaktifkan di XAMPP Control Panel.

## 🤝 Contributing

Jika Anda ingin berkontribusi pada proyek ini, silakan ikuti langkah-langkah berikut:

1. **Buat Branch Baru**  
   Buat branch baru untuk fitur atau perbaikan yang ingin Anda kerjakan:

    ```bash
    git checkout -b bambang
    ```

    Note : ganti nama bambang sesuka anda.

2. **Lakukan Perubahan dan Commit**
   Setelah melakukan perubahan, lakukan commit:

    ```bash
    git commit -m "Deskripsi perubahan"
    ```
    
4. **Push Perubahan**  
   After making changes, push them to your branch:

    ```bash
    git push origin bambang
    ```

5. **Buat Pull Request**
    Setelah push, buat pull request di GitHub untuk menggabungkan perubahan Anda ke branch utama.

> **Note**: Make sure to follow the branch naming format above, and ensure your pull request is ready for review so it can be merged into the main branch.

---

Thanks for following along, and happy coding! If you have any questions or run into any issues, don’t hesitate to ask. Hope everything goes smoothly! 😄





