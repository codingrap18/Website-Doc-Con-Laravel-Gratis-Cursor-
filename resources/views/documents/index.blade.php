@extends('layouts.app')

@section('page-title', 'Document Management')

@section('content')
<div x-data="{ ...bulkActions(), ...filters() }" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Document Management</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage engineering documents and reviews</p>
        </div>

        <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
            @if(auth()->user()->isDocumentController() || auth()->user()->isAdmin())
            <a href="{{ route('documents.create') }}"
               class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Document
            </a>
            @endif

            <button @click="toggleFilters()"
                    class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filters
            </button>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg py-1 z-10">
                    <a href="{{ route('documents.export.excel') }}"
                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                        Export to Excel
                    </a>
                    <a href="{{ route('documents.export.pdf') }}"
                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                        Export to PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div x-show="showFilters" x-transition class="bg-white dark:bg-gray-800 rounded-lg shadow-sm card-3d p-6">
        <form method="GET" action="{{ route('documents.index') }}" x-ref="filterForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Document Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Document Number
                    </label>
                    <input type="text"
                           name="document_number"
                           value="{{ request('document_number') }}"
                           placeholder="Search document number..."
                           class="form-input">
                </div>

                <!-- Document Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Document Title
                    </label>
                    <input type="text"
                           name="document_title"
                           value="{{ request('document_title') }}"
                           placeholder="Search document title..."
                           class="form-input">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Status
                    </label>
                    <select name="status" class="form-select">
                        <option value="all">All Statuses</option>
                        @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Reviewer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Latest Reviewer
                    </label>
                    <select name="reviewer_id" class="form-select">
                        <option value="all">All Reviewers</option>
                        @foreach($reviewers as $reviewer)
                        <option value="{{ $reviewer->id }}" {{ request('reviewer_id') == $reviewer->id ? 'selected' : '' }}>
                            {{ $reviewer->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Document Position -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Document Position
                    </label>
                    <input type="text"
                           name="document_position"
                           value="{{ request('document_position') }}"
                           placeholder="Search position..."
                           class="form-input">
                </div>

                <!-- Submission Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Submission Date From
                    </label>
                    <input type="date"
                           name="submission_date_from"
                           value="{{ request('submission_date_from') }}"
                           class="form-input">
                </div>

                <!-- Submission Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Submission Date To
                    </label>
                    <input type="date"
                           name="submission_date_to"
                           value="{{ request('submission_date_to') }}"
                           class="form-input">
                </div>

                <!-- Overdue Only -->
                <div class="flex items-center space-x-3">
                    <input type="checkbox"
                           name="overdue_only"
                           value="1"
                           {{ request('overdue_only') ? 'checked' : '' }}
                           class="form-checkbox">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Show Overdue Only
                    </label>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" @click="clearFilters()" class="btn-secondary">
                    Clear Filters
                </button>
                <button type="submit" class="btn-primary">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Bulk Actions Bar -->
    <div x-show="showBulkActions" x-transition class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <span class="text-blue-800 dark:text-blue-200 font-medium">
                <span x-text="getSelectedCount()"></span> documents selected
            </span>

            @if(auth()->user()->isDocumentController() || auth()->user()->isAdmin())
            <div class="flex space-x-3">
                <form method="POST" action="{{ route('documents.bulk-update') }}" x-data="{ action: 'update_status', status: '', reviewer_id: '' }">
                    @csrf
                    <input type="hidden" name="document_ids" :value="JSON.stringify(selectedItems)">
                    <input type="hidden" name="action" x-model="action">
                    <input type="hidden" name="status" x-model="status">
                    <input type="hidden" name="reviewer_id" x-model="reviewer_id">

                    <div class="flex space-x-2">
                        <select x-model="action" class="form-select text-sm">
                            <option value="update_status">Update Status</option>
                            <option value="assign_reviewer">Assign Reviewer</option>
                        </select>

                        <select x-show="action === 'update_status'" x-model="status" class="form-select text-sm">
                            <option value="">Select Status</option>
                            @foreach($statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        <select x-show="action === 'assign_reviewer'" x-model="reviewer_id" class="form-select text-sm">
                            <option value="">Select Reviewer</option>
                            @foreach($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn-primary text-sm">Apply</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Documents Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        @if(auth()->user()->isDocumentController() || auth()->user()->isAdmin())
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox"
                                   @change="toggleAll([{{ $documents->pluck('id')->implode(',') }}])"
                                   :checked="selectedItems.length === {{ $documents->count() }} && {{ $documents->count() }} > 0"
                                   class="form-checkbox">
                        </th>
                        @endif
                        <th class="table-header">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'document_number', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                               class="group inline-flex items-center">
                                Document Number
                                <svg class="ml-1 w-4 h-4 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </a>
                        </th>
                        <th class="table-header">Document Title</th>
                        <th class="table-header">Revision</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'submission_date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                               class="group inline-flex items-center">
                                Submission Date
                                <svg class="ml-1 w-4 h-4 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </a>
                        </th>
                        <th class="table-header">Target Date</th>
                        <th class="table-header">Latest Reviewer</th>
                        <th class="table-header">Position</th>
                        <th class="table-header">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($documents as $document)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        @if(auth()->user()->isDocumentController() || auth()->user()->isAdmin())
                        <td class="px-6 py-4">
                            <input type="checkbox"
                                   @change="toggleItem({{ $document->id }})"
                                   :checked="isSelected({{ $document->id }})"
                                   class="form-checkbox">
                        </td>
                        @endif
                        <td class="table-cell">
                            <div class="font-medium text-gray-900 dark:text-white">
                                {{ $document->document_number }}
                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="text-gray-900 dark:text-white">
                                {{ Str::limit($document->document_title, 50) }}
                            </div>
                        </td>
                        <td class="table-cell">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                {{ $document->revision }}
                            </span>
                        </td>
                        <td class="table-cell">
                            <span class="status-badge status-{{ strtolower($document->status) }}">
                                {{ $document->getStatusDescription() }}
                            </span>
                        </td>
                        <td class="table-cell">
                            @if($document->submission_date)
                                <div class="text-gray-900 dark:text-white">
                                    {{ $document->submission_date->format('M d, Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $document->submission_date->diffForHumans() }}
                                </div>
                            @else
                                <span class="text-gray-400">Not submitted</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            @if($document->target_date)
                                <div class="text-gray-900 dark:text-white">
                                    {{ $document->target_date->format('M d, Y') }}
                                </div>
                                @if($document->isOverdue())
                                <div class="text-xs text-red-600 dark:text-red-400 font-medium">
                                    {{ $document->getDaysOverdue() }} days overdue
                                </div>
                                @endif
                            @else
                                <span class="text-gray-400">No target</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            @if($document->latestReviewer)
                                <div class="text-gray-900 dark:text-white">
                                    {{ $document->latestReviewer->name }}
                                </div>
                            @else
                                <span class="text-gray-400">Unassigned</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            <div class="text-gray-900 dark:text-white">
                                {{ $document->document_position ?: 'Not specified' }}
                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('documents.show', $document) }}"
                                   class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-200"
                                   title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @if(auth()->user()->isDocumentController() || auth()->user()->isAdmin())
                                <a href="{{ route('documents.edit', $document) }}"
                                   class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-200"
                                   title="Edit Document">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @endif

                                @if(auth()->user()->isReviewer() && $document->latest_reviewer_id === auth()->id() && !in_array($document->status, ['IFC', 'IFI']))
                                <a href="{{ route('documents.review', $document) }}"
                                   class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200"
                                   title="Review Document">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg font-medium">No documents found</p>
                                <p class="text-sm">Try adjusting your filters or add a new document.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            {{ $documents->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.btn-primary {
    @apply inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors;
}

.btn-secondary {
    @apply inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors;
}

.form-input {
    @apply block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors;
}

.form-select {
    @apply block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors;
}

.form-checkbox {
    @apply h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded;
}

.table-header {
    @apply px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider;
}

.table-cell {
    @apply px-6 py-4 whitespace-nowrap text-sm;
}

.status-badge {
    @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
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
@endsection

