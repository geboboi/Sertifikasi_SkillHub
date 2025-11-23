<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\ParticipantFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Get the classes that the participant is enrolled in.
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'enrollments', 'participant_id', 'class_id')
                    ->withTimestamps()
                    ->withPivot('enrolled_at');
    }

    /**
     * Get all enrollments for this participant.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
