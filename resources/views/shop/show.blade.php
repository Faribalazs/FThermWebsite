@extends('layouts.public')

@section('title', translate($product->name))

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-primary-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('shop.index') }}" class="hover:text-primary-600">Products</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900 font-medium">{{ translate($product->name) }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Product Images -->
            <div class="space-y-4">
                @if($product->images->count() > 0)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ translate($product->name) }}" class="w-full h-96 object-cover" id="mainImage">
                </div>
                @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                    <button onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')" class="bg-white rounded-lg border-2 border-gray-200 hover:border-primary-500 transition overflow-hidden">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ translate($product->name) }}" class="w-full h-24 object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
                @else
                <div class="bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl h-96 flex items-center justify-center">
                    <svg class="w-32 h-32 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                @if($product->category)
                <p class="text-primary-600 font-medium mb-2">{{ translate($product->category->name) }}</p>
                @endif
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ translate($product->name) }}</h1>
                
                @if($product->price)
                <div class="mb-6">
                    <p class="text-4xl font-bold text-primary-600">{{ number_format($product->price, 2) }} RSD</p>
                </div>
                @endif

                <div class="bg-white rounded-xl p-6 border border-gray-200 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Description</h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ translate($product->description) }}</p>
                </div>

                @if($product->technical_specs)
                <div class="bg-white rounded-xl p-6 border border-gray-200 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Technical Specifications</h3>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ translate($product->technical_specs) }}</div>
                </div>
                @endif

                @if($product->pdf_path)
                <div class="mb-6">
                    <a href="{{ asset('storage/' . $product->pdf_path) }}" target="_blank" class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold px-6 py-3 rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download PDF
                    </a>
                </div>
                @endif

                <div class="space-y-4">
                    <a href="#contact" class="block w-full bg-primary-600 hover:bg-primary-700 text-white text-center font-semibold px-8 py-4 rounded-lg transition transform hover:scale-105">
                        Request Inquiry
                    </a>
                    <a href="{{ route('home') }}#contact" class="block w-full bg-accent-600 hover:bg-accent-700 text-white text-center font-semibold px-8 py-4 rounded-lg transition">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($related_products->count() > 0)
        <div class="mt-20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($related_products as $related)
                <a href="{{ route('shop.show', $related) }}" class="bg-white rounded-xl shadow-sm hover:shadow-xl transition border border-gray-200 overflow-hidden group">
                    @if($related->primaryImage)
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 overflow-hidden">
                        <img src="{{ asset('storage/' . $related->primaryImage->image_path) }}" alt="{{ translate($related->name) }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-sm font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition line-clamp-2">{{ translate($related->name) }}</h3>
                        @if($related->price)
                        <p class="text-lg font-bold text-primary-600">{{ number_format($related->price, 2) }} RSD</p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Contact Section -->
<section id="contact" class="py-20 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Interested in this product?</h2>
            <p class="text-xl text-gray-600">Send us an inquiry and we'll get back to you with more information</p>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 space-y-6">
            @csrf
            <input type="hidden" name="message" value="Inquiry about product: {{ translate($product->name) }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name') }}">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('email') }}">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                <input type="text" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('phone') }}">
                @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-4 rounded-lg transition transform hover:scale-105">
                Send Inquiry
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
