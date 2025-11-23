<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{

    public function index()
    {
        $classes = Classes::withCount('participants')->latest()->paginate(10);
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor' => 'required|string|max:255',
        ]);

        Classes::create($validated);

        return redirect()->route('classes.index')
                        ->with('success', 'Class created successfully.');
    }

    public function show(Classes $class)
    {
        $class->load(['participants' => function($query) {
            $query->withPivot('enrolled_at');
        }]);
        
        return view('classes.show', compact('class'));
    }

    public function edit(Classes $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor' => 'required|string|max:255',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
                        ->with('success', 'Class updated successfully.');
    }


    public function destroy(Classes $class)
    {
        // Cascade delete will automatically remove all enrollments
        $class->delete();

        return redirect()->route('classes.index')
                        ->with('success', 'Class deleted successfully.');
    }
}