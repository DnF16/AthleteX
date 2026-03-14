<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceSystemTest extends TestCase
{
    use RefreshDatabase;

    protected $coach;
    protected $coachUser;
    protected $athlete;

    protected function setUp(): void
    {
        parent::setUp();

        // Create coach and user
        $this->coach = Coach::create([
            'coach_first_name' => 'John',
            'coach_last_name' => 'Smith',
        ]);

        $this->coachUser = User::factory()->create([
            'role' => 'coach',
            'coach_id' => $this->coach->id,
        ]);

        // Create athlete assigned to coach
        $this->athlete = Athlete::create([
            'student_id' => 'S001',
            'first_name' => 'Alice',
            'last_name' => 'Johnson',
            'coach_id' => $this->coach->id,
        ]);
    }

    /** @test */
    public function coach_can_check_attendance_for_today()
    {
        $response = $this->actingAs($this->coachUser)
            ->get(route('coach.attendance.index'));

        $response->assertStatus(200);
        $response->assertViewHas('today', Carbon::today()->toDateString());
        $response->assertViewHas('athletesWithStatus');
    }

    /** @test */
    public function attendance_can_only_be_recorded_for_today()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        $response = $this->actingAs($this->coachUser)
            ->post(route('coach.attendance.store'), [
                'attendance_date' => $yesterday,
                'attendance' => [
                    $this->athlete->id => ['status' => 'present', 'remarks' => ''],
                ],
            ]);

        $response->assertSessionHasErrors('attendance_date');
        $this->assertDatabaseMissing('attendances', [
            'athlete_id' => $this->athlete->id,
            'date' => $yesterday,
        ]);
    }

    /** @test */
    public function attendance_is_stored_with_coach_id_and_remarks()
    {
        $today = Carbon::today()->toDateString();

        $this->actingAs($this->coachUser)
            ->post(route('coach.attendance.store'), [
                'attendance_date' => $today,
                'attendance' => [
                    $this->athlete->id => ['status' => 'late', 'remarks' => 'Traffic'],
                ],
            ]);

        $this->assertDatabaseHas('attendances', [
            'athlete_id' => $this->athlete->id,
            'date' => $today,
            'status' => 'late',
            'remarks' => 'Traffic',
            'coach_id' => $this->coach->id,
        ]);
    }

    /** @test */
    public function attendance_status_can_be_updated()
    {
        $today = Carbon::today()->toDateString();

        // Create initial attendance
        Attendance::create([
            'athlete_id' => $this->athlete->id,
            'date' => $today,
            'status' => 'present',
            'remarks' => '',
            'coach_id' => $this->coach->id,
        ]);

        // Update attendance
        $this->actingAs($this->coachUser)
            ->post(route('coach.attendance.store'), [
                'attendance_date' => $today,
                'attendance' => [
                    $this->athlete->id => ['status' => 'absent', 'remarks' => 'Sick'],
                ],
            ]);

        $this->assertDatabaseHas('attendances', [
            'athlete_id' => $this->athlete->id,
            'date' => $today,
            'status' => 'absent',
            'remarks' => 'Sick',
        ]);
    }

    /** @test */
    public function all_four_attendance_statuses_are_supported()
    {
        $statuses = ['present', 'absent', 'late', 'excused'];

        foreach ($statuses as $status) {
            $attendance = Attendance::create([
                'athlete_id' => $this->athlete->id,
                'date' => Carbon::today()->addDays(1)->toDateString(),
                'status' => $status,
                'coach_id' => $this->coach->id,
            ]);

            $this->assertEquals($status, $attendance->status);
            $attendance->delete();
        }
    }

    /** @test */
    public function past_attendance_records_go_to_history()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        Attendance::create([
            'athlete_id' => $this->athlete->id,
            'date' => $yesterday,
            'status' => 'present',
            'coach_id' => $this->coach->id,
        ]);

        $response = $this->actingAs($this->coachUser)
            ->get(route('attendance.history'));

        $response->assertStatus(200);
        $response->assertViewHas('attendanceMap');
        
        // Verify the record exists
        $key = $this->athlete->id . '_' . $yesterday;
        $this->assertArrayHasKey($key, $response->viewData('attendanceMap'));
    }

    /** @test */
    public function attendance_is_marked_as_editable_only_for_today()
    {
        $today = Carbon::today()->toDateString();

        $response = $this->actingAs($this->coachUser)
            ->get(route('coach.attendance.index'));

        // Check that athletes have isEditable flag for today
        $athletesWithStatus = $response->viewData('athletesWithStatus');
        $this->assertTrue($athletesWithStatus[0]['isEditable']);
    }
}
