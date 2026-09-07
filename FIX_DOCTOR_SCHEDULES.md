# Lỗi `RelationNotFoundException: schedules` và cách đã sửa

## 1. Lỗi gặp phải

```
Illuminate\Database\Eloquent\RelationNotFoundException
Call to undefined relationship [schedules] on model [App\Models\Doctor].
```

Xảy ra khi mở trang **Doctor Dashboard** (`Doctor::with(['schedules', 'appointment'])`).

## 2. Nguyên nhân

Dự án ban đầu dùng schema đơn giản: `doctor_schedules` có cột `doctor_id` trỏ thẳng
tới bảng `doctors`.

Sau khi import `database/mediconnect_complete_final.sql`, schema đã đổi sang mô hình
theo cơ sở y tế:

```
doctors
  -> doctor_assignments (facility_specialization_id, doctor_id, ...)
       -> doctor_schedules (doctor_assignment_id, day, start_time, end_time, ...)
       -> doctor_appointment_slots
```

Bảng `doctor_schedules` **không còn cột `doctor_id`**, chỉ còn `doctor_assignment_id`.
Model `App\Models\Doctor` khi đó chưa khai báo quan hệ `schedules()` nào cả, nên
Eloquent báo `RelationNotFoundException`.

Ngoài ra, nhiều đoạn code cũ (trong `DoctorController`, `AdminController`,
`LocalController`) vẫn còn viết thẳng:

```php
DoctorSchedule::where('doctor_id', $id)->...
DoctorSchedule::create(['doctor_id' => $doctor->id, ...]);
```

Các dòng này sẽ lỗi SQL (`Unknown column 'doctor_id'`) ngay khi được gọi tới, vì cột
đó không còn tồn tại.

## 3. Cách đã sửa

### a. Thêm quan hệ còn thiếu trong `app/Models/Doctor.php`

```php
public function schedules()
{
    return $this->hasManyThrough(
        DoctorSchedule::class,
        DoctorAssignment::class,
        'doctor_id',            // cột trên doctor_assignments trỏ về doctors
        'doctor_assignment_id', // cột trên doctor_schedules trỏ về doctor_assignments
        'id',
        'id'
    );
}

public function appointment()
{
    return $this->hasManyThrough(
        Appointments::class,
        DoctorAssignment::class,
        'doctor_id',
        'doctor_assignment_id',
        'id',
        'id'
    );
}
```

`hasManyThrough` cho phép lấy `DoctorSchedule` / `Appointments` của một `Doctor`
thông qua bảng trung gian `doctor_assignments`, đúng với schema mới.

### b. Thêm helper `firstOrCreateAssignment()` trong `Doctor.php`

Các form nhập liệu cũ (thêm/sửa thông tin bác sĩ) chưa thu thập facility/specialization,
nhưng `doctor_assignments.facility_specialization_id` lại bắt buộc (NOT NULL). Helper này
tự lấy assignment có sẵn của bác sĩ, hoặc tự tạo 1 assignment mặc định (khớp theo
`expertise`, nếu không khớp thì lấy facility_specialization đang Active đầu tiên) để các
form cũ vẫn lưu được lịch làm việc mà không cần sửa giao diện.

### c. Cập nhật `app/Models/DoctorSchedule.php`

- `fillable`: đổi `doctor_id` → `doctor_assignment_id`.
- Quan hệ `doctor()` (belongsTo cột không tồn tại) đổi thành `doctorAssignment()`.

### d. Cập nhật các Controller còn dùng `doctor_id` trực tiếp

| File | Hàm | Thay đổi |
|---|---|---|
| `DoctorController.php` | `saveDoctorDetails`, `saveEditedDoctorDetails` | Lấy `$assignment = $doctor->firstOrCreateAssignment()`, tạo/xóa `DoctorSchedule` theo `doctor_assignment_id` thay vì `doctor_id` |
| `AdminController.php` | `saveDoctorDetails`, `saveThisDoctorDetails` | Tương tự như trên |
| `LocalController.php` | `getDoctorListForFilter` | Đổi truy vấn `DoctorSchedule::where('doctor_id', ...)` sang dùng quan hệ `$details->schedules` |

## 4. Cách đã kiểm tra

- Chạy `php artisan route:list` để xác nhận Laravel boot thành công sau khi sửa model.
- Viết script tạm bootstrap Laravel, gọi:
  - `Doctor::find(201)->firstOrCreateAssignment()` → trả về đúng assignment có sẵn.
  - Tạo mới 1 `DoctorSchedule` gắn với `doctor_assignment_id` đó → thành công.
  - `$doctor->load('schedules')->schedules->count()` → đếm đúng số lịch (bao gồm lịch vừa tạo).
  - Xóa lịch vừa tạo → thành công.
- Xóa file script tạm sau khi xác nhận.

## 5. Lưu ý còn lại

Helper `firstOrCreateAssignment()` chỉ là giải pháp tương thích tạm thời để không vỡ
luồng cũ. Về lâu dài, nên cập nhật giao diện "Thêm/Sửa thông tin bác sĩ" để admin/bác sĩ
tự chọn **Facility** và **Specialization** thay vì để hệ thống tự chọn mặc định.
