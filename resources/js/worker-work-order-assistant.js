const ASSISTANT_SELECTOR = '[data-work-order-assistant]';
const HUNGARIAN_LOCALE = 'hu-HU';
const SERBIAN_LOCALE = 'sr-RS';
const DEFAULT_PIPER_VOICE = 'hu_HU-anna-medium';
const PIPER_HUNGARIAN_VOICES = {
    'hu_HU-anna-medium': 'Anna',
    'hu_HU-berta-medium': 'Berta',
    'hu_HU-imre-medium': 'Imre',
};
const TOTAL_CORE_STEPS = 10;
let piperTtsModulePromise = null;

const SERBIAN_RECOGNITION_STEPS = new Set([
    'clientName',
    'clientAddress',
    'location',
]);

function loadPiperTtsModule() {
    if (!piperTtsModulePromise) {
        piperTtsModulePromise = import('@mintplex-labs/piper-tts-web');
    }
    return piperTtsModulePromise;
}

const STEP_PROGRESS = {
    clientType: 1,
    clientName: 2,
    contactChoice: 2,
    clientAddress: 3,
    clientPhone: 4,
    location: 5,
    kilometers: 6,
    serviceTitle: 7,
    hours: 8,
    servicePrice: 9,
    materials: 10,
    materialSearch: 10,
    materialChoice: 10,
    materialQuantity: 10,
    moreMaterials: 10,
    review: 10,
    done: 10,
};

const NUMBER_WORDS = {
    nulla: 0,
    egy: 1,
    ketto: 2,
    ket: 2,
    kettot: 2,
    harom: 3,
    harmat: 3,
    negy: 4,
    negyet: 4,
    ot: 5,
    otot: 5,
    hat: 6,
    hatot: 6,
    het: 7,
    hetet: 7,
    nyolc: 8,
    nyolcat: 8,
    kilenc: 9,
    kilencet: 9,
    tiz: 10,
    tizenegy: 11,
    tizenketto: 12,
    tizenket: 12,
    tizenharom: 13,
    tizennegy: 14,
    tizenot: 15,
    tizenhat: 16,
    tizenhet: 17,
    tizennyolc: 18,
    tizenkilenc: 19,
    husz: 20,
    huszonegy: 21,
    huszonketto: 22,
    huszonket: 22,
    huszonharom: 23,
    huszonnegy: 24,
    huszonot: 25,
    huszonhat: 26,
    huszonhet: 27,
    huszonnyolc: 28,
    huszonkilenc: 29,
    harminc: 30,
    negyven: 40,
    otven: 50,
    hatvan: 60,
    hetven: 70,
    nyolcvan: 80,
    kilencven: 90,
    szaz: 100,
};

const MATERIAL_SYNONYMS = {
    klima: 'klima',
    klimaberendezes: 'klima',
    cso: 'cev',
    rezcso: 'bakarna cev',
    kabel: 'kabl',
    szigeteles: 'izolacija',
    konzol: 'konzola',
    csavar: 'sraf',
    szelep: 'ventil',
    szuro: 'filter',
    gaz: 'gas',
    pumpa: 'pumpa',
    keringeto: 'cirkulaciona pumpa',
    termosztat: 'termostat',
    kazan: 'kotao',
    radiator: 'radijator',
};

