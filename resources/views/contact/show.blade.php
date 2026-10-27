@extends('layouts.public')

@section('title', __('ftherm.contact.page_title'))
@section('meta_description', __('ftherm.contact.page_description'))

@php
    $companyPhone = setting_value('company_phone');
    $companyEmail = setting_value('company_email');
    $companyAddress = setting_value('company_address');
    $telHref = $companyPhone ? 'tel:' . preg_replace('/[^\d+]/', '', $companyPhone) : null;
@endphp

@section('content')
    <div class="contact-page">
        <section class="contact-page__hero">
            <div class="mx-auto max-w-[1280px] px-4 lg:px-10">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-sky-200">FTHERM · {{ __('ftherm.nav.contact') }}</p>
                <h1 class="mt-4 text-4xl font-black leading-tight sm:text-6xl">{{ __('ftherm.contact.page_heading') }}</h1>
                <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-200">{{ __('ftherm.contact.page_description') }}</p>
            </div>
        </section>

        <div class="contact-page__content mx-auto max-w-[1280px] px-4 py-12 lg:px-10 lg:py-16">
            <section class="contact-page__methods" aria-labelledby="contact-details-heading">
                    <h2 id="contact-details-heading" class="text-2xl font-black text-slate-950">{{ __('ftherm.contact.details_title') }}</h2>
                    <div class="mt-5 grid gap-3">
                        @if ($companyPhone)
                            <a href="{{ $telHref }}" class="contact-page__method">
                                <span class="contact-page__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z"/></svg>
                                </span>
                                <span class="min-w-0"><span class="contact-page__label">{{ __('ftherm.contact.phone') }}</span><span class="contact-page__value">{{ $companyPhone }}</span></span>
                            </a>
                        @endif
                        @if ($companyEmail)
                            <a href="mailto:{{ $companyEmail }}" class="contact-page__method">
                                <span class="contact-page__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <span class="min-w-0"><span class="contact-page__label">{{ __('ftherm.contact.email') }}</span><span class="contact-page__value">{{ $companyEmail }}</span></span>
                            </a>
                        @endif
                        @if ($companyAddress)
                            <div class="contact-page__method">
                                <span class="contact-page__icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 10c0 6-8 11-8 11S4 16 4 10a8 8 0 1116 0z"/><circle cx="12" cy="10" r="2.5"/></svg>
                                </span>
                                <span class="min-w-0"><span class="contact-page__label">{{ __('ftherm.company.address') }}</span><span class="contact-page__value">{{ $companyAddress }}</span></span>
                            </div>
                        @endif
                    </div>
            </section>
            <x-company-details class="contact-page__company" />

            <section id="contact" class="contact-page__form min-w-0" aria-labelledby="contact-form-heading">
                <h2 id="contact-form-heading" class="text-2xl font-black text-slate-950">{{ __('ftherm.contact.title') }}</h2>
                <p class="mb-5 mt-3 leading-7 text-slate-600">{{ __('ftherm.contact.subtitle') }}</p>
                @if (session('contact_success'))
                    <p role="status" class="mb-5 rounded border border-emerald-200 bg-emerald-50 p-4 font-semibold text-emerald-900">{{ session('contact_success') }}</p>
                @endif
                @include('contact._form')
            </section>
        </div>
    </div>
@endsection
