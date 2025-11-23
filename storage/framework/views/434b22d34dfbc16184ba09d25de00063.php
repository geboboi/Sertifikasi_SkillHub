<?php $__env->startSection('title', 'New Enrollment - SkillHub'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('enrollments.index')); ?>" class="text-indigo-600 hover:text-indigo-900 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Enrollments
    </a>
    <h1 class="text-3xl font-bold text-gray-900 mt-2">Enroll Participant to Class</h1>
    <p class="mt-1 text-sm text-gray-600">Select a participant and one or more classes to enroll</p>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <form action="<?php echo e(route('enrollments.store')); ?>" method="POST" class="p-6">
        <?php echo csrf_field(); ?>
        
        <div class="space-y-6">
            <!-- Select Participant -->
            <div>
                <label for="participant_id" class="block text-sm font-medium text-gray-700">Select Participant *</label>
                <select name="participant_id" 
                        id="participant_id" 
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 <?php $__errorArgs = ['participant_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Choose a participant...</option>
                    <?php $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($participant->id); ?>" <?php echo e(old('participant_id') == $participant->id ? 'selected' : ''); ?>>
                        <?php echo e($participant->name); ?> (<?php echo e($participant->email); ?>)
                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['participant_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                
                <?php if($participants->count() == 0): ?>
                <p class="mt-2 text-sm text-amber-600">
                    No participants available. 
                    <a href="<?php echo e(route('participants.create')); ?>" class="font-medium underline">Create a participant first</a>
                </p>
                <?php endif; ?>
            </div>

            <!-- Select Classes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Classes * (Can select multiple)</label>
                <div class="space-y-2 max-h-64 overflow-y-auto border border-gray-300 rounded-md p-4">
                    <?php $__empty_1 = true; $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" 
                                   name="class_ids[]" 
                                   id="class_<?php echo e($class->id); ?>" 
                                   value="<?php echo e($class->id); ?>"
                                   <?php echo e(is_array(old('class_ids')) && in_array($class->id, old('class_ids')) ? 'checked' : ''); ?>

                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="class_<?php echo e($class->id); ?>" class="font-medium text-gray-700 cursor-pointer">
                                <?php echo e($class->name); ?>

                            </label>
                            <p class="text-gray-500">Instructor: <?php echo e($class->instructor); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-amber-600">
                        No classes available. 
                        <a href="<?php echo e(route('classes.create')); ?>" class="font-medium underline">Create a class first</a>
                    </p>
                    <?php endif; ?>
                </div>
                <?php $__errorArgs = ['class_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['class_ids.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <?php if($participants->count() > 0 && $classes->count() > 0): ?>
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
            <?php endif; ?>
        </div>

        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="<?php echo e(route('enrollments.index')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    <?php echo e(($participants->count() == 0 || $classes->count() == 0) ? 'disabled' : ''); ?>>
                Create Enrollment
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gabrielajs/sertifikasi/resources/views/enrollments/create.blade.php ENDPATH**/ ?>