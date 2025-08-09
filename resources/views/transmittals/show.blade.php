@extends('layouts.app')

@section('page-title', $transmittal->transmittal_number)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $transmittal->transmittal_number }}</h1>
            <p class="text-gray-600 dark:text-gray-400">Transmittal Letter Details</p>
        </div>

        <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('transmittals.pdf', $transmittal) }}"
               class="btn-secondary"
               target="_blank">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                View PDF
            </a>

            <a href="{{ route('transmittals.download', $transmittal) }}"
               class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>

            <a href="{{ route('transmittals.index') }}" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Transmittals
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Transmittal Details Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-6 py-4">
                    <h2 class="text-lg font-semibold">Transmittal Information</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Transmittal Number</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $transmittal->transmittal_number }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $transmittal->date->format('M d, Y') }}</dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Vendor Name</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $transmittal->vendor_name }}</dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $transmittal->description }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</dt>
                            <dd class="mt-1">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr($transmittal->creator->name, 0, 1) }}</span>
                                    </div>
                                    <span class="text-gray-900 dark:text-white">{{ $transmittal->creator->name }}</span>
                                </div>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created Date</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">
                                {{ $transmittal->created_at->format('M d, Y \a\t g:i A') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Documents List -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Transmitted Documents ({{ $transmittal->getDocumentCount() }} items)
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="table-header">No.</th>
                                <th class="table-header">Document Number</th>
                                <th class="table-header">Document Title</th>
                                <th class="table-header">Revision</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Position</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($documents as $index => $document)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="table-cell text-center">{{ $index + 1 }}</td>
                                <td class="table-cell">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $document->document_number }}
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <div class="text-gray-900 dark:text-white">
                                        {{ Str::limit($document->document_title, 40) }}
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        {{ $document->revision }}
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <span class="status-badge status-{{ strtolower($document->status) }}">
                                        {{ $document->status }}
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <div class="text-gray-900 dark:text-white">
                                        {{ $document->document_position ?: 'N/A' }}
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <a href="{{ route('documents.show', $document) }}"
                                       class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-200"
                                       title="View Document">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    <a href="{{ route('transmittals.pdf', $transmittal) }}"
                       class="block w-full btn-primary text-center"
                       target="_blank">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        View PDF
                    </a>

                    <a href="{{ route('transmittals.download', $transmittal) }}"
                       class="block w-full btn-secondary text-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download PDF
                    </a>

                    <a href="{{ route('transmittals.create') }}"
                       class="block w-full btn-secondary text-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create New Transmittal
                    </a>
                </div>
            </div>

            <!-- Document Summary -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Document Summary</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Documents:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $transmittal->getDocumentCount() }}</span>
                        </div>

                        @php
                            $statusCounts = $documents->groupBy('status')->map->count();
                        @endphp

                        @foreach($statusCounts as $status => $count)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $status }}:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $count }}</span>
                        </div>
                        @endforeach
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

