<nav class="mobile-app-nav" aria-label="{{ __('ftherm.mobile.navigation') }}" data-mobile-nav data-home-page="{{ request()->routeIs('home') ? 'true' : 'false' }}">
    <span class="mobile-app-nav__surface" aria-hidden="true"></span>
    <div class="mobile-app-nav__inner">
        <a href="{{ route('home') }}#services" class="mobile-app-nav__item" data-destination="services" @if(request()->routeIs('services.*', 'local-seo.*')) aria-current="page" @endif>
            <x-public-icon name="services" />
            <span>{{ __('ftherm.mobile.services') }}</span>
        </a>
        <a href="{{ route('references.index') }}" class="mobile-app-nav__item" @if(request()->routeIs('references.*')) aria-current="page" @endif>
            <x-public-icon name="projects" />
            <span>{{ __('ftherm.mobile.projects') }}</span>
        </a>
        <a href="{{ route('home') }}" class="mobile-app-nav__home" data-destination="home" aria-label="FTHERM — {{ __('ftherm.mobile.home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>
            <img src="{{ asset('images/logo.svg') }}" alt="" width="88" height="58">
        </a>
        <a href="{{ route('contact') }}" class="mobile-app-nav__item" @if(request()->routeIs('contact')) aria-current="page" @endif>
            <x-public-icon name="contact" />
            <span>{{ __('ftherm.nav.contact') }}</span>
        </a>
        <button type="button" class="mobile-app-nav__item" @click="mobileMenu = true" aria-controls="mobile-menu" :aria-expanded="mobileMenu.toString()">
            <x-public-icon name="menu" />
            <span>{{ __('ftherm.mobile.menu') }}</span>
        </button>
    </div>
</nav>

@if ($companyPhone)
    <a href="{{ $telHref }}" class="mobile-call-button mobile-app-call" aria-label="{{ __('ftherm.cta.call') }}: {{ $companyPhone }}">
        <x-public-icon name="phone" />
    </a>
@endif
