@extends('layouts.admin')

@section('title', 'Radnici')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Radnici</h1>
            <p class="mt-2 text-sm text-gray-500">Upravljanje nalozima radnika i njihovim statusima.</p>
        </div>
        <a href="{{ route('admin.workers.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-primary-700 shadow-sm transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Dodaj novog radnika
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Radnik</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontakt</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Naloga</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Upravljanje</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($workers as $worker)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $worker->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center mr-3 border border-gray-200 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $worker->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($worker->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                    Aktivan
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                    Banovan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.workers.edit', $worker) }}" class="text-gray-500 hover:text-primary-600 font-medium transition-colors" title="Izmeni">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                @if($worker->is_active)
                                    <form action="{{ route('admin.workers.ban', $worker) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite da banujete ovog korisnika?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-500 hover:text-orange-600 transition-colors" title="Banuj">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.workers.unban', $worker) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite da aktivirate ovog korisnika?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-500 hover:text-green-600 transition-colors" title="Aktiviraj">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.workers.destroy', $worker) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovog radnika?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-600 transition-colors" title="Obriši">
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
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="h-12 w-12 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-lg font-medium text-gray-900">Još uvek nema radnika</p>
                                <p class="mt-1 text-sm text-gray-500">Počnite tako što ćete dodati svog prvog radnika.</p>
                                <a href="{{ route('admin.workers.create') }}" class="mt-4 text-primary-600 hover:text-primary-700 font-medium">
                                    + Dodaj radnika
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($workers->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $workers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

