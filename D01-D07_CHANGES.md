# D01–D07 — File/Function Map & Changes Summary

Tài liệu này liệt kê: (1) các file/hàm liên quan tới từng hạng mục D01–D07,
(2) những thay đổi đã thực hiện so với code gốc, để phục vụ review & commit.

> Phạm vi thay đổi: chỉ sửa code cần thiết để test chạy được và để vá các lỗi
> thật phát hiện qua test. Không có thay đổi UI/UX ngoài phạm vi cần thiết.

---

## 0. Hạ tầng test (không thuộc D nào riêng, nhưng cần cho tất cả)

Trước khi có thay đổi này, `php artisan test` không chạy được vì DB test
(SQLite `:memory:`) chỉ có 3 migration gốc (`users`, `cache`, `jobs`), trong
khi ứng dụng dùng ~15 bảng khác chỉ tồn tại trong
`database/mediconnect_complete_final.sql` (dump MySQL, không phải migration).

### File mới

| File                                                                                | Mục đích                                                                                                                      |
| ----------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------- |
| `database/migrations/2024_01_01_000000_create_cities_table.php`                     | Bảng `cities`                                                                                                                 |
| `database/migrations/2024_01_01_000001_add_profile_fields_to_users_table.php`       | Thêm `city_id, address, date_of_birth, gender, profile_picture, account_status, email_verified_at, last_login_at` vào `users` |
| `database/migrations/2024_01_01_000002_create_facilities_table.php`                 | Bảng `facilities`                                                                                                             |
| `database/migrations/2024_01_01_000003_create_specializations_table.php`            | Bảng `specializations`                                                                                                        |
| `database/migrations/2024_01_01_000004_create_facility_specializations_table.php`   | Bảng `facility_specializations`                                                                                               |
| `database/migrations/2024_01_01_000005_create_patient_profiles_table.php`           | Bảng `patient_profiles`                                                                                                       |
| `database/migrations/2024_01_01_000006_create_doctors_table.php`                    | Bảng `doctors`                                                                                                                |
| `database/migrations/2024_01_01_000007_create_doctor_assignments_table.php`         | Bảng `doctor_assignments`                                                                                                     |
| `database/migrations/2024_01_01_000008_create_doctor_schedules_table.php`           | Bảng `doctor_schedules`                                                                                                       |
| `database/migrations/2024_01_01_000009_create_doctor_schedule_exceptions_table.php` | Bảng `doctor_schedule_exceptions`                                                                                             |
| `database/migrations/2024_01_01_000010_create_doctor_appointment_slots_table.php`   | Bảng `doctor_appointment_slots`                                                                                               |
| `database/migrations/2024_01_01_000011_create_appointments_table.php`               | Bảng `appointments`                                                                                                           |
| `database/migrations/2024_01_01_000012_create_appointment_histories_table.php`      | Bảng `appointment_histories`                                                                                                  |
| `database/migrations/2024_01_01_000013_create_notifications_table.php`              | Bảng `notifications` (Laravel database notifications)                                                                         |
| `database/migrations/2024_01_01_000014_create_medical_contents_table.php`           | Bảng `medical_contents`                                                                                                       |
| `database/migrations/2024_01_01_000015_create_contact_messages_table.php`           | Bảng `contact_messages`                                                                                                       |
| `tests/Feature/Concerns/CreatesAppointmentFixtures.php`                             | Trait dùng chung để tạo nhanh City/Facility/Specialization/FacilitySpecialization/Doctor/Assignment/Slot trong test           |

### File đã sửa

| File                                 | Thay đổi                                                                                                                                              |
| ------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------- |
| `database/factories/UserFactory.php` | Thêm `number`, `user_type` (`Patient`), `account_status` (`Active`) vào `definition()` — cột `number` là `NOT NULL` nên factory cũ tạo user sẽ lỗi DB |
| `tests/Feature/ExampleTest.php`      | Bỏ comment, bật lại `use RefreshDatabase;` — test gốc không migrate DB nên luôn lỗi 500                                                               |

