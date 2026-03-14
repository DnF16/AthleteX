<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Coach;
use App\Models\Athlete;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_coach_sees_assigned_athletes_on_attendance_page()
    {
        // create a user and coach profile
        $coachUser = User::factory()->create([
            'role' => 'coach',
        ]);

        // make a corresponding coach record and link it on the user
        $coachProfile = Coach::create([
            // minimal required fields, others can be null
            'coach_first_name' => 'Jane',
            'coach_last_name' => 'Smith',
        ]);
        $coachUser->coach_id = $coachProfile->id;
        $coachUser->save();

        // create an athlete that belongs to that coach profile
        $athlete = Athlete::create([
            'student_id' => 'STU123',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'coach_id' => $coachProfile->id,
        ]);

        // authenticate as the coach user and visit attendance
        $this->actingAs($coachUser);
        $response = $this->get(route('coach.attendance.index'));

        $response->assertStatus(200);
        $response->assertSeeText('John');
        $response->assertSeeText('Doe');
    }
}
