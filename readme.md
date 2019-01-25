# Configuration Web SDN 1 Karangkobar

Clone proyek
```sh
git clone https://gitlab.com/harumshidiqi/project-elementary.git
```
Setup branch
```sh
git checkout -b dev
```
# Konfigurasi proyek
Jalankan perintah berikut untuk melakukan konfigurasi proyek
```sh
Copy file .env.example dan rename menjadi .env kemudian atur database
composer install
npm install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```
Sebelum menjalankan proyek silahkan compile file asset dengan menjalankan
```sh
npm run dev
```
Menjalankan proyek
```sh
php artisan serve
```

---
Alur penggunaan git
```sh
git add .
git commit -m "Commit message"
git pull origin dev
---
Selesaikan konflik apabila ada
---
git push origin dev
```"# School" 
"# School" 
