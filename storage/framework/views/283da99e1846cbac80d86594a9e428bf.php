<?php $__env->startSection('page-title', 'Create Transmittal Letter'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6" x-data="transmittalForm()">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Transmittal Letter</h1>
            <p class="text-gray-600 dark:text-gray-400">Generate a new transmittal letter for document submission</p>
        </div>
        <a href="<?php echo e(route('transmittals.index')); ?>" class="btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Transmittals
        </a>
    </div>

    <!-- Auto-generated Number Display -->
    <div class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-lg p-6 card-3d">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold"><?php echo e($transmittalNumber); ?></h2>
                <p class="text-primary-100">Auto-generated transmittal number</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-primary-200">Generation Date</div>
                <div class="text-lg font-semibold"><?php echo e(now()->format('M d, Y')); ?></div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d">
        <form method="POST" action="<?php echo e(route('transmittals.store')); ?>" class="p-6 space-y-6">
            <?php echo csrf_field(); ?>

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
                <!-- Transmittal Number -->
                <div>
                    <label for="transmittal_number" class="form-label required">Transmittal Number</label>
                    <input type="text"
                           id="transmittal_number"
                           name="transmittal_number"
                           value="<?php echo e(old('transmittal_number', $transmittalNumber)); ?>"
                           class="form-input <?php $__errorArgs = ['transmittal_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           readonly
                           required>
                    <?php $__errorArgs = ['transmittal_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="form-error"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="form-help">Auto-generated based on current date</p>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="form-label required">Transmittal Date</label>
                    <input type="date"
                           id="date"
                           name="date"
                           value="<?php echo e(old('date', now()->format('Y-m-d'))); ?>"
                           class="form-input <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['date'];
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
            </div>

            <!-- Vendor Name -->
            <div>
                <label for="vendor_name" class="form-label required">Vendor Name</label>
                <input type="text"
                       id="vendor_name"
                       name="vendor_name"
                       value="<?php echo e(old('vendor_name')); ?>"
                       placeholder="Enter vendor or company name"
                       class="form-input <?php $__errorArgs = ['vendor_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       required>
                <?php $__errorArgs = ['vendor_name'];
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

            <!-- Description -->
            <div>
                <label for="description" class="form-label required">Description</label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          placeholder="Describe the purpose of this transmittal..."
                          class="form-textarea <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          required><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
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

            <!-- Document Selection -->
            <div>
                <label class="form-label required">Select Documents</label>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Choose the documents to include in this transmittal letter</p>

                <!-- Search Filter -->
                <div class="mb-4">
                    <input type="text"
                           x-model="searchQuery"
                           placeholder="Search documents by number or title..."
                           class="form-input">
                </div>

                <!-- Documents List -->
                <div class="border border-gray-200 dark:border-gray-600 rounded-lg max-h-96 overflow-y-auto">
                    <?php if($documents->count() > 0): ?>
                    <div class="divide-y divide-gray-200 dark:divide-gray-600">
                        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer"
                               x-show="documentMatches(<?php echo e(json_encode($document->document_number . ' ' . $document->document_title)); ?>)">
                            <input type="checkbox"
                                   name="document_ids[]"
                                   value="<?php echo e($document->id); ?>"
                                   class="form-checkbox"
                                   @change="updateSelectedCount()"
                                   <?php echo e(collect(old('document_ids', []))->contains($document->id) ? 'checked' : ''); ?>>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white"><?php echo e($document->document_number); ?></p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($document->document_title); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="status-badge status-<?php echo e(strtolower($document->status)); ?>">
                                            <?php echo e($document->status); ?>

                                        </span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Rev. <?php echo e($document->revision); ?></p>
                                    </div>
                                </div>
                                <?php if($document->document_position): ?>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e($document->document_position); ?></p>
                                <?php endif; ?>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php else: ?>
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="font-medium">No documents available</p>
                        <p class="text-sm">Add documents to the system first.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <?php $__errorArgs = ['document_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="form-error"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <!-- Selected Count -->
                <div class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                    <span x-text="selectedCount"></span> document(s) selected
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Quick Actions:
                </div>
                <div class="flex space-x-3">
                    <button type="button"
                            @click="selectAll()"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-200">
                        Select All
                    </button>
                    <button type="button"
                            @click="selectNone()"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                        Select None
                    </button>
                    <button type="button"
                            @click="selectApproved()"
                            class="text-sm text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200">
                        Select IFC Only
                    </button>
                </div>
            </div>

            <!-- Information Box -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Transmittal Letter Information
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>The transmittal number is auto-generated based on the current date</li>
                                <li>Select documents that are ready for transmission to vendors</li>
                                <li>Typically include documents with status IFC (Issued for Construction)</li>
                                <li>A PDF will be automatically generated for download and printing</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                <a href="<?php echo e(route('transmittals.index')); ?>" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Create Transmittal Letter
                </button>
            </div>
        </form>
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

.form-textarea {
    @apply block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none;
}

.form-textarea.error {
    @apply border-red-300 dark:border-red-600 focus:border-red-500 focus:ring-red-500;
}

.form-checkbox {
    @apply h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded;
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

.status-badge {
    @apply inline-flex items-center px-2 py-1 rounded-full text-xs font-medium;
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

<script>
function transmittalForm() {
    return {
        searchQuery: '',
        selectedCount: 0,

        init() {
            this.updateSelectedCount();
        },

        documentMatches(documentText) {
            if (!this.searchQuery) return true;
            return documentText.toLowerCase().includes(this.searchQuery.toLowerCase());
        },

        updateSelectedCount() {
            this.selectedCount = document.querySelectorAll('input[name="document_ids[]"]:checked').length;
        },

        selectAll() {
            const checkboxes = document.querySelectorAll('input[name="document_ids[]"]');
            checkboxes.forEach(cb => {
                if (cb.closest('label').style.display !== 'none') {
                    cb.checked = true;
                }
            });
            this.updateSelectedCount();
        },

        selectNone() {
            const checkboxes = document.querySelectorAll('input[name="document_ids[]"]');
            checkboxes.forEach(cb => cb.checked = false);
            this.updateSelectedCount();
        },

        selectApproved() {
            this.selectNone();
            const labels = document.querySelectorAll('input[name="document_ids[]"]');
            labels.forEach(checkbox => {
                const label = checkbox.closest('label');
                if (label.querySelector('.status-ifc')) {
                    checkbox.checked = true;
                }
            });
            this.updateSelectedCount();
        }
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\My Own Project\document-control2\resources\views/transmittals/create.blade.php ENDPATH**/ ?>