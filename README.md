# LicensePilot

LicensePilot คือระบบจัดการ License สำหรับ Plugin หรือซอฟต์แวร์ที่ต้องใช้ License Key  
รองรับการตรวจสอบผ่าน API, ระบบ Login แยก Admin/Customer และต่ออายุ License

---

## ⚙️ Requirements

ก่อนติดตั้ง โปรดตรวจสอบว่าคุณมีเครื่องมือเหล่านี้:

- PHP 8.1 หรือสูงกว่า
- Composer
- MySQL หรือ MariaDB
- Node.js และ npm
- Git

---

## 🚀 วิธีติดตั้งโปรเจกต์บนเครื่องของคุณ

### 1. Clone โปรเจกต์จาก GitHub

```bash
git clone https://github.com/Angkul/LicensePilot.git
cd LicensePilot
```

---

### 2. ติดตั้ง Laravel dependencies (ผ่าน Composer)

```bash
composer install
```

หากไม่มี `composer` ให้ติดตั้งจาก: https://getcomposer.org/

---

### 3. ติดตั้ง Frontend dependencies (ผ่าน npm)

```bash
npm install
```

จากนั้น build frontend assets:

```bash
npm run dev
```

---

### 4. ตั้งค่าไฟล์ `.env`

```bash
cp .env.example .env
```

จากนั้นแก้ไขค่าในไฟล์ `.env` ให้เชื่อมกับฐานข้อมูลของคุณ เช่น:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=license_pilot
DB_USERNAME=root
DB_PASSWORD=
```

---

### 5. Generate APP KEY

```bash
php artisan key:generate
```

---

### 6. สร้างฐานข้อมูล (Database)

- เข้าไปที่ MySQL/phpMyAdmin แล้วสร้าง database ชื่อ `license_pilot`
- หรือใช้ CLI:
  ```sql
  CREATE DATABASE license_pilot;
  ```

---

### 7. รัน Migration เพื่อสร้างตาราง

```bash
php artisan migrate
```

---

### 8. เริ่มรันโปรเจกต์

```bash
php artisan serve
```

จากนั้นเปิดเว็บเบราว์เซอร์ไปที่:

```
http://localhost:8000
```

---

## 🔐 ระบบ Login (ถ้าใช้ Laravel Breeze)

คุณสามารถสมัครสมาชิกใหม่ที่ `/register`  
หรือใช้คำสั่งสร้างผู้ใช้ admin:

```bash
php artisan tinker
```

```php
use App\Models\User;
User::create([
    'name' => 'admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
]);
```

---

## 🧪 ตรวจสอบ License ผ่าน API

API ตัวอย่าง:

```
GET /api/license/check?key=XXXX-YYYY&domain=example.com
```

(ต้องมีระบบ API Controller แยก ซึ่งสามารถพัฒนาเพิ่มเติมได้)

---

## 📁 โฟลเดอร์สำคัญ

| โฟลเดอร์ | คำอธิบาย |
|----------|-----------|
| `app/Http/Controllers` | Logic สำหรับจัดการ License และ Dashboard |
| `routes/web.php` | Routing สำหรับเว็บ |
| `resources/views` | Blade Templates |
| `database/migrations` | โครงสร้างตารางฐานข้อมูล |

---

## 📌 ผู้พัฒนา

โดย [Angkul](https://github.com/Angkul)
website: https://www.ehowme.com, https://www.angkul.com

---
