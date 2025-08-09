@extends('layouts.app')

@section('page-title', 'Review Document')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Review Document</h1>
            <p class="text-gray-600 dark:text-gray-400">Submit your review for this engineering document</p>
        </div>
        <a href="{{ route('documents.show', $document) }}" class="btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Document
        </a>
    </div>

    <!-- Document Information Card -->
    <div class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-lg p-6 card-3d">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold">{{ $document->document_number }}</h2>
                <p class="text-primary-100 mt-1">{{ $document->document_title }}</p>
                <p class="text-primary-200 text-sm mt-2">Current Status: {{ $document->getStatusDescription() }} • Revision {{ $document->revision }}</p>
            </div>
            @if($document->isOverdue())
            <div class="text-right">
                <div class="bg-red-500 bg-opacity-20 border border-red-300 rounded-lg px-3 py-2">
                    <div class="text-red-100 text-sm font-medium">OVERDUE</div>
                    <div class="text-red-200 text-xs">{{ $document->getDaysOverdue() }} days</div>
                </div>
            </div>
            @endif
        </div>

        @if($document->target_date)
        <div class="mt-4 pt-4 border-t border-primary-400 border-opacity-30">
            <div class="flex justify-between text-sm">
                <span class="text-primary-200">Submission Date: {{ $document->submission_date->format('M d, Y') }}</span>
                <span class="text-primary-200">Target Date: {{ $document->target_date->format('M d, Y') }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Review Form -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d">
        <form method="POST" action="{{ route('documents.review.store', $document) }}" class="p-6 space-y-6">
            @csrf

            @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
                <h4 class="font-medium mb-2">Please correct the following errors:</h4>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Review Status -->
                <div>
                    <label for="status" class="form-label required">Review Status</label>
                    <select id="status"
                            name="status"
                            class="form-select @error('status') error @enderror"
                            required>
                        <option value="">Select Status</option>
                        <option value="IFR" {{ old('status') == 'IFR' ? 'selected' : '' }}>IFR - Issued for Review</option>
                        <option value="RIFR" {{ old('status') == 'RIFR' ? 'selected' : '' }}>RIFR - Re-Issued for Review</option>
                        <option value="IFA" {{ old('status') == 'IFA' ? 'selected' : '' }}>IFA - Issued for Approval</option>
                        <option value="RIFA" {{ old('status') == 'RIFA' ? 'selected' : '' }}>RIFA - Re-Issued for Approval</option>
                        <option value="IFC" {{ old('status') == 'IFC' ? 'selected' : '' }}>IFC - Issued for Construction</option>
                        <option value="RIFC" {{ old('status') == 'RIFC' ? 'selected' : '' }}>RIFC - Re-Issued for Construction</option>
                        <option value="IFI" {{ old('status') == 'IFI' ? 'selected' : '' }}>IFI - Issued for Information</option>
                    </select>
                    @error('status')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="form-help">Select the appropriate status after your review</p>
                </div>

                <!-- Revision -->
                <div>
                    <label for="revision" class="form-label required">New Revision</label>
                    <input type="text"
                           id="revision"
                           name="revision"
                           value="{{ old('revision') }}"
                           placeholder="e.g., A, A1, B, C, 0"
                           class="form-input @error('revision') error @enderror"
                           required>
                    @error('revision')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="form-help">Current revision: {{ $document->revision }}</p>
                </div>
            </div>

            <!-- Review Comment -->
            <div>
                <label for="comment" class="form-label required">Review Comment</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="review-option {{ old('comment') == 'Approved' ? 'selected' : '' }}">
                        <input type="radio"
                               name="comment"
                               value="Approved"
                               {{ old('comment') == 'Approved' ? 'checked' : '' }}
                               class="sr-only"
                               required>
                        <div class="review-card approved">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Approved</span>
                            <span class="text-xs text-gray-500">Document meets all requirements</span>
                        </div>
                    </label>

                    <label class="review-option {{ old('comment') == 'App. As Noted' ? 'selected' : '' }}">
                        <input type="radio"
                               name="comment"
                               value="App. As Noted"
                               {{ old('comment') == 'App. As Noted' ? 'checked' : '' }}
                               class="sr-only"
                               required>
                        <div class="review-card conditional">
                            <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">App. As Noted</span>
                            <span class="text-xs text-gray-500">Approved with minor comments</span>
                        </div>
                    </label>

                    <label class="review-option {{ old('comment') == 'Not Approved' ? 'selected' : '' }}">
                        <input type="radio"
                               name="comment"
                               value="Not Approved"
                               {{ old('comment') == 'Not Approved' ? 'checked' : '' }}
                               class="sr-only"
                               required>
                        <div class="review-card rejected">
                            <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Not Approved</span>
                            <span class="text-xs text-gray-500">Requires major revisions</span>
                        </div>
                    </label>
                </div>
                @error('comment')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Review Notes -->
            <div>
                <label for="review_notes" class="form-label">Review Notes</label>
                <textarea id="review_notes"
                          name="review_notes"
                          rows="6"
                          placeholder="Provide detailed comments about your review..."
                          class="form-textarea @error('review_notes') error @enderror">{{ old('review_notes') }}</textarea>
                @error('review_notes')
                <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-help">Provide specific feedback on technical content, compliance, and any required changes</p>
            </div>

            <!-- Review Guidelines -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Review Guidelines
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Approved:</strong> Document is technically correct and ready for next phase</li>
                                <li><strong>App. As Noted:</strong> Document is approved but with minor comments that don't require resubmission</li>
                                <li><strong>Not Approved:</strong> Document requires major revisions and resubmission</li>
                                <li>Always provide clear, actionable feedback in the review notes</li>
                                <li>Reference specific sections, drawings, or calculations when applicable</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('documents.show', $document) }}" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Submit Review
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

