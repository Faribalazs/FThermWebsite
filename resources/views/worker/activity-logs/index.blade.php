@extends('layouts.worker')

@section('title', 'Dnevnik Aktivnosti')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 animate-fade-in">
            <h1 class="text-3xl font-bold text-gray-900">Dnevnik Aktivnosti</h1>
            <p class="text-gray-600 mt-1">Pregled svih vaših aktivnosti u sistemu</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('worker.activity-logs.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Action Type Filter -->
                <div>
                    <label for="action_type" class="block text-sm font-medium text-gray-700 mb-2">Tip akcije</label>
                    <select name="action_type" id="action_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Sve akcije</option>
                        @foreach($actionTypes as $key => $label)
                            <option value="{{ $key }}" {{ request('action_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Entity Type Filter -->
                <div>
                    <label for="entity_type" class="block text-sm font-medium text-gray-700 mb-2">Tip entiteta</label>
                    <select name="entity_type" id="entity_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Svi entiteti</option>
                        @foreach($entityTypes as $key => $label)
                            <option value="{{ $key }}" {{ request('entity_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Od datuma</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Do datuma</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-2 lg:col-span-4 flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filtriraj
                    </button>
                    <a href="{{ route('worker.activity-logs.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                        Poništi filtere
                    </a>
                </div>
            </form>
        </div>

        <!-- Activity Logs List -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            @if($logs->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($logs as $log)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <!-- Action Badge -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $log->action_type === 'create' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                            {{ $log->action_type === 'update' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                            {{ $log->action_type === 'delete' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}
                                            {{ $log->action_type === 'replenish' ? 'bg-purple-100 text-purple-800 border border-purple-200' : '' }}
                                            {{ $log->action_type === 'set' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : '' }}">
                                            {{ $log->getActionLabel() }}
                                        </span>

                                        <!-- Entity Badge -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                            {{ $log->getEntityLabel() }}
                                        </span>

                                        <!-- Timestamp -->
                                        <span class="text-xs text-gray-500">
                                            {{ $log->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-gray-900 font-medium mb-2">{{ $log->description }}</p>

                                    <!-- Additional Data -->
                                    @if($log->data)
                                        <div class="mt-3 bg-gray-50 rounded-lg p-4 border border-gray-200">
                                            <p class="text-xs font-semibold text-gray-600 mb-2 uppercase">Detalji:</p>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                                                @foreach($log->data as $key => $value)
                                                    @if(!is_array($value))
                                                        <div class="flex items-start">
                                                            <span class="font-semibold text-gray-700 min-w-[120px]">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                            <span class="text-gray-600">{{ $value }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Date -->
                                <div class="ml-6 text-right">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $log->created_at->format('d.m.Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $log->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-lg font-medium text-gray-900 mb-2">Nema aktivnosti</p>
                    <p class="text-gray-500">
                        @if(request()->hasAny(['action_type', 'entity_type', 'date_from', 'date_to']))
                            Nema aktivnosti koje odgovaraju izabranim filterima.
                        @else
                            Još uvek nema evidentiranih aktivnosti.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
