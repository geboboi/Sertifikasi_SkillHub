<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{

    public function index()
    {
        $enrollments = Enrollment::with(['participant', 'class'])
                                 ->latest()
                                 ->paginate(15);
        return view('enrollments.index', compact('enrollments'));
    }


    public function create()
    {
        $participants = Participant::orderBy('name')->get();
        $classes = Classes::orderBy('name')->get();
        
        return view('enrollments.create', compact('participants', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'class_ids' => 'required|array|min:1',
            'class_ids.*' => 'exists:classes,id',
        ]);

        try {
            DB::beginTransaction();

            $participant = Participant::findOrFail($validated['participant_id']);
            
            foreach ($validated['class_ids'] as $classId) {
                // Check if already enrolled
                $exists = Enrollment::where('participant_id', $participant->id)
                                   ->where('class_id', $classId)
                                   ->exists();
                
                if (!$exists) {
                    Enrollment::create([
                        'participant_id' => $participant->id,
                        'class_id' => $classId,
                        'enrolled_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('enrollments.index')
                           ->with('success', 'Enrollment(s) created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->with('error', 'Error creating enrollment: ' . $e->getMessage())
                           ->withInput();
        }
    }


    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')
                        ->with('success', 'Enrollment cancelled successfully.');
    }


    public function participantClasses(Participant $participant)
    {
        $participant->load(['classes' => function($query) {
            $query->withPivot('enrolled_at');
        }]);
        
        return view('enrollments.participant-classes', compact('participant'));
    }


    public function classParticipants(Classes $class)
    {
        $class->load(['participants' => function($query) {
            $query->withPivot('enrolled_at');
        }]);
        
        return view('enrollments.class-participants', compact('class'));
    }
}