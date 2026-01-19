# 🚀 Quick Start Guide - AHF Hotel System

## Status Sistem Saat Ini

### ✅ Yang Sudah Berfungsi

#### 1. **Backend Server (AHF-SERVER)**

- ✅ Laravel API Server berjalan di `http://192.168.1.100:8000`
- ✅ Database MySQL terhubung (`data_takeoff`)
- ✅ Semua migration sudah dijalankan
- ✅ API Endpoints tersedia (16 endpoints)

#### 2. **Android STB (TakeOffLauncher_v2)**

- ✅ Aplikasi launcher sudah build
- ✅ Koneksi ke server via Retrofit
- ✅ Flow: Video → Greeting → Registration → Home
- ✅ Admin Panel (tekan UP 5x)

---

## 📡 API Endpoints yang Tersedia

### Device Management

| Endpoint                     | Method | Deskripsi                    |
| ---------------------------- | ------ | ---------------------------- |
| `/api/v1/check-registration` | GET    | Cek status registrasi device |
| `/api/v1/guest-info`         | GET    | Info tamu (nama, room)       |
| `/api/v1/remote-clear`       | GET    | Clear cache via ADB          |

### UI Customization

| Endpoint             | Method | Deskripsi               |
| -------------------- | ------ | ----------------------- |
| `/api/v1/greeting`   | GET    | Custom greeting message |
| `/api/v1/background` | GET    | Home background image   |
| `/api/v1/home-menus` | GET    | Bottom menu items       |
| `/api/v1/apps`       | GET    | Daftar aplikasi         |
| `/api/v1/marquee`    | GET    | Running text            |
| `/api/v1/weather`    | GET    | Data cuaca              |
| `/api/v1/latest-apk` | GET    | Versi APK terbaru       |

### Guest Services - Dining

| Endpoint                | Method | Deskripsi           |
| ----------------------- | ------ | ------------------- |
| `/api/v1/dining-menus`  | GET    | Daftar menu makanan |
| `/api/v1/dining-order`  | POST   | Buat order makanan  |
| `/api/v1/dining-orders` | GET    | History order       |

### Guest Services - Amenities

| Endpoint                   | Method | Deskripsi        |
| -------------------------- | ------ | ---------------- |
| `/api/v1/amenities`        | GET    | Daftar amenities |
| `/api/v1/amenity-request`  | POST   | Request amenity  |
| `/api/v1/amenity-requests` | GET    | History request  |

### Hotel Information

| Endpoint                   | Method | Deskripsi       |
| -------------------------- | ------ | --------------- |
| `/api/v1/hotel-info`       | GET    | Informasi hotel |
| `/api/v1/hotel-facilities` | GET    | Fasilitas hotel |

---

## 🧪 Testing API

### 1. Test Device Registration

```bash
# Cek device belum terdaftar
curl "http://localhost:8000/api/v1/check-registration?device_id=TV-TEST-001&device_name=Test%20Device"

# Response:
# {
#   "status": "success",
#   "is_registered": false,
#   "registration_code": "REG-XXXXX"
# }
```

### 2. Test Greeting

```bash
curl "http://localhost:8000/api/v1/greeting"

# Response:
# {
#   "status": "success",
#   "data": {
#     "title": "Welcome",
#     "content": "Welcome to our hotel!",
#     "image": "http://localhost:8000/img/hotel3.png"
#   }
# }
```

### 3. Test Dining Menus

```bash
curl "http://localhost:8000/api/v1/dining-menus?lang=id"

# Response:
# {
#   "status": "success",
#   "menus": []  # Kosong jika belum ada data
# }
```

### 4. Test Hotel Facilities

```bash
curl "http://localhost:8000/api/v1/hotel-facilities?lang=id"

# Response:
# {
#   "status": "success",
#   "facilities": []  # Kosong jika belum ada data
# }
```

### 5. Test Create Dining Order

```bash
curl -X POST "http://localhost:8000/api/v1/dining-order" \
  -H "Content-Type: application/json" \
  -d '{
    "device_id": "TV-TEST-001",
    "menu_id": 1,
    "quantity": 2,
    "notes": "Extra pedas"
  }'

# Response:
# {
#   "status": "success",
#   "message": "Pesanan berhasil dibuat",
#   "order": { ... }
# }
```

---

## 📝 Langkah-Langkah Deployment

### Step 1: Setup Data Awal di Admin Panel

1. **Akses Admin Panel**

    ```
    http://192.168.1.100:8000/admin
    ```

2. **Tambah Menu Makanan** (`/admin/dining-menu`)
    - Nama: Nasi Goreng
    - Nama EN: Fried Rice
    - Kategori: Main Course
    - Harga: 35000
    - Upload gambar
    - Set `is_available = true`

3. **Tambah Amenities** (`/admin/amenities`)
    - Nama: Handuk
    - Nama EN: Towel
    - Deskripsi: Handuk mandi
    - Upload icon
    - Set `is_available = true`

4. **Tambah Hotel Info** (`/admin/info`)
    - Title: Jam Operasional
    - Content: 24 Jam
    - Upload icon
    - Set `is_active = true`

5. **Tambah Facilities** (`/admin/facilities`)
    - Nama: Swimming Pool
    - Lokasi: Lantai 5
    - Jam: 06:00 - 22:00
    - Set `is_available = true`

