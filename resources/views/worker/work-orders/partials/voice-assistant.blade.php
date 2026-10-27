<section
    id="work-order-voice-assistant"
    data-work-order-assistant
    class="mb-6 sm:mb-8 overflow-hidden rounded-2xl border border-sky-200 bg-gradient-to-br from-sky-50 via-white to-blue-50 shadow-sm"
    aria-labelledby="work-order-assistant-title"
>
    <button
        type="button"
        data-assistant-toggle
        class="flex w-full items-center justify-between gap-3 p-4 text-left sm:p-5"
        aria-expanded="false"
        aria-controls="work-order-assistant-panel"
    >
        <span class="flex min-w-0 items-center gap-3">
            <span class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-sky-500 text-white shadow-md">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 18.5a6.5 6.5 0 006.5-6.5V9a6.5 6.5 0 10-13 0v3a6.5 6.5 0 006.5 6.5zm0 0V22m-4 0h8M9 9v3a3 3 0 006 0V9a3 3 0 10-6 0z" />
                </svg>
            </span>
            <span class="min-w-0">
                <span id="work-order-assistant-title" class="block text-base font-bold text-gray-900 sm:text-lg">
                    Magyar hangasszisztens
                </span>
                <span class="mt-0.5 block text-xs text-gray-600 sm:text-sm">
                    Mondd el az adatokat, és kitölti a radni nalogot
                </span>
            </span>
        </span>
        <span class="flex flex-shrink-0 items-center gap-2">
            <span class="hidden rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700 sm:inline-flex">
                Ingyenes
            </span>
            <svg data-assistant-chevron class="h-5 w-5 text-gray-500 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </span>
    </button>

    <div id="work-order-assistant-panel" data-assistant-panel class="hidden border-t border-sky-100">
        <div class="p-4 sm:p-5">
            <div data-assistant-intro>
                <p class="text-sm leading-6 text-gray-700">
                    Az asszisztens magyarul kérdez, a válaszaidat pedig beírja a lentebbi munkalapba.
                    Beszélhetsz a mikrofonba vagy gépelhetsz is.
                </p>
                <p class="mt-2 text-xs leading-5 text-gray-500">
                    Minden újonnan kiválasztott magyar hang az első indításakor körülbelül 63 MB-ot tölt le, utána a böngésző helyben tárolja.
                </p>
                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                    <button
                        type="button"
                        data-assistant-start
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary-600 to-sky-500 px-5 py-3 text-sm font-bold text-white shadow-md transition hover:from-primary-700 hover:to-sky-600 focus:outline-none focus:ring-4 focus:ring-sky-200"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18.5a6.5 6.5 0 006.5-6.5V9a6.5 6.5 0 10-13 0v3a6.5 6.5 0 006.5 6.5zm0 0V22m-4 0h8" />
                        </svg>
                        Hangos kitöltés indítása
                    </button>
                    <span class="self-center text-xs text-gray-500">Nem ment el semmit jóváhagyás nélkül.</span>
                </div>
            </div>

            <div data-assistant-conversation class="hidden">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <div class="mb-1 flex items-center justify-between text-xs font-semibold text-gray-500">
                            <span>Kitöltés folyamata</span>
                            <span data-assistant-progress-text>1 / 10</span>
                        </div>
                        <div class="h-1.5 overflow-hidden rounded-full bg-sky-100">
                            <div data-assistant-progress-bar
                                class="h-full rounded-full bg-gradient-to-r from-primary-600 to-sky-400 transition-all duration-300"
                                style="width: 10%"></div>
                        </div>
                    </div>
                    <div class="flex flex-shrink-0 items-center gap-2">
                        <button
                            type="button"
                            data-assistant-repeat
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-sky-200 bg-white text-primary-700 transition hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-sky-100 disabled:cursor-not-allowed disabled:opacity-40"
                            title="Kérdés újraolvasása tiszta magyar hanggal"
                            disabled
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v6h6M20 20v-6h-6M5.1 15a7 7 0 0011.2 2.3L20 14M4 10l3.7-3.3A7 7 0 0118.9 9" />
                            </svg>
                            <span class="sr-only">Kérdés újraolvasása tiszta magyar hanggal</span>
                        </button>
                        <button
                            type="button"
                            data-assistant-sound
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-sky-200 bg-white text-primary-700 transition hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-sky-100"
                            aria-pressed="true"
                            title="Magyar felolvasás kikapcsolása"
                        >
                            <svg data-assistant-sound-on class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5L6 9H2v6h4l5 4V5zm4.5 3.5a5 5 0 010 7M18 6a8 8 0 010 12" />
                            </svg>
                            <svg data-assistant-sound-off class="hidden h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5L6 9H2v6h4l5 4V5zm5 4l5 5m0-5l-5 5" />
                            </svg>
                            <span class="sr-only">Magyar felolvasás be- vagy kikapcsolása</span>
                        </button>
                    </div>
                </div>

                <div class="mb-3 flex items-center justify-between gap-3 rounded-xl border border-sky-100 bg-white/70 px-3 py-2">
                    <label for="work-order-assistant-voice" class="text-xs font-semibold text-gray-600">
                        Magyar hang
                    </label>
                    <select
                        id="work-order-assistant-voice"
                        data-assistant-voice
                        class="rounded-lg border border-sky-200 bg-white py-1.5 pl-3 pr-8 text-xs font-bold text-primary-700 focus:border-primary-500 focus:ring-2 focus:ring-primary-200"
                    >
                        <option value="hu_HU-anna-medium">Anna</option>
                        <option value="hu_HU-berta-medium">Berta</option>
                        <option value="hu_HU-imre-medium">Imre</option>
                    </select>
                </div>

                <div
                    data-assistant-messages
                    class="work-order-assistant-messages max-h-80 space-y-3 overflow-y-auto rounded-xl border border-sky-100 bg-white/80 p-3 sm:p-4"
                    role="log"
                    aria-live="polite"
                    aria-relevant="additions"
                ></div>

                <div data-assistant-quick-replies class="mt-3 flex flex-wrap gap-2"></div>

                <div class="mt-3 flex items-stretch gap-2">
                    <input
                        type="text"
                        data-assistant-input
                        class="min-w-0 flex-1 rounded-xl border border-gray-300 px-3 py-3 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200"
                        placeholder="Írd be a választ…"
                        autocomplete="off"
                    >
                    <button
                        type="button"
                        data-assistant-language
                        class="inline-flex w-12 flex-shrink-0 flex-col items-center justify-center rounded-xl border border-sky-200 bg-white text-primary-700 transition hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-sky-100"
                        title="Mikrofon nyelve: magyar. Kattints a szerb nyelvhez."
                    >
                        <span data-assistant-language-code class="text-xs font-extrabold leading-none">HU</span>
                        <span class="mt-1 text-[9px] font-semibold leading-none text-gray-500">MIC</span>
                        <span class="sr-only">Mikrofon felismerési nyelvének váltása</span>
                    </button>
                    <button
                        type="button"
                        data-assistant-microphone
                        class="inline-flex w-12 flex-shrink-0 items-center justify-center rounded-xl border border-sky-200 bg-white text-primary-700 transition hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-sky-100 disabled:cursor-not-allowed disabled:opacity-40"
                        aria-pressed="false"
                        title="Válasz bemondása magyarul"
                    >
                        <svg data-assistant-mic-idle class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15a3 3 0 003-3V7a3 3 0 10-6 0v5a3 3 0 003 3zm0 0v4m-4 0h8m3-7a7 7 0 01-14 0" />
                        </svg>
                        <span data-assistant-mic-live class="hidden h-3 w-3 animate-pulse rounded-full bg-red-500"></span>
                        <span class="sr-only">Mikrofon indítása</span>
                    </button>
                    <button
                        type="button"
                        data-assistant-send
                        class="inline-flex w-12 flex-shrink-0 items-center justify-center rounded-xl bg-primary-600 text-white transition hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-200"
                        title="Válasz elküldése"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-6-6l6 6-6 6" />
                        </svg>
                        <span class="sr-only">Válasz elküldése</span>
                    </button>
                </div>

                <div class="mt-2 flex min-h-5 items-start justify-between gap-3">
                    <p data-assistant-status class="text-xs text-gray-500">
                        A mikrofon csak a gomb megnyomásakor figyel.
                    </p>
                    <button type="button" data-assistant-restart
                        class="flex-shrink-0 text-xs font-semibold text-primary-700 hover:text-primary-900">
                        Újrakezdés
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
