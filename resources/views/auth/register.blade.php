@extends('layouts.app')

@section('title', 'Register - CAT HOUSE')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="login-container register-container">
    <!-- Back to Home Floating Link -->
    <a href="{{ route('home') }}" class="login-back-btn">
        <i class="fa-solid fa-arrow-left"></i> Beranda
    </a>

    <!-- LEFT COLUMN: Photo Frame Section -->
    <div class="login-photo-section">
        <div class="login-photo-wrapper">
            <img 
                src="{{ asset('images/cat-photo.png') }}?v={{ time() }}" 
                alt="Cat House Photo" 
                class="login-photo-img" 
                id="registerCatPhoto"
                onerror="if (this.src.indexOf('.png') !== -1) { this.src='{{ asset('images/cat-photo.jpg') }}?v={{ time() }}'; } else { this.style.display='none'; document.getElementById('catPhotoFallback').style.display='flex'; }"
            >
            <div id="catPhotoFallback" class="login-photo-fallback">
                <i class="fa-solid fa-cat"></i>
                <p>Frame Foto Kucing</p>
                <span style="font-size: 11px; opacity: 0.7; margin-top: 4px;">Simpan foto Anda di <code>public/images/cat-photo.png</code></span>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Register Form Section -->
    <div class="login-form-section register-form-section">
        <div class="register-form-content">
            
            <!-- Logo Frame -->
            <div class="register-logo-frame">
                <img 
                    src="{{ asset('images/logo.png') }}" 
                    alt="CAT HOUSE Logo" 
                    class="login-logo-img" 
                    id="registerLogoImg"
                    onerror="this.style.display='none'; document.getElementById('logoFallback').style.display='flex';"
                >
                <div id="logoFallback" class="login-logo-fallback">
                    <div class="logo-icon-house">
                        <i class="fa-solid fa-cat text-2xl text-amber-800"></i>
                    </div>
                    <span class="logo-text-fallback">CAT HOUSE</span>
                </div>
            </div>

            <!-- Subtitle -->
            <p class="register-subtitle">Please register to create account</p>

            <!-- Alerts for Session & Validation Messages -->
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

            <!-- Register Form -->
            <form action="{{ route('register') }}" method="POST" class="register-form">
                @csrf

                <!-- Username Input Group -->
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            name="username" 
                            id="username" 
                            value="{{ old('username') }}" 
                            required 
                            autofocus
                            placeholder="User" 
                            class="form-input @error('username') is-invalid @enderror"
                        >
                        <span class="input-icon">
                            <i class="fa-solid fa-user input-icon-fa"></i>
                        </span>
                    </div>
                    @error('username')
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
                            placeholder="12345678" 
                            class="form-input @error('password') is-invalid @enderror"
                        >
                        <!-- Right Key Icon (Password Visibility Toggle) -->
                        <button type="button" class="input-icon input-icon-toggle password-icon-box" id="togglePasswordBtn" aria-label="Toggle password visibility" title="Lihat password">
                            <img 
                                src="{{ asset('images/key-icon.png') }}" 
                                alt="Password Hidden" 
                                id="passwordToggleImg" 
                                class="login-input-icon-img password-icon-img" 
                                width="20" 
                                height="20"
                                data-hidden-src="{{ asset('images/key-icon.png') }}"
                                data-visible-src="{{ asset('images/key-slash-icon.png') }}"
                            >
                        </button>
                    </div>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Input Group -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="user@gmail.com" 
                            class="form-input @error('email') is-invalid @enderror"
                        >
                        <span class="input-icon">
                            <i class="fa-solid fa-envelope input-icon-fa"></i>
                        </span>
                    </div>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Input Group -->
                <div class="form-group">
                    <label for="alamat" class="form-label">Address</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            name="alamat" 
                            id="alamat" 
                            value="{{ old('alamat') }}" 
                            placeholder="Jl. Kambing Guling" 
                            class="form-input @error('alamat') is-invalid @enderror"
                        >
                        <span class="input-icon">
                            <i class="fa-solid fa-address-book input-icon-fa"></i>
                        </span>
                    </div>
                    @error('alamat')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number Input Group -->
                <div class="form-group">
                    <label for="no_telp" class="form-label">Phone Number</label>
                    <div class="phone-input-group">
                        <div class="phone-prefix-box">+62</div>
                        <div class="phone-input-wrapper">
                            <input 
                                type="text" 
                                name="no_telp" 
                                id="no_telp" 
                                value="{{ old('no_telp') }}" 
                                required 
                                placeholder="0812345678910" 
                                class="form-input @error('no_telp') is-invalid @enderror"
                            >
                            <span class="input-icon">
                                <i class="fa-solid fa-phone input-icon-fa"></i>
                            </span>
                        </div>
                    </div>
                    @error('no_telp')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    Register
                </button>
            </form>

            <!-- Login Link -->
            <div class="register-footer-links">
                <p>Already have an account ? <a href="{{ route('login') }}">Login</a></p>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.body.classList.add('login-page-body', 'register-page-body');

    // Toggle password visibility
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const passwordToggleImg = document.getElementById('passwordToggleImg');

    if (togglePasswordBtn && passwordInput && passwordToggleImg) {
        togglePasswordBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const isPassword = passwordInput.getAttribute('type') === 'password';
            
            if (isPassword) {
                passwordInput.setAttribute('type', 'text');
                passwordToggleImg.src = passwordToggleImg.getAttribute('data-visible-src');
                passwordToggleImg.alt = 'Password Visible';
                togglePasswordBtn.setAttribute('title', 'Sembunyikan password');
            } else {
                passwordInput.setAttribute('type', 'password');
                passwordToggleImg.src = passwordToggleImg.getAttribute('data-hidden-src');
                passwordToggleImg.alt = 'Password Hidden';
                togglePasswordBtn.setAttribute('title', 'Lihat password');
            }
            passwordInput.focus();
        });
    }
</script>
@endsection
