<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="theme" :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Document Control System') - Engineering Document Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/react@2.0.18/24/outline/index.js" type="module"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div
             x-show="$store.sidebar.open"
             x-transition:enter="transition-transform duration-300 ease-out"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition-transform duration-300 ease-in"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="sidebar fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-xl lg:static lg:translate-x-0">

            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-6 bg-primary-600 dark:bg-primary-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"/>
                        </svg>
                    </div>
                    <div class="text-white">
                        <h1 class="text-lg font-semibold">Document Control</h1>
                        <p class="text-xs text-primary-200">Engineering System</p>
                    </div>
                </div>
                <button @click="$store.sidebar.close()" class="lg:hidden text-white hover:text-primary-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center space-x-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('dashboard') ? 'bg-primary-50 dark:bg-primary-900/40 text-primary-700 dark:text-primary-200 border-r-2 border-primary-500' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7zm0 0a2 2 0 012-2h.01M3 7a2 2 0 012-2h.01M15 13l-3-3 4.5-4.5M9 13h10.5A1.5 1.5 0 0021 11.5v.01"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('documents.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('documents.*') ? 'bg-primary-50 dark:bg-primary-900/40 text-primary-700 dark:text-primary-200 border-r-2 border-primary-500' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Document Table
                </a>

                @if(auth()->user()->isReviewer())
                <a href="{{ route('reviews.pending') }}"
                   class="flex items-center space-x-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('reviews.*') ? 'bg-primary-50 dark:bg-primary-900/40 text-primary-700 dark:text-primary-200 border-r-2 border-primary-500' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    My Reviews
                </a>
                @endif

                <a href="{{ route('notifications.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('notifications.*') ? 'bg-primary-50 dark:bg-primary-900/40 text-primary-700 dark:text-primary-200 border-r-2 border-primary-500' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-5a9.984 9.984 0 01-1.69-5.58A1 1 0 0114 6V4a2 2 0 012-2h.01"/>
                    </svg>
                    Notifications
                </a>

                @if(auth()->user()->isDocumentController() || auth()->user()->isAdmin())
                <a href="{{ route('transmittals.index') }}"
                   class="flex items-center space-x-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('transmittals.*') ? 'bg-primary-50 dark:bg-primary-900/40 text-primary-700 dark:text-primary-200 border-r-2 border-primary-500' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Transmittal Letters
                </a>
                @endif

                <!-- Divider -->
                <hr class="my-4 border-gray-200 dark:border-gray-700">

                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-3">
                    Settings
                </div>

                <button @click="toggle()"
                        class="w-full text-left flex items-center space-x-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <span x-text="dark ? 'Light Mode' : 'Dark Mode'"></span>
                </button>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 smooth-all">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center space-x-4">
                        <!-- Mobile menu button -->
                        <button @click="$store.sidebar.toggle()"
                                class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <!-- Desktop collapse/expand button -->
                        <button @click="$store.sidebar.toggle()"
                                class="hidden lg:inline-flex items-center justify-center w-9 h-9 rounded-md border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 smooth-all"
                                aria-label="Toggle sidebar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                            @yield('page-title', 'Dashboard')
                        </h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Real-time Clock -->
                        <div x-data="clock" class="hidden md:block text-sm text-gray-600 dark:text-gray-400">
                            <div x-text="date" class="font-medium"></div>
                            <div x-text="time" class="text-xs"></div>
                        </div>

                        <!-- Notifications -->
                        <div x-data="notifications" class="relative">
                            <button @click="showDropdown = !showDropdown"
                                    class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-5a9.984 9.984 0 01-1.69-5.58A1 1 0 0114 6V4a2 2 0 012-2h.01"/>
                                </svg>
                                <span x-show="unreadCount > 0"
                                      x-text="unreadCount"
                                      class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
                            </button>
                        </div>

                        <!-- Theme Toggle -->
                        <button @click="toggle()"
                                class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                            <svg x-show="!dark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg x-show="dark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center space-x-3 text-sm bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-2 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden md:block text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg py-1 z-50">
                                <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-600">
                                    {{ ucfirst(auth()->user()->role) }}
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto p-6">
                @if(session('success'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="text-green-600 hover:text-green-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="text-red-600 hover:text-red-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div
         x-show="$store.sidebar.open"
         x-transition:enter="transition-opacity duration-300 ease-out"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-300 ease-in"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="$store.sidebar.close()"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>

</body>
</html>

