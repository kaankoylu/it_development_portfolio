@extends('layouts.app')

@section('title', 'Owner Login')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login-center-wrapper">
        <div class="login-card">
            <h2>Sign In</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" style="color: #66bb6a; font-family: sans-serif; font-size: 14px; margin-bottom: 15px;" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input id="email" class="login-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-msg" />
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input id="password" class="login-input" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="error-msg" />
                </div>

                <label for="remember_me" class="remember-me-group">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                <div class="login-actions">
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @else
                        <div></div>
                    @endif

                    <button type="submit" class="login-submit-btn">
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