---

## D01 — Add City to Doctor

**Chức năng:** bác sĩ/admin gán `city_id` cho user bác sĩ khi tạo/sửa hồ sơ.

| File                                                                                             | Hàm liên quan                                                                           |
| ------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------- |
| `app/Models/City.php`                                                                            | Model `City`                                                                            |
| `app/Models/User.php`                                                                            | Quan hệ `city()`                                                                        |
| `app/Http/Controllers/DoctorController.php`                                                      | `saveDoctorDetails()`, `getEditDoctorForm()`, `saveEditedDoctorDetails()`               |
| `app/Http/Controllers/AdminController.php`                                                       | `saveDoctorDetails()`, `getAdminEditDoctorDetailsFormData()`, `saveThisDoctorDetails()` |
| `resources/views/doctor/DoctorEditProfileForm.blade.php`, `DoctorDetailsForm.blade.php`          | Dropdown chọn city                                                                      |
| `resources/views/admin/AdminEditDoctorDetailsForm.blade.php`, `AdminDoctorDetailsForm.blade.php` | Dropdown chọn city                                                                      |

**Test:** `tests/Feature/D01_AddCityToDoctorTest.php` (5 test case)

- Set city khi sửa hồ sơ, bỏ trống city để xóa, `city_id` không tồn tại bị validation chặn,
  form sửa chỉ liệt kê city `Active`, và graceful-fail khi thiếu dữ liệu facility/specialization
  (xem mục "Bug đã sửa" bên dưới).

**Không có thay đổi code nghiệp vụ** cho D01 — chỉ cần hạ tầng migration ở mục 0
để test chạy được.

---

## D02 — Improve Availability Scheduling

**Chức năng:** bác sĩ khai báo lịch làm việc (`DoctorSchedule`) → hệ thống tự
sinh các slot khám (`DoctorAppointmentSlot`) qua `DoctorSchedule::generateSlots()`.

| File                                        | Hàm liên quan                                                                                       |
| ------------------------------------------- | --------------------------------------------------------------------------------------------------- |
| `app/Models/DoctorSchedule.php`             | `generateSlots()`                                                                                   |
| `app/Models/DoctorAppointmentSlot.php`      | Model slot                                                                                          |
| `app/Http/Controllers/DoctorController.php` | `saveDoctorDetails()`, `saveEditedDoctorDetails()` (tạo `DoctorSchedule` rồi gọi `generateSlots()`) |
| `app/Http/Controllers/AdminController.php`  | `saveDoctorDetails()`, `saveThisDoctorDetails()` (tương tự)                                         |

**Test:** `tests/Unit/D02_DoctorScheduleGenerateSlotsTest.php` (4 test case)

### 🐞 Bug đã sửa — `app/Models/DoctorSchedule.php`

1. **Không sinh slot nào cả (nghiêm trọng):** model không có giá trị mặc định
   cho `is_available`. Khi `DoctorSchedule::create([...])` không truyền field
   này (đúng như cách `DoctorController`/`AdminController` đang gọi), thuộc
   tính in-memory là `null` ngay sau khi tạo → `generateSlots()` gặp
   `if (!$this->is_available) return;` và thoát ngay lập tức. Kết quả: **không
   bao giờ có slot khám nào được tạo** khi bác sĩ khai báo lịch qua ứng dụng.
    - **Fix:** thêm `protected $attributes = ['is_available' => true];` để khớp
      với `DEFAULT 1` của cột DB.
2. **Không idempotent (double-run gây crash):** `generateSlots()` dùng
   `firstOrCreate(['slot_date' => $date->format('Y-m-d'), ...])` — chuỗi ngày
   thô, trong khi cast `date` trên SQLite lưu kèm giờ (`Y-m-d H:i:s`), khiến
   `firstOrCreate()` không nhận diện được bản ghi đã tồn tại → gọi `create()`
   lần 2 và vi phạm unique constraint.
    - **Fix:** thay bằng kiểm tra tồn tại bằng `whereDate('slot_date', ...)`
      rồi mới `create()` nếu chưa có.