.form-select {
    @apply block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors;
}

.form-select.error {
    @apply border-red-300 dark:border-red-600 focus:border-red-500 focus:ring-red-500;
}

.form-textarea {
    @apply block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none;
}

.form-textarea.error {
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

.review-option {
    @apply cursor-pointer;
}

.review-card {
    @apply border-2 border-gray-200 dark:border-gray-600 rounded-lg p-4 text-center transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-500;
}

.review-option.selected .review-card,
.review-option input:checked + .review-card {
    @apply border-primary-500 bg-primary-50 dark:bg-primary-900/20;
}

.review-card.approved {
    @apply hover:border-green-300 hover:bg-green-50 dark:hover:bg-green-900/20;
}

.review-card.conditional {
    @apply hover:border-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20;
}

.review-card.rejected {
    @apply hover:border-red-300 hover:bg-red-50 dark:hover:bg-red-900/20;
}

.review-option input:checked + .review-card.approved {
    @apply border-green-500 bg-green-50 dark:bg-green-900/20;
}

.review-option input:checked + .review-card.conditional {
    @apply border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20;
}

.review-option input:checked + .review-card.rejected {
    @apply border-red-500 bg-red-50 dark:bg-red-900/20;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle review option selection
    const reviewOptions = document.querySelectorAll('input[name="comment"]');
    reviewOptions.forEach(option => {
        option.addEventListener('change', function() {
            // Remove selected class from all options
            document.querySelectorAll('.review-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            // Add selected class to current option
            if (this.checked) {
                this.closest('.review-option').classList.add('selected');
            }
        });
    });

    // Auto-suggest revision based on status and current revision
    const statusSelect = document.getElementById('status');
    const revisionInput = document.getElementById('revision');
    const currentRevision = '{{ $document->revision }}';

    statusSelect.addEventListener('change', function() {
        if (!revisionInput.value) {
            let suggestedRevision = '';

            switch(this.value) {
                case 'IFR':
                    suggestedRevision = 'A';
                    break;
                case 'RIFR':
                    if (currentRevision === 'A') {
                        suggestedRevision = 'A1';
                    } else if (currentRevision.startsWith('A')) {
                        const num = parseInt(currentRevision.substring(1)) || 0;
                        suggestedRevision = 'A' + (num + 1);
                    }
                    break;
                case 'IFA':
                    suggestedRevision = 'B';
                    break;
                case 'RIFA':
                    if (currentRevision === 'B') {
                        suggestedRevision = 'C';
                    } else if (['C', 'D', 'E'].includes(currentRevision)) {
                        suggestedRevision = String.fromCharCode(currentRevision.charCodeAt(0) + 1);
                    }
                    break;
                case 'IFC':
                    suggestedRevision = '0';
                    break;
                case 'RIFC':
                    suggestedRevision = 'A';
                    break;
                case 'IFI':
                    suggestedRevision = currentRevision;
                    break;
            }

            if (suggestedRevision) {
                revisionInput.value = suggestedRevision;
            }
        }
    });
});
</script>
@endsection

