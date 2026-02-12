@extends('layouts.public')

@section('title', 'Products')

@section('content')
<div class="bg-gradient-to-r from-industrial-900 to-industrial-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Products</h1>
        <p class="text-xl text-gray-300">Browse our selection of premium HVAC equipment</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Categories</h3>
                <form method="GET" action="{{ route('shop.index') }}">
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="category" value="" {{ request('category') == '' ? 'checked' : '' }} onchange="this.form.submit()" class="text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-gray-700">All Products</span>
                        </label>
                        @foreach($categories as $category)
                        <label class="flex items-center">
                            <input type="radio" name="category" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }} onchange="this.form.submit()" class="text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-gray-700">{{ translate($category->name) }}</span>
                        </label>
                        @endforeach
                    </div>
                </form>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                <a href="{{ route('shop.show', $product) }}" class="bg-white rounded-xl shadow-sm hover:shadow-xl transition border border-gray-200 overflow-hidden group">
                    @if($product->primaryImage)
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 overflow-hidden">
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ translate($product->name) }}" class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    @else
                    <div class="h-56 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="p-6">
                        @if($product->category)
                        <p class="text-sm text-primary-600 font-medium mb-2">{{ translate($product->category->name) }}</p>
                        @endif
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition line-clamp-2">{{ translate($product->name) }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ translate($product->description) }}</p>
                        @if($product->price)
                        <p class="text-2xl font-bold text-primary-600">{{ number_format($product->price, 2) }} RSD</p>
                        @endif
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-xl text-gray-500">No products found</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
