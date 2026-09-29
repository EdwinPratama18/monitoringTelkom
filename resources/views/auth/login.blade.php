<x-guest-layout>
    <div class="login-box">
        <!-- Session Status -->
        @if (session('status'))
            <div style="background-color: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; font-size: 12px; padding: 10px 12px; border-radius: 6px; margin-bottom: 16px;">
                {{ session('status') }}
            </div>
        @endif

        <!-- Logo & Header -->
        <div class="login-header">
            <img src="{{ asset('images/telkom-logo.png') }}" alt="Telkom Indonesia" class="login-logo" />
            <h1 class="login-title">STO WITEL BASE-G</h1>
            <p class="login-subtitle">Sistem Informasi Monitoring & Pemeliharaan DEFA</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="input-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="email@witelbaseg.id"
                       class="form-input @error('email') is-error @enderror" />
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="password" class="input-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="form-input @error('password') is-error @enderror" />
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login">
                <span>Login</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <!-- Footer -->
        <div class="login-footer">
            PT Telkom Indonesia (Persero) Tbk &bull; Witel Papua
        </div>
    </div>
</x-guest-layout>
