<?php $__env->startSection('page-title', $document->document_number); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($document->document_number); ?></h1>
            <p class="text-gray-600 dark:text-gray-400"><?php echo e($document->document_title); ?></p>
        </div>

        <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
            <?php if(auth()->user()->isReviewer() && $document->latest_reviewer_id === auth()->id() && !in_array($document->status, ['IFC', 'IFI'])): ?>
            <a href="<?php echo e(route('documents.review', $document)); ?>" class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Review Document
            </a>
            <?php endif; ?>

            <?php if(auth()->user()->isDocumentController() || auth()->user()->isAdmin()): ?>
            <a href="<?php echo e(route('documents.edit', $document)); ?>" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Document
            </a>
            <?php endif; ?>

            <a href="<?php echo e(route('documents.index')); ?>" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Documents
            </a>
        </div>
    </div>

    <!-- Status Alert -->
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Document Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Document Details Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-6 py-4">
                    <h2 class="text-lg font-semibold">Document Information</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Document Number</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($document->document_number); ?></dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Revision</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    <?php echo e($document->revision); ?>

                                </span>
                            </dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Document Title</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white"><?php echo e($document->document_title); ?></dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1">
                                <span class="status-badge status-<?php echo e(strtolower($document->status)); ?>">
                                    <?php echo e($document->getStatusDescription()); ?>

                                </span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Document Position</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white"><?php echo e($document->document_position ?: 'Not specified'); ?></dd>
                        </div>

                        <?php if($document->submission_date): ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Submission Date</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">
                                <?php echo e($document->submission_date->format('M d, Y')); ?>

                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    (<?php echo e($document->submission_date->diffForHumans()); ?>)
                                </span>
                            </dd>
                        </div>
                        <?php endif; ?>

                        <?php if($document->target_date): ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Target Date</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">
                                <?php echo e($document->target_date->format('M d, Y')); ?>

                                <?php if($document->isOverdue()): ?>
                                <span class="text-sm text-red-600 dark:text-red-400 font-medium">
                                    (<?php echo e($document->getDaysOverdue()); ?> days overdue)
                                </span>
                                <?php elseif($document->target_date->isFuture()): ?>
                                <span class="text-sm text-green-600 dark:text-green-400">
                                    (<?php echo e($document->target_date->diffForHumans()); ?>)
                                </span>
                                <?php endif; ?>
                            </dd>
                        </div>
                        <?php endif; ?>

                        <?php if($document->latestReviewer): ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Latest Reviewer</dt>
                            <dd class="mt-1">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium"><?php echo e(substr($document->latestReviewer->name, 0, 1)); ?></span>
                                    </div>
                                    <span class="text-gray-900 dark:text-white"><?php echo e($document->latestReviewer->name); ?></span>
                                </div>
                            </dd>
                        </div>
                        <?php endif; ?>

                        <?php if($document->submit_to_reviewer_date): ?>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted to Reviewer</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">
                                <?php echo e($document->submit_to_reviewer_date->format('M d, Y')); ?>

                            </dd>
                        </div>
                        <?php endif; ?>
                    </dl>
                </div>
            </div>

            <!-- Review History -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Review History</h3>
                </div>
                <div class="p-6">
                    <?php if($document->reviews->count() > 0): ?>
                    <div class="space-y-6">
                        <?php $__currentLoopData = $document->reviews->sortByDesc('reviewed_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-l-4 border-primary-400 pl-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium"><?php echo e(substr($review->reviewer->name, 0, 1)); ?></span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white"><?php echo e($review->reviewer->name); ?></p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($review->reviewed_at->format('M d, Y \a\t g:i A')); ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 text-sm font-medium rounded-full <?php echo e($review->getCommentClass()); ?>">
                                        <?php echo e($review->comment); ?>

                                    </span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Revision <?php echo e($review->revision); ?></p>
                                </div>
                            </div>
                            <?php if($review->review_notes): ?>
                            <div class="mt-3 text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <strong>Review Notes:</strong><br>
                                <?php echo e($review->review_notes); ?>

                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No reviews yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This document hasn't been reviewed yet.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <?php if(auth()->user()->isReviewer() && $document->latest_reviewer_id === auth()->id() && !in_array($document->status, ['IFC', 'IFI'])): ?>
                    <a href="<?php echo e(route('documents.review', $document)); ?>" class="block w-full btn-primary text-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Review Document
                    </a>
                    <?php endif; ?>

                    <?php if(auth()->user()->isDocumentController() || auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('documents.edit', $document)); ?>" class="block w-full btn-secondary text-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Document
                    </a>
                    <?php endif; ?>

                    <a href="<?php echo e(route('documents.index')); ?>" class="block w-full btn-secondary text-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        View All Documents
                    </a>
                </div>
            </div>

            <!-- Document Timeline -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Document Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <!-- Created -->
                            <li>
                                <div class="relative pb-8">
                                    <div class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600"></div>
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm text-gray-900 dark:text-white font-medium">Document Created</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($document->created_at->format('M d, Y \a\t g:i A')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <?php if($document->submission_date): ?>
                            <!-- Submitted -->
                            <li>
                                <div class="relative pb-8">
                                    <div class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600"></div>
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm text-gray-900 dark:text-white font-medium">Document Submitted</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($document->submission_date->format('M d, Y \a\t g:i A')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php endif; ?>

                            <?php $__currentLoopData = $document->reviews->sortBy('reviewed_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- Review -->
                            <li>
                                <div class="relative <?php echo e($loop->last ? '' : 'pb-8'); ?>">
                                    <?php if(!$loop->last): ?>
                                    <div class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600"></div>
                                    <?php endif; ?>
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full <?php echo e($review->comment === 'Approved' ? 'bg-green-500' : ($review->comment === 'Not Approved' ? 'bg-red-500' : 'bg-yellow-500')); ?> flex items-center justify-center">
                                                <?php if($review->comment === 'Approved'): ?>
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <?php elseif($review->comment === 'Not Approved'): ?>
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                <?php else: ?>
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <p class="text-sm text-gray-900 dark:text-white font-medium"><?php echo e($review->comment); ?></p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">by <?php echo e($review->reviewer->name); ?></p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($review->reviewed_at->format('M d, Y \a\t g:i A')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Status Legend -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status Legend</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">NS</span>
                            <span class="text-gray-800 dark:text-gray-200">Not Submitted</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">IFR</span>
                            <span class="text-gray-800 dark:text-gray-200">Issued for Review</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">IFA</span>
                            <span class="text-gray-800 dark:text-gray-200">Issued for Approval</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">IFC</span>
                            <span class="text-gray-800 dark:text-gray-200">Issued for Construction</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">IFI</span>
                            <span class="text-gray-800 dark:text-gray-200">Issued for Information</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-primary {
    @apply inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors;
}

.btn-secondary {
    @apply inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors;
}

.status-badge {
    @apply inline-flex items-center px-3 py-1 rounded-full text-sm font-medium;
}

.status-ns { @apply bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200; }
.status-ifr { @apply bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200; }
.status-rifr { @apply bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200; }
.status-ifa { @apply bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200; }
.status-rifa { @apply bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200; }
.status-ifc { @apply bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200; }
.status-rifc { @apply bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200; }
.status-ifi { @apply bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\My Own Project\document-control2\resources\views/documents/show.blade.php ENDPATH**/ ?>