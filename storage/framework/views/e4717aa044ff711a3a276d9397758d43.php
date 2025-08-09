<?php $__env->startSection('page-title', 'Transmittal Letters'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Transmittal Letters</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage document transmittal letters</p>
        </div>

        <div class="mt-4 sm:mt-0">
            <a href="<?php echo e(route('transmittals.create')); ?>"
               class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create Transmittal Letter
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transmittals</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($transmittals->total()); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">This Month</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($transmittals->where('date', '>=', now()->startOfMonth())->count()); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Documents</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($transmittals->sum(function($t) { return count($t->document_ids); })); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Unique Vendors</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($transmittals->unique('vendor_name')->count()); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transmittals Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transmittal Letters</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="table-header">
                            <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'transmittal_number', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])); ?>"
                               class="group inline-flex items-center">
                                Transmittal Number
                                <svg class="ml-1 w-4 h-4 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </a>
                        </th>
                        <th class="table-header">
                            <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])); ?>"
                               class="group inline-flex items-center">
                                Date
                                <svg class="ml-1 w-4 h-4 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </a>
                        </th>
                        <th class="table-header">Vendor Name</th>
                        <th class="table-header">Description</th>
                        <th class="table-header">Documents</th>
                        <th class="table-header">Created By</th>
                        <th class="table-header">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $transmittals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transmittal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="table-cell">
                            <div class="font-medium text-gray-900 dark:text-white">
                                <?php echo e($transmittal->transmittal_number); ?>

                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="text-gray-900 dark:text-white">
                                <?php echo e($transmittal->date->format('M d, Y')); ?>

                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                <?php echo e($transmittal->date->diffForHumans()); ?>

                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="text-gray-900 dark:text-white">
                                <?php echo e($transmittal->vendor_name); ?>

                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="text-gray-900 dark:text-white">
                                <?php echo e(Str::limit($transmittal->description, 50)); ?>

                            </div>
                        </td>
                        <td class="table-cell">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200">
                                <?php echo e($transmittal->getDocumentCount()); ?> documents
                            </span>
                        </td>
                        <td class="table-cell">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium"><?php echo e(substr($transmittal->creator->name, 0, 1)); ?></span>
                                </div>
                                <span class="text-gray-900 dark:text-white"><?php echo e($transmittal->creator->name); ?></span>
                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="flex items-center space-x-2">
                                <a href="<?php echo e(route('transmittals.show', $transmittal)); ?>"
                                   class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-200"
                                   title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <a href="<?php echo e(route('transmittals.pdf', $transmittal)); ?>"
                                   class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200"
                                   title="View PDF"
                                   target="_blank">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </a>

                                <a href="<?php echo e(route('transmittals.download', $transmittal)); ?>"
                                   class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200"
                                   title="Download PDF">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>

                                <?php if(auth()->user()->isAdmin()): ?>
                                <button onclick="deleteTransmittal(<?php echo e($transmittal->id); ?>)"
                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200"
                                        title="Delete Transmittal">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg font-medium">No transmittal letters found</p>
                                <p class="text-sm">Create your first transmittal letter to get started.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($transmittals->hasPages()): ?>
        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            <?php echo e($transmittals->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php if(auth()->user()->isAdmin()): ?>
<!-- Hidden Delete Forms -->
<?php $__currentLoopData = $transmittals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transmittal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<form id="deleteForm<?php echo e($transmittal->id); ?>" method="POST" action="<?php echo e(route('transmittals.destroy', $transmittal)); ?>" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<style>
.btn-primary {
    @apply inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors;
}

.table-header {
    @apply px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider;
}

.table-cell {
    @apply px-6 py-4 whitespace-nowrap text-sm;
}
</style>

<script>
function deleteTransmittal(transmittalId) {
    if (confirm('Are you sure you want to delete this transmittal letter? This action cannot be undone.')) {
        document.getElementById('deleteForm' + transmittalId).submit();
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\My Own Project\document-control2\resources\views/transmittals/index.blade.php ENDPATH**/ ?>