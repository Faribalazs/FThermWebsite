@extends('layouts.public')

@section('title', __('frontend.shop_title'))

@section('content')
<!-- Header -->
<section class="bg-gradient-to-br from-primary-800 via-primary-900 to-gray-900 text-white py-16 md:py-20 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
    <div class="relative max-w-[1440px] mx-auto px-4 lg:px-10">
        <div class="max-w-2xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3 tracking-tight">{{ __('frontend.shop_title') }}</h1>
            <p class="text-lg text-primary-100/80">{{ __('frontend.shop_subtitle') }}</p>
        </div>
    </div>
</section>

<div class="max-w-[1440px] mx-auto px-4 lg:px-10 py-10 md:py-14">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-60 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 lg:sticky lg:top-24">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">{{ __('frontend.shop_categories') }}</h3>
                <form method="GET" action="{{ route('shop.index') }}">
                    <div class="space-y-2">
                        <label class="flex items-center px-3 py-2 rounded-lg cursor-pointer transition {{ request('category') == '' ? 'bg-primary-50 text-primary-700' : 'hover:bg-gray-50 text-gray-600' }}">
                            <input type="radio" name="category" value="" {{ request('category') == '' ? 'checked' : '' }} onchange="this.form.submit()" class="text-primary-600 focus:ring-primary-500 w-4 h-4">
                            <span class="ml-3 text-sm font-medium">{{ __('frontend.shop_all_products') }}</span>
                        </label>
                        @foreach($categories as $category)
                        <label class="flex items-center px-3 py-2 rounded-lg cursor-pointer transition {{ request('category') == $category->id ? 'bg-primary-50 text-primary-700' : 'hover:bg-gray-50 text-gray-600' }}">
                            <input type="radio" name="category" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }} onchange="this.form.submit()" class="text-primary-600 focus:ring-primary-500 w-4 h-4">
                            <span class="ml-3 text-sm font-medium">{{ translate($category->name) }}</span>
                        </label>
                        @endforeach
                    </div>
                </form>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($products as $product)
                <a href="{{ route('shop.show', $product) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                    @if($product->primaryImage)
                    <div class="relative overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ translate($product->name) }}" class="w-full h-52 object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    @else
                    <div class="h-52 bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center">
                        <svg class="w-14 h-14 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="p-5">
                        @if($product->category)
                        <p class="text-xs text-primary-600 font-bold uppercase tracking-wider mb-2">{{ translate($product->category->name) }}</p>
                        @endif
                        <h3 class="text-base font-bold text-gray-900 mb-2 group-hover:text-primary-700 transition-colors line-clamp-2">{{ translate($product->name) }}</h3>
                        <p class="text-gray-500 text-xs mb-3 line-clamp-2 leading-relaxed">{{ translate($product->description) }}</p>
                        @if($product->price)
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-bold text-primary-600">{{ number_format($product->price, 2) }}</span>
                            <span class="text-xs text-gray-400 font-medium">RSD</span>
                        </div>
                        @endif
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <p class="text-lg text-gray-500 font-medium">{{ __('frontend.shop_no_products') }}</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-10">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection