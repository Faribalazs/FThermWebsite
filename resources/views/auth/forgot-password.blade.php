<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Forgot Password?</h2>
        <p class="mt-2 text-gray-600">
            No problem. Just let us know your email address and we will email you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" 
                class="block mt-2 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus
                placeholder="admin@ftherm.rs" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition">
                ← Back to login
            </a>
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 shadow-lg">
                {{ __('Send Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