---

## D03 — New Booking Notification

**Chức năng:** bệnh nhân đặt lịch → nhận `AppointmentBookedNotification`.

| File                                                    | Hàm liên quan                                                                    |
| ------------------------------------------------------- | -------------------------------------------------------------------------------- |
| `app/Notifications/AppointmentBookedNotification.php`   | Nội dung thông báo                                                               |
| `app/Http/Controllers/AppointmentBookingController.php` | `store()` → gọi `$user->notify(new AppointmentBookedNotification($appointment))` |

**Test:** `tests/Feature/D03_NewBookingNotificationTest.php` (2 test case) —
đặt lịch thành công gửi notification + slot đã bị người khác đặt thì không
gửi notification nào (dùng `Notification::fake()`).

**Không có thay đổi code nghiệp vụ.**

---

## D04 — Reschedule Notification

**Chức năng:** bệnh nhân đổi lịch hẹn → nhận `AppointmentRescheduledNotification`.

| File                                                       | Hàm liên quan                                                                                                         |
| ---------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------- |
| `app/Notifications/AppointmentRescheduledNotification.php` | Nội dung thông báo                                                                                                    |
| `app/Http/Controllers/AppointmentManagementController.php` | `rescheduleForm()`, `reschedule()` → gọi `Auth::user()->notify(new AppointmentRescheduledNotification($appointment))` |

**Test:** `tests/Feature/D04_RescheduleNotificationTest.php` (2 test case) —
đổi lịch thành công gửi notification + không cho đổi sang slot của bác sĩ khác
(và không gửi notification khi bị từ chối).

**Không có thay đổi code nghiệp vụ.**

---

## D05 — Cancellation Notification

**Chức năng:** bệnh nhân hủy lịch hẹn → nhận `AppointmentCancelledNotification`.

| File                                                       | Hàm liên quan                                                                                               |
| ---------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------- |
| `app/Notifications/AppointmentCancelledNotification.php`   | Nội dung thông báo                                                                                          |
| `app/Http/Controllers/AppointmentManagementController.php` | `cancelForm()`, `cancel()` → gọi `Auth::user()->notify(new AppointmentCancelledNotification($appointment))` |

**Test:** `tests/Feature/D05_CancellationNotificationTest.php` (3 test case) —
hủy thành công gửi notification, không hủy được appointment đã `Completed`,
và một bệnh nhân không thể hủy appointment của người khác (404, không gửi
notification).

**Không có thay đổi code nghiệp vụ.**

---

## D06 — Search/Filter Appointments

**Chức năng:** Admin xem/tìm/lọc danh sách lịch hẹn.

| File                                                | Hàm liên quan                                       |
| --------------------------------------------------- | --------------------------------------------------- |
| `app/Http/Controllers/AdminController.php`          | `getAppointmentPage()`, `updateAppointmentStatus()` |
| `resources/views/admin/AdminAppointments.blade.php` | Danh sách + form tìm/lọc                            |

**Test:** `tests/Feature/D06_SearchFilterAppointmentsTest.php` (4 test case)

### 🐞 Bug đã sửa

1. **Trang danh sách appointment của Admin luôn crash 500 (nghiêm trọng):**
   `getAppointmentPage()` gọi `Appointments::with(['patient', 'doctor.user'])`
   nhưng model `Appointments` **không có** quan hệ `doctor` (chỉ có
   `doctorAssignment`) → `RelationNotFoundException`.
    - **Fix:** đổi thành `with(['patient', 'doctorAssignment.doctor.user'])`.
