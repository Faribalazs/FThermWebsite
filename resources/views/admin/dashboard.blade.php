@extends('layouts.admin')

@section('title', 'Kontrolna tabla')

@section('content')
<div class="animate-fade-in-up">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Kontrolna tabla</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Pregled stanja i brze radnje</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 lg:p-5 group hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg sm:text-2xl font-black text-gray-900">{{ $stats['total_products'] }}</p>
                    <p class="text-[10px] sm:text-xs text-gray-500 font-medium">Proizvodi</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 lg:p-5 group hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg sm:text-2xl font-black text-green-600">{{ $stats['total_services'] }}</p>
                    <p class="text-[10px] sm:text-xs text-gray-500 font-medium">Usluge</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 lg:p-5 group hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg sm:text-2xl font-black text-purple-600">{{ $stats['total_inquiries'] }}</p>
                    <p class="text-[10px] sm:text-xs text-gray-500 font-medium">Upiti</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 lg:p-5 group hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-lg sm:rounded-xl bg-gradient-to-br from-secondary-50 to-secondary-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg sm:text-2xl font-black text-secondary-600">{{ $stats['unread_inquiries'] }}</p>
                    <p class="text-[10px] sm:text-xs text-gray-500 font-medium">Nepročitani</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Website Analytics -->
    <section class="mb-6 sm:mb-8">
        <div class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-primary-600">Analitika sajta</p>
                <h2 class="mt-1 text-lg font-black text-gray-900 sm:text-xl">Posete i popularnost</h2>
            </div>
            <p class="text-xs text-gray-500">Podaci bez botova · poslednjih 30 dana</p>
        </div>

        @if($analytics['available'])
            <div class="mb-4 grid grid-cols-2 gap-3 lg:grid-cols-4">
                @foreach([
                    ['label' => 'Danas', 'value' => $analytics['today'], 'color' => 'text-sky-600', 'bg' => 'from-sky-50 to-sky-100'],
                    ['label' => 'Posete / 7 dana', 'value' => $analytics['seven_days'], 'color' => 'text-indigo-600', 'bg' => 'from-indigo-50 to-indigo-100'],
                    ['label' => 'Posete / 30 dana', 'value' => $analytics['thirty_days'], 'color' => 'text-primary-600', 'bg' => 'from-primary-50 to-primary-100'],
                    ['label' => 'Jedinstveni posetioci', 'value' => $analytics['unique_thirty_days'], 'color' => 'text-emerald-600', 'bg' => 'from-emerald-50 to-emerald-100'],
                ] as $metric)
                    <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
                        <div class="mb-3 h-1.5 w-12 rounded-full bg-gradient-to-r {{ $metric['bg'] }}"></div>
                        <p class="text-2xl font-black {{ $metric['color'] }} sm:text-3xl">{{ number_format($metric['value']) }}</p>
                        <p class="mt-1 text-[11px] font-bold text-gray-500 sm:text-xs">{{ $metric['label'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mb-4 grid gap-4 xl:grid-cols-[1.35fr_0.65fr]">
                <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
                    <div class="mb-5 flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-black text-gray-900">Posete poslednjih 7 dana</h3>
                            <p class="mt-0.5 text-xs text-gray-500">Dnevni broj pregleda javnih stranica</p>
                        </div>
                        <span class="rounded-full px-2.5 py-1 text-xs font-black {{ $analytics['growth'] >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ $analytics['growth'] >= 0 ? '+' : '' }}{{ $analytics['growth'] }}%
                        </span>
                    </div>
                    @php $trendMax = max(1, $analytics['trend']->max('total')); @endphp
                    <div class="flex h-44 items-end gap-2 sm:gap-4" aria-label="Grafikon poseta">
                        @foreach($analytics['trend'] as $day)
                            <div class="flex min-w-0 flex-1 flex-col items-center justify-end gap-2">
                                <span class="text-[10px] font-black text-gray-600">{{ $day['total'] }}</span>
                                <div class="w-full max-w-10 rounded-t-lg bg-gradient-to-t from-primary-600 to-sky-400 transition-all" style="height: {{ max(5, round(($day['total'] / $trendMax) * 112)) }}px"></div>
                                <span class="text-[9px] font-bold text-gray-400 sm:text-[10px]">{{ $day['date'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 xl:grid-cols-1">
                    <div class="rounded-2xl border border-gray-100 bg-gradient-to-br from-slate-900 to-slate-800 p-4 text-white shadow-sm sm:p-5">
                        <p class="text-xs font-bold text-slate-300">Promena poseta</p>
                        <p class="mt-2 text-2xl font-black {{ $analytics['growth'] >= 0 ? 'text-green-300' : 'text-red-300' }}">{{ $analytics['growth'] >= 0 ? '+' : '' }}{{ $analytics['growth'] }}%</p>
                        <p class="mt-1 text-[10px] leading-4 text-slate-400">u odnosu na prethodnih 30 dana</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
                        <p class="text-xs font-bold text-gray-500">Konverzija u upite</p>
                        <p class="mt-2 text-2xl font-black text-purple-600">{{ $analytics['conversion'] }}%</p>
                        <p class="mt-1 text-[10px] leading-4 text-gray-400">upiti / jedinstveni posetioci</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-4 py-3 sm:px-5"><h3 class="text-sm font-black text-gray-900">Najpopularnije stranice</h3></div>
                    <div class="divide-y divide-gray-50">
                        @forelse($analytics['popular_pages'] as $page)
                            <div class="flex items-center justify-between gap-3 px-4 py-3 sm:px-5">
                                <span class="min-w-0 truncate text-xs font-bold text-gray-700" title="{{ $page->path }}">{{ $page->path }}</span>
                                <span class="flex-shrink-0 rounded-full bg-primary-50 px-2.5 py-1 text-[10px] font-black text-primary-700">{{ number_format($page->total) }}</span>
                            </div>
                        @empty
                            <p class="p-5 text-sm text-gray-400">Još nema podataka.</p>
                        @endforelse
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">
                    @foreach([
                        ['title' => 'Uređaji', 'items' => $analytics['devices'], 'key' => 'device'],
                        ['title' => 'Jezici', 'items' => $analytics['languages'], 'key' => 'locale'],
                        ['title' => 'Izvori', 'items' => $analytics['sources'], 'key' => 'source'],
                    ] as $group)
                        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
                            <h3 class="mb-3 text-xs font-black uppercase tracking-wide text-gray-500">{{ $group['title'] }}</h3>
                            <div class="space-y-3">
                                @forelse($group['items'] as $item)
                                    @php $label = $item->{$group['key']}; @endphp
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="min-w-0 truncate text-xs font-bold capitalize text-gray-700">{{ $label }}</span>
                                        <span class="text-xs font-black text-gray-900">{{ number_format($item->total) }}</span>
                                    </div>
                                @empty
                                    <span class="text-xs text-gray-400">Nema podataka</span>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                Analitika će biti dostupna nakon pokretanja migracija: <code class="font-bold">php artisan migrate --force</code>
            </div>
        @endif
    </section>

    <!-- Recent Inquiries -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6 sm:mb-8">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-1.5 sm:p-2 rounded-lg sm:rounded-xl">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900">Nedavni upiti</h3>
                        <p class="text-[10px] sm:text-xs text-gray-500 hidden sm:block">Poslednjih 5 primljenih upita</p>
                    </div>
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center gap-1 text-xs sm:text-sm font-bold text-primary-600 hover:text-primary-700 hover:gap-2 transition-all duration-200">
                    Vidi sve
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50/50 to-transparent border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Ime</th>
                        <th class="px-6 py-3 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Datum</th>
                        <th class="px-6 py-3 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">Akcije</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recent_inquiries as $inquiry)
                    <tr class="hover:bg-gradient-to-r hover:from-primary-50/30 hover:to-transparent transition-all duration-200 group">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-gray-900">{{ $inquiry->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="text-sm text-gray-600">{{ $inquiry->email }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-center">
                            <span class="text-xs text-gray-500 font-medium">{{ $inquiry->created_at->format('d.m.Y') }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-center">
                            @if($inquiry->is_read)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-500 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Pročitano
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-secondary-50 text-secondary-700 border border-secondary-200 animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary-500"></span>
                                    Novo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex justify-end">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 transition-all duration-200 hover:scale-110" title="Pregledaj">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-4 rounded-2xl mb-3">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900">Nema upita</p>
                                <p class="text-xs text-gray-500 mt-0.5">Kada neko pošalje upit, pojaviće se ovde</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="lg:hidden divide-y divide-gray-50">
            @forelse($recent_inquiries as $inquiry)
            <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="block p-4 hover:bg-gradient-to-r hover:from-primary-50/30 hover:to-transparent transition-all duration-200">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                            {{ mb_substr($inquiry->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $inquiry->name }}</p>
                            <p class="text-[11px] text-gray-400 truncate">{{ $inquiry->email }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1 flex-shrink-0">
                        @if($inquiry->is_read)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-50 text-gray-500 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Pročitano
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-secondary-50 text-secondary-700 border border-secondary-200 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary-500"></span>
                                Novo
                            </span>
                        @endif
                        <span class="text-[10px] text-gray-400">{{ $inquiry->created_at->format('d.m.Y') }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="p-8 text-center">
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-4 rounded-2xl inline-block mb-3">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-gray-900">Nema upita</p>
                <p class="text-xs text-gray-500 mt-0.5">Kada neko pošalje upit, pojaviće se ovde</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-1.5 sm:p-2 rounded-lg sm:rounded-xl">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900">Brze radnje</h3>
                    <p class="text-[10px] sm:text-xs text-gray-500 hidden sm:block">Prečice do čestih akcija</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
            <a href="{{ route('admin.products.create') }}" class="group flex items-center gap-3 p-4 sm:p-5 hover:bg-gradient-to-br hover:from-primary-50/50 hover:to-transparent transition-all duration-200">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Novi proizvod</p>
                    <p class="text-[10px] sm:text-xs text-gray-500">Dodaj u katalog</p>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-primary-500 ml-auto flex-shrink-0 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('admin.services.create') }}" class="group flex items-center gap-3 p-4 sm:p-5 hover:bg-gradient-to-br hover:from-green-50/50 hover:to-transparent transition-all duration-200">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 group-hover:text-green-600 transition-colors">Nova usluga</p>
                    <p class="text-[10px] sm:text-xs text-gray-500">Dodaj na sajt</p>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-green-500 ml-auto flex-shrink-0 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('admin.inquiries.index') }}" class="group flex items-center gap-3 p-4 sm:p-5 hover:bg-gradient-to-br hover:from-purple-50/50 hover:to-transparent transition-all duration-200">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 group-hover:text-purple-600 transition-colors">Svi upiti</p>
                    <p class="text-[10px] sm:text-xs text-gray-500">Pregledaj poruke</p>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-purple-500 ml-auto flex-shrink-0 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="group flex items-center gap-3 p-4 sm:p-5 hover:bg-gradient-to-br hover:from-amber-50/50 hover:to-transparent transition-all duration-200">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 group-hover:text-amber-600 transition-colors">Podešavanja</p>
                    <p class="text-[10px] sm:text-xs text-gray-500">Konfiguriši sajt</p>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-amber-500 ml-auto flex-shrink-0 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection
