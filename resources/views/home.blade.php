@extends('layouts.public')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-primary-900/30 to-transparent"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 lg:py-40">
        <div class="max-w-3xl">
            <div class="inline-block mb-4 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium">
                <span class="flex items-center gap-2">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-secondary-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary-400"></span>
                    </span>
                    Professional HVAC Solutions
                </span>
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                {{ translate($hero['hero_title']->value ?? ['en' => 'Modern Heating Solutions']) }}
            </h1>
            <p class="text-xl md:text-2xl text-primary-100 mb-8 leading-relaxed">
                {{ translate($hero['hero_subtitle']->value ?? ['en' => 'Professional installation of heat pumps and HVAC systems']) }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#contact" class="inline-flex items-center justify-center bg-secondary-600 hover:bg-secondary-700 text-white font-bold px-8 py-4 rounded-xl transition transform hover:scale-105 shadow-xl hover:shadow-2xl">
                    {{ translate($hero['hero_cta']->value ?? ['en' => 'Request Offer']) }}
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <a href="#services" class="inline-flex items-center justify-center bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-bold px-8 py-4 rounded-xl transition border-2 border-white/20">
                    Learn More
                </a>
            </div>
        </div>
    </div>
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-12 md:h-20">
            <path d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 bg-light-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">What We Offer</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Services</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Professional HVAC solutions tailored to your needs with expert installation and maintenance</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 hover:border-primary-200 transform hover:-translate-y-2">
                @if($service->icon)
                <div class="text-5xl mb-6">{{ $service->icon }}</div>
                @else
                <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                @endif
                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-primary-600 transition">{{ translate($service->title) }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ translate($service->description) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
            <div>
                <span class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Featured Products</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Premium HVAC Equipment</h2>
                <p class="text-xl text-gray-600">Explore our range of high-quality heating and cooling solutions</p>
            </div>
            <a href="{{ route('shop.index') }}" class="hidden md:inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl transition shadow-lg hover:shadow-xl">
                View All Products
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featured_products as $product)
            <a href="{{ route('shop.show', $product) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-primary-200 overflow-hidden transform hover:-translate-y-2">
                @if($product->primaryImage)
                <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-light-100 to-light-200 overflow-hidden">
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ translate($product->name) }}" class="w-full h-56 object-cover group-hover:scale-110 transition duration-500">
                </div>
                @else
                <div class="h-56 bg-gradient-to-br from-primary-100 via-primary-200 to-primary-300 flex items-center justify-center">
                    <svg class="w-20 h-20 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition">{{ translate($product->name) }}</h3>
                    @if($product->price)
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-bold text-primary-600">{{ number_format($product->price, 2) }}</p>
                        <span class="text-gray-500 font-medium">RSD</span>
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-12 md:hidden">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-4 rounded-xl transition shadow-lg">
                View All Products
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('/images/dots.svg')] opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-semibold mb-4">Why Choose Us</span>
            <h2 class="text-4xl md:text-5xl font-bold mb-4">Why Choose FTHERM</h2>
            <p class="text-xl text-primary-100 max-w-2xl mx-auto">Your trusted partner in professional HVAC solutions with years of expertise</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3">Experience</h3>
                <p class="text-primary-100">Years of expertise in HVAC systems installation and maintenance</p>
            </div>
            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3">Professional Installation</h3>
                <p class="text-primary-100">Expert installation and comprehensive maintenance services</p>
            </div>
            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3">Energy Efficiency</h3>
                <p class="text-primary-100">Save money with our modern energy-efficient systems</p>
            </div>
            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3">Warranty</h3>
                <p class="text-primary-100">Comprehensive warranty coverage for peace of mind</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-20 bg-light-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-4">Contact Us</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Get In Touch</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Have questions? We're here to help. Send us a message and we'll respond as soon as possible.</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
                @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6 bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-900 mb-2">Name *</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" value="{{ old('name') }}" placeholder="John Doe">
                        @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email *</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" value="{{ old('email') }}" placeholder="john@example.com">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-900 mb-2">Phone</label>
                        <input type="text" id="phone" name="phone" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" value="{{ old('phone') }}" placeholder="+381 64 123 4567">
                        @error('phone')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-bold text-gray-900 mb-2">Message *</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none" placeholder="Tell us about your project...">{{ old('message') }}</textarea>
                        @error('message')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold px-8 py-4 rounded-xl transition transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <span>Send Message</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="space-y-8">
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                        Contact Information
                    </h3>
                    <div class="space-y-6">
                        <div class="flex items-start group">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 mb-1">Phone</p>
                                <a href="tel:0641391360" class="text-primary-600 hover:text-primary-700 font-medium">064 139 1360</a>
                            </div>
                        </div>
                        <div class="flex items-start group">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 mb-1">Email</p>
                                <a href="mailto:farkas.tibor@ftherm.rs" class="text-primary-600 hover:text-primary-700 font-medium break-all">farkas.tibor@ftherm.rs</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 p-8 rounded-2xl border border-primary-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Business Hours
                    </h3>
                    <div class="space-y-3 text-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Monday - Friday:</span>
                            <span class="text-primary-700 font-bold">8:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Saturday:</span>
                            <span class="text-primary-700 font-bold">9:00 AM - 2:00 PM</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Sunday:</span>
                            <span class="text-gray-500 font-bold">Closed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