2. **Chưa có tính năng search/filter (đúng yêu cầu D06):** `getAppointmentPage()`
   trước đó chỉ `paginate(8)`, không nhận tham số nào.
    - **Fix:** thêm filter theo `status` (query `?status=`) và search theo
      `appointment_number`/`patient_name` (query `?search=`), giữ pagination
      kèm `withQueryString()`.
3. **View dùng field/trạng thái đã lỗi thời:** `AdminAppointments.blade.php`
   tham chiếu `$app->name`, `$app->day`, `$app->date`, `$app->time`,
   `$app->doctor->user->name` (không còn tồn tại sau khi đổi schema) và các
   trạng thái `Approved`/`Cancel` không có trong enum hiện tại
   (`Pending|Confirmed|Rejected|Cancelled|Completed|NoShow`).
    - **Fix:** cập nhật sang field thật (`appointment_number`, `patient_name`,
      `doctorAssignment.doctor.user.name`, `appointment_date`, `start_time`),
      sửa nhãn/trạng thái nút hành động cho khớp enum, thêm form tìm/lọc GET.
4. `updateAppointmentStatus()` trước đó không validate `status` — có thể ghi
   một chuỗi bất kỳ vào cột enum.
    - **Fix:** thêm `$req->validate([...'status' => 'required|in:Pending,Confirmed,Rejected,Cancelled,Completed,NoShow'])`,
      dùng `findOrFail` thay vì `find()` im lặng, redirect về đúng trang
      `Admin/Appointments` thay vì `Admin/AdminDashboard`.

---

## D07 — Fix Doctor Authorization (IDOR)

**Chức năng:** đảm bảo bác sĩ chỉ thao tác được trên dữ liệu của chính mình.

| File                                        | Hàm liên quan                                                                                                            |
| ------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| `app/Http/Controllers/DoctorController.php` | `saveDoctorDetails()`, `getEditDoctorForm()`, `saveEditedDoctorDetails()`, `deleteDoctor()`, `updateAppointmentStatus()` |

**Test:** `tests/Feature/D07_DoctorAuthorizationTest.php` (6 test case)

### 🐞 Lỗ hổng bảo mật đã sửa (IDOR — Insecure Direct Object Reference)

Trước đây, các route dưới middleware `isDoctor` chỉ kiểm tra "đã đăng nhập với
vai trò Doctor", **không kiểm tra quyền sở hữu dữ liệu**:

| Hàm                         | Vấn đề trước khi sửa                                                                                                                                 | Cách sửa                                                                                                                      |
| --------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------- |
| `getEditDoctorForm($id)`    | Nhận `$id` từ URL, load hồ sơ của **bất kỳ** bác sĩ nào                                                                                              | Thêm `abort_unless((int) $id === Auth::id(), 403);`                                                                           |
| `saveEditedDoctorDetails()` | Dùng `User::find($req->user_id)` và `Doctor::find($req->id)` — 2 field client tự gửi lên, có thể sửa hồ sơ **bác sĩ khác**                           | Bỏ qua `user_id`/`id` từ request, luôn dùng `User::find(Auth::id())` và `Doctor::where('user_id', Auth::id())->firstOrFail()` |
| `deleteDoctor($id)`         | `User::find($id)->delete()` — bác sĩ A có thể **xóa vĩnh viễn tài khoản** bác sĩ B (hoặc bất kỳ user nào) chỉ bằng đổi URL                           | Thêm `abort_unless((int) $id === Auth::id(), 403);` trước khi xóa                                                             |
| `saveDoctorDetails()`       | Dùng `$req->user_id` để gán `city_id` và tạo `Doctor` — có thể tạo hồ sơ bác sĩ gắn vào **user khác**                                                | Đổi sang `Auth::id()` cho cả `User::where('id', ...)` và `Doctor::create(['user_id' => ...])`                                 |
| `updateAppointmentStatus()` | _(đã có sẵn kiểm tra, không đổi)_ — đã lọc theo `whereHas('doctorAssignment', fn($q) => $q->where('doctor_id', $doctor->id))` nên không bị ảnh hưởng | —                                                                                                                             |

