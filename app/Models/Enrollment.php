<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    /** @use HasFactory<\Database\Factories\EnrollmentFactory> */
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'class_id',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    /**
     * Get the participant that owns the enrollment.
     */
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    /**
     * Get the class that owns the enrollment.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
