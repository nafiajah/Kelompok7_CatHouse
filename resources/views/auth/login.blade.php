@extends('layouts.app')

@section('title', 'Login - CAT HOUSE')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="login-container">
    <!-- Back to Home Floating Link -->
    <a href="{{ route('home') }}" class="login-back-btn">
        <i class="fa-solid fa-arrow-left"></i> Beranda
    </a>

    <!-- LEFT COLUMN: Photo Frame Section -->
    <div class="login-photo-section">
        <div class="login-photo-wrapper">
            <!-- Photo Image with fallback to JPG then fallback box -->
            <img 
                src="{{ asset('images/cat-photo.png') }}?v={{ time() }}" 
                alt="Cat House Photo" 
                class="login-photo-img" 
                id="loginCatPhoto"
                onerror="if (this.src.indexOf('.png') !== -1) { this.src='{{ asset('images/cat-photo.jpg') }}?v={{ time() }}'; } else { this.style.display='none'; document.getElementById('catPhotoFallback').style.display='flex'; }"
            >
            <!-- Fallback Frame if image missing -->
            <div id="catPhotoFallback" class="login-photo-fallback">
                <i class="fa-solid fa-cat"></i>
                <p>Frame Foto Kucing</p>
                <span style="font-size: 11px; opacity: 0.7; margin-top: 4px;">Simpan foto Anda di <code>public/images/cat-photo.png</code></span>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Login Form Section -->
    <div class="login-form-section">
        <div class="login-form-content">
            
            <!-- Logo Frame -->
            <div class="login-logo-frame">
                <img 
                    src="{{ asset('images/logo.png') }}" 
                    alt="CAT HOUSE Logo" 
                    class="login-logo-img" 
                    id="loginLogoImg"
                    onerror="this.style.display='none'; document.getElementById('logoFallback').style.display='flex';"
                >
                <!-- Fallback Frame for Logo -->
                <div id="logoFallback" class="login-logo-fallback">
                    <div class="logo-icon-house">
                        <i class="fa-solid fa-cat text-2xl text-amber-800"></i>
                    </div>
                    <span class="logo-text-fallback">CAT HOUSE</span>
                </div>
            </div>

            <!-- Welcome Back Title & Subtitle -->
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Please login to your account</p>

            <!-- Alerts for Session Messages -->
            @if(session('error'))
                <div class="login-alert login-alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="login-alert login-alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="login-form">
                @csrf

                <!-- Username Input Group -->
                <div class="form-group">
                    <label for="login" class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            name="login" 
                            id="login" 
                            value="{{ old('login') }}" 
                            required 
                            autofocus
                            placeholder="Enter your username" 
                            class="form-input @error('login') is-invalid @enderror"
                        >
                        <!-- Right Icon -->
                        <span class="input-icon">
                            <i class="fa-regular fa-user"></i>
                        </span>
                    </div>
                    @error('login')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input Group -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="Enter your password" 
                            class="form-input @error('password') is-invalid @enderror"
                        >
                        <!-- Right Key Icon -->
                        <span class="input-icon">
                            <i class="fa-solid fa-key"></i>
                        </span>
                    </div>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="form-options-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" class="checkbox-input">
                        <span>Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    Login
                </button>
            </form>

            <!-- Register Link -->
            <div class="login-footer-links">
                <p>Belum memiliki akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </div>

            <!-- Demo Quick Login Helper -->
            <div class="demo-badge-container">
                <div class="demo-badge-header">
                    <i class="fa-solid fa-key" style="color: #E58396;"></i> Akun Uji Coba:
                </div>
                <div class="demo-badge-grid">
                    <div><strong>Admin:</strong> admin / admin123</div>
                    <div><strong>User:</strong> user / user123</div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.body.classList.add('login-page-body');
</script>
@endsection
