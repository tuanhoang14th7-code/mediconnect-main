<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\DoctorAssignment;

class DoctorSchedule extends Model
{
    protected $table = "doctor_schedules";
    // Cột doctor_id không còn tồn tại trong schema mới, lịch làm việc
    // được gắn với 1 doctor_assignment thay vì gắn trực tiếp với doctor
    protected $fillable = [
        'doctor_assignment_id',
        'day',
        'start_time',
        'end_time',
        'slot_duration_minutes',
        'valid_from',
        'valid_until',
        'is_available',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_available' => 'boolean',
    ];

    // Khớp với DEFAULT của cột DB: nếu không truyền is_available khi create(),
    // model in-memory phải mặc định true, nếu không generateSlots() sẽ thoát sớm.
    protected $attributes = [
        'is_available' => true,
    ];

    public function doctorAssignment()
    {
        return $this->belongsTo(DoctorAssignment::class, 'doctor_assignment_id');
    }

    // Sinh các DoctorAppointmentSlot còn thiếu cho khoảng ngày hợp lệ của lịch này,
    // dựa trên slot_duration_minutes. Dùng firstOrCreate để không tạo trùng slot đã có.
    public function generateSlots(int $daysAhead = 60): void
    {
        if (!$this->is_available) {
            return;
        }

        $rangeStart = $this->valid_from ? $this->valid_from->copy() : today();
        if ($rangeStart->lt(today())) {
            $rangeStart = today();
        }

        $rangeEnd = $this->valid_until
            ? $this->valid_until->copy()
            : today()->addDays($daysAhead);

        if ($rangeEnd->lt($rangeStart)) {
            return;
        }

        $weekdays = [
            'Sunday', 'Monday', 'Tuesday', 'Wednesday',
            'Thursday', 'Friday', 'Saturday',
        ];
        $dayIndex = array_search($this->day, $weekdays);

        for ($date = $rangeStart->copy(); $date->lte($rangeEnd); $date->addDay()) {
            if ((int) $date->dayOfWeek !== $dayIndex) {
                continue;
            }

            $slotStart = Carbon::parse($date->format('Y-m-d') . ' ' . $this->start_time);
            $dayEnd = Carbon::parse($date->format('Y-m-d') . ' ' . $this->end_time);

            while ($slotStart->copy()->addMinutes($this->slot_duration_minutes)->lte($dayEnd)) {
                $slotEnd = $slotStart->copy()->addMinutes($this->slot_duration_minutes);

                // Tra cứu bằng whereDate() thay vì so khớp chuỗi trực tiếp,
                // vì cast 'date' có thể lưu kèm giờ (00:00:00) tùy driver DB
                // (ví dụ SQLite), khiến firstOrCreate() không nhận ra bản ghi đã tồn tại.
                $exists = DoctorAppointmentSlot::where('doctor_assignment_id', $this->doctor_assignment_id)
                    ->whereDate('slot_date', $date->format('Y-m-d'))
                    ->where('start_time', $slotStart->format('H:i:s'))
                    ->exists();

                if (!$exists) {
                    DoctorAppointmentSlot::create([
                        'doctor_assignment_id' => $this->doctor_assignment_id,
                        'slot_date' => $date->format('Y-m-d'),
                        'start_time' => $slotStart->format('H:i:s'),
                        'doctor_schedule_id' => $this->id,
                        'end_time' => $slotEnd->format('H:i:s'),
                        'status' => 'Available',
                    ]);
                }


                $slotStart = $slotEnd;
            }
        }
    }
}
