# TeamManager

Hệ thống quản lý nhóm (TeamManager) được xây dựng trên nền tảng **PHP Laravel 13** kết hợp giao diện **Blade Templates** và **Tailwind CSS v4**.

---

## 🛠 Công nghệ sử dụng (Tech Stack)

- **Backend**: [Laravel Framework 13.x](https://laravel.com)
- **PHP**: `>= 8.3` (Hiện tại: `8.5.x`)
- **Frontend**: [Blade Template Engine](https://laravel.com/docs/blade)
- **Asset Bundler**: [Vite 8](https://vite.dev) + [@tailwindcss/vite](https://tailwindcss.com)
- **CSS Framework**: [Tailwind CSS v4](https://tailwindcss.com)
- **Cơ sở dữ liệu**: SQLite (Mặc định cho môi trường phát triển) / Hỗ trợ MySQL, PostgreSQL
- **Testing & Code Quality**: PHPUnit, Laravel Pint
- **AI Agent Tooling**: Laravel Boost (Hỗ trợ Antigravity, MCP Server, Agent Skills)

---

## 📋 Yêu cầu hệ thống (Prerequisites)

- **PHP**: `^8.3` hoặc `^8.5` với các extension: `bcmath`, `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo_sqlite`, `tokenizer`, `xml`, `zip`.
- **Composer**: `^2.x`
- **Node.js**: `>= 20.x` & **npm**: `>= 10.x`

---

## ⚙️ Hướng dẫn cài đặt (Installation)

Nếu bạn vừa clone repository về máy tính mới, thực hiện các bước sau:

### 1. Cài đặt các gói phụ thuộc PHP
```bash
composer install
```

### 2. Cài đặt các gói phụ thuộc Frontend
> **Lưu ý trên Windows**: Sử dụng `npm.cmd` nếu gặp lỗi PowerShell Execution Policy.
```powershell
npm.cmd install
```

### 3. Cấu hình biến môi trường
Sao chép file `.env.example` thành `.env` (nếu chưa có):
```powershell
copy .env.example .env
```
Tạo khóa mã hóa ứng dụng:
```powershell
php artisan key:generate
```

### 4. Khởi tạo Database & Chạy Migrations
Mặc định ứng dụng sử dụng SQLite (`database/database.sqlite`):
```powershell
php artisan migrate
```

---

## 🚀 Hướng dẫn khởi chạy phát triển (Development)

### Cách 1: Chạy đồng thời cả Backend và Frontend (Khuyến nghị)
Laravel hỗ trợ lệnh `composer run dev` để chạy song song server, worker queue và Vite:
```powershell
composer run dev
```

### Cách 2: Chạy riêng biệt từng dịch vụ

1. **Khởi chạy máy chủ Laravel (Backend)**:
   ```powershell
   php artisan serve
   ```
   Ứng dụng sẽ hoạt động tại: `http://localhost:8000`

2. **Khởi chạy Vite Development Server (Frontend Hot-Reload)**:
   ```powershell
   npm.cmd run dev
   ```

---

## 📦 Build Assets cho Production

Khi triển khai hoặc muốn biên dịch tĩnh toàn bộ asset CSS/JS:
```powershell
npm.cmd run build
```

Các file đã tối ưu sẽ nằm trong thư mục `public/build`.

---

## 🧪 Kiểm thử & Định dạng mã nguồn (Testing & Formatting)

### Chạy Unit & Feature Tests
```powershell
php artisan test
```
hoặc chạy trực tiếp với PHPUnit:
```powershell
vendor/bin/phpunit
```

### Định dạng mã nguồn theo chuẩn Laravel Pint
```powershell
vendor/bin/pint --dirty --format agent
```
hoặc định dạng toàn bộ dự án:
```powershell
vendor/bin/pint
```

---

## 📂 Cấu trúc thư mục chính

```text
TeamManager/
├── app/                  # Chứa logic ứng dụng (Models, Controllers, v.v.)
│   ├── Http/Controllers/ # Xử lý các request từ web routes
│   └── Models/          # Eloquent Models
├── database/             # Migrations, Factories, Seeders
│   └── database.sqlite   # File CSDL SQLite mặc định
├── resources/
│   ├── css/              # Tailwind CSS styles (app.css)
│   ├── js/               # JavaScript entry point (app.js)
│   └── views/            # Blade Templates (.blade.php)
├── routes/
│   ├── web.php           # Các route giao diện Blade
│   └── console.php       # Artisan commands tùy chỉnh
├── tests/                # Feature và Unit tests
└── vite.config.js        # Cấu hình Vite & Tailwind
```
