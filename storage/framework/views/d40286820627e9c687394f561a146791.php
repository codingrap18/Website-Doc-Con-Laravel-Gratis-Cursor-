

<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
        <div class="p-6 bg-gradient-to-r from-primary-500 to-secondary-500 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Welcome back, <?php echo e(auth()->user()->name); ?>!</h1>
                    <p class="text-primary-100 mt-1"><?php echo e(ucfirst(auth()->user()->role)); ?> • <?php echo e(now()->format('l, F d, Y')); ?></p>
                </div>
                <div class="hidden md:block">
                    <div x-data="clock" class="text-right">
                        <div x-text="time" class="text-2xl font-bold"></div>
                        <div x-text="date" class="text-sm text-primary-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Documents</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($statistics['total_documents']); ?></p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Reviews</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($statistics['pending_reviews']); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Overdue</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($statistics['overdue_documents']); ?></p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed This Month</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($statistics['completed_this_month']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(auth()->user()->isReviewer() && $statistics['my_pending_reviews'] > 0): ?>
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                    You have <?php echo e($statistics['my_pending_reviews']); ?> document(s) pending your review
                </h3>
                <div class="mt-2">
                    <a href="<?php echo e(route('reviews.pending')); ?>"
                       class="text-sm bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-700 transition-colors">
                        View Pending Reviews
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Status Distribution Chart -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Document Status Distribution</h3>
                <div class="h-64">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Submissions Chart -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Monthly Submission Trends</h3>
                <div class="h-64">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Activities</h3>
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-<?php echo e($activity['color']); ?>-100 dark:bg-<?php echo e($activity['color']); ?>-900 rounded-full flex items-center justify-center">
                                <?php if($activity['icon'] === 'document-plus'): ?>
                                <svg class="w-4 h-4 text-<?php echo e($activity['color']); ?>-600 dark:text-<?php echo e($activity['color']); ?>-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <?php else: ?>
                                <svg class="w-4 h-4 text-<?php echo e($activity['color']); ?>-600 dark:text-<?php echo e($activity['color']); ?>-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm text-gray-900 dark:text-white"><?php echo e($activity['message']); ?></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($activity['date']->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent activities</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Overdue Documents Alert -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Overdue Documents</h3>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $overdueDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border-l-4 border-red-400 pl-3 py-2">
                        <p class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($document->document_number); ?></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($document->getDaysOverdue()); ?> days overdue</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($document->latestReviewer?->name ?? 'Unassigned'); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4">
                        <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">No overdue documents</p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if($overdueDocuments->count() > 0): ?>
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                    <a href="<?php echo e(route('documents.index', ['overdue_only' => true])); ?>"
                       class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-200 font-medium">
                        View all overdue documents →
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = <?php echo json_encode($chartData['status_distribution'], 15, 512) ?>;

    window.createChart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.map(item => item.label),
            datasets: [{
                data: statusData.map(item => item.value),
                backgroundColor: [
                    '#3B82F6', '#14B8A6', '#10B981', '#F59E0B',
                    '#EF4444', '#8B5CF6', '#F97316', '#06B6D4'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Monthly Submissions Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = <?php echo json_encode($chartData['monthly_submissions'], 15, 512) ?>;

    window.createChart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.labels,
            datasets: [{
                label: 'Submissions',
                data: monthlyData.data,
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\My Own Project\document-control2\resources\views/dashboard/index.blade.php ENDPATH**/ ?>