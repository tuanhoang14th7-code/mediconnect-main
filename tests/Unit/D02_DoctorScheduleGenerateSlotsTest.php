<?php

namespace Tests\Unit;

use App\Models\Doctor;
use App\Models\DoctorAppointmentSlot;
use App\Models\DoctorAssignment;
use App\Models\DoctorSchedule;
use App\Models\Facility;
use App\Models\FacilitySpecialization;
use App\Models\Specialization;
use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * D02 - Improve Availability scheduling.
 */
class D02_DoctorScheduleGenerateSlotsTest extends TestCase
{
    use RefreshDatabase;

    private function makeAssignment(): DoctorAssignment
    {
        $user = User::factory()->create(['user_type' => 'Doctor']);
        $doctor = Doctor::create([
            'image' => 'person1.jpg',
            'user_id' => $user->id,
            'expertise' => 'Dermatology',
            'experience' => 5,
            'education' => 'MBBS',
            'profession' => 'Skin Specialist',
        ]);
        $city = City::create(['name' => 'Hanoi', 'country' => 'Vietnam', 'status' => 'Active']);
        $facility = Facility::create([
            'city_id' => $city->id,
            'name' => 'Facility',
            'code' => 'F1',
            'address' => 'Somewhere',
            'phone' => '0123456789',
            'status' => 'Active',
        ]);
        $specialization = Specialization::create(['name' => 'Dermatology', 'slug' => 'dermatology', 'status' => 'Active']);
        $facilitySpecialization = FacilitySpecialization::create([
            'facility_id' => $facility->id,
            'specialization_id' => $specialization->id,
            'status' => 'Active',
        ]);

        return $doctor->assignments()->create([
            'facility_specialization_id' => $facilitySpecialization->id,
            'status' => 'Active',
        ]);
    }

    public function test_generate_slots_creates_slots_only_on_matching_weekday_within_range(): void
    {
        $assignment = $this->makeAssignment();

        // Find the next Monday to make the test date-independent.
        $validFrom = today()->next('Monday');
        $validUntil = $validFrom->copy()->addDays(13); // covers 2 Mondays

        $schedule = DoctorSchedule::create([
            'doctor_assignment_id' => $assignment->id,
            'day' => 'Monday',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'slot_duration_minutes' => 30,
            'valid_from' => $validFrom->format('Y-m-d'),
            'valid_until' => $validUntil->format('Y-m-d'),
        ]);

        $schedule->generateSlots();

        $slots = DoctorAppointmentSlot::where('doctor_assignment_id', $assignment->id)->orderBy('slot_date')->get();

        // 1 hour / 30 minutes = 2 slots per Monday, 2 Mondays in range.
        $this->assertCount(4, $slots);
        foreach ($slots as $slot) {
            $this->assertSame('Monday', $slot->slot_date->format('l'));
        }
    }

    public function test_generate_slots_does_nothing_when_schedule_is_not_available(): void
    {
        $assignment = $this->makeAssignment();

        $schedule = DoctorSchedule::create([
            'doctor_assignment_id' => $assignment->id,
            'day' => 'Monday',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'slot_duration_minutes' => 30,
            'is_available' => false,
        ]);

        $schedule->generateSlots();

        $this->assertSame(0, DoctorAppointmentSlot::where('doctor_assignment_id', $assignment->id)->count());
    }

    public function test_generate_slots_is_idempotent_when_called_twice(): void
    {
        $assignment = $this->makeAssignment();

        $validFrom = today()->next('Monday');

        $schedule = DoctorSchedule::create([
            'doctor_assignment_id' => $assignment->id,
            'day' => 'Monday',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'slot_duration_minutes' => 30,
            'valid_from' => $validFrom->format('Y-m-d'),
            'valid_until' => $validFrom->format('Y-m-d'),
        ]);

        $schedule->generateSlots();
        $schedule->generateSlots();

        $this->assertSame(2, DoctorAppointmentSlot::where('doctor_assignment_id', $assignment->id)->count());
    }

    public function test_generate_slots_skips_past_dates_and_starts_from_today(): void
    {
        $assignment = $this->makeAssignment();

        $schedule = DoctorSchedule::create([
            'doctor_assignment_id' => $assignment->id,
            'day' => today()->format('l'),
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'slot_duration_minutes' => 30,
            'valid_from' => today()->subDays(10)->format('Y-m-d'),
            'valid_until' => today()->format('Y-m-d'),
        ]);

        $schedule->generateSlots();

        $slots = DoctorAppointmentSlot::where('doctor_assignment_id', $assignment->id)->get();

        foreach ($slots as $slot) {
            $this->assertTrue($slot->slot_date->gte(today()));
        }
    }
}
