@extends('layouts.app')

@section('page-title', 'Notifications')

@section('content')
<div class="space-y-6" x-data="notificationManager()">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Notifications</h1>
            <p class="text-gray-600 dark:text-gray-400">Stay updated with system activities and alerts</p>
        </div>

        <div class="mt-4 sm:mt-0 flex space-x-3">
            <button @click="markAllAsRead()"
                    class="btn-secondary"
                    :disabled="unreadCount === 0">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mark All Read
            </button>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg py-1 z-10">
                    <a href="?filter=all"
                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 {{ request('filter', 'all') === 'all' ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                        All Notifications
                    </a>
                    <a href="?filter=unread"
                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 {{ request('filter') === 'unread' ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                        Unread Only
                    </a>
                    <a href="?filter=review"
                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 {{ request('filter') === 'review' ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                        Review Notifications
                    </a>
                    <a href="?filter=overdue"
                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 {{ request('filter') === 'overdue' ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                        Overdue Alerts
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-5a9.984 9.984 0 01-1.69-5.58A1 1 0 0114 6V4a2 2 0 012-2h.01"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Notifications</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $notifications->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg card-3d">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L3 7v11c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V7l-7-5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Unread</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="unreadCount">{{ $notifications->where('read_at', null)->count() }}</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Review Notifications</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $notifications->where('type', 'review')->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Overdue Alerts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $notifications->where('type', 'overdue')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg card-3d">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                @switch(request('filter', 'all'))
                    @case('unread')
                        Unread Notifications
                        @break
                    @case('review')
                        Review Notifications
                        @break
                    @case('overdue')
                        Overdue Alerts
                        @break
                    @default
                        All Notifications
                @endswitch
            </h3>
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($notifications as $notification)
            <div class="p-6 {{ $notification->read_at ? 'opacity-75' : '' }} notification-item"
                 data-notification-id="{{ $notification->id }}">
                <div class="flex items-start space-x-4">
                    <!-- Icon based on type -->
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center notification-icon-{{ $notification->type }}">
                            @switch($notification->type)
                                @case('review')
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @break
                                @case('overdue')
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    @break
                                @case('reminder')
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                            @endswitch
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $notification->title }}
                                @if(!$notification->read_at)
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    New
                                </span>
                                @endif
                            </p>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>

                                @if(!$notification->read_at)
                                <button @click="markAsRead({{ $notification->id }})"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 text-xs">
                                    Mark Read
                                </button>
                                @endif

                                <button @click="deleteNotification({{ $notification->id }})"
                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 text-xs">
                                    Delete
                                </button>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ $notification->message }}
                        </p>
                        @if($notification->read_at)
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Read {{ $notification->read_at->diffForHumans() }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-5a9.984 9.984 0 01-1.69-5.58A1 1 0 0114 6V4a2 2 0 012-2h.01"/>
                    </svg>
                    <p class="text-lg font-medium">No notifications found</p>
                    <p class="text-sm">
                        @if(request('filter') === 'unread')
                            You have no unread notifications.
                        @else
                            All caught up! New notifications will appear here.
                        @endif
                    </p>
                </div>
            </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.btn-secondary {
    @apply inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors disabled:opacity-50 disabled:cursor-not-allowed;
}

.notification-icon-review {
    @apply bg-blue-100 dark:bg-blue-900;
}

.notification-icon-overdue {
    @apply bg-red-100 dark:bg-red-900;
}

.notification-icon-reminder {
    @apply bg-yellow-100 dark:bg-yellow-900;
}

.notification-icon-info {
    @apply bg-gray-100 dark:bg-gray-700;
}

.notification-item:hover {
    @apply bg-gray-50 dark:bg-gray-700;
}
</style>

<script>
function notificationManager() {
    return {
        unreadCount: {{ $notifications->where('read_at', null)->count() }},

        async markAsRead(notificationId) {
            try {
                const response = await fetch(`/api/notifications/${notificationId}/read`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                });

                if (response.ok) {
                    // Update UI
                    const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (notification) {
                        notification.classList.add('opacity-75');
                        notification.querySelector('.bg-blue-100, .bg-blue-900')?.remove();
                        notification.querySelector('button[onclick*="markAsRead"]')?.remove();
                    }

                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                }
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        },

        async markAllAsRead() {
            try {
                const response = await fetch('/api/notifications/mark-all-read', {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                });

                if (response.ok) {
                    // Reload page to show updated state
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error marking all notifications as read:', error);
            }
        },

        async deleteNotification(notificationId) {
            if (confirm('Are you sure you want to delete this notification?')) {
                try {
                    const response = await fetch(`/api/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        }
                    });

                    if (response.ok) {
                        // Remove from UI
                        const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        if (notification) {
                            notification.remove();
                        }
                    }
                } catch (error) {
                    console.error('Error deleting notification:', error);
                }
            }
        }
    }
}
</script>
@endsection

