<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classes extends Model
{
    /** @use HasFactory<\Database\Factories\ClassesFactory> */
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'description',
        'instructor',
    ];

    /**
     * Get the participants enrolled in this class.
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Participant::class, 'enrollments', 'class_id', 'participant_id')
                    ->withTimestamps()
                    ->withPivot('enrolled_at');
    }

    /**
     * Get all enrollments for this class.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }
}
