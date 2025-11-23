<?php $__env->startSection('title', $class->name . ' - SkillHub'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('classes.index')); ?>" class="text-indigo-600 hover:text-indigo-900 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Classes
    </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900"><?php echo e($class->name); ?></h1>
            <p class="mt-1 text-sm text-gray-600">Class Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('classes.edit', $class)); ?>" 
               class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                Edit
            </a>
            <form action="<?php echo e(route('classes.destroy', $class)); ?>" 
                  method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this class?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="px-6 py-5">
        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">Instructor</dt>
                <dd class="mt-1 text-sm text-gray-900"><?php echo e($class->instructor); ?></dd>
            </div>
            
            <div>
                <dt class="text-sm font-medium text-gray-500">Total Participants</dt>
                <dd class="mt-1 text-sm text-gray-900"><?php echo e($class->participants->count()); ?> students</dd>
            </div>
            
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Description</dt>
                <dd class="mt-1 text-sm text-gray-900"><?php echo e($class->description ?? 'No description provided'); ?></dd>
            </div>
            
            <div>
                <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                <dd class="mt-1 text-sm text-gray-900"><?php echo e($class->created_at->format('F d, Y')); ?></dd>
            </div>
        </dl>
    </div>
</div>

<!-- Enrolled Participants -->
<div class="mt-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">Enrolled Participants (<?php echo e($class->participants->count()); ?>)</h2>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <?php if($class->participants->count() > 0): ?>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $class->participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900"><?php echo e($participant->name); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500"><?php echo e($participant->email); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500"><?php echo e($participant->phone ?? '-'); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500"><?php echo e(\Carbon\Carbon::parse($participant->pivot->enrolled_at)->format('M d, Y')); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="<?php echo e(route('participants.show', $participant)); ?>" 
                           class="text-indigo-600 hover:text-indigo-900">View Profile</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No participants enrolled</h3>
            <p class="mt-1 text-sm text-gray-500">This class doesn't have any enrolled participants yet.</p>
            <div class="mt-6">
                <a href="<?php echo e(route('enrollments.create')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Enroll Participant
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gabrielajs/Documents/Laravel/sertifikasi/resources/views/classes/show.blade.php ENDPATH**/ ?>