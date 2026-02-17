@extends('layouts.admin')

@section('title', 'Radnici')

@section('content')
<div class="animate-fade-in-up">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Radnici</h1>
            <p class="mt-2 text-sm text-gray-600">Upravljanje nalozima radnika i njihovim statusima.</p>
        </div>
        <a href="{{ route('admin.workers.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 border border-transparent rounded-xl text-sm font-bold text-white hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Dodaj novog radnika
        </a>
    </div>

    <!-- Info Box about Permissions -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-light-50 border-l-4 border-primary-500 p-5 rounded-xl shadow-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0 bg-gradient-to-br from-primary-500 to-primary-600 p-2 rounded-xl">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-bold text-primary-900 mb-1">Upravljanje Dozvolama</h3>
                <p class="text-sm text-gray-700">
                    Kliknite na ikonu <strong>Izmeni</strong> pored svakog radnika da biste podesili njihove dozvole pristupa. Radnici će videti samo stranice za koje imaju dodeljene dozvole.
                </p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Radnik</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kontakt</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Dozvole</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status Naloga</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Upravljanje</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($workers as $worker)
                    <tr class="hover:bg-gradient-to-r hover:from-primary-50/30 hover:to-transparent transition-all duration-200 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center text-primary-700 font-bold text-sm mr-3 shadow-md">
                                    {{ substr($worker->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $worker->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mr-3 border border-gray-200 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
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
                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Aktivan
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 shadow-sm">
                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Banovan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.workers.edit', $worker) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 text-primary-600 hover:from-primary-100 hover:to-primary-200 transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md" title="Izmeni radnika i dozvole">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                @if($worker->is_active)
                                    <form action="{{ route('admin.workers.ban', $worker) }}" method="POST" class="inline" data-confirm="Da li ste sigurni da želite da banujete ovog korisnika?" data-type="ban">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600 hover:from-orange-100 hover:to-orange-200 transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md" title="Banuj">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.workers.unban', $worker) }}" method="POST" class="inline" data-confirm="Da li ste sigurni da želite da aktivirate ovog korisnika?" data-type="activate">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-green-50 to-green-100 text-green-600 hover:from-green-100 hover:to-green-200 transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md" title="Aktiviraj">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.workers.destroy', $worker) }}" method="POST" class="inline" data-confirm="Da li ste sigurni da želite da obrišete ovog radnika?" data-type="delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-red-50 to-red-100 text-red-600 hover:from-red-100 hover:to-red-200 transition-all duration-200 hover:scale-110 shadow-sm hover:shadow-md" title="Obriši">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <p class="text-lg font-bold text-gray-900">Još uvek nema radnika</p>
                                <p class="mt-1 text-sm text-gray-500 mb-4">Počnite tako što ćete dodati svog prvog radnika.</p>
                                <a href="{{ route('admin.workers.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
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
</div>
@endsection
