@extends('layouts.public')

@section('title', translate($product->name))

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-[1440px] mx-auto px-4 lg:px-10 py-4">
        <nav>
            <ol class="flex items-center gap-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-primary-600 transition">{{ __('frontend.nav_home') }}</a></li>
                <li><svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                <li><a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-primary-600 transition">{{ __('frontend.nav_products') }}</a></li>
                <li><svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                <li class="text-gray-900 font-medium truncate max-w-[200px]">{{ translate($product->name) }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Product Detail -->
<div class="max-w-[1440px] mx-auto px-4 lg:px-10 py-10 md:py-14">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 mb-16">
        <!-- Product Images -->
        <div class="space-y-4">
            @if($product->images->count() > 0)
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ translate($product->name) }}" class="w-full h-80 md:h-96 object-cover" id="mainImage">
            </div>
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-3">
                @foreach($product->images as $image)
                <button onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')" class="bg-white rounded-xl border-2 border-gray-100 hover:border-primary-400 transition-all overflow-hidden focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ translate($product->name) }}" class="w-full h-20 md:h-24 object-cover">
                </button>
                @endforeach
            </div>
            @endif
            @else
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl h-80 md:h-96 flex items-center justify-center">
                <svg class="w-24 h-24 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div>
            @if($product->category)
            <p class="text-xs text-primary-600 font-bold uppercase tracking-wider mb-3">{{ translate($product->category->name) }}</p>
            @endif
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">{{ translate($product->name) }}</h1>

            @if($product->price)
            <div class="mb-6">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl md:text-4xl font-bold text-primary-600">{{ number_format($product->price, 2) }}</span>
                    <span class="text-sm text-gray-400 font-medium">RSD</span>
                </div>
            </div>
            @endif

            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-5">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">{{ __('frontend.product_description') }}</h3>
                <p class="text-gray-600 leading-relaxed text-sm whitespace-pre-line">{{ translate($product->description) }}</p>
            </div>

            @if($product->technical_specs)
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-5">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">{{ __('frontend.product_specs') }}</h3>
                <div class="text-gray-600 leading-relaxed text-sm whitespace-pre-line">{{ translate($product->technical_specs) }}</div>
            </div>
            @endif

            @if($product->pdf_path)
            <div class="mb-6">
                <a href="{{ asset('storage/' . $product->pdf_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-3 rounded-xl transition text-sm">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    {{ __('frontend.product_download_pdf') }}
                </a>
            </div>
            @endif

            <div class="space-y-3">
                <a href="#contact" class="flex items-center justify-center gap-2 w-full bg-primary-600 hover:bg-primary-700 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-sm hover:shadow-md group">
                    {{ __('frontend.product_inquiry') }}
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="{{ route('home') }}#contact" class="flex items-center justify-center gap-2 w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-8 py-4 rounded-xl transition">
                    {{ __('frontend.product_contact') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($related_products->count() > 0)
    <div class="mt-16 pt-12 border-t border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ __('frontend.product_related') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related_products as $related)
            <a href="{{ route('shop.show', $related) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                @if($related->primaryImage)
                <div class="relative overflow-hidden bg-gray-100">
                    <img src="{{ asset('storage/' . $related->primaryImage->image_path) }}" alt="{{ translate($related->name) }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-500">
                </div>
                @else
                <div class="h-44 bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                <div class="p-4">
                    <h3 class="text-sm font-bold text-gray-900 mb-2 group-hover:text-primary-700 transition-colors line-clamp-2">{{ translate($related->name) }}</h3>
                    @if($related->price)
                    <div class="flex items-baseline gap-1">
                        <span class="text-lg font-bold text-primary-600">{{ number_format($related->price, 2) }}</span>
                        <span class="text-xs text-gray-400 font-medium">RSD</span>
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Contact / Inquiry Section -->
<section id="contact" class="py-16 md:py-20 bg-gray-50 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 lg:px-10">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">{{ __('frontend.product_interested') }}</h2>
            <p class="text-gray-500">{{ __('frontend.product_interested_desc') }}</p>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-5">
            @csrf
            <input type="hidden" name="message" value="Inquiry about product: {{ translate($product->name) }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('frontend.contact_name') }} <span class="text-secondary-500">*</span></label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition text-sm" value="{{ old('name') }}" placeholder="{{ __('frontend.contact_name_placeholder') }}">
                    @error('name')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('frontend.contact_email') }} <span class="text-secondary-500">*</span></label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition text-sm" value="{{ old('email') }}" placeholder="{{ __('frontend.contact_email_placeholder') }}">
                    @error('email')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('frontend.contact_phone') }}</label>
                <input type="text" id="phone" name="phone" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition text-sm" value="{{ old('phone') }}" placeholder="{{ __('frontend.contact_phone_placeholder') }}">
                @error('phone')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2 group">
                <span>{{ __('frontend.product_send_inquiry') }}</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </form>
    </div>
</section>

<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}
</script>
@endsection