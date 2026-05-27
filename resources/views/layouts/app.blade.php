<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/svg" href="{{ asset('favicon.svg') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="h-screen flex flex-col ">
            @include('layouts.navigation')

            @isset($header)
                <header class="sticky top-[64px] z-40 backdrop-blur bg-gray-200 dark:bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0  after:border-y after:border-white/10">
                    <div class=" mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 min-h-0 overflow-auto bg-cover bg-center bg-fixed"
    style="background-image: url('{{ asset('images/background.png') }}');
           padding-bottom: var(--notif-bar-h, 0px);
           transition: padding-bottom 0.5s ease;">
    <div class="h-full min-h-0">
        {{ $slot }}
    </div>
</main>
            @include('layouts.avatar-modal')
        </div>

<div id="errorNotifPanel"
    class="fixed bottom-0 left-0 right-0 z-[9999] translate-y-full transition-transform duration-500 ease-in-out"
    style="will-change:transform;">

    {{-- Header --}}
    <div class="flex items-center justify-between px-4 py-2
                bg-red-600 text-white shadow-2xl border-t-2 border-red-400">
        <div class="flex items-center gap-3">
            <div class="relative flex-shrink-0">
                <div class="w-2.5 h-2.5 rounded-full bg-white animate-ping absolute inset-0"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-white relative"></div>
            </div>
            <span class="font-bold text-sm tracking-wide uppercase">⚠ CCTV Error Terdeteksi</span>
            <span id="errorNotifCount" class="bg-white text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">0</span>
        </div>
        <button id="btnNotifToggleDetail"
            class="flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white/20 hover:bg-white/30 text-white text-xs font-medium transition">
            <svg id="notifChevronDown" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            <svg id="notifChevronUp"   width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="hidden"><polyline points="18 15 12 9 6 15"/></svg>
            Detail
        </button>
    </div>

    {{-- Detail list --}}
    <div id="errorNotifDetail" class="bg-red-700 border-t border-red-500 overflow-hidden transition-all duration-300" style="max-height:0;">
        <div id="errorNotifList" class="flex flex-wrap gap-2 px-4 py-2 max-h-28 overflow-y-auto"></div>
    </div>
</div>

<audio id="errorAlertAudio" preload="auto" loop>
    <source src="{{ asset('audio/alert1.mpeg') }}" type="audio/mpeg">
</audio>

<style>
    #errorNotifPanel.notif-visible { transform: translateY(0); }
    #errorNotifPanel.notif-hidden  { transform: translateY(100%); }
    :root { --notif-bar-h: 0px; }
</style>

<script>
window.__ACK_RESET_TIME__ = '{{ \App\Models\Setting::get("ack_reset_time", "10:00") }}';
</script>

<script>


window.lockSubmit = function(btn, label) {
    if (!btn) return false;
    if (btn.dataset.submitting === '1') return false;
    btn.dataset.submitting = '1';
    btn._origHTML = btn.innerHTML;
    btn.disabled = true;
    btn.style.opacity = '0.6';
    btn.textContent = label || 'Memproses...';
    return true;
};
window.unlockSubmit = function(btn) {
    if (!btn) return;
    delete btn.dataset.submitting;
    btn.disabled = false;
    btn.style.opacity = '';
    if (btn._origHTML !== undefined) btn.innerHTML = btn._origHTML;
};


(function() {
    'use strict';
    const POLL_MS   = 5_000;
    const AUDIO_SRC = '{{ asset("audio/alert1.mpeg") }}';
    const API_URL   = '{{ route("api.active.errors") }}';
    const ACK_URL   = '/api/cctvs/__ID__/acknowledge-error';
    const CSRF      = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const LS_ACK_LOCAL = 'cctv_ack_local';

    let _errors       = [];
    let _localAckIds  = new Set(); 
    let _firstFetchDone = false;  
    let _detailOpen   = false;
    let _audioCtx     = null;
    let _audioBuffer  = null;
    let _sourceNode   = null;
    let _audioReady   = false;
    let _audioPlaying = false;

    const panel      = document.getElementById('errorNotifPanel');
    const countBadge = document.getElementById('errorNotifCount');
    const list       = document.getElementById('errorNotifList');
    const detail     = document.getElementById('errorNotifDetail');
    const btnToggle  = document.getElementById('btnNotifToggleDetail');
    const chevDown   = document.getElementById('notifChevronDown');
    const chevUp     = document.getElementById('notifChevronUp');
    const htmlAudio  = document.getElementById('errorAlertAudio');

    async function initAudio() {
        try {
            _audioCtx   = new (window.AudioContext || window.webkitAudioContext)();
            const resp  = await fetch(AUDIO_SRC);
            const buf   = await resp.arrayBuffer();
            _audioBuffer = await _audioCtx.decodeAudioData(buf);
            _audioReady  = true;
        } catch(e) { _audioReady = false; }
    }
    function startAudio() {
        if (_audioPlaying) return;
        _audioPlaying = true;
        if (_audioReady && _audioCtx) {
            try {
                if (_audioCtx.state === 'suspended') _audioCtx.resume();
                _sourceNode = _audioCtx.createBufferSource();
                _sourceNode.buffer = _audioBuffer;
                _sourceNode.loop   = true;
                _sourceNode.connect(_audioCtx.destination);
                _sourceNode.start(0);
                return;
            } catch(e) {}
        }
        htmlAudio.loop = true; htmlAudio.currentTime = 0;
        htmlAudio.play().catch(() => {});
    }
    function stopAudio() {
        _audioPlaying = false;
        try { if (_sourceNode) { _sourceNode.stop(); _sourceNode.disconnect(); _sourceNode = null; } } catch(e) {}
        htmlAudio.pause(); htmlAudio.currentTime = 0;
    }
    ['click','keydown','touchstart'].forEach(ev =>
        document.addEventListener(ev, () => _audioCtx?.state === 'suspended' && _audioCtx.resume())
    );

    function showPanel() {
        panel.classList.remove('notif-hidden');
        panel.classList.add('notif-visible');
        requestAnimationFrame(() => {
            const h = panel.querySelector('.flex.items-center.justify-between')?.offsetHeight ?? 44;
            document.documentElement.style.setProperty('--notif-bar-h', h + 'px');
        });
    }
    function hidePanel() {
        document.documentElement.style.setProperty('--notif-bar-h', '0px');
        panel.classList.remove('notif-visible');
        panel.classList.add('notif-hidden');
        _detailOpen = false;
        detail.style.maxHeight = '0';
        chevDown.classList.remove('hidden');
        chevUp.classList.add('hidden');
    }

    btnToggle?.addEventListener('click', () => {
        _detailOpen = !_detailOpen;
        detail.style.maxHeight = _detailOpen ? (detail.scrollHeight + 50) + 'px' : '0';
        chevDown.classList.toggle('hidden', _detailOpen);
        chevUp.classList.toggle('hidden', !_detailOpen);
    });

    async function acknowledgeError(cctvId) {
        const id = Number(cctvId);

        _localAckIds.add(id);
        renderErrors();

        window.dispatchEvent(new CustomEvent('cctv:acknowledged', { detail: { id } }));

        try {
            await fetch(ACK_URL.replace('__ID__', id), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            });

            _localAckIds.delete(id);
        } catch(err) {

            console.warn('Acknowledge network error:', err);
        }
    }

    window._ackError      = acknowledgeError;
    window._isAcknowledged = (id) => _localAckIds.has(Number(id));

    function esc(s) { return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

    function getVisibleErrors() {
        return _errors.filter(e => !_localAckIds.has(Number(e.id)));
    }

    function renderErrors() {
        if (!_firstFetchDone) return;

        const visible = getVisibleErrors();
        countBadge.textContent = visible.length;

        if (visible.length === 0) {
            hidePanel();
            stopAudio();
            list.innerHTML = '';
            return;
        }

        showPanel();
        if (!_audioPlaying) startAudio();

        list.innerHTML = visible.map(e => `
            <div class="flex items-center gap-2 bg-red-800/60 border border-red-500/40
                        rounded-lg px-3 py-1.5 text-xs text-white whitespace-nowrap flex-shrink-0">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="#fca5a5" class="flex-shrink-0">
                    <path d="M12 2L1 21h22L12 2z"/>
                    <rect x="11" y="8" width="2" height="6" fill="white"/>
                    <rect x="11" y="16" width="2" height="2" fill="white"/>
                </svg>
                <span class="font-semibold">${esc(e.location)}</span>
                <span class="text-red-300">·</span>
                <span>${esc(e.cctv_name)}</span>
                <button
                    onclick="window._ackError(${e.id})"
                    class="ml-1 flex items-center gap-1 px-2 py-0.5 rounded
                        bg-white/20 hover:bg-white/40 border border-white/40
                        text-white text-[10px] font-bold transition flex-shrink-0"
                    title="Acknowledge">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Ack
                </button>
            </div>`).join('');

        if (_detailOpen) detail.style.maxHeight = (detail.scrollHeight + 50) + 'px';
    }

    async function fetchErrors() {
        try {
            const r = await fetch(API_URL, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
            });
            if (!r.ok) return;

            const serverErrors = await r.json();


            const serverIds = new Set(serverErrors.map(e => Number(e.id)));
            for (const ackId of _localAckIds) {
                if (!serverIds.has(ackId)) _localAckIds.delete(ackId);
            }

            _errors = serverErrors;
            _firstFetchDone = true;
            renderErrors();
        } catch(e) {}
    }


    document.addEventListener('DOMContentLoaded', async () => {
      
        initAudio().catch(() => {});
        await fetchErrors();

        setInterval(fetchErrors, POLL_MS);
    });

    window.addEventListener('beforeunload', () => {
    });
})();
</script>
    </body>
</html>