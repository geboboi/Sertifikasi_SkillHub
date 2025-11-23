<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Participant;
use App\Models\Classes;
use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test participant can be created.
     */
    public function test_participant_can_be_created(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta'
        ]);

        $this->assertInstanceOf(Participant::class, $participant);
        $this->assertEquals('John Doe', $participant->name);
        $this->assertEquals('john@example.com', $participant->email);
        $this->assertDatabaseHas('participants', [
            'email' => 'john@example.com'
        ]);
    }

    /**
     * Test participant email must be unique.
     */
    public function test_participant_email_must_be_unique(): void
    {
        Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Participant::create([
            'name' => 'Jane Doe',
            'email' => 'john@example.com', // Duplicate email
        ]);
    }

    /**
     * Test participant can have multiple classes.
     */
    public function test_participant_can_have_multiple_classes(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $class1 = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $class2 = Classes::create([
            'name' => 'Web Development',
            'instructor' => 'Robert Martinez',
        ]);

        $participant->classes()->attach([$class1->id, $class2->id]);

        $this->assertEquals(2, $participant->classes()->count());
        $this->assertTrue($participant->classes->contains($class1));
        $this->assertTrue($participant->classes->contains($class2));
    }

    /**
     * Test deleting participant cascades to enrollments.
     */
    public function test_deleting_participant_cascades_to_enrollments(): void
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

        $this->assertDatabaseHas('enrollments', [
            'participant_id' => $participant->id,
        ]);

        $participant->delete();

        $this->assertDatabaseMissing('enrollments', [
            'participant_id' => $participant->id,
        ]);
    }

    /**
     * Test participant fillable attributes.
     */
    public function test_participant_fillable_attributes(): void
    {
        $participant = new Participant();
        
        $expected = ['name', 'email', 'phone', 'address'];
        
        $this->assertEquals($expected, $participant->getFillable());
    }

    /**
     * Test participant has classes relationship.
     */
    public function test_participant_has_classes_relationship(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $participant->classes()
        );
    }

    /**
     * Test participant has enrollments relationship.
     */
    public function test_participant_has_enrollments_relationship(): void
    {
        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $participant->enrollments()
        );
    }
}