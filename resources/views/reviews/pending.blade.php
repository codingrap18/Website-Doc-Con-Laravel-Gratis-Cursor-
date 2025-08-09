@extends('layouts.app')

@section('page-title', 'Pending Reviews')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pending Reviews</h1>
            <p class="text-gray-600 dark:text-gray-400">Documents waiting for your review</p>
        </div>

        <div class="mt-4 sm:mt-0">
            <a href="{{ route('reviews.index') }}"
               class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                All Reviews
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Reviews</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingDocuments->count() }}</p>
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
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingDocuments->filter(fn($doc) => $doc->isOverdue())->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">On Time</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingDocuments->filter(fn($doc) => !$doc->isOverdue())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Documents -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Documents Awaiting Review</h3>
        </div>

        @if($pendingDocuments->count() > 0)
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($pendingDocuments as $document)
            <div class="p-6 {{ $document->isOverdue() ? 'bg-red-50 dark:bg-red-900/10 border-l-4 border-red-500' : '' }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $document->document_number }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $document->document_title }}
                                </p>

                                <div class="mt-3 flex items-center space-x-4 text-sm">
                                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        Rev. {{ $document->revision }}
                                    </div>

                                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Submitted {{ $document->submission_date->format('M d, Y') }}
                                    </div>

                                    @if($document->target_date)
                                    <div class="flex items-center {{ $document->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-400' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Target {{ $document->target_date->format('M d, Y') }}
                                        @if($document->isOverdue())
                                        ({{ $document->getDaysOverdue() }} days overdue)
                                        @endif
                                    </div>
                                    @endif

                                    @if($document->document_position)
                                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $document->document_position }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="status-badge status-{{ strtolower($document->status) }}">
                                    {{ $document->getStatusDescription() }}
                                </span>

                                @if($document->isOverdue())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                    Overdue
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex space-x-3">
                        <a href="{{ route('documents.show', $document) }}"
                           class="btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Details
                        </a>

                        <a href="{{ route('documents.review', $document) }}"
                           class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Start Review
                        </a>
                    </div>

                    @if($document->isOverdue())
                    <div class="text-right">
                        <span class="text-sm font-medium text-red-600 dark:text-red-400">
                            Priority: HIGH
                        </span>
                        <p class="text-xs text-red-500 dark:text-red-400">
                            Immediate attention required
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-12 text-center">
            <div class="text-gray-500 dark:text-gray-400">
                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-lg font-medium">No pending reviews</p>
                <p class="text-sm">Great! You're all caught up with your document reviews.</p>
                <div class="mt-4">
                    <a href="{{ route('reviews.index') }}"
                       class="btn-secondary">
                        View All Reviews
                    </a>
                </div>
            </div>
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

