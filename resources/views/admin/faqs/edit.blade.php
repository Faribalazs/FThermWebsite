@extends('layouts.admin')

@section('title', 'Izmeni pitanje')

@section('content')
<div class="animate-fade-in-up">
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors duration-200 group">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Nazad na česta pitanja
        </a>
    </div>

    @include('admin.faqs._form', ['faq' => $faq])
</div>
@endsection
