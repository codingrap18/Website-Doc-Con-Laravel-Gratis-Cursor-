@extends('layouts.app')

@section('page-title', 'Add New Document')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Document</h1>
            <p class="text-gray-600 dark:text-gray-400">Create a new engineering document for review</p>
        </div>
        <a href="{{ route('documents.index') }}" class="btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Documents
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d">
        <form method="POST" action="{{ route('documents.store') }}" class="p-6 space-y-6">
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
                <!-- Document Number -->
                <div>
                    <label for="document_number" class="form-label required">Document Number</label>
                    <input type="text"
                           id="document_number"
                           name="document_number"
                           value="{{ old('document_number') }}"
                           placeholder="e.g., PTA-ENG-001-2024"
                           class="form-input @error('document_number') error @enderror"
                           required>
                    @error('document_number')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="form-help">Use format: PROJECT-DISCIPLINE-NUMBER-YEAR</p>
                </div>

                <!-- Document Title -->
                <div>
                    <label for="document_title" class="form-label required">Document Title</label>
                    <input type="text"
                           id="document_title"
                           name="document_title"
                           value="{{ old('document_title') }}"
                           placeholder="Enter document title"
                           class="form-input @error('document_title') error @enderror"
                           required>
                    @error('document_title')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Revision -->
                <div>
                    <label for="revision" class="form-label required">Revision</label>
                    <select id="revision"
                            name="revision"
                            class="form-select @error('revision') error @enderror"
                            required>
                        <option value="">Select Revision</option>
                        <option value="NS" {{ old('revision') == 'NS' ? 'selected' : '' }}>NS - Not Submitted</option>
                        <option value="A" {{ old('revision') == 'A' ? 'selected' : '' }}>A - First Issue</option>
                        <option value="A1" {{ old('revision') == 'A1' ? 'selected' : '' }}>A1 - Minor Revision</option>
                        <option value="A2" {{ old('revision') == 'A2' ? 'selected' : '' }}>A2 - Minor Revision</option>
                        <option value="B" {{ old('revision') == 'B' ? 'selected' : '' }}>B - Major Revision</option>
                        <option value="C" {{ old('revision') == 'C' ? 'selected' : '' }}>C - Major Revision</option>
                        <option value="D" {{ old('revision') == 'D' ? 'selected' : '' }}>D - Major Revision</option>
                        <option value="0" {{ old('revision') == '0' ? 'selected' : '' }}>0 - For Construction</option>
                    </select>
                    @error('revision')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="form-label required">Status</label>
                    <select id="status"
                            name="status"
                            class="form-select @error('status') error @enderror"
                            required>
                        <option value="">Select Status</option>
                        @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                            {{ $key }} - {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('status')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submission Date -->
                <div>
                    <label for="submission_date" class="form-label">Submission Date</label>
                    <input type="date"
                           id="submission_date"
                           name="submission_date"
                           value="{{ old('submission_date') }}"
                           class="form-input @error('submission_date') error @enderror">
                    @error('submission_date')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="form-help">Target date will be calculated automatically (5 working days)</p>
                </div>

                <!-- Latest Reviewer -->
                <div>
                    <label for="latest_reviewer_id" class="form-label">Assign Reviewer</label>
                    <select id="latest_reviewer_id"
                            name="latest_reviewer_id"
                            class="form-select @error('latest_reviewer_id') error @enderror">
                        <option value="">Select Reviewer</option>
                        @foreach($reviewers as $reviewer)
                        <option value="{{ $reviewer->id }}" {{ old('latest_reviewer_id') == $reviewer->id ? 'selected' : '' }}>
                            {{ $reviewer->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('latest_reviewer_id')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Document Position -->
            <div>
                <label for="document_position" class="form-label">Document Position</label>
                <input type="text"
                       id="document_position"
                       name="document_position"
                       value="{{ old('document_position') }}"
                       placeholder="e.g., Main Engineering, Process Engineering, Electrical"
                       class="form-input @error('document_position') error @enderror">
                @error('document_position')
                <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-help">Specify the engineering discipline or department</p>
            </div>

            <!-- Status Information Box -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Document Status Information
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>NS:</strong> Not Submitted Yet</li>
                                <li><strong>IFR:</strong> Issued for Review (Revision A)</li>
                                <li><strong>RIFR:</strong> Re-Issued for Review (A1, A2, A3...)</li>
                                <li><strong>IFA:</strong> Issued for Approval (Revision B)</li>
                                <li><strong>RIFA:</strong> Re-Issued for Approval (C, D, E...)</li>
                                <li><strong>IFC:</strong> Issued for Construction (Revision 0)</li>
                                <li><strong>RIFC:</strong> Re-Issued for Construction (Revision A)</li>
                                <li><strong>IFI:</strong> Issued for Information</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('documents.index') }}" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create Document
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-populate submission date with today's date when status is not NS
    const statusSelect = document.getElementById('status');
    const submissionDateInput = document.getElementById('submission_date');

    statusSelect.addEventListener('change', function() {
        if (this.value && this.value !== 'NS' && !submissionDateInput.value) {
            submissionDateInput.value = new Date().toISOString().split('T')[0];
        }
    });
});
</script>
@endsection

