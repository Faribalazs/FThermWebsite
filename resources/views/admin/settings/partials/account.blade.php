<section aria-labelledby="admin-account-heading">
    <div class="mb-4">
        <h2 id="admin-account-heading" class="text-lg font-bold text-gray-900">Administratorski nalog</h2>
        <p class="mt-1 text-sm text-gray-500">Promenite podatke za prijavu na svoj nalog.</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="flex items-center gap-2 text-sm sm:text-base font-bold text-gray-900">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email za prijavu
                </h3>
            </div>
            <form action="{{ route('admin.settings.email.update') }}" method="POST" class="p-4 sm:p-6 space-y-5" aria-label="Promena email adrese">
                @csrf
                @method('PATCH')
                <p class="text-sm leading-relaxed text-gray-600">Ovu adresu koristite za prijavu u admin panel.</p>
                <div>
                    <label for="admin_email" class="block text-sm font-semibold text-gray-700 mb-2">Email adresa</label>
                    <input id="admin_email" name="email" type="email" value="{{ old('email', auth('admin')->user()->email) }}" required maxlength="255" autocomplete="username" autocapitalize="none" spellcheck="false"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"
                        aria-invalid="{{ $errors->adminEmail->has('email') ? 'true' : 'false' }}" @if($errors->adminEmail->has('email')) aria-describedby="admin_email_error" @endif>
                    @error('email', 'adminEmail')
                        <p id="admin_email_error" class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="admin_email_current_password" class="block text-sm font-semibold text-gray-700 mb-2">Trenutna lozinka</label>
                    <input id="admin_email_current_password" name="current_password" type="password" required autocomplete="current-password"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"
                        aria-invalid="{{ $errors->adminEmail->has('current_password') ? 'true' : 'false' }}" @if($errors->adminEmail->has('current_password')) aria-describedby="admin_email_password_error" @endif>
                    @error('current_password', 'adminEmail')
                        <p id="admin_email_password_error" class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full sm:w-auto px-5 py-3 bg-primary-600 text-white rounded-xl text-sm font-semibold hover:bg-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-colors">Sačuvaj email</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="flex items-center gap-2 text-sm sm:text-base font-bold text-gray-900">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v3h8z" />
                    </svg>
                    Promena lozinke
                </h3>
            </div>
            <form action="{{ route('admin.settings.password.update') }}" method="POST" class="p-4 sm:p-6 space-y-5" aria-label="Promena lozinke">
                @csrf
                @method('PUT')
                <input type="hidden" name="username" value="{{ auth('admin')->user()->email }}" autocomplete="username">
                <div>
                    <label for="admin_current_password" class="block text-sm font-semibold text-gray-700 mb-2">Trenutna lozinka</label>
                    <input id="admin_current_password" name="current_password" type="password" required autocomplete="current-password"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"
                        aria-invalid="{{ $errors->adminPassword->has('current_password') ? 'true' : 'false' }}" @if($errors->adminPassword->has('current_password')) aria-describedby="admin_current_password_error" @endif>
                    @error('current_password', 'adminPassword')
                        <p id="admin_current_password_error" class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="admin_password" class="block text-sm font-semibold text-gray-700 mb-2">Nova lozinka</label>
                    <input id="admin_password" name="password" type="password" required minlength="8" autocomplete="new-password" aria-describedby="admin_password_help{{ $errors->adminPassword->has('password') ? ' admin_password_error' : '' }}"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"
                        aria-invalid="{{ $errors->adminPassword->has('password') ? 'true' : 'false' }}">
                    <p id="admin_password_help" class="mt-2 text-xs text-gray-500">Najmanje 8 karaktera. Koristite lozinku koju ne koristite na drugim sajtovima.</p>
                    @error('password', 'adminPassword')
                        <p id="admin_password_error" class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="admin_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Potvrdite novu lozinku</label>
                    <input id="admin_password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password"
                        class="w-full rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <button type="submit" class="w-full sm:w-auto px-5 py-3 bg-primary-600 text-white rounded-xl text-sm font-semibold hover:bg-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-colors">Promeni lozinku</button>
            </form>
        </div>
    </div>
</section>
