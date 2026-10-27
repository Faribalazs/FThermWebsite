@props(['name'])
@php
    $paths = [
        'home' => 'M3 10l9-7 9 7M5 9v12h5v-7h4v7h5V9',
        'menu' => 'M4 6h16M4 12h16M4 18h16',
        'services' => 'M14.7 6.3a5 5 0 00-6.4 6.4L3 18a2.1 2.1 0 003 3l5.3-5.3a5 5 0 006.4-6.4l-3.2 3.2-3-3 3.2-3.2z',
        'phone' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11.04 11.04 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z',
        'projects' => 'M4 4h16v16H4zM4 16l5-5 4 4 3-3 4 4M15 8h.01',
        'contact' => 'M3 5h18v14H3zM3 6l9 7 9-7',
    ];
@endphp
<svg {{ $attributes }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="{{ $paths[$name] ?? $paths['contact'] }}" />
</svg>