6. **Set Global Settings** (`/admin/settings/global`)
    - Custom Greeting Title: "Selamat Datang"
    - Custom Welcome Greeting: "Terima kasih telah menginap di hotel kami"
    - Upload Greeting Image
    - Upload Home Background

7. **Tambah System Apps** (`/admin/system-apps`)
    - App Name: YouTube
    - Package: com.google.android.youtube.tv
    - Upload icon
    - Set `is_visible = true`

### Step 2: Test dari STB

1. **Install APK ke STB**

    ```bash
    adb connect 192.168.1.XXX:5555
    adb install -r app/build/outputs/apk/debug/app-debug.apk
    ```

2. **Konfigurasi Server IP**
    - Buka app → Tekan UP 5x
    - Masukkan IP: `192.168.1.100:8000`
    - Test Connection
    - Save

3. **Restart App**
    - Video splash akan muncul
    - Greeting screen dengan data dari server
    - Klik Continue
    - Device registration check
    - Admin aktivasi di dashboard
    - Home screen muncul

### Step 3: Test Fitur Layanan

1. **Test Dining Order**
    - Klik menu "Restoran" di bottom bar
    - Pilih menu makanan
    - Tambah quantity
    - Submit order
    - Admin cek di `/admin/requests/dining`

2. **Test Amenity Request**
    - Klik menu "Amenities"
    - Pilih item (handuk, sabun, dll)
    - Submit request
    - Admin cek di `/admin/requests/amenities`

3. **Test Hotel Info**
    - Klik menu "Informasi Hotel"
    - Lihat jam operasional, kontak, dll

---

## 🎯 Fitur yang Perlu Diimplementasikan di Android

### High Priority

#### 1. **Dining Menu Dialog** 🔴

**File:** `MainActivity.kt`

Tambahkan dialog untuk menampilkan menu makanan:

```kotlin
private fun showDiningDialog() {
    val deviceId = getUniqueDeviceId()

    // Fetch menus
    apiService.getDiningMenus("id").enqueue(object : Callback<DiningMenuResponse> {
        override fun onResponse(call: Call<DiningMenuResponse>, response: Response<DiningMenuResponse>) {
            if (response.isSuccessful) {
                val menus = response.body()?.menus ?: emptyList()
                // Show dialog with menus
                // User can select and order
            }
        }
        override fun onFailure(call: Call<DiningMenuResponse>, t: Throwable) {
            Toast.makeText(this@MainActivity, "Failed to load menus", Toast.LENGTH_SHORT).show()
        }
    })
}
```

#### 2. **Amenity Request Dialog** 🔴

Similar dengan dining, tapi untuk amenities

#### 3. **Hotel Info Dialog** 🔴

Tampilkan informasi hotel dan fasilitas

#### 4. **Order History** 🟡

Tampilkan history order dan request

---

## 🔧 Troubleshooting

### Problem: API tidak bisa diakses dari STB

**Solusi:**

```bash
# Cek firewall Windows
# Allow port 8000

# Test dari STB
adb shell
curl http://192.168.1.100:8000/api/v1/greeting
```

### Problem: Device tidak muncul di admin

**Solusi:**

```bash
# Cek database
php artisan tinker
>>> App\Models\ManagedDevice::all();

# Cek log
tail -f storage/logs/laravel.log
```

### Problem: Order tidak tersimpan

**Solusi:**

- Pastikan device sudah terdaftar dan aktif
- Cek menu_id valid
- Cek log error di Laravel

---

## 📊 Database Schema

### managed_devices

```sql
- id
- device_id (unique)
- device_name
- room_number
- is_active
- registration_code
- ip_address
- status_online
- last_seen
```

### dining_menus

```sql
- id
- name
- name_en
- description
- description_en
- category
- price
- image_path
- is_available
```

### hotel_orders

```sql
- id
- device_id (FK)
- menu_id (FK)
- room_number
- quantity
- total_price
- notes
- status (pending/processing/completed/cancelled)
- ordered_at
```

### room_amenities

```sql
- id
- name
- name_en
- description
- description_en
- icon_path
- is_available
```

### amenity_requests

```sql
- id
- device_id (FK)
- amenity_id (FK)
- room_number
- quantity
- notes
- status (pending/processing/completed/cancelled)
- requested_at
```

---

## 🎉 Next Steps

1. ✅ **Backend API** - DONE
2. ✅ **Database Schema** - DONE
3. ✅ **Admin Panel** - DONE
4. 🔴 **Android UI untuk Dining** - TODO
5. 🔴 **Android UI untuk Amenities** - TODO
6. 🔴 **Android UI untuk Hotel Info** - TODO
7. 🟡 **Real-time Notifications** - TODO (WebSocket)
8. 🟡 **Payment Integration** - TODO (Optional)

---

## 📞 Support

Jika ada pertanyaan atau masalah:

1. Cek log Laravel: `storage/logs/laravel.log`
2. Cek log Android: `adb logcat | grep TakeOff`
3. Test API dengan curl/Postman
4. Cek database langsung

**Last Updated:** 2026-01-19 00:15  
**Status:** Backend Ready, Android UI Pending
