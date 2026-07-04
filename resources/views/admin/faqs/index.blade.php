@extends('layouts.admin')

@section('title', 'Česta pitanja')

@section('content')
<div class="animate-fade-in-up">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-3 sm:gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 p-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 1.793-2 3.272-2 1.933 0 3.5 1.343 3.5 3 0 1.295-.957 2.398-2.3 2.817-.646.202-1.2.76-1.2 1.433V15m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Česta pitanja</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Pitanja i odgovori prikazani na naslovnoj strani</p>
            </div>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center px-4 sm:px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-xs sm:text-sm font-bold hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Novo pitanje
        </a>
    </div>

    <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-gray-900">{{ $faqs->total() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Ukupno</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-green-600">{{ $faqs->where('active', true)->count() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Aktivna</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-3 sm:p-4 text-center">
            <p class="text-lg sm:text-2xl font-black text-gray-400">{{ $faqs->where('active', false)->count() }}</p>
            <p class="text-[10px] sm:text-xs text-gray-500 font-medium mt-0.5">Neaktivna</p>
        </div>
    </div>

    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider w-20">#</th>
                    <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Pitanje</th>
                    <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">Akcije</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($faqs as $faq)
                    <tr class="hover:bg-gradient-to-r hover:from-primary-50/30 hover:to-transparent transition-all duration-200 group">
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-primary-100 to-primary-200 text-primary-700 font-bold text-xs shadow-sm">
                                {{ $faq->order }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-gray-900">{{ $faq->question['sr'] ?? $faq->question['en'] ?? '' }}</p>
                            <p class="mt-1 max-w-2xl truncate text-[11px] text-gray-400">{{ $faq->answer['sr'] ?? $faq->answer['en'] ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($faq->active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Aktivno
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-500 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Neaktivno
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 transition-all duration-200 hover:scale-110" title="Izmeni">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline" data-confirm="Da li ste sigurni da želite da obrišete pitanje '{{ $faq->question['sr'] ?? $faq->question['en'] ?? '' }}'?" data-type="delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-all duration-200 hover:scale-110" title="Obriši">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-4 rounded-2xl mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 1.793-2 3.272-2 1.933 0 3.5 1.343 3.5 3 0 1.295-.957 2.398-2.3 2.817-.646.202-1.2.76-1.2 1.433V15m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-base font-bold text-gray-900">Nema pitanja</p>
                                <p class="mt-1 text-sm text-gray-500 mb-4">Počnite dodavanjem prvog pitanja</p>
                                <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Novo pitanje
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($faqs->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>

    <div class="lg:hidden space-y-3">
        @forelse($faqs as $faq)
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900">{{ $faq->question['sr'] ?? $faq->question['en'] ?? '' }}</p>
                            <p class="mt-1 line-clamp-2 text-[11px] text-gray-400">{{ $faq->answer['sr'] ?? $faq->answer['en'] ?? '' }}</p>
                        </div>
                        @if($faq->active)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-200 flex-shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Aktivno
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-50 text-gray-500 border border-gray-200 flex-shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Neaktivno
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            <span class="text-xs font-bold text-gray-600">Redosled: {{ $faq->order }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline" data-confirm="Da li ste sigurni da želite da obrišete pitanje '{{ $faq->question['sr'] ?? $faq->question['en'] ?? '' }}'?" data-type="delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8 text-center">
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-4 rounded-2xl inline-block mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 1.793-2 3.272-2 1.933 0 3.5 1.343 3.5 3 0 1.295-.957 2.398-2.3 2.817-.646.202-1.2.76-1.2 1.433V15m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-base font-bold text-gray-900">Nema pitanja</p>
                <p class="mt-1 text-sm text-gray-500 mb-4">Počnite dodavanjem prvog pitanja</p>
                <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-bold shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Novo pitanje
                </a>
            </div>
        @endforelse

        @if($faqs->hasPages())
            <div class="mt-4">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
