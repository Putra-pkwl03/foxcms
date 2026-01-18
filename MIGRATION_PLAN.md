# Migration Plan: AHFix → AHF-SERVER (Laravel)

## ✅ Completed

1. **Larastrap Package** - Installed and configured
2. **Basic Models** - DiningMenu, HotelFacility, SystemApp
3. **Admin Layout** - Bootstrap 5 with sidebar
4. **Dashboard** - Stats cards and overview
5. **Dining Menu CRUD** - Full implementation

## 🔄 In Progress - Core Features

### Database Tables (from legacy SQL)

- [x] dining_menus
- [x] hotel_facilities
- [x] system_apps
- [ ] managed_devices (Device registration)
- [ ] guest_checkin (Check-in management)
- [ ] room_amenities (Amenities catalog)
- [ ] amenity_requests (Guest amenity requests)
- [ ] hotel_orders (Dining orders from guests)
- [ ] hotel_info (Information pages)
- [ ] global_settings (System settings)
- [ ] system_marquee (Running text)

### Admin Panel Pages (from admin.php)

- [x] Dashboard
- [ ] Devices Management (devices.php)
- [ ] Check-in Management (checkin.php)
- [ ] Send Notification (send_notification.php)
- [x] Facilities (facilities.php)
- [ ] Amenities Management (amenities.php)
- [ ] Information Pages (information.php)
- [x] Dining Menu (dining.php)
- [ ] Dining Orders (dining_orders.php)
- [ ] Amenity Requests (amenity_requests.php)
- [ ] Entertainment Apps Control (app_control.php)
- [ ] Running Text (running_text.php)
- [ ] System Update (update.php)
- [ ] Flashscreen/Background (flashscreen.php)

### API Endpoints (for Android App)

From api/api.php:

- [ ] checkRegistration - Check if device is registered
- [ ] getStatus - Get launcher enabled/disabled status
- [ ] getGuestInfo - Get guest name and room number
- [ ] getMarqueeText - Get running text
- [ ] getAppVisibility - Get visible apps list
- [ ] getAppVersion - Get launcher version
- [ ] getHomeBackground - Get dynamic background
- [ ] getWeather - Weather data
- [ ] getCustomGreeting - Custom greeting message

From other API files:

- [ ] getDining - Get dining menu items
- [ ] getFacilities - Get facilities list
- [ ] getInfo - Get information pages
- [ ] posOrder - Submit dining order
- [ ] flashscreen - Upload flashscreen/background

### Authentication

- [ ] Admin login system
- [ ] Session management
- [ ] Password hashing (already using bcrypt in SQL)

## 📋 Next Steps Priority

1. **Complete Migrations** - Finish all table migrations
2. **API Controller** - Create unified API for Android app
3. **Device Management** - Registration and monitoring
4. **Guest Management** - Check-in/check-out system
5. **Orders System** - Handle dining and amenity requests
6. **Settings Panel** - Global settings and marquee text
7. **File Upload** - Images for menu, facilities, backgrounds

## 🎯 Key Features from Legacy System

### Admin Features

- Device registration with unique codes
- Guest check-in/check-out tracking
- Real-time order management
- Push notifications to devices
- Dynamic content management (menu, facilities, info)
- Background image customization
- Running text management
- App visibility control

### Android App Features (via API)

- Device auto-registration
- Guest information display
- Dynamic menu loading
- Bilingual support (ID/EN)
- Weather integration
- Running text display
- Push notifications
- Background updates

## 🔧 Technical Notes

- Using Larastrap for lightweight Bootstrap 5 components
- Maintaining compatibility with existing Android app
- API responses must match legacy format
- Image paths need proper URL handling
- Session management for guest data
