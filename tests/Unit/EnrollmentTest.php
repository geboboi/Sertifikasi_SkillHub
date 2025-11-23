<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Enrollment;
use App\Models\Participant;
use App\Models\Classes;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test enrollment can be created.
     */
    public function test_enrollment_can_be_created(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $enrollment = Enrollment::create([
            'participant_id' => $participant->id,
            'class_id' => $class->id,
            'enrolled_at' => now(), 
        ]);

        $this->assertInstanceOf(Enrollment::class, $enrollment);
        $this->assertEquals($participant->id, $enrollment->participant_id);
        $this->assertEquals($class->id, $enrollment->class_id);
        $this->assertDatabaseHas('enrollments', [
            'participant_id' => $participant->id,
            'class_id' => $class->id,
        ]);
    }

    /**
     * Test enrollment prevents duplicates.
     */
    public function test_enrollment_prevents_duplicates(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        Enrollment::create([
            'participant_id' => $participant->id,
            'class_id' => $class->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Enrollment::create([
            'participant_id' => $participant->id,
            'class_id' => $class->id, // Duplicate
        ]);
    }

    /**
     * Test enrollment belongs to participant.
     */
    public function test_enrollment_belongs_to_participant(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $enrollment = Enrollment::create([
            'participant_id' => $participant->id,
            'class_id' => $class->id,
        ]);

        $this->assertInstanceOf(Participant::class, $enrollment->participant);
        $this->assertEquals($participant->id, $enrollment->participant->id);
    }

    /**
     * Test enrollment belongs to class.
     */
    public function test_enrollment_belongs_to_class(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $enrollment = Enrollment::create([
            'participant_id' => $participant->id,
            'class_id' => $class->id,
        ]);

        $this->assertInstanceOf(Classes::class, $enrollment->class);
        $this->assertEquals($class->id, $enrollment->class->id);
    }

    /**
     * Test enrollment fillable attributes.
     */
    public function test_enrollment_fillable_attributes(): void
    {
        $enrollment = new Enrollment();
        
        $expected = ['participant_id', 'class_id', 'enrolled_at'];
        
        $this->assertEquals($expected, $enrollment->getFillable());
    }

    /**
     * Test enrollment has enrolled_at timestamp.
     */
    public function test_enrollment_has_enrolled_at_timestamp(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $enrollment = Enrollment::create([
            'participant_id' => $participant->id,
            'class_id' => $class->id,
            'enrolled_at' => now(),
        ]);

        $this->assertNotNull($enrollment->enrolled_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $enrollment->enrolled_at);
    }
}