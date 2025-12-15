@extends('layouts.authentication.master')
@section('title', 'Login')

@section('css')

@endsection

@section('content')
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-sign-in-alt"></i> Login</h1>
            <p>Access your account to continue</p>
        </div>

        <div class="login-form">
            <form id="formLogin" action="{{ route('login.attempt') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email_username">{{ __('Email/Username') }}<span class="text-danger">*</span></label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" class="@error('email_username') is-invalid @enderror" id="email_username"
                            name="email_username" placeholder="{{ __('Enter your email or username') }}" autofocus
                            required />
                    </div>
                    @error('email_username')
                        <div class="error-message" id="usernameError">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}<span class="text-danger">*</span></label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon-left"></i>

                        <input type="password" id="password" class="@error('password') is-invalid @enderror"
                            placeholder="Enter your password" name="password" required>

                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye" style="margin: 0;"></i>
                        </button>
                    </div>

                    @error('password')
                        <div class="error-message" id="usernameError">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn" id="submitBtn">
                    <span>Login</span>
                </button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    {!! NoCaptcha::renderJs() !!}
@endsection
