@extends('layouts.app')

@section('page-title', 'Document Reviews')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Document Reviews</h1>
            <p class="text-gray-600 dark:text-gray-400">
                @if(auth()->user()->isReviewer())
                    Your document review history
                @else
                    All document reviews in the system
                @endif
            </p>
        </div>

        @if(auth()->user()->isReviewer())
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('reviews.pending') }}"
               class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pending Reviews
            </a>
        </div>
        @endif
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Reviews</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reviews->total() }}</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Approved</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reviews->where('comment', 'Approved')->count() }}</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">App. As Noted</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reviews->where('comment', 'App. As Noted')->count() }}</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Not Approved</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reviews->where('comment', 'Not Approved')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Review History</h3>
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($reviews as $review)
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <!-- Document Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('documents.show', $review->document) }}"
                                       class="hover:text-primary-600 dark:hover:text-primary-400">
                                        {{ $review->document->document_number }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $review->document->document_title }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $review->getCommentClass() }}">
                                    {{ $review->comment }}
                                </span>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Revision {{ $review->revision }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-white text-xs font-medium">{{ substr($review->reviewer->name, 0, 1) }}</span>
                                </div>
                                <span>{{ $review->reviewer->name }}</span>
                            </div>
                            <span>•</span>
                            <span>{{ $review->reviewed_at ? $review->reviewed_at->format('M d, Y \a\t g:i A') : 'Not reviewed yet' }}</span>
                            @if($review->reviewed_at)
                            <span>•</span>
                            <span>{{ $review->reviewed_at->diffForHumans() }}</span>
                            @endif
                        </div>

                        @if($review->review_notes)
                        <div class="mt-3 text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                            <strong>Review Notes:</strong><br>
                            {{ $review->review_notes }}
                        </div>
                        @endif
                    </div>

                    <!-- Document Status -->
                    <div class="flex-shrink-0">
                        <span class="status-badge status-{{ strtolower($review->status) }}">
                            {{ $review->status }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-lg font-medium">No reviews found</p>
                    <p class="text-sm">
                        @if(auth()->user()->isReviewer())
                            You haven't completed any reviews yet.
                        @else
                            No reviews have been completed in the system.
                        @endif
                    </p>
                </div>
            </div>
            @endforelse
        </div>

        @if($reviews->hasPages())
        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.btn-primary {
    @apply inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors;
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

