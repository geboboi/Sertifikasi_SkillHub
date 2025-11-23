<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Classes;
use App\Models\Participant;
use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test class can be created.
     */
    public function test_class_can_be_created(): void
    {
        $class = Classes::create([
            'name' => 'Graphic Design',
            'description' => 'Learn graphic design basics',
            'instructor' => 'Amanda Chen'
        ]);

        $this->assertInstanceOf(Classes::class, $class);
        $this->assertEquals('Graphic Design', $class->name);
        $this->assertEquals('Amanda Chen', $class->instructor);
        $this->assertDatabaseHas('classes', [
            'name' => 'Graphic Design'
        ]);
    }

    /**
     * Test class can have multiple participants.
     */
    public function test_class_can_have_multiple_participants(): void
    {
        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $participant1 = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $participant2 = Participant::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        $class->participants()->attach([$participant1->id, $participant2->id]);

        $this->assertEquals(2, $class->participants()->count());
        $this->assertTrue($class->participants->contains($participant1));
        $this->assertTrue($class->participants->contains($participant2));
    }

    /**
     * Test deleting class cascades to enrollments.
     */
    public function test_deleting_class_cascades_to_enrollments(): void
    {
        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $participant = Participant::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        Enrollment::create([
            'participant_id' => $participant->id,
            'class_id' => $class->id,
        ]);

        $this->assertDatabaseHas('enrollments', [
            'class_id' => $class->id,
        ]);

        $class->delete();

        $this->assertDatabaseMissing('enrollments', [
            'class_id' => $class->id,
        ]);
    }

    /**
     * Test class fillable attributes.
     */
    public function test_class_fillable_attributes(): void
    {
        $class = new Classes();
        
        $expected = ['name', 'description', 'instructor'];
        
        $this->assertEquals($expected, $class->getFillable());
    }

    /**
     * Test class uses correct table name.
     */
    public function test_class_uses_correct_table_name(): void
    {
        $class = new Classes();
        
        $this->assertEquals('classes', $class->getTable());
    }

    /**
     * Test class has participants relationship.
     */
    public function test_class_has_participants_relationship(): void
    {
        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $class->participants()
        );
    }

    /**
     * Test class has enrollments relationship.
     */
    public function test_class_has_enrollments_relationship(): void
    {
        $class = Classes::create([
            'name' => 'Graphic Design',
            'instructor' => 'Amanda Chen',
        ]);

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $class->enrollments()
        );
    }
}