function normalizeText(value) {
    return String(value || '')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .replace(/đ/g, 'dj')
        .replace(/[^a-z0-9\s.,+-]/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();
}

function serbianCyrillicToLatin(value) {
    const characters = {
        А: 'A', Б: 'B', В: 'V', Г: 'G', Д: 'D', Ђ: 'Đ', Е: 'E', Ж: 'Ž', З: 'Z',
        И: 'I', Ј: 'J', К: 'K', Л: 'L', Љ: 'Lj', М: 'M', Н: 'N', Њ: 'Nj', О: 'O',
        П: 'P', Р: 'R', С: 'S', Т: 'T', Ћ: 'Ć', У: 'U', Ф: 'F', Х: 'H', Ц: 'C',
        Ч: 'Č', Џ: 'Dž', Ш: 'Š',
        а: 'a', б: 'b', в: 'v', г: 'g', д: 'd', ђ: 'đ', е: 'e', ж: 'ž', з: 'z',
        и: 'i', ј: 'j', к: 'k', л: 'l', љ: 'lj', м: 'm', н: 'n', њ: 'nj', о: 'o',
        п: 'p', р: 'r', с: 's', т: 't', ћ: 'ć', у: 'u', ф: 'f', х: 'h', ц: 'c',
        ч: 'č', џ: 'dž', ш: 'š',
    };

    return [...String(value || '')].map((character) => characters[character] || character).join('');
}

function normalizeMaterialQuery(value) {
    const normalized = normalizeText(value);
    const translatedTokens = normalized.split(' ').flatMap((token) => {
        const synonymKey = Object.keys(MATERIAL_SYNONYMS)
            .sort((left, right) => right.length - left.length)
            .find((key) => token === key || token.startsWith(key));
        const replacement = synonymKey ? MATERIAL_SYNONYMS[synonymKey] : null;
        return replacement ? replacement.split(' ') : [token];
    });

    return translatedTokens.join(' ');
}

function isSkipAnswer(value) {
    const answer = normalizeText(value);
    return answer === '-'
        || answer.includes('kihagy')
        || answer.includes('nincs')
        || answer.includes('nincsen')
        || answer.includes('nem tudom')
        || answer.includes('nem ismert')
        || answer === 'ures';
}

function isYesAnswer(value) {
    const answer = normalizeText(value);
    const words = answer.split(' ');
    if (words.includes('nem') || words.includes('nincs') || words.includes('nincsen')) return false;
    return ['igen', 'persze', 'aha', 'jo', 'oke', 'ok', 'van', 'kell', 'adok', 'meg']
        .some((word) => words.includes(word));
}

function isNoAnswer(value) {
    const answer = normalizeText(value);
    const words = answer.split(' ');
    return words.includes('nem')
        || answer.includes('nincs')
        || answer.includes('nincsen')
        || answer.includes('ennyi')
        || answer === 'kesz'
        || answer.includes('kihagy');
}

function parseHungarianNumber(value, { integer = false } = {}) {
    const normalized = normalizeText(value).replace(',', '.');
    const compactDigits = normalized.replace(/(?<=\d)\s+(?=\d)/g, '');
    const numericMatch = compactDigits.match(/-?\d+(?:\.\d+)?/);
    let parsed;

    if (numericMatch) {
        const numericValue = /^\d{1,3}(?:\.\d{3})+$/.test(numericMatch[0])
            ? numericMatch[0].replace(/\./g, '')
            : numericMatch[0];
        parsed = Number(numericValue);
        if (normalized.includes('fel')) parsed += 0.5;
    } else {
        const cleaned = normalized
            .replace(/\b(es|dinar|dinart|ora|orat|kilometer|kilometert|km|darab|db)\b/g, '')
            .replace(/[\s-]+/g, '');
        parsed = NUMBER_WORDS[cleaned];

        if (!Number.isFinite(parsed)) {
            const ones = {
                egy: 1,
                ket: 2,
                ketto: 2,
                kettot: 2,
                harom: 3,
                harmat: 3,
                negy: 4,
                negyet: 4,
                ot: 5,
                otot: 5,
                hat: 6,
                hatot: 6,
                het: 7,
                hetet: 7,
                nyolc: 8,
                nyolcat: 8,
                kilenc: 9,
                kilencet: 9,
            };
            const parseUnderHundred = (word) => {
                if (!word) return 0;
                if (Object.prototype.hasOwnProperty.call(ones, word)) return ones[word];
                if (word === 'tiz') return 10;
                if (word.startsWith('tizen')) return 10 + (ones[word.slice(5)] || 0);
                if (word === 'husz') return 20;
                if (word.startsWith('huszon')) return 20 + (ones[word.slice(6)] || 0);
                const tens = {
                    harminc: 30,
                    negyven: 40,
                    otven: 50,
                    hatvan: 60,
                    hetven: 70,
                    nyolcvan: 80,
                    kilencven: 90,
                };
                const tensKey = Object.keys(tens).find((key) => word.startsWith(key));
                if (tensKey) return tens[tensKey] + (ones[word.slice(tensKey.length)] || 0);
                return null;
            };
            const parseUnderThousand = (word) => {
                if (!word) return 0;
                const hundredIndex = word.indexOf('szaz');
                if (hundredIndex === -1) return parseUnderHundred(word);
                const prefix = word.slice(0, hundredIndex);
                const remainder = word.slice(hundredIndex + 4);
                const hundreds = prefix ? (ones[prefix] || parseUnderHundred(prefix)) : 1;
                const rest = parseUnderHundred(remainder);
                return hundreds && rest !== null ? (hundreds * 100) + rest : null;
            };
            const parseWholeNumber = (word) => {
                const millionIndex = word.indexOf('millio');
                if (millionIndex !== -1) {
                    const prefix = word.slice(0, millionIndex);
                    const remainder = word.slice(millionIndex + 6);
                    const millions = prefix ? parseUnderThousand(prefix) : 1;
                    const rest = parseWholeNumber(remainder);
                    return millions !== null && rest !== null ? (millions * 1000000) + rest : null;
                }
                const thousandIndex = word.indexOf('ezer');
                if (thousandIndex !== -1) {
                    const prefix = word.slice(0, thousandIndex);
                    const remainder = word.slice(thousandIndex + 4);
                    const thousands = prefix ? parseUnderThousand(prefix) : 1;
                    const rest = parseUnderThousand(remainder);
                    return thousands !== null && rest !== null ? (thousands * 1000) + rest : null;
                }
                return parseUnderThousand(word);
            };

            const hasHalf = cleaned.endsWith('fel');
            const wholePart = hasHalf ? cleaned.slice(0, -3) : cleaned;
            parsed = parseWholeNumber(wholePart);
            if (Number.isFinite(parsed) && hasHalf) parsed += 0.5;
        }
    }

    if (!Number.isFinite(parsed)) {
        return null;
    }

    if (integer) {
        parsed = Math.round(parsed);
    }

    return parsed;
}

function normalizePhoneNumber(value) {
    const rawValue = String(value || '').trim();
    const normalized = normalizeText(rawValue)
        .replace(/[.,/()-]+/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();
    const tokens = normalized.split(' ').filter(Boolean);
    const hasInternationalPrefix = /^\s*(\+|plusz\b|plus\b)/i.test(rawValue);
    const serbianNumbers = {
        nula: 0,
        jedan: 1,
        jedna: 1,
        dva: 2,
        dve: 2,
        tri: 3,
        cetiri: 4,
        pet: 5,
        sest: 6,
        sedam: 7,
        osam: 8,
        devet: 9,
        deset: 10,
        dvadeset: 20,
        trideset: 30,
        cetrdeset: 40,
        pedeset: 50,
        sezdeset: 60,
        sedamdeset: 70,
        osamdeset: 80,
        devedeset: 90,
    };
    const tensWords = new Set([
        'tiz', 'husz', 'harminc', 'negyven', 'otven', 'hatvan', 'hetven', 'nyolcvan', 'kilencven',
        'deset', 'dvadeset', 'trideset', 'cetrdeset', 'pedeset', 'sezdeset', 'sedamdeset', 'osamdeset', 'devedeset',
    ]);

    const wordToNumber = (token) => {
        if (Object.prototype.hasOwnProperty.call(serbianNumbers, token)) return serbianNumbers[token];
        return parseHungarianNumber(token, { integer: true });
    };

    let digits = '';
    for (let index = 0; index < tokens.length; index += 1) {
        const token = tokens[index];
        if (token === 'plus' || token === 'plusz') continue;

        const numericCharacters = token.replace(/\D/g, '');
        if (numericCharacters) {
            digits += numericCharacters;
            continue;
        }

        const number = wordToNumber(token);
        if (number === null || number < 0) continue;

        // After the Serbian mobile prefix "06", a spoken tens value is the
        // operator code (for example 30 or 40), not part of the next digit.
        const isMobileOperatorGroup = digits === '06' && tensWords.has(token);
        if (isMobileOperatorGroup) {
            digits += String(number);
            continue;
        }

        if (tensWords.has(token) && index + 1 < tokens.length) {
            const nextNumber = wordToNumber(tokens[index + 1]);
            if (nextNumber !== null && nextNumber >= 0 && nextNumber <= 9) {
                digits += String(number + nextNumber);
                index += 1;
                continue;
            }
        }

        digits += String(number);
    }

    if (!digits) return '';
    return `${hasInternationalPrefix ? '+' : ''}${digits}`;
}

function bigramSimilarity(left, right) {
    if (left === right) return 1;
    if (!left || !right) return 0;
    if (left.includes(right) || right.includes(left)) {
        return 0.8 + (Math.min(left.length, right.length) / Math.max(left.length, right.length)) * 0.2;
    }

    const pairs = (text) => {
        const result = [];
        for (let index = 0; index < text.length - 1; index += 1) {
            result.push(text.slice(index, index + 2));
        }
        return result;
    };

    const leftPairs = pairs(left);
    const rightPairs = pairs(right);
    if (!leftPairs.length || !rightPairs.length) return 0;

    const available = [...rightPairs];
    let intersection = 0;
    leftPairs.forEach((pair) => {
        const index = available.indexOf(pair);
        if (index !== -1) {
            intersection += 1;
            available.splice(index, 1);
        }
    });

    return (2 * intersection) / (leftPairs.length + rightPairs.length);
}

function translateKnownService(value) {
    const normalized = normalizeText(value);
    const translations = [
        { terms: ['klima', 'felszerel', 'szerel'], result: 'Montaža klima uređaja' },
        { terms: ['klima', 'tisztit'], result: 'Servis i čišćenje klima uređaja' },
        { terms: ['klima', 'karbantart'], result: 'Servis klima uređaja' },
        { terms: ['klima', 'javit'], result: 'Popravka klima uređaja' },
        { terms: ['kazan', 'csere'], result: 'Zamena kotla' },
        { terms: ['kazan', 'javit'], result: 'Popravka kotla' },
        { terms: ['radiator', 'csere'], result: 'Zamena radijatora' },
        { terms: ['radiator', 'szerel'], result: 'Montaža radijatora' },
        { terms: ['hoszivattyu', 'szerel'], result: 'Montaža toplotne pumpe' },
        { terms: ['futes', 'karbantart'], result: 'Servis sistema grejanja' },
    ];

    const match = translations.find(({ terms }) => terms.every((term) => normalized.includes(term)));
    return match ? match.result : String(value || '').trim();
}

function dispatchFieldUpdate(element) {
    element.dispatchEvent(new Event('input', { bubbles: true }));
    element.dispatchEvent(new Event('change', { bubbles: true }));
    element.classList.add('assistant-filled-field');
    window.setTimeout(() => element.classList.remove('assistant-filled-field'), 1400);
}

function initializeWorkOrderAssistant(root) {
    if (root.dataset.assistantInitialized === 'true') return;
    root.dataset.assistantInitialized = 'true';

    const elements = {
        toggle: root.querySelector('[data-assistant-toggle]'),
        panel: root.querySelector('[data-assistant-panel]'),
        chevron: root.querySelector('[data-assistant-chevron]'),
        intro: root.querySelector('[data-assistant-intro]'),
        start: root.querySelector('[data-assistant-start]'),
        conversation: root.querySelector('[data-assistant-conversation]'),
        messages: root.querySelector('[data-assistant-messages]'),
        quickReplies: root.querySelector('[data-assistant-quick-replies]'),
        input: root.querySelector('[data-assistant-input]'),
        language: root.querySelector('[data-assistant-language]'),
        languageCode: root.querySelector('[data-assistant-language-code]'),
        microphone: root.querySelector('[data-assistant-microphone]'),
        micIdle: root.querySelector('[data-assistant-mic-idle]'),
        micLive: root.querySelector('[data-assistant-mic-live]'),
        send: root.querySelector('[data-assistant-send]'),
        sound: root.querySelector('[data-assistant-sound]'),
        soundOn: root.querySelector('[data-assistant-sound-on]'),
        soundOff: root.querySelector('[data-assistant-sound-off]'),
        repeat: root.querySelector('[data-assistant-repeat]'),
        voice: root.querySelector('[data-assistant-voice]'),
        status: root.querySelector('[data-assistant-status]'),
        restart: root.querySelector('[data-assistant-restart]'),
        progressText: root.querySelector('[data-assistant-progress-text]'),
        progressBar: root.querySelector('[data-assistant-progress-bar]'),
    };

    const state = {
        step: 'idle',
        clientType: 'fizicko_lice',
        pendingContact: null,
        enteredClientName: '',
        pendingProduct: null,
        materialMatches: [],
        addedMaterials: [],
        recognition: null,
        recognitionLocale: HUNGARIAN_LOCALE,
        listening: false,
        finalTranscript: '',
        soundEnabled: true,
        piperVoice: DEFAULT_PIPER_VOICE,
        lastSpokenText: '',
        speechRequestId: 0,
        audioContext: null,
        audioSource: null,
    };

    try {
        state.soundEnabled = window.localStorage.getItem('ftherm-assistant-sound') !== 'off';
        const storedVoice = window.localStorage.getItem('ftherm-assistant-voice');
        if (storedVoice && Object.prototype.hasOwnProperty.call(PIPER_HUNGARIAN_VOICES, storedVoice)) {
            state.piperVoice = storedVoice;
        }
    } catch (_) {
        state.soundEnabled = true;
        state.piperVoice = DEFAULT_PIPER_VOICE;
    }
    elements.voice.value = state.piperVoice;

    function setExpanded(expanded) {
        elements.panel.classList.toggle('hidden', !expanded);
        elements.chevron.classList.toggle('rotate-180', expanded);
        elements.toggle.setAttribute('aria-expanded', String(expanded));
    }

    function setStatus(message, tone = 'muted') {
        elements.status.textContent = message;
        elements.status.className = tone === 'error'
            ? 'text-xs font-medium text-red-600'
            : tone === 'success'
                ? 'text-xs font-medium text-green-700'
                : 'text-xs text-gray-500';
    }

    function setSoundButton() {
        elements.soundOn.classList.toggle('hidden', !state.soundEnabled);
        elements.soundOff.classList.toggle('hidden', state.soundEnabled);
        elements.sound.setAttribute('aria-pressed', String(state.soundEnabled));
        elements.sound.title = state.soundEnabled
            ? 'Magyar felolvasás kikapcsolása'
            : 'Magyar felolvasás bekapcsolása';
    }

    function recognitionLanguageName() {
        return state.recognitionLocale === SERBIAN_LOCALE ? 'szerb' : 'magyar';
    }

    function recognitionLanguageAdverb() {
        return state.recognitionLocale === SERBIAN_LOCALE ? 'szerbül' : 'magyarul';
    }

    function piperVoiceName() {
        return PIPER_HUNGARIAN_VOICES[state.piperVoice] || 'Anna';
    }

    function piperVoiceNameWithArticle() {
        const name = piperVoiceName();
        return /^[aáeéiíoóöőuúüű]/i.test(name) ? `az ${name}` : `a ${name}`;
    }

    function setRecognitionLocale(locale, announce = false) {
        state.recognitionLocale = locale === SERBIAN_LOCALE ? SERBIAN_LOCALE : HUNGARIAN_LOCALE;
        if (state.recognition) state.recognition.lang = state.recognitionLocale;

        const isSerbian = state.recognitionLocale === SERBIAN_LOCALE;
        elements.languageCode.textContent = isSerbian ? 'SR' : 'HU';
        elements.language.classList.toggle('border-amber-300', isSerbian);
        elements.language.classList.toggle('bg-amber-50', isSerbian);
        elements.language.classList.toggle('text-amber-800', isSerbian);
        elements.language.title = isSerbian
            ? 'Mikrofon nyelve: szerb. Kattints a magyar nyelvhez.'
            : 'Mikrofon nyelve: magyar. Kattints a szerb nyelvhez.';

        if (announce) {
            setStatus(`A mikrofon most ${recognitionLanguageName()} beszédet ismer fel.`, 'success');
        }
    }

    function setRecognitionLocaleForStep(step) {
        setRecognitionLocale(SERBIAN_RECOGNITION_STEPS.has(step) ? SERBIAN_LOCALE : HUNGARIAN_LOCALE);
    }

    function prepareSpeechText(text) {
        return String(text || '')
            .replace(/Sačuvaj Radni Nalog/gi, 'munkalap mentése')
            .replace(/radni nalog(?:ot)?/gi, 'munkalapot')
            .replace(/\bRSD\b/gi, 'dinár')
            .replace(/\bFTHERM\b/gi, 'ef term')
            .replace(/\n+/g, '. ')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function unlockAudio() {
        const AudioContextClass = window.AudioContext || window.webkitAudioContext;
        if (!AudioContextClass) return Promise.resolve(false);
        if (!state.audioContext) state.audioContext = new AudioContextClass();
        if (state.audioContext.state === 'suspended') {
            return state.audioContext.resume().then(() => true).catch(() => false);
        }
        return Promise.resolve(true);
    }

    function stopAudioSource() {
        if (!state.audioSource) return;
        try {
            state.audioSource.stop();
        } catch (_) {
            // The source may have already ended.
        }
        state.audioSource.disconnect();
        state.audioSource = null;
    }

    function stopSpeaking() {
        state.speechRequestId += 1;
        stopAudioSource();
    }

    async function speak(text) {
        const preparedText = prepareSpeechText(text);
        if (!preparedText) return;

        state.lastSpokenText = preparedText;
        elements.repeat.disabled = false;
        if (!state.soundEnabled) return;

        const requestId = state.speechRequestId + 1;
        state.speechRequestId = requestId;
        stopAudioSource();
        unlockAudio();
        setStatus('A tiszta magyar hang előkészítése… Első alkalommal ez tovább tarthat.');

        try {
            const piperTts = await loadPiperTtsModule();
            if (requestId !== state.speechRequestId) return;

            const audioBlob = await piperTts.predict({
                text: preparedText,
                voiceId: state.piperVoice,
            }, (progress) => {
                if (requestId !== state.speechRequestId) return;
                const loadedMegabytes = progress.loaded / (1024 * 1024);
                const percent = progress.total > 0
                    ? Math.min(100, Math.round((progress.loaded / progress.total) * 100))
                    : null;
                setStatus(
                    percent !== null
                        ? `Magyar hang egyszeri letöltése: ${percent}%`
                        : `Magyar hang letöltése: ${loadedMegabytes.toFixed(1)} MB`,
                );
            });
            if (requestId !== state.speechRequestId) return;

            await unlockAudio();
            if (!state.audioContext) {
                throw new Error('AudioContext is not supported');
            }
            const audioBuffer = await state.audioContext.decodeAudioData(await audioBlob.arrayBuffer());
            if (requestId !== state.speechRequestId) return;

            const source = state.audioContext.createBufferSource();
            source.buffer = audioBuffer;
            source.connect(state.audioContext.destination);
            source.onended = () => {
                if (state.audioSource === source) state.audioSource = null;
                if (requestId === state.speechRequestId) {
                    setStatus(`Piper ${piperVoiceName()} · Mikrofon: ${recognitionLanguageName()}`, 'success');
                }
            };
            state.audioSource = source;
            source.start();
            setStatus(`Piper ${piperVoiceName()} · Mikrofon: ${recognitionLanguageName()}`, 'success');
        } catch (error) {
            if (requestId !== state.speechRequestId) return;
            console.error('Hungarian Piper speech failed:', error);
            setStatus(
                'A magyar hangot nem sikerült betölteni. Ellenőrizd az internetkapcsolatot, majd nyomd meg az újraolvasás gombot.',
                'error',
            );
        }
    }

    function addMessage(sender, text, shouldSpeak = false, spokenText = null) {
        const row = document.createElement('div');
        row.className = sender === 'assistant' ? 'flex items-start gap-2' : 'flex justify-end';

        if (sender === 'assistant') {
            const avatar = document.createElement('span');
            avatar.className = 'mt-0.5 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary-600 text-xs font-bold text-white';
            avatar.textContent = 'F';
            avatar.setAttribute('aria-hidden', 'true');
            row.appendChild(avatar);
        }

        const bubble = document.createElement('div');
        bubble.className = sender === 'assistant'
            ? 'max-w-[88%] whitespace-pre-line rounded-2xl rounded-tl-md bg-sky-50 px-3 py-2 text-sm leading-5 text-gray-800'
            : 'max-w-[88%] whitespace-pre-line rounded-2xl rounded-tr-md bg-primary-600 px-3 py-2 text-sm leading-5 text-white';
        bubble.textContent = text;
        row.appendChild(bubble);
        elements.messages.appendChild(row);
        elements.messages.scrollTop = elements.messages.scrollHeight;

        if (sender === 'assistant' && shouldSpeak) speak(spokenText || text);
    }

    function setQuickReplies(replies = []) {
        elements.quickReplies.replaceChildren();
        replies.forEach((reply) => {
            const config = typeof reply === 'string' ? { label: reply, value: reply } : reply;
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'rounded-full border border-sky-200 bg-white px-3 py-1.5 text-xs font-semibold text-primary-700 transition hover:border-primary-400 hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-sky-100';
            button.textContent = config.label;
            button.addEventListener('click', () => submitAnswer(config.value, config.label));
            elements.quickReplies.appendChild(button);
        });
    }

    function updateProgress(step) {
        const current = STEP_PROGRESS[step] || 1;
        elements.progressText.textContent = `${current} / ${TOTAL_CORE_STEPS}`;
        elements.progressBar.style.width = `${(current / TOTAL_CORE_STEPS) * 100}%`;
    }

    function ask(step, question, replies = [], spokenQuestion = null) {
        state.step = step;
        setRecognitionLocaleForStep(step);
        updateProgress(step);
        elements.input.value = '';
        elements.input.disabled = false;
        elements.send.disabled = false;
        elements.input.placeholder = 'Írd be a választ…';
        setQuickReplies(replies);
        addMessage('assistant', question, true, spokenQuestion);
        elements.input.focus({ preventScroll: true });
    }

    function fillById(id, value) {
        const field = document.getElementById(id);
        if (!field) return false;
        field.value = value;
        dispatchFieldUpdate(field);
        return true;
    }

    function setClientType(type) {
        const radio = document.querySelector(`input[name="client_type"][value="${type}"]`);
        if (!radio) return;
        radio.checked = true;
        dispatchFieldUpdate(radio);
        if (typeof window.toggleClientFields === 'function') window.toggleClientFields();
    }

    function contactDisplayName(contact) {
        return contact?.type === 'pravno_lice'
            ? String(contact.company_name || '').trim()
            : String(contact?.client_name || '').trim();
    }

    function findMatchingContact(clientName) {
        const contacts = Array.isArray(window.workOrderContacts) ? window.workOrderContacts : [];
        const query = normalizeText(serbianCyrillicToLatin(clientName))
            .replace(/[.,+-]/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();
        if (!query) return null;

        const matches = contacts
            .filter((contact) => contact.type === state.clientType)
            .map((contact) => {
                const candidate = normalizeText(serbianCyrillicToLatin(contactDisplayName(contact)))
                    .replace(/[.,+-]/g, ' ')
                    .replace(/\s+/g, ' ')
                    .trim();
                const queryTokens = query.split(' ').filter(Boolean);
                const candidateTokens = candidate.split(' ').filter(Boolean);
                const matchingTokens = queryTokens.filter((token) => candidateTokens.includes(token)).length;
                const tokenScore = matchingTokens / Math.max(queryTokens.length, candidateTokens.length, 1);
                const score = candidate === query
                    ? 1
                    : Math.max(bigramSimilarity(query, candidate), tokenScore);
                return { contact, score };
            })
            .filter(({ score }) => score >= 0.78)
            .sort((left, right) => right.score - left.score);

        return matches[0]?.contact || null;
    }

    function contactDetails(contact) {
        const details = [];
        const address = contact.type === 'pravno_lice'
            ? contact.company_address
            : contact.client_address;
        if (address) details.push(`Cím: ${address}`);
        if (contact.client_phone) details.push(`Telefon: ${contact.client_phone}`);
        if (contact.client_email) details.push(`E-mail: ${contact.client_email}`);
        if (contact.type === 'pravno_lice' && contact.pib) details.push(`PIB: ${contact.pib}`);
        return details.length ? details.join('\n') : 'Nincs hozzá további adat elmentve.';
    }

    function setSavedContactSelector(contact) {
        const selectedText = document.getElementById('contact_selected_text');
        if (selectedText) {
            selectedText.textContent = contactDisplayName(contact);
            selectedText.classList.add('selected');
        }

        const saveCheckbox = document.getElementById('save-contact-checkbox');
        if (saveCheckbox) saveCheckbox.style.display = 'none';
        const saveInput = document.getElementById('save_as_contact');
        if (saveInput) saveInput.checked = false;
    }

    function useSavedContact(contact) {
        if (!contact) return false;

        if (typeof window.selectContact === 'function') {
            window.selectContact(contact.id);
        } else {
            state.clientType = contact.type;
            setClientType(contact.type);
            if (contact.type === 'pravno_lice') {
                fillById('company_name', contact.company_name || '');
                fillById('pib', contact.pib || '');
                fillById('maticni_broj', contact.maticni_broj || '');
                fillById('company_address', contact.company_address || '');
            } else {
                fillById('client_name', contact.client_name || '');
                fillById('client_address', contact.client_address || '');
            }
            fillById('client_phone', contact.client_phone || '');
            fillById('client_email', contact.client_email || '');
            setSavedContactSelector(contact);
        }

        state.clientType = contact.type;
        return true;
    }

    function continueAsNewContact() {
        const fieldsToClear = state.clientType === 'pravno_lice'
            ? ['pib', 'maticni_broj', 'company_address', 'client_phone', 'client_email']
            : ['client_address', 'client_phone', 'client_email'];
        fieldsToClear.forEach((fieldId) => fillById(fieldId, ''));

        const selectedText = document.getElementById('contact_selected_text');
        if (selectedText) {
            selectedText.textContent = 'Izaberite kontakt (opciono)';
            selectedText.classList.remove('selected');
        }
        const saveCheckbox = document.getElementById('save-contact-checkbox');
        if (saveCheckbox) saveCheckbox.style.display = '';

        state.pendingContact = null;
        ask('clientAddress', 'Mi az ügyfél vagy a cég címe? Ha nem szeretnéd megadni, mondd, hogy kihagyás.', [
            { label: 'Kihagyás', value: 'kihagyás' },
        ]);
    }

    function getFirstSection() {
        let section = document.querySelector('#sectionsContainer .section-block');
        if (!section && typeof window.addSection === 'function') {
            window.addSection();
            section = document.querySelector('#sectionsContainer .section-block');
        }
        return section;
    }

    function fillFirstSectionField(fieldName, value) {
        const section = getFirstSection();
        if (!section) return false;
        const field = section.querySelector(`input[name$="[${fieldName}]"]`);
        if (!field) return false;
        field.value = value;
        dispatchFieldUpdate(field);
        return true;
    }

    function availableStock(productId) {
        const warehouse = Number(document.getElementById('warehouse_value')?.value || window.currentWarehouseId || 0);
        if (typeof window.getAvailableQuantity === 'function') {
            return window.getAvailableQuantity(Number(productId), warehouse);
        }
        if (typeof window.getWarehouseStock === 'function') {
            return window.getWarehouseStock(Number(productId), warehouse);
        }
        return 0;
    }

    function findMaterialMatches(query) {
        if (!Array.isArray(window.workOrderProducts)) return [];
        const normalizedQuery = normalizeMaterialQuery(query);
        if (!normalizedQuery) return [];

        return window.workOrderProducts
            .map((product) => {
                const name = normalizeText(product.name);
                const tokenHits = normalizedQuery
                    .split(' ')
                    .filter(Boolean)
                    .filter((token) => name.includes(token)).length;
                const tokenScore = tokenHits / Math.max(1, normalizedQuery.split(' ').filter(Boolean).length);
                const score = Math.max(bigramSimilarity(normalizedQuery, name), tokenScore * 0.92);
                return { product, score, stock: availableStock(product.id) };
            })
            .filter((match) => match.score >= 0.24)
            .sort((left, right) => {
                if ((right.stock > 0) !== (left.stock > 0)) return right.stock > 0 ? 1 : -1;
                return right.score - left.score;
            })
            .slice(0, 5);
    }

    function showMaterialMatches(query) {
        state.materialMatches = findMaterialMatches(query);
        if (!state.materialMatches.length) {
            ask(
                'materialSearch',
                'Nem találtam ilyen anyagot a készletlistában. Próbáld meg a termék nevének egy másik részével.',
                [],
                'Nem találtam ilyen anyagot. Mondd másképpen az anyag nevét.',
            );
            return;
        }

        const spokenOptions = state.materialMatches
            .slice(0, 3)
            .map((match, index) => `${index + 1}. ${match.product.name}, készlet: ${match.stock}`)
            .join('\n');
        const replies = state.materialMatches.map((match, index) => ({
            label: `${index + 1}. ${match.product.name} (${match.stock})`,
            value: `material-choice:${index}`,
        }));
        ask(
            'materialChoice',
            `Ezeket találtam. Válassz a gombokkal, vagy mondd, hogy első, második vagy harmadik.\n${spokenOptions}`,
            replies,
            'Találtam néhány anyagot. Válassz a megjelenő gombokkal, vagy mondd, hogy első, második vagy harmadik.',
        );
    }

    function selectMaterialMatch(index) {
        const match = state.materialMatches[index];
        if (!match) {
            addMessage('assistant', 'Ezt a találatot nem tudtam kiválasztani. Kérlek válassz a megjelenő lehetőségek közül.', true);
            return;
        }

        if (match.stock <= 0) {
            ask(
                'materialSearch',
                `A(z) ${match.product.name} jelenleg nincs készleten ebben a raktárban. Milyen másik anyagot keressek?`,
                [],
                'Ez az anyag jelenleg nincs készleten. Milyen másik anyagot keressek?',
            );
            return;
        }

        state.pendingProduct = match.product;
        ask(
            'materialQuantity',
            `Hány ${match.product.unit || 'darab'} kell a(z) ${match.product.name} anyagból? Jelenleg ${match.stock} van készleten.`,
            [],
            `Hány darabra van szükség a kiválasztott anyagból? Jelenleg ${match.stock} van készleten.`,
        );
    }

    function addPendingMaterial(quantity) {
        const product = state.pendingProduct;
        const section = getFirstSection();
        if (!product || !section) return false;

        const sectionId = Number(section.dataset.section);
        let item = [...section.querySelectorAll('.item-row')].find((row) => {
            const productInput = row.querySelector('input[name$="[product_id]"]');
            return productInput && !productInput.value;
        });

        if (!item && typeof window.addItem === 'function') {
            window.addItem(sectionId);
            const items = section.querySelectorAll('.item-row');
            item = items[items.length - 1];
        }

        if (!item) return false;
        const itemId = Number(item.dataset.item);
        const stock = availableStock(product.id);
        const displayText = `${product.name} - ${product.price} RSD/${product.unit}`;

        if (typeof window.selectProduct === 'function') {
            window.selectProduct(sectionId, itemId, product.id, displayText, product.price, stock);
        } else {
            const productInput = item.querySelector('input[name$="[product_id]"]');
            if (productInput) {
                productInput.value = product.id;
                dispatchFieldUpdate(productInput);
            }
        }

        const quantityInput = item.querySelector('input[name$="[quantity]"]');
        if (quantityInput) {
            quantityInput.value = quantity;
            dispatchFieldUpdate(quantityInput);
        }

        if (typeof window.updateItemPrice === 'function') window.updateItemPrice(sectionId, itemId);
        if (typeof window.updateAllMaterialQuantities === 'function') window.updateAllMaterialQuantities();

        state.addedMaterials.push({
            name: product.name,
            quantity,
            unit: product.unit || 'db',
        });
        state.pendingProduct = null;
        return true;
    }

    function buildReview() {
        const personName = document.getElementById('client_name')?.value;
        const companyName = document.getElementById('company_name')?.value;
        const location = document.getElementById('location')?.value || '–';
        const section = getFirstSection();
        const service = section?.querySelector('input[name$="[title]"]')?.value || '–';
        const materials = state.addedMaterials.length
            ? state.addedMaterials.map((item) => `${item.name}: ${item.quantity} ${item.unit}`).join(', ')
            : 'nincs megadva';

        return [
            'Kész, kitöltöttem a munkalapot.',
            `Ügyfél: ${state.clientType === 'pravno_lice' ? companyName : personName}`,
            `Helyszín: ${location}`,
            `Munka: ${service}`,
            `Anyagok: ${materials}`,
            '',
            'Nézd át az űrlapot, majd a végén nyomd meg a „Sačuvaj Radni Nalog” gombot.',
        ].join('\n');
    }

    function finishAssistant() {
        state.step = 'done';
        updateProgress('done');
        setQuickReplies([
            { label: 'Űrlap ellenőrzése', value: 'assistant-finish' },
            { label: 'Újrakezdés', value: 'assistant-restart' },
        ]);
        elements.input.disabled = true;
        elements.send.disabled = true;
        addMessage(
            'assistant',
            buildReview(),
            true,
            'Kész. Kitöltöttem a munkalapot. Kérlek nézd át az adatokat, majd nyomd meg a munkalap mentése gombot.',
        );
        setStatus('A munkalap ki van töltve, de még nincs véglegesen elmentve.', 'success');
        if (typeof window.triggerAutosave === 'function') window.triggerAutosave();
    }

    function scrollToForm() {
        const firstField = state.clientType === 'pravno_lice'
            ? document.getElementById('company_name')
            : document.getElementById('client_name');
        firstField?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstField?.focus({ preventScroll: true });
    }

    function handleMaterialChoice(answer) {
        if (answer.startsWith('material-choice:')) {
            selectMaterialMatch(Number(answer.split(':')[1]));
            return;
        }

        const normalized = normalizeText(answer);
        const ordinalMap = {
            elso: 0,
            '1': 0,
            egyes: 0,
            masodik: 1,
            '2': 1,
            kettes: 1,
            harmadik: 2,
            '3': 2,
            harmas: 2,
            negyedik: 3,
            '4': 3,
            negyes: 3,
            otodik: 4,
            '5': 4,
            otos: 4,
        };

        const ordinalKey = Object.keys(ordinalMap)
            .find((key) => normalized === key || normalized.includes(` ${key}`) || normalized.startsWith(`${key} `));
        if (ordinalKey) {
            selectMaterialMatch(ordinalMap[ordinalKey]);
            return;
        }

        showMaterialMatches(answer);
    }

    function processAnswer(answer) {
        switch (state.step) {
            case 'clientType': {
                const normalized = normalizeText(answer);
                if (normalized.includes('ceg') || normalized.includes('vallalat') || normalized.includes('vallalkoz') || normalized.includes('jogi')) {
                    state.clientType = 'pravno_lice';
                } else if (normalized.includes('magan') || normalized.includes('szemely') || normalized.includes('ember')) {
                    state.clientType = 'fizicko_lice';
                } else {
                    addMessage('assistant', 'Kérlek válaszd azt, hogy magánszemély vagy cég.', true);
                    return;
                }
                setClientType(state.clientType);
                ask('clientName', state.clientType === 'pravno_lice'
                    ? 'Mi a cég pontos neve?'
                    : 'Mi az ügyfél neve?');
                break;
            }

            case 'clientName':
                if (!answer.trim()) {
                    addMessage('assistant', 'A név kötelező, kérlek mondd vagy írd be.', true);
                    return;
                }
                state.enteredClientName = answer.trim();
                fillById(
                    state.clientType === 'pravno_lice' ? 'company_name' : 'client_name',
                    state.enteredClientName,
                );
                state.pendingContact = findMatchingContact(state.enteredClientName);
                if (state.pendingContact) {
                    ask(
                        'contactChoice',
                        `Találtam egy ilyen mentett kontaktot:\n${contactDisplayName(state.pendingContact)}\n${contactDetails(state.pendingContact)}\n\nEzt használjam, vagy ez egy új ügyfél?`,
                        [
                            { label: 'Ezt a kontaktot használja', value: 'use-contact' },
                            { label: 'Új ügyfél', value: 'new-contact' },
                        ],
                        'Találtam ilyen nevű mentett kontaktot. Ezt használjam, vagy ez egy új ügyfél?',
                    );
                } else {
                    continueAsNewContact();
                }
                break;

            case 'contactChoice': {
                const normalized = normalizeText(answer);
                const choiceWords = normalized.split(' ').filter(Boolean);
                const explicitlyNew = answer === 'new-contact'
                    || normalized.includes('uj')
                    || isNoAnswer(answer);
                const wantsExisting = answer === 'use-contact'
                    || (!explicitlyNew && (
                        choiceWords.includes('ezt')
                        || choiceWords.includes('azt')
                        || normalized.includes('hasznal')
                        || normalized.includes('meglevo')
                        || normalized.includes('kontakt')
                        || isYesAnswer(answer)
                    ));

                if (wantsExisting && state.pendingContact) {
                    const selectedContact = state.pendingContact;
                    if (!useSavedContact(selectedContact)) {
                        addMessage('assistant', 'A mentett kontaktot most nem sikerült betölteni. Folytassuk új ügyfélként.', true);
                        continueAsNewContact();
                        return;
                    }
                    state.pendingContact = null;
                    addMessage('assistant', `${contactDisplayName(selectedContact)} mentett adatait kitöltöttem.`);
                    ask('location', 'Hol lesz a munkavégzés? Mondd a települést vagy a helyszínt.', []);
                } else if (explicitlyNew) {
                    continueAsNewContact();
                } else {
                    addMessage('assistant', 'Kérlek válaszd ki: a mentett kontaktot használjuk, vagy új ügyfélről van szó.', true);
                }
                break;
            }

            case 'clientAddress':
                if (!isSkipAnswer(answer)) {
                    fillById(state.clientType === 'pravno_lice' ? 'company_address' : 'client_address', answer.trim());
                }
                ask('clientPhone', 'Mi az ügyfél telefonszáma? Mondd számjegyenként vagy kisebb csoportokban. Ha szerbül mondod, válts az SR gombra. Ezt a kérdést ki is hagyhatod.', [
                    { label: 'Kihagyás', value: 'kihagyás' },
                ]);
                break;

            case 'clientPhone':
                if (!isSkipAnswer(answer)) {
                    const phoneNumber = normalizePhoneNumber(answer);
                    const phoneDigits = phoneNumber.replace(/\D/g, '');
                    if (phoneDigits.length < 6 || phoneDigits.length > 15) {
                        addMessage(
                            'assistant',
                            'A telefonszámot nem értettem pontosan. Mondd a számjegyeket külön vagy kisebb csoportokban, például: nulla hat három, egy kettő három.',
                            true,
                        );
                        return;
                    }
                    fillById('client_phone', phoneNumber);
                    addMessage('assistant', `A telefonszámot így írtam be: ${phoneNumber}`);
                }
                ask('location', 'Hol lesz a munkavégzés? Mondd a települést vagy a helyszínt.', []);
                break;

            case 'location':
                if (!answer.trim() || isSkipAnswer(answer)) {
                    addMessage('assistant', 'A munkavégzés helye kötelező. Kérlek add meg a települést vagy a helyszínt.', true);
                    return;
                }
                fillById('location', answer.trim());
                ask('kilometers', 'Hány kilométerre van a helyszín? Ha nem kell elszámolni, mondd, hogy kihagyás.', [
                    { label: 'Kihagyás', value: 'kihagyás' },
                ]);
                break;

            case 'kilometers': {
                if (!isSkipAnswer(answer)) {
                    const kilometers = parseHungarianNumber(answer);
                    if (kilometers === null || kilometers < 0) {
                        addMessage('assistant', 'Kérlek egy pozitív számot mondj, például: 25. Vagy válaszd a kihagyást.', true);
                        return;
                    }
                    fillById('km_to_destination', kilometers);
                }
                ask('serviceTitle', 'Milyen munkát kell elvégezni? Például: klíma felszerelés vagy kazán javítás.');
                break;
            }

            case 'serviceTitle': {
                if (!answer.trim()) {
                    addMessage('assistant', 'A munka megnevezése kötelező. Kérlek mondd el röviden, mit kell elvégezni.', true);
                    return;
                }
                const serviceTitle = translateKnownService(answer);
                fillFirstSectionField('title', serviceTitle);
                if (serviceTitle !== answer.trim()) {
                    addMessage('assistant', `A munkalapba ezt a szerb megnevezést írtam: ${serviceTitle}`);
                }
                ask('hours', 'Várhatóan hány munkaórát vesz igénybe? Ha még nem tudod, mondd, hogy kihagyás.', [
                    { label: 'Kihagyás', value: 'kihagyás' },
                ]);
                break;
            }

            case 'hours': {
                if (!isSkipAnswer(answer)) {
                    const hours = parseHungarianNumber(answer);
                    if (hours === null || hours < 0) {
                        addMessage('assistant', 'Kérlek számot mondj, például: 2 és fél helyett 2,5. Vagy válaszd a kihagyást.', true);
                        return;
                    }
                    fillFirstSectionField('hours_spent', hours);
                }
                ask('servicePrice', 'Mennyi a szolgáltatás ára dinárban? Ha még nincs ár, mondd, hogy kihagyás.', [
                    { label: 'Kihagyás', value: 'kihagyás' },
                ]);
                break;
            }

            case 'servicePrice': {
                if (!isSkipAnswer(answer)) {
                    const price = parseHungarianNumber(answer);
                    if (price === null || price < 0) {
                        addMessage('assistant', 'Kérlek az árat számmal add meg, például: 5000. Vagy válaszd a kihagyást.', true);
                        return;
                    }
                    fillFirstSectionField('service_price', price);
                }
                ask('materials', 'Szükség van raktári anyagra ehhez a munkához?', [
                    { label: 'Igen, keresek anyagot', value: 'igen' },
                    { label: 'Nem kell anyag', value: 'nem' },
                ]);
                break;
            }

            case 'materials':
                if (isYesAnswer(answer)) {
                    ask('materialSearch', 'Mondd vagy írd be az anyag nevét. A kiválasztott raktár készletében keresek.');
                } else if (isNoAnswer(answer)) {
                    finishAssistant();
                } else {
                    addMessage('assistant', 'Kérlek válaszolj igennel vagy nemmel.', true);
                }
                break;

            case 'materialSearch':
                showMaterialMatches(answer);
                break;

            case 'materialChoice':
                handleMaterialChoice(answer);
                break;

            case 'materialQuantity': {
                const quantity = parseHungarianNumber(answer, { integer: true });
                const stock = state.pendingProduct ? availableStock(state.pendingProduct.id) : 0;
                if (quantity === null || quantity < 1) {
                    addMessage('assistant', 'A mennyiség legalább 1 legyen. Kérlek mondj egy egész számot.', true);
                    return;
                }
                if (quantity > stock) {
                    addMessage('assistant', `Ebből csak ${stock} van szabad készleten. Adj meg legfeljebb ${stock} darabot.`, true);
                    return;
                }
                if (!addPendingMaterial(quantity)) {
                    addMessage('assistant', 'Az anyagot most nem sikerült az űrlaphoz adni. Kérlek add hozzá kézzel az Anyagok résznél.', true);
                } else {
                    addMessage('assistant', 'Az anyagot és a mennyiséget hozzáadtam a munkalaphoz.');
                }
                ask('moreMaterials', 'Szeretnél még egy anyagot hozzáadni?', [
                    { label: 'Igen, még egyet', value: 'igen' },
                    { label: 'Nem, ennyi', value: 'nem' },
                ]);
                break;
            }

            case 'moreMaterials':
                if (isYesAnswer(answer)) {
                    ask('materialSearch', 'Mi a következő anyag neve?');
                } else if (isNoAnswer(answer)) {
                    finishAssistant();
                } else {
                    addMessage('assistant', 'Kérlek válaszolj igennel vagy nemmel.', true);
                }
                break;

            case 'done':
                if (answer === 'assistant-restart') {
                    startAssistant();
                } else if (answer === 'assistant-finish') {
                    scrollToForm();
                }
                break;

            default:
                break;
        }
    }

    function submitAnswer(rawValue = null, visibleValue = null) {
        const answer = String(rawValue ?? elements.input.value).trim();
        if (!answer) {
            setStatus('Előbb mondd vagy írd be a választ.', 'error');
            return;
        }

        if (state.step === 'done' && answer.startsWith('assistant-')) {
            processAnswer(answer);
            return;
        }

        addMessage('user', visibleValue || answer);
        elements.input.value = '';
        setStatus('A mikrofon csak a gomb megnyomásakor figyel.');
        processAnswer(answer);
    }

    function startAssistant() {
        stopSpeaking();
        state.step = 'idle';
        state.clientType = 'fizicko_lice';
        state.pendingContact = null;
        state.enteredClientName = '';
        state.pendingProduct = null;
        state.materialMatches = [];
        state.addedMaterials = [];
        elements.messages.replaceChildren();
        elements.intro.classList.add('hidden');
        elements.conversation.classList.remove('hidden');
        elements.input.disabled = false;
        elements.send.disabled = false;
        setExpanded(true);
        const greeting = 'Szia! Lépésről lépésre kitöltjük a radni nalogot. A végén még mindent át tudsz nézni.';
        addMessage('assistant', greeting);
        ask(
            'clientType',
            'Az ügyfél magánszemély vagy cég?',
            [
                { label: 'Magánszemély', value: 'magánszemély' },
                { label: 'Cég', value: 'cég' },
            ],
            `${greeting} Az ügyfél magánszemély vagy cég?`,
        );
        if (state.recognition) {
            setStatus('A mikrofon csak a gomb megnyomásakor figyel.');
        } else {
            setStatus('Ezen a böngészőn gépeléssel használható. Hanghoz próbáld Chrome-ban.', 'error');
        }
    }

    function setListening(listening) {
        state.listening = listening;
        elements.microphone.setAttribute('aria-pressed', String(listening));
        elements.microphone.classList.toggle('bg-red-50', listening);
        elements.microphone.classList.toggle('border-red-300', listening);
        elements.micIdle.classList.toggle('hidden', listening);
        elements.micLive.classList.toggle('hidden', !listening);
        setStatus(
            listening
                ? `Figyelek… beszélj ${recognitionLanguageAdverb()}.`
                : `A mikrofon ${recognitionLanguageName()} felismerésre van állítva.`,
        );
    }

    function initializeSpeechRecognition() {
        const Recognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!Recognition) {
            elements.microphone.disabled = true;
            elements.microphone.title = 'Ez a böngésző nem támogatja a hangfelismerést';
            setStatus('Ezen a böngészőn gépeléssel használható. Hanghoz próbáld Chrome-ban.', 'error');
            return;
        }

        state.recognition = new Recognition();
        state.recognition.lang = state.recognitionLocale;
        state.recognition.continuous = false;
        state.recognition.interimResults = true;
        state.recognition.maxAlternatives = 1;

        state.recognition.onstart = () => {
            state.finalTranscript = '';
            setListening(true);
        };

        state.recognition.onresult = (event) => {
            let interimTranscript = '';
            for (let index = event.resultIndex; index < event.results.length; index += 1) {
                const rawTranscript = event.results[index][0].transcript;
                const transcript = state.recognitionLocale === SERBIAN_LOCALE
                    ? serbianCyrillicToLatin(rawTranscript)
                    : rawTranscript;
                if (event.results[index].isFinal) {
                    state.finalTranscript += transcript;
                } else {
                    interimTranscript += transcript;
                }
            }
            elements.input.value = state.finalTranscript || interimTranscript;
        };

        state.recognition.onerror = (event) => {
            if (event.error === 'aborted') {
                state.finalTranscript = '';
                setListening(false);
                return;
            }
            const messages = {
                'not-allowed': 'A mikrofon nincs engedélyezve. Engedélyezd a böngésző címsora mellett.',
                'audio-capture': 'Nem találok használható mikrofont ezen az eszközön.',
                'no-speech': 'Nem hallottam beszédet. Nyomd meg a mikrofont, és próbáld újra.',
                network: 'A hangfelismeréshez most nem érhető el a hálózati szolgáltatás.',
            };
            state.finalTranscript = '';
            setListening(false);
            setStatus(messages[event.error] || 'A hangfelismerés megszakadt. Gépeléssel tovább tudsz menni.', 'error');
        };

        state.recognition.onend = () => {
            const transcript = state.finalTranscript.trim();
            setListening(false);
            if (transcript) {
                elements.input.value = transcript;
                window.setTimeout(() => submitAnswer(), 120);
            }
        };
    }

    elements.toggle.addEventListener('click', () => {
        const opening = elements.panel.classList.contains('hidden');
        if (opening && state.step === 'idle') {
            unlockAudio();
            startAssistant();
            return;
        }
        setExpanded(opening);
    });
    elements.start.addEventListener('click', () => {
        unlockAudio();
        startAssistant();
    });
    elements.restart.addEventListener('click', () => {
        unlockAudio();
        startAssistant();
    });
    elements.send.addEventListener('click', () => submitAnswer());
    elements.input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            submitAnswer();
        }
    });
    elements.language.addEventListener('click', () => {
        if (state.listening) state.recognition?.abort();
        setRecognitionLocale(
            state.recognitionLocale === HUNGARIAN_LOCALE ? SERBIAN_LOCALE : HUNGARIAN_LOCALE,
            true,
        );
    });
    elements.microphone.addEventListener('click', () => {
        if (!state.recognition) return;
        if (state.listening) {
            state.recognition.stop();
            return;
        }
        unlockAudio();
        stopSpeaking();
        try {
            state.recognition.lang = state.recognitionLocale;
            state.recognition.start();
        } catch (_) {
            setStatus('A mikrofon már elindult. Beszélj magyarul.', 'error');
        }
    });
    elements.sound.addEventListener('click', () => {
        state.soundEnabled = !state.soundEnabled;
        if (!state.soundEnabled) stopSpeaking();
        if (state.soundEnabled) unlockAudio();
        try {
            window.localStorage.setItem('ftherm-assistant-sound', state.soundEnabled ? 'on' : 'off');
        } catch (_) {
            // Private browsing can disable local storage; the current session still works.
        }
        setSoundButton();
        setStatus(state.soundEnabled ? 'A magyar felolvasás bekapcsolva.' : 'A magyar felolvasás kikapcsolva.');
    });
    elements.voice.addEventListener('change', async () => {
        const selectedVoice = elements.voice.value;
        if (!Object.prototype.hasOwnProperty.call(PIPER_HUNGARIAN_VOICES, selectedVoice)) return;

        unlockAudio();
        stopSpeaking();
        state.piperVoice = selectedVoice;
        try {
            window.localStorage.setItem('ftherm-assistant-voice', selectedVoice);
        } catch (_) {
            // The selected voice remains active for the current session.
        }

        setStatus(`${piperVoiceNameWithArticle()} magyar hang előkészítése…`);
        try {
            const piperTts = await loadPiperTtsModule();
            piperTts.TtsSession._instance = null;
            if (state.soundEnabled) {
                speak(`Ez ${piperVoiceNameWithArticle()} magyar hang. Jól érthetően fogom felolvasni a kérdéseket.`);
            }
        } catch (error) {
            console.error('Could not switch Piper voice:', error);
            setStatus('A kiválasztott magyar hangot nem sikerült betölteni.', 'error');
        }
    });
    elements.repeat.addEventListener('click', () => {
        if (!state.lastSpokenText) return;
        state.soundEnabled = true;
        setSoundButton();
        unlockAudio();
        speak(state.lastSpokenText);
        setStatus('A kérdést újra felolvasom a Piper magyar hanggal.');
    });

    setSoundButton();
    setRecognitionLocale(HUNGARIAN_LOCALE);
    initializeSpeechRecognition();
}

if (typeof document !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll(ASSISTANT_SELECTOR).forEach(initializeWorkOrderAssistant);
    });
}

export {
    bigramSimilarity,
    normalizeMaterialQuery,
    normalizeText,
    normalizePhoneNumber,
    parseHungarianNumber,
    serbianCyrillicToLatin,
    translateKnownService,
};
