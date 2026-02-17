@extends('layouts.worker')

@section('title', 'Nema Dozvola')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-4rem)] p-6">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center">
            <!-- Icon -->
            <div class="w-20 h-20 mx-auto mb-6 bg-orange-100 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-900 mb-3">Nema Dozvola</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Trenutno nemate dodeljene dozvole za pristup bilo kojoj stranici.
            </p>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                <p class="text-sm text-blue-800">
                    <svg class="inline w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Molimo kontaktirajte administratora da vam dodeli dozvole pristupa.
                </p>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('worker.logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all shadow-md hover:shadow-lg">
                    Odjavi se
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
