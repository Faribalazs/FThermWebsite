@extends('layouts.admin')

@section('title', 'Radnici')

@section('content')
<div class="animate-fade-in-up">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 sm:mb-8">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Radnici</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Upravljanje nalozima radnika i njihovim dozvolama</p>
            </div>
        </div>
        <a href="{{ route('admin.workers.create') }}" class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl text-xs sm:text-sm font-bold text-white hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 w-full sm:w-auto">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Dodaj radnika
        </a>
    </div>

    <div class="space-y-4 sm:space-y-6">
        <!-- Stats Bar -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            @php
                $totalWorkers = $workers->total();
                $activeWorkers = $workers->getCollection()->where('is_active', true)->count();
                $bannedWorkers = $workers->getCollection()->where('is_active', false)->count();
                $noPermissions = $workers->getCollection()->filter(fn($w) => empty($w->permissions))->count();
            @endphp
            <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm p-3 sm:p-4">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $totalWorkers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Ukupno</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm p-3 sm:p-4">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg sm:text-2xl font-bold text-green-600">{{ $activeWorkers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Aktivni</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm p-3 sm:p-4">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg sm:text-2xl font-bold text-red-600">{{ $bannedWorkers }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Banovani</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm p-3 sm:p-4">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg sm:text-2xl font-bold text-amber-600">{{ $noPermissions }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Bez dozvola</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Banner -->
        <div class="bg-gradient-to-r from-blue-50 to-primary-50 border border-blue-200 rounded-xl sm:rounded-2xl p-3 sm:p-4">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-primary-900">
                        <strong>Upravljanje dozvolama:</strong> Kliknite na <span class="inline-flex items-center align-middle mx-0.5 w-5 h-5 sm:w-6 sm:h-6 rounded-md bg-primary-100 text-primary-600 justify-center"><svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></span> da podesite dozvole pristupa. Radnici vide samo stranice za koje imaju odobrenje.
                    </p>
                </div>
            </div>
        </div>

        <!-- Desktop Table Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden lg:block">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Radnik</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kontakt</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Dozvole</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Upravljanje</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($workers as $worker)
                        <tr class="hover:bg-gradient-to-r hover:from-primary-50/30 hover:to-transparent transition-all duration-200 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-bold text-gray-900">{{ $worker->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mr-3 border border-gray-200 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $worker->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $permissions = $worker->permissions ?? [];
                                    $permissionCount = count($permissions);
                                @endphp
                                @if($permissionCount > 0)
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(array_slice($permissions, 0, 2) as $permission)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-light-100 to-light-200 text-primary-800 border border-primary-200 shadow-sm">
                                                {{ \App\Models\User::getAvailablePermissions()[$permission] ?? $permission }}
                                            </span>
                                        @endforeach
                                        @if($permissionCount > 2)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border border-gray-300 shadow-sm">
                                                +{{ $permissionCount - 2 }} još
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 shadow-sm">
                                        Nema dozvola
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($worker->is_active)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                        Aktivan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                        Banovan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.workers.edit', $worker) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 text-primary-600 hover:from-primary-100 hover:to-primary-200 transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md" title="Izmeni">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($worker->is_active)
                                        <form action="{{ route('admin.workers.ban', $worker) }}" method="POST" class="inline" data-confirm="Da li ste sigurni da želite da banujete ovog korisnika?" data-type="ban">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600 hover:from-orange-100 hover:to-orange-200 transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md" title="Banuj">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.workers.unban', $worker) }}" method="POST" class="inline" data-confirm="Da li ste sigurni da želite da aktivirate ovog korisnika?" data-type="activate">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-green-50 to-green-100 text-green-600 hover:from-green-100 hover:to-green-200 transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md" title="Aktiviraj">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.workers.destroy', $worker) }}" method="POST" class="inline" data-confirm="Da li ste sigurni da želite da obrišete ovog radnika?" data-type="delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-red-50 to-red-100 text-red-600 hover:from-red-100 hover:to-red-200 transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md" title="Obriši">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-4 rounded-2xl mb-4">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-bold text-gray-900">Još uvek nema radnika</p>
                                    <p class="mt-1 text-sm text-gray-500 mb-4">Počnite tako što ćete dodati svog prvog radnika.</p>
                                    <a href="{{ route('admin.workers.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        Dodaj radnika
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($workers->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                {{ $workers->links() }}
            </div>
            @endif
        </div>

        <!-- Mobile Card List -->
        <div class="lg:hidden space-y-3">
            @forelse($workers as $worker)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <!-- Card Header: Name + Status -->
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex-shrink-0 flex items-center justify-center text-primary-700 font-bold text-sm shadow-md">
                            {{ substr($worker->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $worker->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $worker->email }}</p>
                        </div>
                    </div>
                    @if($worker->is_active)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300 flex-shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1"></span>
                            Aktivan
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 flex-shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1"></span>
                            Banovan
                        </span>
                    @endif
                </div>

                <!-- Permissions -->
                <div class="px-4 pb-3">
                    @php
                        $permissions = $worker->permissions ?? [];
                        $permissionCount = count($permissions);
                    @endphp
                    @if($permissionCount > 0)
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(array_slice($permissions, 0, 3) as $permission)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-gradient-to-r from-light-100 to-light-200 text-primary-800 border border-primary-200">
                                    {{ \App\Models\User::getAvailablePermissions()[$permission] ?? $permission }}
                                </span>
                            @endforeach
                            @if($permissionCount > 3)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border border-gray-300">
                                    +{{ $permissionCount - 3 }} još
                                </span>
                            @endif
                        </div>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300">
                            Nema dozvola
                        </span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="px-4 pb-3 flex items-center gap-2 border-t border-gray-50 pt-3">
                    <a href="{{ route('admin.workers.edit', $worker) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-br from-primary-50 to-primary-100 text-primary-700 text-xs font-bold hover:from-primary-100 hover:to-primary-200 transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Izmeni
                    </a>
                    @if($worker->is_active)
                        <form action="{{ route('admin.workers.ban', $worker) }}" method="POST" class="flex-1" data-confirm="Da li ste sigurni da želite da banujete ovog korisnika?" data-type="ban">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-br from-orange-50 to-orange-100 text-orange-700 text-xs font-bold hover:from-orange-100 hover:to-orange-200 transition-all duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Banuj
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.workers.unban', $worker) }}" method="POST" class="flex-1" data-confirm="Da li ste sigurni da želite da aktivirate ovog korisnika?" data-type="activate">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-br from-green-50 to-green-100 text-green-700 text-xs font-bold hover:from-green-100 hover:to-green-200 transition-all duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Aktiviraj
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.workers.destroy', $worker) }}" method="POST" data-confirm="Da li ste sigurni da želite da obrišete ovog radnika?" data-type="delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gradient-to-br from-red-50 to-red-100 text-red-600 hover:from-red-100 hover:to-red-200 transition-all duration-200">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8 text-center">
                <div class="flex flex-col items-center justify-center text-gray-500">
                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-4 rounded-2xl mb-4">
                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <p class="text-base font-bold text-gray-900">Još uvek nema radnika</p>
                    <p class="mt-1 text-sm text-gray-500 mb-4">Počnite dodavanjem prvog radnika.</p>
                    <a href="{{ route('admin.workers.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Dodaj radnika
                    </a>
                </div>
            </div>
            @endforelse

            @if($workers->hasPages())
            <div class="py-2">
                {{ $workers->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
