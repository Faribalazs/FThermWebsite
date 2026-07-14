@extends('layouts.public')

@section('title', $page['title'])
@section('meta_description', $page['description'])
@section('meta_keywords', $page['keywords'] ?? ($page['eyebrow'] . ', FTHERM Subotica'))

@push('head')
    <script type="application/ld+json">{!! json_encode([
        chr(64).'context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => url()->current() . '#service',
        'name' => $page['serviceName'],
        'description' => $page['description'],
        'url' => url()->current(),
        'areaServed' => [
            ['@type' => 'City', 'name' => 'Subotica'],
            ['@type' => 'Place', 'name' => 'Palić'],
            ['@type' => 'AdministrativeArea', 'name' => 'Severnobački okrug'],
        ],
        'provider' => ['@id' => url('/#organization')],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode([
        chr(64).'context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($page['faqs'])->map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
        ])->values()->all(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
<article class="bg-white">
    <header class="bg-slate-950 py-20 text-white md:py-28">
        <div class="mx-auto max-w-5xl px-4 lg:px-10">
            <p class="section-kicker section-kicker--light">{{ $page['eyebrow'] }}</p>
            <h1 class="mt-5 max-w-4xl text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">{{ $page['heading'] }}</h1>
            <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-200">{{ $page['intro'] }}</p>
            <a href="#contact" class="ft-btn ft-btn-red mt-8 inline-flex px-6 py-4 font-black text-white">{{ __('ftherm.cta.quote') }}</a>
        </div>
    </header>

    <div class="mx-auto max-w-5xl px-4 py-16 lg:px-10 lg:py-24">
        <section class="grid gap-4 sm:grid-cols-2">
            @foreach ($page['benefits'] as $benefit)
                <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 font-bold text-slate-800">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-sky-700 text-white">✓</span>{{ $benefit }}
                </div>
            @endforeach
        </section>

        <div class="mt-16 space-y-12">
            @foreach ($page['sections'] as $section)
                <section>
                    <h2 class="text-2xl font-black text-slate-950 sm:text-3xl">{{ $section['title'] }}</h2>
                    <p class="mt-4 text-lg leading-8 text-slate-600">{{ $section['text'] }}</p>
                </section>
            @endforeach
        </div>

        <section class="mt-16 border-t border-slate-200 pt-12">
            <h2 class="text-3xl font-black text-slate-950">{{ __('ftherm.nav.faq') }}</h2>
            <div class="mt-8 space-y-4">
                @foreach ($page['faqs'] as $faq)
                    <details class="rounded-2xl border border-slate-200 p-5">
                        <summary class="cursor-pointer font-black text-slate-900">{{ $faq['q'] }}</summary>
                        <p class="mt-4 leading-7 text-slate-600">{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        <section id="contact" class="mt-16 rounded-3xl bg-sky-800 p-7 text-white sm:p-10">
            <h2 class="text-3xl font-black">{{ __('ftherm.services.next_step_title') }}</h2>
            <p class="mt-4 max-w-2xl leading-7 text-sky-100">{{ __('ftherm.services.next_step_text') }}</p>
            <a href="{{ route('home', ['locale' => current_locale()]) }}#contact" class="mt-6 inline-flex rounded-full bg-white px-6 py-3 font-black text-sky-800">{{ __('ftherm.cta.quote') }}</a>
        </section>
    </div>
</article>
@endsection
