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

## 📂 Cấu trúc thư mục chuẩn Enterprise

```text
TeamManager/
├── app/
│   ├── Actions/          # Single-purpose business use cases (bọc DB::transaction)
│   ├── DTOs/             # Strongly-typed Data Transfer Objects (PHP 8.5 readonly class)
│   ├── Enums/            # Type-safe Domain Enums (ProjectStatus, ProjectPriority, MemberStatus)
│   ├── Events/           # Domain Events (MemberAssignedToProject, MemberWorkloadExceeded)
│   ├── Listeners/        # Structured Audit Logging & Notification Handlers
│   ├── Services/         # Enterprise Domain Services (WorkloadService)
│   ├── Http/
│   │   ├── Controllers/  # Thin Controllers (chỉ điều hướng và gọi Actions/Services)
│   │   └── Requests/     # Form Requests validation và DTO transformations ($request->toDto())
│   └── Models/           # Eloquent Models với Enums casts và relationships
├── database/
│   ├── migrations/       # Migrations với foreign keys, indexes, cascades
│   └── seeders/          # Database seeder dữ liệu đa dự án thực tế
├── resources/
│   ├── css/              # Tailwind CSS v4 & Fluent 2 Mica Material utilities
│   └── views/            # Fluent 2 Mica Blade Views & Components
├── routes/
│   └── web.php           # Scoped resourceful web routes
└── tests/                # PHPUnit Feature & Unit Test Suite
```

---

## 🏛️ Quy chuẩn Lập trình Enterprise (Enterprise Guidelines)

1. **Kiến trúc phân tầng (Layered Architecture & Thin Controllers)**:
   - Controller chỉ nhận Request, xác thực, chuyển đổi sang **DTO** và ủy thác cho **Action/Service**.
   - Không đặt business logic hay câu truy vấn phức tạp trực tiếp trong Controller hay Blade Views.
2. **Data Transfer Objects (DTOs)**:
   - Dùng `readonly class` với thuộc tính có kiểu dữ liệu tường minh thay vì mảng lỏng lẻo (`array`).
3. **Domain Enums (PHP 8.5 Native Enums)**:
   - Sử dụng Enum có định kiểu (`string`) cho trạng thái (`ProjectStatus`, `MemberStatus`, `ProjectPriority`).
   - Tích hợp phương thức nhãn (`label()`), màu huy hiệu Fluent 2 (`badgeClass()`), chấm tín hiệu (`dotClass()`).
4. **Đảm bảo tính toàn vẹn dữ liệu (ACID Transactions)**:
   - Mọi thao tác ghi dữ liệu đa bước (gán thành viên, cập nhật đội trưởng) đều được bao bọc trong `DB::transaction()`.
5. **Giám sát tải năng suất (Workload Management Service)**:
   - Tự động tính toán tổng tỷ lệ tải (% Workload) của thành viên khi kiêm nhiệm đa dự án.
   - Kích hoạt sự kiện `MemberWorkloadExceeded` khi vượt ngưỡng 100% công suất.
6. **Kiểm soát tính nghiêm ngặt (Strict Mode)**:
   - Kích hoạt `Model::shouldBeStrict(! app()->isProduction())` trong `AppServiceProvider` nhằm ngăn chặn triệt để lỗi N+1 truy vấn và các thuộc tính chưa được khai báo.
7. **Kiểm thử & Chất lượng mã nguồn**:
   - Tuân thủ bộ test PHPUnit và định dạng tự động với Laravel Pint trước khi hoàn tất.
