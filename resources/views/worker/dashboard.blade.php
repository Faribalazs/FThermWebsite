@extends('layouts.worker')

@section('title', 'Dashboard')

@section('content')
<div class="p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="mb-5 sm:mb-6 animate-fade-in">
            <h1 class="text-xl sm:text-3xl font-bold text-gray-900">
                Dobrodošli, {{ auth('worker')->user()->name }}!
            </h1>
            <p class="text-sm sm:text-base text-gray-500 mt-0.5 sm:mt-1">{{ now()->locale('sr')->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid sm:grid-cols-2 grid-cols-1 lg:grid-cols-4 gap-3 sm:gap-6 mb-5 sm:mb-6">
            <!-- Total Products -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 sm:p-6 animate-scale-in hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3 sm:block">
                        <div class="h-10 w-10 sm:hidden rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] sm:text-sm font-semibold text-gray-400 sm:text-gray-600 uppercase tracking-wider">Materijala</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-0.5 sm:mt-2">{{ $totalProducts }}</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex h-14 w-14 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Work Orders -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 sm:p-6 animate-scale-in hover:shadow-xl transition-shadow duration-300" style="animation-delay: 0.1s">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3 sm:block">
                        <div class="h-10 w-10 sm:hidden rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] sm:text-sm font-semibold text-gray-400 sm:text-gray-600 uppercase tracking-wider">Radni Nalozi</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-0.5 sm:mt-2">{{ $totalWorkOrders }}</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex h-14 w-14 rounded-full bg-gradient-to-br from-green-100 to-green-200 items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Inventory Value -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 sm:p-6 animate-scale-in hover:shadow-xl transition-shadow duration-300" style="animation-delay: 0.2s">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3 sm:block">
                        <div class="h-10 w-10 sm:hidden rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] sm:text-sm font-semibold text-gray-400 sm:text-gray-600 uppercase tracking-wider">Vrednost Zaliha</p>
                            <p class="text-xl sm:text-3xl font-bold text-gray-900 mt-0.5 sm:mt-2">{{ number_format($inventoryValue, 0) }} <span class="text-xs sm:text-sm font-normal text-gray-400">RSD</span></p>
                        </div>
                    </div>
                    <div class="hidden sm:flex h-14 w-14 rounded-full bg-gradient-to-br from-purple-100 to-purple-200 items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Out of Stock -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 sm:p-6 animate-scale-in hover:shadow-xl transition-shadow duration-300" style="animation-delay: 0.3s">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3 sm:block">
                        <div class="h-10 w-10 sm:hidden rounded-xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] sm:text-sm font-semibold text-gray-400 sm:text-gray-600 uppercase tracking-wider">Nema na Stanju</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-0.5 sm:mt-2">{{ $outOfStockCount }}</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex h-14 w-14 rounded-full bg-gradient-to-br from-red-100 to-red-200 items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Low Stock Alert -->
            <div class="bg-white rounded-2xl shadow-enhanced border border-gray-100 overflow-hidden animate-slide-in">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-4 sm:px-6 py-3 sm:py-4">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h2 class="text-base sm:text-xl font-bold text-white">Niske Zalihe</h2>
                        @if($lowStockProducts->count() > 0)
                        <span class="ml-auto bg-white text-red-600 text-xs sm:text-sm font-bold px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full">
                            {{ $lowStockProducts->count() }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="p-4 sm:p-6">
                    @if($lowStockProducts->count() > 0)
                    <div class="space-y-3">
                        @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-3 sm:p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl hover:bg-red-100 transition-colors">
                            <div class="flex items-center gap-2.5 sm:gap-3 flex-1 min-w-0">
                                <div class="hidden sm:flex h-10 w-10 rounded-xl bg-gradient-to-br from-red-100 to-red-200 items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm sm:text-base font-bold text-gray-900 truncate">{{ $product->name }}</p>
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        <span class="font-semibold text-red-600">{{ $product->inventory->quantity ?? 0 }}</span>
                                        <span class="text-gray-400">/</span>
                                        <span class="font-semibold">{{ $product->low_stock_threshold }}</span>
                                        {{ $product->unit }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('worker.inventory.index') }}" class="inline-flex items-center gap-1 px-2.5 sm:px-3 py-1.5 sm:py-2 bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition-colors flex-shrink-0 ml-2">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="hidden sm:inline">Dopuni</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-green-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-600 font-medium">Sve zalihe su u redu!</p>
                        <p class="text-sm text-gray-500 mt-1">Nema materijala sa niskim zalihama</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Work Orders -->
            <div class="bg-white rounded-2xl shadow-enhanced border border-gray-100 overflow-hidden animate-slide-in" style="animation-delay: 0.1s">
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-6 py-3 sm:py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h2 class="text-base sm:text-xl font-bold text-white">Poslednji Nalozi</h2>
                        </div>
                        <a href="{{ route('worker.work-orders.index') }}" class="text-white hover:text-primary-100 text-xs sm:text-sm font-medium transition-colors bg-white/15 backdrop-blur-sm px-3 py-1 rounded-full ring-1 ring-white/20">
                            Svi →
                        </a>
                    </div>
                </div>

                <div class="p-4 sm:p-6">
                    @if($recentWorkOrders->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentWorkOrders as $order)
                        <a href="{{ route('worker.work-orders.show', $order) }}" class="block p-3 sm:p-4 border border-gray-200 rounded-xl hover:border-primary-500 hover:bg-primary-50 transition-all group active:scale-[0.99]">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm sm:text-base font-bold text-gray-900 group-hover:text-primary-700 transition-colors truncate">{{ $order->client_name }}</p>
                                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">{{ $order->location }}</p>
                                    <div class="flex items-center gap-2 sm:gap-4 mt-1.5 sm:mt-2">
                                        <span class="text-[11px] sm:text-xs text-gray-400">
                                            <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $order->created_at->diffForHumans() }}
                                        </span>
                                        <span class="text-[11px] sm:text-xs font-semibold text-gray-500">
                                            {{ $order->sections->count() }} usluga
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm sm:text-lg font-bold text-primary-600">{{ number_format($order->total_amount, 0) }} <span class="text-[10px] sm:text-xs font-normal text-gray-400">RSD</span></p>
                                    @if($order->has_invoice)
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-green-100 text-green-800 text-[10px] sm:text-xs font-semibold rounded-full">
                                        Fakturisano
                                    </span>
                                    @else
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] sm:text-xs font-semibold rounded-full">
                                        Kreirano
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-600 font-medium">Nema radnih naloga</p>
                        <p class="text-sm text-gray-500 mt-1">Kreirajte svoj prvi radni nalog</p>
                        <a href="{{ route('worker.work-orders.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Novi Nalog
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-4 sm:mt-6 bg-white rounded-2xl shadow-md border border-gray-100 p-4 sm:p-6 animate-fade-in" style="animation-delay: 0.2s">
            <h2 class="text-base sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Brze Akcije
            </h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <a href="{{ route('worker.work-orders.create') }}" class="group flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 border-2 border-gray-100 rounded-xl hover:border-green-500 hover:bg-green-50 transition-all active:scale-[0.97] text-center sm:text-left">
                    <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-green-700">Novi Nalog</p>
                        <p class="hidden sm:block text-xs text-gray-500">Kreiraj nalog</p>
                    </div>
                </a>

                <a href="{{ route('worker.products.create') }}" class="group flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 border-2 border-gray-100 rounded-xl hover:border-primary-500 hover:bg-light-50 transition-all active:scale-[0.97] text-center sm:text-left">
                    <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-blue-700">Novi Materijal</p>
                        <p class="hidden sm:block text-xs text-gray-500">Dodaj materijal</p>
                    </div>
                </a>

                <a href="{{ route('worker.inventory.index') }}" class="group flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 border-2 border-gray-100 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition-all active:scale-[0.97] text-center sm:text-left">
                    <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-purple-700">Dopuna Zaliha</p>
                        <p class="hidden sm:block text-xs text-gray-500">Upravljaj zalihama</p>
                    </div>
                </a>

                <a href="{{ route('worker.products.index') }}" class="group flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 border-2 border-gray-100 rounded-xl hover:border-secondary-500 hover:bg-light-50 transition-all active:scale-[0.97] text-center sm:text-left">
                    <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-xl bg-gradient-to-br from-light-100 to-light-200 flex items-center justify-center group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-secondary-700">Svi Materijali</p>
                        <p class="hidden sm:block text-xs text-gray-500">Pregledaj sve</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