**Lưu ý:** đây là lỗ hổng bảo mật thật (không chỉ là lỗi logic) — bất kỳ tài
khoản Doctor nào cũng có thể chiếm quyền/xóa tài khoản Doctor khác trước khi
sửa.

---

## Bug chung khác (không thuộc D nào cụ thể nhưng phát hiện qua test)

`app/Models/Doctor.php::firstOrCreateAssignment()` — hàm helper được gọi từ
cả 4 chỗ (`DoctorController::saveDoctorDetails/saveEditedDoctorDetails`,
`AdminController::saveDoctorDetails/saveThisDoctorDetails`) để tự tạo
`DoctorAssignment` mặc định. Nếu hệ thống **chưa có `FacilitySpecialization`
nào ở trạng thái Active** phù hợp, biến `$facilitySpecialization` là `null`,
và dòng `$facilitySpecialization->id` gây crash
`Attempt to read property "id" on null` (lỗi 500 không rõ nguyên nhân).

- **Fix (`app/Models/Doctor.php`):** thêm kiểm tra `null` và ném
  `RuntimeException` với thông báo rõ ràng: _"Cannot save working schedule: no
  active facility/specialization is configured yet. Please ask an
  administrator to set up at least one active facility and specialization
  first."_
- **Fix (4 điểm gọi ở `DoctorController.php` và `AdminController.php`):** bọc
  `try { ... } catch (\RuntimeException $e) { return redirect(...)->with('infoError'/'doctorDetailsAddError', $e->getMessage()); }`
  để người dùng thấy thông báo lỗi thân thiện thay vì trang lỗi 500.
- **Test:**
    - `tests/Unit/DoctorFirstOrCreateAssignmentTest.php` — xác nhận
      `RuntimeException` với message đúng.
    - `tests/Feature/D01_AddCityToDoctorTest.php::test_saving_edited_profile_fails_gracefully_without_crashing_when_no_facility_specialization_exists`
      — xác nhận request không crash, redirect kèm `infoError`.

---

## Tổng hợp file đã thay đổi (để review diff trước khi commit)

### Code nghiệp vụ (app/)

- `app/Models/Doctor.php` — null-check + `RuntimeException` rõ ràng trong `firstOrCreateAssignment()`
- `app/Models/DoctorSchedule.php` — default `is_available = true`; `generateSlots()` dùng `whereDate()` thay vì so khớp chuỗi
- `app/Http/Controllers/DoctorController.php` — vá IDOR (D07) + bắt `RuntimeException` (D02/chung)
- `app/Http/Controllers/AdminController.php` — sửa quan hệ + thêm search/filter (D06), validate status, bắt `RuntimeException`

### View

- `resources/views/admin/AdminAppointments.blade.php` — cập nhật field/trạng thái đúng schema hiện tại, thêm form tìm/lọc (D06)

### Hạ tầng test / factory

- `database/factories/UserFactory.php`
- `tests/Feature/ExampleTest.php`
- `database/migrations/2024_01_01_0000*_*.php` (16 file mới, xem mục 0)

### Test mới (toàn bộ là file mới)

- `tests/Feature/Concerns/CreatesAppointmentFixtures.php`
- `tests/Feature/D01_AddCityToDoctorTest.php`
- `tests/Unit/D02_DoctorScheduleGenerateSlotsTest.php`
- `tests/Feature/D03_NewBookingNotificationTest.php`
- `tests/Feature/D04_RescheduleNotificationTest.php`
- `tests/Feature/D05_CancellationNotificationTest.php`
- `tests/Feature/D06_SearchFilterAppointmentsTest.php`
- `tests/Feature/D07_DoctorAuthorizationTest.php`
- `tests/Unit/DoctorFirstOrCreateAssignmentTest.php`

**Kết quả cuối:** `php artisan test` → 29 passed (83 assertions).
