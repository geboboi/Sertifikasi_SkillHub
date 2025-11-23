@extends('layouts.app')

@section('title', 'New Enrollment - SkillHub')

@section('content')
<div class="mb-6">
    <a href="{{ route('enrollments.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Enrollments
    </a>
    <h1 class="text-3xl font-bold text-gray-900 mt-2">Enroll Participant to Class</h1>
    <p class="mt-1 text-sm text-gray-600">Select a participant and one or more classes to enroll</p>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <form action="{{ route('enrollments.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="space-y-6">
            <!-- Select Participant -->
            <div>
                <label for="participant_id" class="block text-sm font-medium text-gray-700">Select Participant *</label>
                <select name="participant_id" 
                        id="participant_id" 
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('participant_id') border-red-500 @enderror">
                    <option value="">Choose a participant...</option>
                    @foreach($participants as $participant)
                    <option value="{{ $participant->id }}" {{ old('participant_id') == $participant->id ? 'selected' : '' }}>
                        {{ $participant->name }} ({{ $participant->email }})
                    </option>
                    @endforeach
                </select>
                @error('participant_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                @if($participants->count() == 0)
                <p class="mt-2 text-sm text-amber-600">
                    No participants available. 
                    <a href="{{ route('participants.create') }}" class="font-medium underline">Create a participant first</a>
                </p>
                @endif
            </div>

            <!-- Select Classes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Classes * (Can select multiple)</label>
                <div class="space-y-2 max-h-64 overflow-y-auto border border-gray-300 rounded-md p-4">
                    @forelse($classes as $class)
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" 
                                   name="class_ids[]" 
                                   id="class_{{ $class->id }}" 
                                   value="{{ $class->id }}"
                                   {{ is_array(old('class_ids')) && in_array($class->id, old('class_ids')) ? 'checked' : '' }}
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="class_{{ $class->id }}" class="font-medium text-gray-700 cursor-pointer">
                                {{ $class->name }}
                            </label>
                            <p class="text-gray-500">Instructor: {{ $class->instructor }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-amber-600">
                        No classes available. 
                        <a href="{{ route('classes.create') }}" class="font-medium underline">Create a class first</a>
                    </p>
                    @endforelse
                </div>
                @error('class_ids')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('class_ids.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($participants->count() > 0 && $classes->count() > 0)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Note:</strong> You can enroll a participant to multiple classes at once. 
                            If the participant is already enrolled in a selected class, that enrollment will be skipped.
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('enrollments.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    {{ ($participants->count() == 0 || $classes->count() == 0) ? 'disabled' : '' }}>
                Create Enrollment
            </button>
        </div>
    </form>
</div>
@endsection