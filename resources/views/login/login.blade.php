@extends('layout/login-layout')

@section('title','Sign In')

@section('container')

    <!-- Eyebrow + Heading -->
    <div class="am-form-eyebrow">Secure Access</div>
    <h1 class="am-form-title">Welcome back</h1>
    <p class="am-form-sub">Sign in to access your E-Paper archives and editorial content.</p>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="am-alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form action="" method="POST" id="am-login-form" novalidate>
        @csrf

        {{-- Username / Email --}}
        <div class="am-field">
            <label class="am-label" for="username_or_email">Username or Email</label>
            <div class="am-input-wrap">
                <svg class="am-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                <input
                    type="text"
                    id="username_or_email"
                    name="username_or_email"
                    class="am-input"
                    placeholder="you@example.com"
                    value="{{ old('username_or_email') }}"
                    autocomplete="username"
                    required
                >
            </div>
        </div>

        {{-- Password --}}
        <div class="am-field">
            <label class="am-label" for="password">Password</label>
            <div class="am-input-wrap">
                <svg class="am-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="am-input"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
                <button type="button" class="am-pass-toggle" aria-label="Toggle password visibility">
                    <!-- Eye open -->
                    <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    <!-- Eye closed (hidden by default) -->
                    <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            <div class="am-forgot-row">
                <a href="#">Forgot password?</a>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" name="login" id="am-submit-btn" class="am-btn-submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            <span>Sign In</span>
        </button>

        {{-- Register link --}}
        @if (Route::has('register'))
            <div class="am-card-links">
                Don't have an account?
                <a href="{{ route('register') }}">Create one</a>
            </div>
        @endif

        {{-- Secure footer badge --}}
        <div class="am-secure-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Authorized personnel only &nbsp;·&nbsp; SSL encrypted connection
        </div>
    </form>

@endsection