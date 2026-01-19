# 🏨 AHF Hotel System - Panduan Integrasi Lengkap

## 📋 Daftar Isi

1. [Arsitektur Sistem](#arsitektur-sistem)
2. [Fitur yang Tersedia](#fitur-yang-tersedia)
3. [Setup & Konfigurasi](#setup--konfigurasi)
4. [API Endpoints](#api-endpoints)
5. [Checklist Deployment](#checklist-deployment)
6. [Troubleshooting](#troubleshooting)

---

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                    HOTEL GUEST EXPERIENCE                    │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌──────────────┐         ┌──────────────┐                  │
│  │   STB/TV     │◄────────┤  AHF-SERVER  │                  │
│  │  (Android)   │  API    │   (Laravel)  │                  │
│  │ TakeOffLaun- │         │              │                  │
│  │   cher_v2    │         │  MySQL DB    │                  │
│  └──────────────┘         └──────────────┘                  │
│         │                         │                          │
│         │                         │                          │
│         ▼                         ▼                          │
│  ┌──────────────────────────────────────┐                   │
│  │         FITUR LAYANAN HOTEL          │                   │
│  ├──────────────────────────────────────┤                   │
│  │ • Informasi Hotel                    │                   │
│  │ • Pemesanan Makanan (Dining)         │                   │
│  │ • Request Amenities                  │                   │
│  │ • Aplikasi Terkelola                 │                   │
│  │ • Live TV                            │                   │
│  │ • Greeting Screen                    │                   │
│  │ • Device Management (ADB)            │                   │
│  └──────────────────────────────────────┘                   │
└─────────────────────────────────────────────────────────────┘
```

---

## ✨ Fitur yang Tersedia

### 1. **Device Management** ✅

- ✅ Auto-discovery perangkat baru
- ✅ Registration code system
- ✅ Remote device control via ADB
- ✅ Device status monitoring (online/offline)
- ✅ Room assignment

**Cara Kerja:**

1. STB boot → kirim device_id ke server
2. Server cek database → jika belum ada, buat record baru dengan `is_active=false`
3. Server return `registration_code`
4. Admin aktivasi device di dashboard
5. STB dapat akses penuh ke fitur hotel

### 2. **Guest Services** ✅

#### A. Dining Menu (Pemesanan Makanan)

- ✅ Tampilkan menu makanan dengan harga
- ✅ Guest dapat order dari TV
- ✅ Admin terima notifikasi order
- ✅ Status tracking (pending → processing → completed)

**Database:** `dining_menus`, `hotel_orders`

#### B. Room Amenities (Request Fasilitas)

- ✅ Request handuk, sabun, dll
- ✅ Admin terima request
- ✅ Status tracking

**Database:** `room_amenities`, `amenity_requests`

#### C. Hotel Information

- ✅ Informasi fasilitas hotel
- ✅ Jam operasional
- ✅ Kontak

**Database:** `hotel_infos`, `hotel_facilities`

### 3. **App Management** ✅

- ✅ Whitelist aplikasi yang boleh diinstall
- ✅ Auto-uninstall aplikasi tidak terdaftar
- ✅ Remote install APK
- ✅ App visibility control

**Database:** `system_apps`

### 4. **Customization** ✅

- ✅ Custom greeting message & image
- ✅ Custom home background
- ✅ Marquee text (running text)
- ✅ Multi-language support (ID/EN)

**Database:** `global_settings`, `system_marquees`

### 5. **Guest Check-in** ✅

- ✅ Data tamu (nama, room, check-in/out)
- ✅ Display welcome message

**Database:** `guest_checkins`

---

## 🚀 Setup & Konfigurasi

### A. Server Setup (AHF-SERVER)

#### 1. Install Dependencies

```bash
cd d:\MMAcces\AHF-SERVER
composer install
npm install
```

#### 2. Environment Configuration

```env
# .env
APP_URL=http://192.168.1.100:8000  # Ganti dengan IP server Anda
DB_DATABASE=data_takeoff
DB_USERNAME=root
DB_PASSWORD=root
```

#### 3. Database Migration

```bash
php artisan migrate
php artisan db:seed  # Optional: seed data awal
```

#### 4. Storage Link

```bash
php artisan storage:link
```

#### 5. Run Server

```bash
# Development
php artisan serve --host=0.0.0.0 --port=8000

# Production (gunakan Nginx/Apache)
```

### B. Android STB Setup (TakeOffLauncher_v2)

#### 1. Build APK

```bash
cd d:\MMAcces\TakeOffLauncher_v2
./gradlew assembleDebug
# atau
./gradlew assembleRelease
```

#### 2. Install ke STB

```bash
adb connect 192.168.1.XXX:5555
adb install -r app/build/outputs/apk/debug/app-debug.apk
```

#### 3. Set Device Owner (Kiosk Mode)

```bash
adb shell dpm set-device-owner com.takeoff.launcher/.MyDeviceAdminReceiver
```

#### 4. Konfigurasi Server IP

- Tekan tombol **UP 5x** di remote untuk buka Admin Panel
- Masukkan IP server: `192.168.1.100:8000`
- Test Connection → Save

---

## 📡 API Endpoints

### Base URL

```
http://192.168.1.100:8000/api/v1
```

### Endpoints List

| Method | Endpoint              | Deskripsi                       | Auth |
| ------ | --------------------- | ------------------------------- | ---- |
| GET    | `/check-registration` | Cek status registrasi device    | ❌   |
| GET    | `/guest-info`         | Info tamu berdasarkan device_id | ❌   |
| GET    | `/home-menus`         | Menu navigasi bottom bar        | ❌   |
| GET    | `/apps`               | Daftar aplikasi yang diizinkan  | ❌   |
| GET    | `/background`         | Background image home screen    | ❌   |
| GET    | `/greeting`           | Custom greeting message         | ❌   |
| GET    | `/marquee`            | Running text                    | ❌   |
| GET    | `/weather`            | Data cuaca                      | ❌   |
| GET    | `/latest-apk`         | Versi APK terbaru               | ❌   |
| GET    | `/remote-clear`       | Clear cache remote via ADB      | ❌   |

### Contoh Request

#### 1. Check Registration

```bash
curl "http://192.168.1.100:8000/api/v1/check-registration?device_id=TV-12345&device_name=Samsung%20TV"
```

**Response (Belum Terdaftar):**

```json
{
    "status": "success",
    "is_registered": false,
    "registration_code": "REG-ABC123"
}
```

**Response (Sudah Terdaftar):**

```json
{
    "status": "success",
    "is_registered": true,
    "registration_code": "REG-ABC123"
}
```

#### 2. Get Guest Info

```bash
curl "http://192.168.1.100:8000/api/v1/guest-info?device_id=TV-12345"
```

**Response:**

```json
{
    "status": "success",
    "data": {
        "guest_name": "Mr. John Doe",
        "room_number": "101"
    }
}
```

#### 3. Get Apps

```bash
curl "http://192.168.1.100:8000/api/v1/apps?lang=id"
```

**Response:**

```json
{
    "status": "success",
    "apps": [
        {
            "app_key": "youtube",
            "app_name": "YouTube",
            "app_name_en": "YouTube",
            "icon_path": "http://192.168.1.100:8000/storage/icons/youtube.png",
            "android_package": "com.google.android.youtube.tv",
            "is_visible": true
        }
    ]
}
```

#### 4. Get Greeting

```bash
curl "http://192.168.1.100:8000/api/v1/greeting"
```

**Response:**

```json
{
    "status": "success",
    "data": {
        "title": "Selamat Datang",
        "content": "Terima kasih telah menginap di hotel kami!",
        "image": "http://192.168.1.100:8000/storage/greeting.jpg"
    }
}
```

---

## ✅ Checklist Deployment

### Pre-Deployment

- [ ] Server sudah terinstall PHP 8.2+, MySQL, Composer
- [ ] Network sudah dikonfigurasi (IP static untuk server)
- [ ] Firewall allow port 8000 (atau 80/443 untuk production)
- [ ] Database sudah dibuat (`data_takeoff`)

### Server Deployment

- [ ] Clone/copy AHF-SERVER ke server
- [ ] `composer install --optimize-autoloader --no-dev`
- [ ] Copy `.env.example` → `.env` dan konfigurasi
- [ ] `php artisan key:generate`
- [ ] `php artisan migrate --force`
- [ ] `php artisan storage:link`
- [ ] Set permission folder `storage/` dan `bootstrap/cache/`
- [ ] Setup Nginx/Apache virtual host (production)
- [ ] Setup SSL certificate (optional, untuk HTTPS)
- [ ] `php artisan serve --host=0.0.0.0 --port=8000` (dev) atau setup systemd service

### Admin Panel Setup

- [ ] Akses `http://SERVER_IP:8000/admin`
- [ ] Login dengan kredensial default (atau buat user baru)
- [ ] Upload menu makanan di **Dining Menu**
- [ ] Upload amenities di **Room Amenities**
- [ ] Konfigurasi **Global Settings**:
    - [ ] Custom greeting title & message
    - [ ] Upload greeting background image
    - [ ] Upload home background image
    - [ ] Set launcher version
- [ ] Tambahkan aplikasi di **System Apps**
- [ ] Set marquee text di **Settings → Marquee**

### STB Deployment

- [ ] Build APK: `./gradlew assembleRelease`
- [ ] Sign APK (untuk production)
- [ ] Install ke semua STB via ADB atau manual
- [ ] Set device owner: `adb shell dpm set-device-owner ...`
- [ ] Konfigurasi server IP di Admin Panel STB
- [ ] Test koneksi ke server
- [ ] Verifikasi device muncul di Admin Dashboard
- [ ] Aktivasi device di dashboard
- [ ] Assign room number
- [ ] Test semua fitur:
    - [ ] Greeting screen muncul
    - [ ] Home screen load dengan background custom
    - [ ] Menu bottom bar muncul
    - [ ] Apps dialog berfungsi
    - [ ] Dining order berfungsi
    - [ ] Amenity request berfungsi
    - [ ] Clear cache berfungsi

### Post-Deployment

- [ ] Monitor device status (online/offline)
- [ ] Test order makanan dari STB → admin terima
- [ ] Test request amenity dari STB → admin terima
- [ ] Setup backup database (cron job)
- [ ] Setup monitoring (uptime, error logs)
- [ ] Dokumentasi untuk staff hotel

---

## 🔧 Troubleshooting

### 1. STB tidak bisa connect ke server

**Gejala:** Registration card muncul terus, error "Connection Failed"

**Solusi:**

```bash
# Cek server berjalan
curl http://192.168.1.100:8000/api/v1/greeting

# Cek firewall
# Windows: Allow port 8000 di Windows Firewall
# Linux: sudo ufw allow 8000

# Cek IP di STB
# Buka Admin Panel → pastikan IP benar (tanpa http://)
# Contoh: 192.168.1.100:8000
```

### 2. Device tidak muncul di Admin Dashboard

**Gejala:** STB sudah connect, tapi tidak ada di daftar devices

**Solusi:**

```bash
# Cek database
php artisan tinker
>>> App\Models\ManagedDevice::all();

# Cek log
tail -f storage/logs/laravel.log
```

### 3. Apps tidak bisa diinstall

**Gejala:** Klik app di dialog, tidak ada yang terjadi

**Solusi:**

- Pastikan APK sudah diupload ke `storage/app/public/apks/`
- Cek URL APK di database `system_apps.apk_url`
- Pastikan STB punya permission install unknown sources

### 4. Greeting screen tidak muncul

**Gejala:** Langsung ke registration/home screen

**Solusi:**

- Cek API `/api/v1/greeting` return data
- Cek `global_settings` table ada key `custom_greeting_title`, `custom_welcome_greeting`, `custom_greeting_image`
- Rebuild APK jika ada perubahan flow

### 5. Order/Request tidak sampai ke admin

**Gejala:** Guest order makanan, admin tidak terima

**Solusi:**

- Implementasi WebSocket/Polling untuk real-time notification
- Sementara: Admin refresh halaman secara manual
- Cek table `hotel_orders` dan `amenity_requests`

---

## 📊 Database Schema Overview

### Tabel Utama

| Tabel              | Deskripsi                      | Relasi                              |
| ------------------ | ------------------------------ | ----------------------------------- |
| `managed_devices`  | Data STB/TV yang terdaftar     | -                                   |
| `guest_checkins`   | Data tamu yang check-in        | `managed_devices`                   |
| `dining_menus`     | Menu makanan hotel             | -                                   |
| `hotel_orders`     | Order makanan dari guest       | `managed_devices`, `dining_menus`   |
| `room_amenities`   | Daftar amenities tersedia      | -                                   |
| `amenity_requests` | Request amenity dari guest     | `managed_devices`, `room_amenities` |
| `system_apps`      | Aplikasi yang diizinkan        | -                                   |
| `hotel_facilities` | Fasilitas hotel                | -                                   |
| `hotel_infos`      | Informasi hotel                | -                                   |
| `global_settings`  | Konfigurasi global (key-value) | -                                   |
| `system_marquees`  | Running text                   | -                                   |

---

## 🎯 Fitur yang Perlu Ditambahkan (Roadmap)

### High Priority

- [ ] **Real-time Notifications** (WebSocket untuk order/request)
- [ ] **PMS Integration** (Property Management System)
- [ ] **Payment Gateway** (untuk paid services)
- [ ] **Analytics Dashboard** (usage statistics)

### Medium Priority

- [ ] **Multi-language Content** (database-driven translations)
- [ ] **Weather API Integration** (real weather data)
- [ ] **TV Channel Management** (IPTV integration)
- [ ] **Feedback System** (guest satisfaction survey)

### Low Priority

- [ ] **Voice Control** (Google Assistant integration)
- [ ] **Chromecast Support**
- [ ] **Mobile App** (guest companion app)

---

## 📞 Support

Untuk bantuan lebih lanjut:

- Email: support@ahf-hotel.com
- Dokumentasi: http://docs.ahf-hotel.com
- GitHub Issues: https://github.com/your-repo/issues

---

**Last Updated:** 2026-01-19  
**Version:** 1.0.0  
**Author:** AHF Development Team
