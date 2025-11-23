<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{

    public function index()
    {
        $participants = Participant::withCount('classes')->latest()->paginate(10);
        return view('participants.index', compact('participants'));
    }


    public function create()
    {
        return view('participants.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Participant::create($validated);

        return redirect()->route('participants.index')
                        ->with('success', 'Participant created successfully.');
    }

 
    public function show(Participant $participant)
    {
        $participant->load(['classes' => function($query) {
            $query->withPivot('enrolled_at');
        }]);
        
        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email,' . $participant->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $participant->update($validated);

        return redirect()->route('participants.index')
                        ->with('success', 'Participant updated successfully.');
    }

    public function destroy(Participant $participant)
    {
        // Cascade delete will automatically remove all enrollments
        $participant->delete();

        return redirect()->route('participants.index')
                        ->with('success', 'Participant deleted successfully.');
    }
}