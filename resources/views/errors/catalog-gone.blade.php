@extends('layouts.public')

@php
    $copy = match (current_locale()) {
        'hu' => [
            'title' => 'A termékkatalógus jelenleg nem elérhető | FTHERM',
            'eyebrow' => 'FTHERM szolgáltatások',
            'heading' => 'A termékkatalógus jelenleg nem elérhető',
            'text' => 'A webáruházat kikapcsoltuk, de továbbra is segítünk a megfelelő klíma-, hőszivattyú- és fűtési rendszer kiválasztásában, telepítésében és szervizelésében.',
            'services' => 'Szolgáltatások megtekintése',
            'quote' => 'Ajánlatkérés',
        ],
        'en' => [
            'title' => 'Product catalog currently unavailable | FTHERM',
            'eyebrow' => 'FTHERM services',
            'heading' => 'The product catalog is currently unavailable',
            'text' => 'The online shop is switched off, but we can still help you choose, install and service the right air-conditioning, heat-pump or heating system.',
            'services' => 'View our services',
            'quote' => 'Request a quote',
        ],
        default => [
            'title' => 'Katalog proizvoda trenutno nije dostupan | FTHERM',
            'eyebrow' => 'FTHERM usluge',
            'heading' => 'Katalog proizvoda trenutno nije dostupan',
            'text' => 'Internet prodavnica je isključena, ali i dalje možemo da vam pomognemo pri izboru, ugradnji i servisu klima uređaja, toplotnih pumpi i sistema grejanja.',
            'services' => 'Pogledajte usluge',
            'quote' => 'Zatražite ponudu',
        ],
    };
@endphp

@section('title', $copy['title'])
@section('meta_description', $copy['text'])
@section('robots', 'noindex, nofollow, noarchive')

@section('content')
    <div class="service-page">
        <section class="service-hero min-h-[620px]">
            <img src="{{ asset('images/ftherm/hero-ftherm-technician-ac-installation.webp') }}"
                alt="FTHERM" class="service-hero__image" width="1600" height="1067">
            <div class="service-hero__overlay"></div>
            <div class="service-container service-hero__inner">
                <div class="max-w-3xl">
                    <p class="service-kicker">{{ $copy['eyebrow'] }}</p>
                    <h1 class="service-title mt-5 text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">
                        {{ $copy['heading'] }}
                    </h1>
                    <p class="service-hero-copy mt-6 text-base leading-8 sm:text-lg">{{ $copy['text'] }}</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('home', ['locale' => current_locale()]) }}#services"
                            class="service-btn service-btn--red">{{ $copy['services'] }}</a>
                        <a href="{{ route('home', ['locale' => current_locale()]) }}#contact"
                            class="service-btn service-btn--ghost">{{ $copy['quote'] }}</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
