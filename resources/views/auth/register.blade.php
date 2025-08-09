@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Create Account</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Join the document control system
        </p>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg text-sm">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Full Name
            </label>
            <div class="mt-1">
                <input id="name"
                       name="name"
                       type="text"
                       value="{{ old('name') }}"
                       required
                       autocomplete="name"
                       class="auth-input"
                       placeholder="Enter your full name">
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Email Address
            </label>
            <div class="mt-1">
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       class="auth-input"
                       placeholder="Enter your email address">
            </div>
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Role
            </label>
            <div class="mt-1">
                <select id="role"
                        name="role"
                        required
                        class="auth-input">
                    <option value="">Select your role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="document_controller" {{ old('role') == 'document_controller' ? 'selected' : '' }}>Document Controller</option>
                    <option value="reviewer" {{ old('role') == 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                </select>
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Password
            </label>
            <div class="mt-1">
                <input id="password"
                       name="password"
                       type="password"
                       required
                       autocomplete="new-password"
                       class="auth-input"
                       placeholder="Enter your password">
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Confirm Password
            </label>
            <div class="mt-1">
                <input id="password_confirmation"
                       name="password_confirmation"
                       type="password"
                       required
                       autocomplete="new-password"
                       class="auth-input"
                       placeholder="Confirm your password">
            </div>
        </div>

        <div>
            <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 transition-colors">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-primary-500 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </span>
                Create Account
            </button>
        </div>

        <div class="text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}"
                   class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</div>

<style>
.auth-input {
    @apply appearance-none block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors;
}
</style>
@endsection

