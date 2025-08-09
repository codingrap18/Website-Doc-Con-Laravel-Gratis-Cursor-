<?php $__env->startSection('page-title', 'Edit Document'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Document</h1>
            <p class="text-gray-600 dark:text-gray-400">Update document information and status</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('documents.show', $document)); ?>" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Details
            </a>
            <a href="<?php echo e(route('documents.index')); ?>" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Documents
            </a>
        </div>
    </div>

    <!-- Document Info Card -->
    <div class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-lg p-6 card-3d">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold"><?php echo e($document->document_number); ?></h2>
                <p class="text-primary-100"><?php echo e($document->document_title); ?></p>
            </div>
            <div class="text-right">
                <div class="text-sm text-primary-200">Current Status</div>
                <div class="text-lg font-semibold"><?php echo e($document->getStatusDescription()); ?></div>
                <div class="text-sm text-primary-200">Revision <?php echo e($document->revision); ?></div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d">
        <form method="POST" action="<?php echo e(route('documents.update', $document)); ?>" class="p-6 space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <?php if($errors->any()): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
                <h4 class="font-medium mb-2">Please correct the following errors:</h4>
                <ul class="list-disc list-inside space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="text-sm"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Document Number -->
                <div>
                    <label for="document_number" class="form-label required">Document Number</label>
                    <input type="text"
                           id="document_number"
                           name="document_number"
                           value="<?php echo e(old('document_number', $document->document_number)); ?>"
                           placeholder="e.g., PTA-ENG-001-2024"
                           class="form-input <?php $__errorArgs = ['document_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['document_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="form-error"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Document Title -->
                <div>
                    <label for="document_title" class="form-label required">Document Title</label>
                    <input type="text"
                           id="document_title"
                           name="document_title"
                           value="<?php echo e(old('document_title', $document->document_title)); ?>"
                           placeholder="Enter document title"
                           class="form-input <?php $__errorArgs = ['document_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['document_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="form-error"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Revision -->
                <div>
                    <label for="revision" class="form-label required">Revision</label>
                    <select id="revision"
                            name="revision"
                            class="form-select <?php $__errorArgs = ['revision'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required>
                        <option value="">Select Revision</option>
                        <option value="NS" <?php echo e(old('revision', $document->revision) == 'NS' ? 'selected' : ''); ?>>NS - Not Submitted</option>
                        <option value="A" <?php echo e(old('revision', $document->revision) == 'A' ? 'selected' : ''); ?>>A - First Issue</option>
                        <option value="A1" <?php echo e(old('revision', $document->revision) == 'A1' ? 'selected' : ''); ?>>A1 - Minor Revision</option>
                        <option value="A2" <?php echo e(old('revision', $document->revision) == 'A2' ? 'selected' : ''); ?>>A2 - Minor Revision</option>
                        <option value="B" <?php echo e(old('revision', $document->revision) == 'B' ? 'selected' : ''); ?>>B - Major Revision</option>
                        <option value="C" <?php echo e(old('revision', $document->revision) == 'C' ? 'selected' : ''); ?>>C - Major Revision</option>
                        <option value="D" <?php echo e(old('revision', $document->revision) == 'D' ? 'selected' : ''); ?>>D - Major Revision</option>
                        <option value="0" <?php echo e(old('revision', $document->revision) == '0' ? 'selected' : ''); ?>>0 - For Construction</option>
                    </select>
                    <?php $__errorArgs = ['revision'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="form-error"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="form-label required">Status</label>
                    <select id="status"
                            name="status"
                            class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required>
                        <option value="">Select Status</option>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e(old('status', $document->status) == $key ? 'selected' : ''); ?>>
                            <?php echo e($key); ?> - <?php echo e($label); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="form-error"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Submission Date -->
                <div>
                    <label for="submission_date" class="form-label">Submission Date</label>
                    <input type="date"
                           id="submission_date"
                           name="submission_date"
                           value="<?php echo e(old('submission_date', $document->submission_date?->format('Y-m-d'))); ?>"
                           class="form-input <?php $__errorArgs = ['submission_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['submission_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="form-error"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="form-help">Target date: <?php echo e($document->target_date?->format('M d, Y') ?? 'Not calculated'); ?></p>
                </div>

                <!-- Latest Reviewer -->
                <div>
                    <label for="latest_reviewer_id" class="form-label">Assign Reviewer</label>
                    <select id="latest_reviewer_id"
                            name="latest_reviewer_id"
                            class="form-select <?php $__errorArgs = ['latest_reviewer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Select Reviewer</option>
                        <?php $__currentLoopData = $reviewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($reviewer->id); ?>" <?php echo e(old('latest_reviewer_id', $document->latest_reviewer_id) == $reviewer->id ? 'selected' : ''); ?>>
                            <?php echo e($reviewer->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['latest_reviewer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="form-error"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php if($document->latestReviewer): ?>
                    <p class="form-help">Current: <?php echo e($document->latestReviewer->name); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Document Position -->
            <div>
                <label for="document_position" class="form-label">Document Position</label>
                <input type="text"
                       id="document_position"
                       name="document_position"
                       value="<?php echo e(old('document_position', $document->document_position)); ?>"
                       placeholder="e.g., Main Engineering, Process Engineering, Electrical"
                       class="form-input <?php $__errorArgs = ['document_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['document_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="form-error"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Document Status Summary -->
            <?php if($document->isOverdue()): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                            Document Overdue
                        </h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            <p>This document is <?php echo e($document->getDaysOverdue()); ?> working days overdue. Target date was <?php echo e($document->target_date->format('M d, Y')); ?>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Review History -->
            <?php if($document->reviews->count() > 0): ?>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Review History</h3>
                <div class="space-y-3">
                    <?php $__currentLoopData = $document->reviews->sortByDesc('reviewed_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center text-sm">
                        <div>
                            <span class="font-medium text-gray-900 dark:text-white"><?php echo e($review->reviewer->name); ?></span>
                            <span class="text-gray-500 dark:text-gray-400">reviewed revision <?php echo e($review->revision); ?></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($review->getCommentClass()); ?>">
                                <?php echo e($review->comment); ?>

                            </span>
                            <span class="text-gray-500 dark:text-gray-400"><?php echo e($review->reviewed_at->format('M d, Y')); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Form Actions -->
            <div class="flex justify-between pt-6 border-t border-gray-200 dark:border-gray-600">
                <div>
                    <?php if(auth()->user()->isAdmin()): ?>
                    <button type="button"
                            onclick="confirmDelete()"
                            class="btn-danger">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Document
                    </button>
                    <?php endif; ?>
                </div>

                <div class="flex space-x-3">
                    <a href="<?php echo e(route('documents.show', $document)); ?>" class="btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Update Document
                    </button>
                </div>
            </div>
        </form>

        <?php if(auth()->user()->isAdmin()): ?>
        <!-- Hidden Delete Form -->
        <form id="deleteForm" method="POST" action="<?php echo e(route('documents.destroy', $document)); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
        </form>
        <?php endif; ?>
    </div>
</div>

<style>
.form-label {
    @apply block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1;
}

.form-label.required::after {
    content: ' *';
    @apply text-red-500;
}

.form-input {
    @apply block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors;
}

.form-input.error {
    @apply border-red-300 dark:border-red-600 focus:border-red-500 focus:ring-red-500;
}

.form-select {
    @apply block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors;
}

.form-select.error {
    @apply border-red-300 dark:border-red-600 focus:border-red-500 focus:ring-red-500;
}

.form-error {
    @apply mt-1 text-sm text-red-600 dark:text-red-400;
}

.form-help {
    @apply mt-1 text-sm text-gray-500 dark:text-gray-400;
}

.btn-primary {
    @apply inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors;
}

.btn-secondary {
    @apply inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors;
}

.btn-danger {
    @apply inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-900 transition-colors;
}
</style>

<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this document? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-populate submission date when status changes from NS to something else
    const statusSelect = document.getElementById('status');
    const submissionDateInput = document.getElementById('submission_date');
    const originalStatus = '<?php echo e($document->status); ?>';

    statusSelect.addEventListener('change', function() {
        if (originalStatus === 'NS' && this.value && this.value !== 'NS' && !submissionDateInput.value) {
            submissionDateInput.value = new Date().toISOString().split('T')[0];
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\My Own Project\document-control2\resources\views/documents/edit.blade.php ENDPATH**/ ?>