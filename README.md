# MapLearn Platform API - Backend

**MapLearn** là nền tảng học tập trực tuyến dành cho học sinh THPT, được xây dựng như đồ án học kỳ 2 và được FPT Aptech vinh danh trong bài viết: [MapLearn.Edu - Nền tảng học tập trực tuyến dành cho học sinh THPT](https://aptech.fpt.edu.vn/maplearn-edu-nen-tang-hoc-tap-truc-tuyen-danh-cho-hoc-sinh-thpt.html).

Repository này là phần Backend API được xây dựng bằng Laravel 12 và PHP 8.2+, cung cấp RESTful API cho frontend Next.js.

## Links

-   **Live Demo**: https://maplearn.htuanqn.id.vn/
-   **Frontend Repository**: https://github.com/hoangtuanqn/maplearn-platform-web-nextjs
-   **Video giới thiệu**: https://youtu.be/tpkcZAqdP0o

### Tài khoản demo

#### Học sinh

-   Bạn có thể tự tạo được tài khoản học sinh mới qua trang đăng ký.

#### Giảng viên

-   **Username**: `nguyen_anh_phong_2`
-   **Password**: `Aptech@123`

#### Quản trị viên

-   **Email**: `vu_ngoc_anh_1`
-   **Password**: `Aptech@123`

**Lưu ý**: Đây là tài khoản demo. Vui lòng không thay đổi thông tin quan trọng.

---

![Hình ảnh minh họa](https://i.ibb.co/fVW9tfSH/2025-12-09-090407.png)
![Hình ảnh minh họa](https://i.ibb.co/fVW9tfSH/2025-12-09-090407.png)
![Hình ảnh minh họa](https://i.ibb.co/m53WkjDz/1.png)
![Hình ảnh minh họa](https://i.ibb.co/Lh9PLcsW/2.png)
![Hình ảnh minh họa](https://i.ibb.co/Nnr3dm20/3.png)

---

## Thành viên nhóm phát triển

1. Phạm Hoàng Tuấn
2. Lâm Hoàng An
3. Trần Hoàng Anh

---

## Công nghệ sử dụng

### Core Framework & Language

-   **PHP 8.2+**: Ngôn ngữ lập trình chính
-   **Laravel 12.0**: Framework PHP với kiến trúc MVC

### Authentication & Security

-   **JWT (tymon/jwt-auth)**: JSON Web Token cho stateless authentication
-   **Laravel Socialite**: OAuth authentication với Google, Facebook, Discord
-   **Google 2FA (pragmarx/google2fa)**: Xác thực hai yếu tố
-   **Anti-cheat System**: Hệ thống phát hiện gian lận trong thi trực tuyến

### Database & ORM

-   **MySQL**: Hệ quản trị cơ sở dữ liệu quan hệ
-   **Eloquent ORM**: Object-Relational Mapping của Laravel
-   **Query Builder (spatie/laravel-query-builder)**: Xây dựng query phức tạp, filter, sort động

### Payment Integration

-   **VNPay**: Cổng thanh toán ngân hàng
-   **MoMo**: Ví điện tử MoMo
-   **ZaloPay**: Ví điện tử ZaloPay

### Queue & Background Jobs

-   **Laravel Queue**: Xử lý jobs bất đồng bộ
-   **Database Queue Driver**: Lưu trữ jobs trong database
-   **Email Queue**: Gửi email ngầm để tối ưu hiệu năng

### Realtime & Broadcasting

-   **Pusher**: WebSocket service cho thông báo realtime
-   **Laravel Echo**: Broadcasting events

### File & Storage

-   **Cloudinary**: Cloud storage cho hình ảnh, video
-   **Laravel Storage**: Quản lý file uploads

### Email & Notifications

-   **Laravel Mail**: Gửi email với template
-   **SMTP (Gmail)**: Email service provider
-   **Notification System**: Thông báo đa kênh (email, database, pusher)

### Additional Libraries

-   **Carbon**: Thao tác với ngày tháng
-   **Faker**: Tạo dữ liệu giả cho testing/seeding
-   **QR Code (endroid/qr-code)**: Tạo QR code cho certificates

### Development Tools

-   **PHPStan**: Static analysis tool
-   **PHP CS Fixer**: Code style fixer
-   **Laravel Pint**: Code formatting
-   **Laravel Sail**: Docker development environment
-   **PHPUnit**: Testing framework

---

## Tính năng chính

### Xác thực & Bảo mật

**Đăng ký & Đăng nhập**

-   Đăng ký tài khoản với email/username
-   Xác thực email bằng link gửi qua mail (sử dụng Queue Jobs để xử lý ngầm)
-   Đăng nhập bằng username/email + password
-   Đăng nhập bằng mạng xã hội: Google, Facebook, Discord (OAuth 2.0)
-   Tự động tạo tài khoản khi đăng nhập OAuth lần đầu
-   JWT token với access token và refresh token
-   Auto-refresh token khi hết hạn

**Quản lý tài khoản**

-   Quên mật khẩu & reset password qua email
-   Đổi mật khẩu trong profile
-   Cập nhật thông tin cá nhân (avatar, bio, trường học, năm sinh, v.v.)
-   Google 2FA - Xác thực hai yếu tố (bật/tắt, quét QR code)
-   Gửi lại email xác thực (rate limit: 2 lần/5 phút)

**Phân quyền**

-   3 roles: Student, Teacher, Admin
-   Middleware kiểm tra role cho từng route
-   Policy-based authorization cho resources

### Hệ thống khóa học

**Quản lý khóa học**

-   CRUD khóa học với đầy đủ thông tin (tên, mô tả, thumbnail, intro video, giá)
-   Phân loại theo: Cấp độ (Lớp 10, 11, 12, Đại học năng lực, Đại học tổng hợp), Môn học (Toán, Lý, Hóa, Sinh, Anh, Văn), Danh mục
-   Khóa học tiên quyết (prerequisite courses)
-   Chế độ học tuần tự hoặc tự do nhảy bài
-   Đề thi cuối khóa (optional)
-   Slug-based URL thân thiện SEO
-   Hệ thống đánh giá & review (rating 1-5 sao)
-   Thống kê: số học viên, thời lượng, số bài học

**Chương & Bài học**

-   CRUD chapters (chương học) với thứ tự position
-   CRUD lessons (bài học) với video, nội dung markdown
-   Upload video lên Cloudinary
-   Thời lượng bài học tự động tính
-   Gửi email thông báo khi có video mới (Queue Job)

**Theo dõi tiến độ học tập**

-   Lưu lịch sử xem video (pause position, completed)
-   Tính phần trăm hoàn thành khóa học theo thời gian xem
-   Tracking từng học viên: bài nào đã xem, bài nào chưa
-   Dashboard thống kê cho giáo viên xem tiến độ lớp
-   API lấy bài học tiếp theo chưa hoàn thành

**Tính năng nâng cao**

-   Đề xuất khóa học dựa trên lịch sử học (AI-ready data export)
-   Khóa học bán chạy nhất (best seller badge)
-   Khóa học miễn phí & có phí
-   Đăng ký khóa học miễn phí 1 click
-   Filter & search: theo giá, rating, giáo viên, completion status, progress range
-   Sort động (latest, popular, price, rating)

### Hệ thống thi trực tuyến

**Quản lý đề thi**

-   CRUD exam papers với nhiều loại kỳ thi (ĐGNL HSA, V-ACT, ĐGTĐ TSA, Tốt nghiệp THPT, Cuối kỳ, Giữa kỳ)
-   Phân loại theo môn học, cấp độ, tỉnh thành
-   Độ khó: Dễ, Trung bình, Khó, Rất khó
-   Cấu hình: Điểm tối đa, điểm đạt, thời gian làm bài
-   Giới hạn số lần làm bài (max attempts)
-   Mật khẩu bảo vệ đề thi (optional)
-   Thời gian mở/đóng đề thi

**Câu hỏi & Đáp án**

-   CRUD questions với đáp án trắc nghiệm
-   Hỗ trợ LaTeX/KaTeX cho công thức toán học
-   Upload hình ảnh cho câu hỏi
-   Trộn đáp án ngẫu nhiên khi thi

**Làm bài & Chấm điểm**

-   Bắt đầu bài thi (tạo attempt record)
-   Lưu trạng thái làm bài (pause/resume)
-   Nộp bài và chấm điểm tự động
-   Xem đáp án chi tiết sau khi nộp
-   Lịch sử làm bài (attempts history)
-   Điểm cao nhất & điểm trung bình

**Anti-cheat System**

-   Bật/tắt chống gian lận cho từng đề
-   Theo dõi số lần vi phạm (switch tab, copy/paste, v.v.)
-   Tự động đánh dấu bài thi gian lận
-   Giới hạn số lần vi phạm tối đa (configurable)
-   API detect cheat từ frontend

**Bảng xếp hạng**

-   Ranking board theo điểm cao nhất
-   Hiển thị top performers
-   Kiểm tra vị trí của user trong bảng xếp hạng

### Thanh toán & Đăng ký khóa học

**Payment Integration**

-   VNPay: Thanh toán qua thẻ ATM/Visa/Mastercard
-   MoMo: Thanh toán qua ví MoMo
-   ZaloPay: Thanh toán qua ví ZaloPay
-   Payment callback handling & verification
-   Transaction status tracking (pending, paid, cancelled, expired)

**Quản lý Payment**

-   Tạo invoice khi mua khóa học
-   Hủy payment trước khi thanh toán
-   Lịch sử giao dịch của user
-   Admin dashboard: thống kê doanh thu, filter theo ngày, trạng thái
-   Email hóa đơn sau khi thanh toán thành công (Queue)

**Đăng ký khóa học**

-   Đăng ký khóa học miễn phí trực tiếp
-   Mua khóa học có phí qua payment gateway
-   Kiểm tra đã đăng ký hay chưa (is_enrolled)
-   Thông báo cho giáo viên khi có học viên mới (Notification + Email Queue)

### Hệ thống Blog/Posts

-   CRUD bài viết với rich text editor
-   Upload hình ảnh thumbnail
-   Slug-based URL
-   Filter theo khóa học liên quan
-   View counter (tăng lượt xem)
-   Export data cho AI search

### Chứng chỉ (Certificates)

-   Tự động tạo certificate khi hoàn thành khóa học
-   QR Code verification cho certificate
-   API public kiểm tra tính hợp lệ của certificate
-   Thông tin: Tên học viên, khóa học, ngày hoàn thành, điểm thi (nếu có)
-   Email gửi certificate sau khi hoàn thành (Queue)

### Hệ thống thông báo

**Notification Types**

-   Email Verification: Xác thực email khi đăng ký
-   Password Reset: Link reset password
-   New Video: Thông báo video mới trong khóa học đang học
-   Course Completed: Chúc mừng hoàn thành khóa học
-   Student Enrolled: Thông báo giáo viên có học viên mới
-   Teacher Added: Thông báo khi được thêm làm giáo viên khóa học
-   Invoice: Hóa đơn thanh toán
-   Exam Required: Nhắc nhở làm đề thi cuối khóa

**Notification Channels**

-   Email (qua Queue)
-   Database notification
-   Pusher (realtime broadcast)

### Dashboard & Analytics

**Admin Dashboard**

-   Tổng quan: Tổng số khóa học, học viên, giáo viên, bài thi
-   Thống kê doanh thu theo ngày/tháng/năm
-   Biểu đồ tăng trưởng học viên
-   Top khóa học bán chạy
-   Quản lý toàn bộ users, courses, exams, payments

**Teacher Dashboard**

-   Khóa học của tôi (courses I teach)
-   Danh sách học viên từng khóa
-   Theo dõi tiến độ học của từng học viên
-   Lịch sử học chi tiết (lesson view histories)
-   Thống kê số học viên đăng ký trong 7 ngày gần nhất
-   Xem thông tin chi tiết học viên (stats, histories)

**Student Dashboard**

-   Khóa học đã đăng ký
-   Tiến độ học từng khóa (phần trăm completion)
-   Đề thi đã làm & điểm số
-   Lịch sử thanh toán
-   Certificates đã nhận

### Tính năng kỹ thuật

**Queue Jobs (Xử lý bất đồng bộ)**

-   Email Queue: Tất cả email đều gửi qua queue để không làm chậm response
-   Notification Queue: Thông báo realtime qua Pusher
-   Observer Pattern: Tự động trigger jobs khi có sự kiện (course created, payment completed, v.v.)
-   Retry mechanism: Jobs thất bại sẽ retry tự động
-   Failed jobs tracking: Log jobs thất bại để xử lý

**API Features**

-   RESTful API design chuẩn
-   Pagination: Hỗ trợ phân trang cho tất cả list endpoints
-   Filter & Sort: Dynamic query parameters (spatie/query-builder)
-   Optional Authentication: Middleware auth.optional.jwt cho endpoints vừa cho guest vừa cho user
-   Rate Limiting: Throttle cho các endpoints nhạy cảm
-   CORS: Cấu hình CORS cho frontend Next.js
-   Cookie-based JWT: Store JWT trong HTTP-only cookie (production)

**Database**

-   Migrations: Quản lý schema versioning
-   Seeders: Data giả cho development & demo
-   Factories: Generate fake data dễ dàng
-   Foreign Keys: Ràng buộc toàn vẹn dữ liệu
-   Cascade Delete: Tự động xóa related records
-   Soft Deletes: Xóa mềm cho một số tables

**Security**

-   JWT Authentication: Stateless & scalable
-   CSRF Protection: Bảo vệ form submissions
-   XSS Prevention: Laravel's Blade auto-escaping
-   SQL Injection Prevention: Eloquent ORM parameterized queries
-   Password Hashing: Bcrypt với cost factor 12
-   Google 2FA: Two-factor authentication optional
-   Policy-based Authorization: Fine-grained permission control

**Code Quality**

-   PHPStan: Static analysis để catch bugs sớm
-   PHP CS Fixer: Auto-format code theo PSR-12
-   Custom Artisan Command: `php artisan code:check-imports` để dọn dẹp imports thừa
-   Service Layer: Tách business logic ra khỏi controllers
-   Observers: Auto-handle model events
-   Traits: Reusable code cho authorization & cookies

---

## Cài đặt & Chạy dự án

### Yêu cầu hệ thống

-   PHP >= 8.2
-   Composer
-   MySQL >= 5.7 hoặc MariaDB
-   Node.js & NPM
-   Git

### Các bước cài đặt

**1. Clone repository**

```bash
git clone https://github.com/hoangtuanqn/maplearn-platform-api.git
cd maplearn-platform-api
```

**2. Cài đặt dependencies**

```bash
composer install
npm install
```

**3. Cấu hình môi trường**

```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

**4. Cấu hình file .env**

Cập nhật các thông tin quan trọng trong file `.env`:

```env
# Database
DB_CONNECTION=mysql
DB_DATABASE=maplearn
DB_USERNAME=root
DB_PASSWORD=your_password

# Application URLs
APP_URL=http://localhost:8000
APP_URL_FRONT_END=http://localhost:3000
COOKIE_DOMAIN_PROD=.yourdomain.com

# Environment (development: local, production: production)
APP_ENV=local
APP_DEBUG=true
```

**Lưu ý**: Đổi `APP_ENV=production` và `APP_DEBUG=false` khi deploy production.

**5. Khởi tạo database**

```bash
php artisan migrate --seed
```

**6. Storage link**

```bash
php artisan storage:link
```

**7. Chạy development server**

```bash
# Chạy tất cả services
composer dev
```

Hoặc chạy từng service riêng:

```bash
php artisan serve                    # Laravel server
php artisan queue:work --tries=1     # Queue worker
php artisan pail --timeout=0         # View logs
npm run dev                          # Build assets
```

**8. Truy cập**

Backend API: http://localhost:8000

---

## Các lệnh hữu ích

**Development**

```bash
php artisan optimize:clear                # Xóa cache
composer dump-autoload                    # Refresh autoload
php artisan code:check-imports --fix      # Xóa imports thừa
composer stan                             # Static analysis
composer test                             # Run tests
```

**Queue Management**

```bash
php artisan queue:work                    # Chạy queue worker (gửi email ngầm)
php artisan queue:work --tries=1          # Chạy queue với 1 lần retry
php artisan queue:listen                  # Auto-restart khi có code changes
```

**Database**

```bash
php artisan migrate                       # Chạy migrations
php artisan migrate:rollback              # Rollback migration
php artisan migrate:fresh --seed          # Reset & seed lại database
php artisan db:seed                       # Chỉ chạy seeders
```

---

## API Documentation

API base URL: `http://localhost:8000/api/v1`

**Authentication Endpoints**

```
POST   /auth/register
POST   /auth/login
POST   /auth/verify-email
POST   /auth/verify-2fa
POST   /auth/forgot-password
POST   /auth/reset-password
GET    /auth/{provider}                  # OAuth (google/facebook/discord)
GET    /auth/{provider}/callback
POST   /auth/me                          # Get user info (auth required)
POST   /auth/logout
POST   /auth/refresh
```

**Courses Endpoints**

```
GET    /courses
GET    /courses/{slug}
POST   /courses                          # teacher/admin
PUT    /courses/{slug}                   # teacher/admin
DELETE /courses/{slug}                   # teacher/admin
GET    /courses/{slug}/study             # auth required
GET    /courses/{course}/study/{lesson}
GET    /courses/{course}/reviews
POST   /courses/recommended
```

**Exams Endpoints**

```
GET    /exams
GET    /exams/{slug}
GET    /exams/questions/{exam}           # auth required
POST   /exams/{exam}/start               # auth required
POST   /exams/{exam}/submit              # auth required
GET    /exams/{exam}/{id}/results        # auth required
GET    /exams/{exam}/ranking
GET    /exams/{exam}/attempts            # auth required
POST   /exams/{exam}/detect-cheat        # auth required
```

**Payment Endpoints**

```
GET    /payments                         # auth required
POST   /payments                         # auth required
POST   /payments/enroll-free-course/{course}
POST   /payments/{transaction_code}/cancel
GET    /payment/vnpay/return
GET    /payment/momo/return
GET    /payment/zalopay/return
```

**Profile Endpoints**

```
POST   /profile/update                   # auth required
POST   /profile/change-password          # auth required
GET    /profile/courses                  # auth required
GET    /profile/exams                    # auth required
GET    /profile/payments                 # auth required
POST   /profile/resend-verify-email      # auth required
GET    /profile/2fa/generate             # auth required
POST   /profile/2fa/toggle               # auth required
```

Xem file `MapLearn.postman_collection_Master.json` để có bộ collection đầy đủ.

---

## Cấu trúc thư mục

```
app/
├── Console/Commands/          # Custom artisan commands
├── Events/                    # Events (Pusher, broadcasting)
├── Filters/                   # Query filters
├── Helpers/                   # Helper functions
├── Http/
│   ├── Controllers/          # API Controllers
│   ├── Middleware/           # Custom middleware
│   └── Requests/             # Form request validation
├── Mail/                     # Email templates
├── Models/                   # Eloquent models
├── Notifications/            # Notification classes
├── Observers/                # Model observers
├── Policies/                 # Authorization policies
├── Services/                 # Business logic services
└── Traits/                   # Reusable traits

config/                       # Configuration files
database/
├── factories/               # Model factories
├── migrations/              # Database migrations
└── seeders/                 # Database seeders

routes/
├── api.php                  # Main API routes
├── auth.php                 # Authentication routes
├── course.php               # Course routes
├── exams.php                # Exam routes
└── payment.php              # Payment routes
```

---

## Workflow

**Queue Jobs Workflow**

Dự án sử dụng Laravel Queue để xử lý các tác vụ nặng bất đồng bộ:

1. Email Notifications: Tất cả email được đẩy vào queue
2. Pusher Notifications: Thông báo realtime chạy qua queue
3. Observer Auto-trigger: Khi có sự kiện, Observer tự động tạo jobs

Ví dụ: Khi user đăng ký tài khoản, API trả về ngay response, job gửi email xác thực được push vào queue, queue worker xử lý gửi email ngầm.

**Anti-cheat System Workflow**

1. Frontend track các hành vi nghi vấn (switch tab, copy/paste, v.v.)
2. Gửi API `/exams/{exam}/detect-cheat` khi phát hiện vi phạm
3. Backend tăng `violation_count` trong `exam_attempts`
4. Nếu vượt quá `max_violation_attempts` đánh dấu `is_cheating = true`
5. Hiển thị warning trong bảng ranking

**Payment Flow**

1. User chọn khóa học, tạo payment record (status: pending)
2. Redirect đến payment gateway (VNPay/MoMo/ZaloPay)
3. User thanh toán, gateway callback về API
4. Verify signature, update payment status = paid
5. Observer trigger: Gửi email invoice + notification cho giáo viên
6. User được enroll vào khóa học

---

## Deploy Production

**Server yêu cầu**

-   PHP 8.2+, Composer
-   MySQL/MariaDB
-   Nginx/Apache
-   Supervisor (để chạy queue worker)

**Cập nhật .env**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.yourdomain.com
APP_URL_FRONT_END=https://yourdomain.com
COOKIE_DOMAIN_PROD=.yourdomain.com
```

**Optimize**

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Setup Queue Worker với Supervisor**

```ini
[program:maplearn-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/maplearn-platform-api/artisan queue:work --tries=1
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/maplearn-platform-api/storage/logs/worker.log
```

---

## Tài liệu tham khảo

-   [Laravel Documentation](https://laravel.com/docs/12.x)
-   [JWT Auth Documentation](https://jwt-auth.readthedocs.io/)
-   [Spatie Query Builder](https://spatie.be/docs/laravel-query-builder)
-   [Pusher Documentation](https://pusher.com/docs)
-   [VNPay Integration](https://sandbox.vnpayment.vn/apis/)
