<x-app-layout>
    <div class="h-full overflow-hidden">
        <div class=" h-full">
            <div class="flex gap-4 h-full min-h-0 px-4 pb-4 pt-3">
                <div id="toastContainer" class="fixed top-5 right-5 space-y-2 z-50"></div>
                <div class="flex-1 min-w-0 rounded-2xl border border-gray-200 dark:border-white/10 bg-white/80 dark:bg-gray-800/50 p-4 shadow-xl backdrop-blur-md h-full min-h-0 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="floorTitle">{{ $building->name }}</h3>
                    </div>

                    <div id="floorTabs" class="flex flex-wrap gap-2 mb-3"></div>

                    <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-gray-100 dark:bg-gray-900 p-2 flex-1 min-h-0">
                        <div id="maintenanceMap" class="w-full h-full rounded-lg overflow-hidden"></div>
                    </div>

                    <div class="mt-3 flex items-end justify-between gap-3 flex-wrap">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <div class="flex flex-wrap gap-3">
                                <span class="flex items-center gap-1">
                                    <span class="inline-block w-3 h-3 rounded-full"
                                        style="background:{{ \App\Models\Setting::colorDue() }}"></span>
                                    Perlu Maintenance (&gt;{{ \App\Models\Setting::dueHours() >= 24 ? (\App\Models\Setting::dueHours() / 24).' hari' : \App\Models\Setting::dueHours().' jam' }})
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="inline-block w-3 h-3 rounded-full"
                                        style="background:{{ \App\Models\Setting::colorOverdue() }}"></span>
                                    Overdue (&gt;{{ \App\Models\Setting::overdueHours() >= 24 ? (\App\Models\Setting::overdueHours() / 24).' hari' : \App\Models\Setting::overdueHours().' jam' }})
                                </span>
                                <span class="flex items-center gap-1">
                                    <span style="font-size:14px;font-weight:900;color:#ef4444;text-shadow:0 0 4px rgba(239,68,68,0.8);line-height:1;">!</span>
                                    CCTV Error
                                </span>
                            </div>
                            @if(auth()->user()->hasRole('manajer', 'superadmin'))
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Klik kanan pada denah untuk tambah CCTV. Klik kanan pada CCTV untuk hapus.
                            </div>
                            @endif
                        </div>

                        <a href="{{ request('from') === 'dashboard' ? route('dashboard') : route('buildings.monitoring') }}"
                            class="flex-shrink-0 flex items-center gap-2 px-4 py-2.5 rounded-full
                                bg-gray-900/80 dark:bg-white/10 backdrop-blur-md border border-white/10
                                text-yellow-400 hover:text-yellow-300 hover:bg-gray-900
                                text-sm font-semibold shadow-xl transition-all duration-200 hover:scale-105">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7"/>
                            </svg>
                            Kembali
                        </a>
                    </div>

                </div>

                <div id="infoPanelWrapper" class="rounded-2xl border border-gray-200 dark:border-white/10 bg-white/80 dark:bg-gray-800/50 p-4 shadow-xl backdrop-blur-md h-full min-h-0 overflow-y-auto overflow-x-hidden flex-shrink-0">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Info CCTV</h3>
                        <button id="btnCloseInfo" 
                            class="hidden text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors text-xl leading-none"
                            title="Tutup">✕</button>
                    </div>

                    <div id="emptyInfoState" class="text-sm text-gray-600 dark:text-gray-300">
                        Klik marker CCTV untuk melihat detail.
                    </div>

                    <div id="cctvInfoPanel" class="hidden space-y-3">
                        <input type="hidden" id="selectedCctvId">

                        <div class="rounded-lg border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-gray-900/40 p-3 text-sm dark:text-white space-y-2">
                            <div><b>Nama :</b> <span id="infoNameText">-</span></div>
                            <div><b>IP Address :</b> <span id="infoIpText">-</span></div>   
                            <div><b>Status CCTV :</b> <span id="infoStatusText"></span></div>
                            <div><b id="infoMaintenanceNoteLabel">Keterangan Maintenance :</b> <span id="infoMaintenanceNote">-</span></div>
                            <div><b>Terakhir Maintenance :</b> <span id="infoLastMaintenance">-</span></div>
                             <div><b>Petugas Maintenance :</b> <span id="infoMaintainer">-</span></div>
                            <div id="infoMaintenancePhotoWrap" class="hidden">
                                <b id="infoPhotoLabel" class="block mb-1">Foto :</b>
                                <img id="infoMaintenancePhoto" src="" 
                                    class=" max-h-20 object-cover rounded-lg border border-amber-400/50 shadow cursor-pointer"
                                    title="Klik untuk lihat penuh">
                            </div>
                        </div>

                        <div id="ackWrap" class="hidden">
                            <button id="btnAcknowledge" type="button"
                                class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg
                                    bg-blue-600/10 hover:bg-blue-600/20 border border-blue-500/30
                                    text-blue-600 dark:text-blue-400 text-xs font-semibold transition">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Acknowledge — Tandai Sudah Diketahui
                            </button>
                            <p class="text-[10px] text-gray-400 text-center mt-1">
                                Alarm notifikasi akan berhenti untuk CCTV ini
                            </p>
                        </div>
                        @if(auth()->user()->role !== 'security')
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Nama Petugas Maintenance <span class="text-red-500">*</span></label>
                            <input id="technicianName" type="text" required
                                class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2"
                                placeholder="Nama petugas">
                        </div>

                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Keterangan Maintenance (opsional)</label>


                                <div class="relative">
                                    <textarea id="maintenanceNote" rows="4"
                                        class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 resize-none pr-32"
                                        placeholder="Catatan maintenance..."></textarea>
                                    <div id="maintenancePhotoPreview" class="hidden absolute bottom-6 right-6">
                                        <img id="maintenancePhotoImg" src=""
                                            class=" h-20 w-20 object-cover rounded-lg border-2 border-amber-400 shadow-lg">
                                            <button id="btnRemoveMaintenancePhoto" type="button"
                                            class="absolute -top-1.5 -right-1.5 w-4 h-4 rounded-full bg-red-500 hover:bg-red-400 text-white flex items-center justify-center shadow"
                                            style="font-size:9px; line-height:1;">✕</button>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-start gap-2">
                                    <label class="cursor-pointer flex items-center gap-1 px-2 py-1.5 rounded-lg border border-gray-300 dark:border-white/10 text-xs text-gray-500 dark:text-amber-500 hover:bg-gray-50 dark:hover:bg-white/5">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Foto
                                        <input id="maintenancePhoto" type="file" accept="image/*" class="hidden">
                                    </label>
                                </div>
                        </div>

                        <div class="flex gap-2 items-center">
                            <button id="btnMarkMaintenance" type="button"
                                class="flex-1 px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black font-semibold">
                                Tandai Maintenance
                            </button>

                            <button id="btnToggleErrorForm" type="button"
                                class="px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white font-semibold"
                                title="Laporkan Error">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#ef4444">
                                    <path d="M12 2L1 21h22L12 2z"></path>
                                    <rect x="11" y="8" width="2" height="6" fill="white"></rect>
                                    <rect x="11" y="16" width="2" height="2" fill="white"></rect>
                                </svg>
                            </button>
                        </div>

                        <div id="errorFormWrap" class="hidden rounded-lg border border-red-300/40 dark:border-red-500/20 bg-red-50 dark:bg-red-500/10 p-3">
                            <label class="block text-xs text-red-700 dark:text-red-300 mb-1">Keterangan Error <span class="text-red-500">*</span>
                            <span id="errorDescriptionError" class="text-red-500 font-normal"></span>
                            </label>
                            <div class="relative">
                                <textarea id="errorDescription" rows="4"
                                    class="w-full rounded-lg border border-red-300 dark:border-red-500/30 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 resize-none pr-32"
                                    placeholder="Jelaskan error CCTV...">
                                </textarea>

                                <div id="errorPhotoPreview" class="hidden absolute bottom-6 right-6">
                                    <div class="relative">
                                        <img id="errorPhotoImg" src=""
                                            class=" h-20 w-20 object-cover rounded-lg border border-red-300 shadow">
                                            <button id="btnRemoveErrorPhoto" type="button"
                                            class="absolute -top-1.5 -right-1.5 w-4 h-4 rounded-full bg-red-500 hover:bg-red-400 text-white flex items-center justify-center shadow"
                                            style="font-size:9px; line-height:1;">✕</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 flex items-start gap-2">
                                <label class="cursor-pointer flex items-center gap-1 px-2 py-1.5 rounded-lg border border-red-300 dark:border-red-500/30 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Foto Error
                                    <input id="errorPhoto" type="file" accept="image/*" class="hidden">
                                </label>
                                
                            </div>
                            <button id="btnMarkError" type="button"
                                class="mt-2 w-full px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white font-semibold">
                                Submit Error CCTV
                            </button>
                        </div>
                        @else
                        <div class="rounded-lg border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-gray-800/30 px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center mt-2">
                            <svg class="mx-auto mb-1.5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Anda hanya memiliki akses lihat.<br>Hubungi petugas untuk melakukan maintenance.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div id="modalAddCctv" class="fixed flex inset-0 z-[999] items-center justify-center hidden ">
            <div id="modalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
            <div class="relative z-10 w-full max-w-md mx-4 rounded-2xl border border-white/10 bg-gray-900 shadow-2xl p-6 space-y-4
                        transition-all duration-300 scale-95 opacity-0" id="modalPanel">

                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white">Tambah CCTV</h3>
                    <button id="btnModalClose" class="text-gray-400 hover:text-white text-xl leading-none">✕</button>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Nama CCTV <span class="text-red-500">*</span></label>
                        <input id="modalCctvName" type="text"
                            class="w-full rounded-lg border border-white/10 bg-gray-800 text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                            placeholder="Contoh: CCTV Lobby Lt.1">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">IP Address</label>
                        <input id="modalCctvIp" type="text"
                            class="w-full rounded-lg border border-white/10 bg-gray-800 text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                            placeholder="Contoh: 192.168.1.10">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Tipe CCTV <span class="text-red-500">*</span></label>
                        <select id="modalCctvType"
                            class="w-full rounded-lg border border-white/10 bg-gray-800 text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="dome">Dome — Kamera bulat plafon</option>
                            <option value="bullet">Bullet — Kamera silinder outdoor</option>
                            <option value="ptz">PTZ — Pan-Tilt-Zoom</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-3 rounded-lg bg-gray-800/60 border border-white/5 px-3 py-2">
                        <div id="modalIconPreview" class="w-10 h-10 flex items-center justify-center"></div>
                        <span class="text-xs text-gray-400">Preview marker pada denah</span>
                    </div>
                </div>

                <div class="flex gap-2 pt-1">
                    <button id="btnModalCancel" type="button"
                        class="flex-1 px-3 py-2 rounded-lg border border-white/10 text-gray-300 hover:bg-white/5 text-sm font-medium">
                        Batal
                    </button>
                    <button id="btnModalSubmit" type="button"
                        class="flex-1 px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black text-sm font-semibold">
                        Tambahkan
                    </button>
                </div>
            </div>
        </div>

        <div id="modalDeleteCctv" class="fixed flex inset-0 z-[999] items-center justify-center hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modalDeleteBackdrop"></div>
            <div id="modalDeletePanel"
                class="relative z-10 w-full max-w-sm mx-4 rounded-2xl border border-white/10 bg-gray-900 shadow-2xl p-6 space-y-4
                    transition-all duration-300 scale-95 opacity-0">

                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ef4444">
                            <path d="M12 2L1 21h22L12 2z"/>
                            <rect x="11" y="8" width="2" height="6" fill="white"/>
                            <rect x="11" y="16" width="2" height="2" fill="white"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Hapus CCTV</h3>
                        <p class="text-sm text-gray-400 mt-0.5">
                            Hapus <span id="deleteCctvName" class="text-white font-semibold"></span>?
                            Tindakan ini tidak bisa dibatalkan.
                        </p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button id="btnDeleteCancel" type="button"
                        class="flex-1 px-3 py-2 rounded-lg border border-white/10 text-gray-300 hover:bg-white/5 text-sm font-medium">
                        Batal
                    </button>
                    <button id="btnDeleteConfirm" type="button"
                        class="flex-1 px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white text-sm font-semibold">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        .animate-pulse-slow {
            animation: pulseSlow 1.8s infinite;
        }
        .animate-pulse-fast {
            animation: pulseFast 0.55s infinite;
        }
        @keyframes pulseSlow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .45; transform: scale(1.08); }
        }
        @keyframes pulseFast {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .15; transform: scale(1.15); }
        }
        .animate-pulse-red-slow {
            animation: pulseRedSlow 1.8s infinite;
        }
        @keyframes pulseRedSlow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .45; transform: scale(1.08); }
        }
        .cctv-icon {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            border: 2px solid white;
            box-shadow: 0 0 0 2px rgba(0,0,0,.3);
        }
        .cctv-icon.normal {
            background: #22c55e;
        }
        .cctv-icon.due {
            background: #f59e0b;
            animation: pulseSlow 1.8s infinite;
        }
        .cctv-icon.error {
            width: auto;
            height: auto;
            border-radius: 0;
            border: none;
            box-shadow: none;
            color: #ef4444;
            font-size: 20px;
            font-weight: 700;
            line-height: 1;
            animation: pulseFast .55s infinite;
            text-shadow: 0 0 6px rgba(239,68,68,.45);
        }
        .cctv-selected {
            transform: scale(1.5);
            z-index: 999 !important;
            filter: drop-shadow(0 0 6px #facc15)
                    drop-shadow(0 0 12px rgba(250,204,21,0.8));
        }
        /* Ikon CCTV per tipe */
        .cctv-icon-dome   { color: #60a5fa; }
        .cctv-icon-bullet { color: #fbbf24; }
        .cctv-icon-ptz    { color: #f472b6; }
        #maintenanceMap {
            width: 100%;
            height: 100%;
        }

        .leaflet-container img {
            image-rendering: crisp-edges;
        }
        
        #infoPanelWrapper {
            width: 0;
            padding-left: 0;
            padding-right: 0;
            opacity: 0;
            pointer-events: none;
            transition: width 0.35s cubic-bezier(.4,0,.2,1),
                        opacity 0.3s ease,
                        padding 0.35s ease;
            border-width: 0;
        }
        #infoPanelWrapper.panel-open {
            width: 360px;
            padding-left: 1rem;
            padding-right: 1rem;
            opacity: 1;
            pointer-events: auto;
            border-width: 1px;
        }

@media (max-width: 767px) {

    .flex.gap-4.h-full.min-h-0.px-4.pb-4.pt-3 {
        flex-direction: column !important;
        height: auto !important;
        overflow-y: auto !important;
        padding-bottom: 5rem !important;
    }

    .flex-1.min-w-0.rounded-2xl.border.border-gray-200 {
        height: auto !important;
        min-height: 0 !important;
    }

    #maintenanceMap {
        min-height: 320px !important;
        height: 320px !important;
    }

    #floorTabs {
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 4px;
        gap: 0.4rem !important;
        scrollbar-width: none;
    }
    #floorTabs::-webkit-scrollbar { display: none; }

    #infoPanelWrapper {

        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        max-height: 75vh !important;
        border-radius: 1.25rem 1.25rem 0 0 !important;
        border-width: 1px !important;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        padding-top: 0.75rem !important;
        padding-bottom: 1rem !important;
        z-index: 500 !important;
        overflow-y: auto !important;
  
        transform: translateY(100%) !important;
        opacity: 1 !important;
        transition: transform 0.35s cubic-bezier(.4,0,.2,1) !important;
        pointer-events: none !important;
    }

    #infoPanelWrapper.panel-open {
        width: 100% !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
        border-width: 1px !important;
        opacity: 1 !important;
    }

    #infoPanelWrapper::before {
        content: '';
        display: block;
        width: 40px;
        height: 4px;
        background: rgba(156, 163, 175, 0.5);
        border-radius: 2px;
        margin: 0 auto 12px;
    }

    #infoPanelWrapper.panel-open ~ * {
        pointer-events: none;
    }

    #mobileBackdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 490;
        backdrop-filter: blur(2px);
    }
    #mobileBackdrop.active {
        display: block;
    }


    .mt-3.text-sm.text-gray-700 .flex.flex-wrap.gap-4 {
        gap: 0.5rem !important;
        font-size: 0.7rem !important;
    }

    #modalPanel,
    #modalDeletePanel {
        max-width: calc(100vw - 2rem) !important;
        margin: 0 1rem !important;
    }
}

@media (max-width: 480px) {
    #maintenanceMap {
        min-height: 260px !important;
        height: 260px !important;
    }

    #infoPanelWrapper {
        max-height: 80vh !important;
    }
}

    </style>

    <script>
        window.__STATUS_COLORS__ = {
            due:     '{{ \App\Models\Setting::colorDue() }}',
            overdue: '{{ \App\Models\Setting::colorOverdue() }}',
            error:   '#ef4444',
        };
        window.__THRESHOLDS__ = {
            dueSeconds:     {{ \App\Models\Setting::dueHours() * 3600 }},
            overdueSeconds: {{ \App\Models\Setting::overdueHours() * 3600 }},
        };
        window.__FLOORS__ = @json($floorsPayload);
        window.__CSRF__ = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        window.__ROUTES__ = {
            storeCctvForFloor: "{{ url('/maintenance/floors') }}/__FLOOR__/cctvs",
            deleteCctv: "{{ url('/maintenance/cctvs') }}/__CCTV__",
            updateCctv: "{{ url('/maintenance/cctvs') }}/__CCTV__",
            markMaintenance: "{{ url('/maintenance/cctvs') }}/__CCTV__/mark-maintenance",
            markError: "{{ url('/maintenance/cctvs') }}/__CCTV__/mark-error",
        };
    </script>

    <script>
        let leafletMap = null;
        let currentFloor = null;
        let floorImageOverlay = null;
        let floorImageSize = { w: 1000, h: 800 };
        let cctvMarkers = new Map();
        let selectedCctv = null;
        let selectedLeafletMarker = null;
        let hasUnsavedMaintenance = false;

        const floors = window.__FLOORS__ || [];
        const _selectCctvId = new URLSearchParams(window.location.search).get('select_cctv');
        if (_selectCctvId) history.replaceState({}, '', window.location.pathname);

        const byId = (id) => document.getElementById(id);

        function routeTemplate(template, value) {
            return template.replace(/__\w+__/, value);
        }


async function apiFetch(url, options = {}) {
    window.showLoading?.();
    try {
        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            ...(options.body && !(options.body instanceof FormData)
                ? { 'Content-Type': 'application/json' } : {}),
            ...(options.headers || {}),
        };
        const resp = await fetch(url, { ...options, headers });
        const data = await resp.json();
        if (!resp.ok) throw new Error(data.message || 'Terjadi kesalahan server.');
        return data;
    } finally {
        window.hideLoading?.();
    }
}

        function computeVisualStatus(cctv) {
    if (cctv.is_error) return 'error';
    if (!cctv.last_maintenance_at) return 'overdue';
    const diffSeconds = (new Date() - new Date(cctv.last_maintenance_at)) / 1000;
    if (diffSeconds >= {{ \App\Models\Setting::overdueHours() * 3600 }}) return 'overdue';
    if (diffSeconds >= {{ \App\Models\Setting::dueHours() * 3600 }})     return 'due';
    return 'normal';
}

        function visualStatusLabel(cctv) {
    const dueH     = Math.round(window.__THRESHOLDS__?.dueSeconds     / 3600) || 24;
    const overdueH = Math.round(window.__THRESHOLDS__?.overdueSeconds / 3600) || 72;
    const fmtH = h => h >= 24 ? (h / 24) + ' hari' : h + ' jam';

    if (cctv.visual_status === 'error')   return 'Error';
    if (cctv.visual_status === 'overdue') return `Overdue (>${fmtH(overdueH)})`;
    if (cctv.visual_status === 'due')     return `Perlu Maintenance (>${fmtH(dueH)})`;
    return 'Normal';
}

        function visualStatusClass(cctv) {
            return cctv.visual_status || 'normal';
        }

        const CCTV_IMAGES = {
    dome:   '{{ asset("images/cctv/dome.png") }}',
    bullet: '{{ asset("images/cctv/bullet.png") }}',
    ptz:    '{{ asset("images/cctv/ptz.png") }}',
};


function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1,3), 16);
    const g = parseInt(hex.slice(3,5), 16);
    const b = parseInt(hex.slice(5,7), 16);
    return `rgba(${r},${g},${b},${alpha})`;
}


    function makeCctvIcon(cctv, isSelected = false) {
        const SIZE = 30;
        const type   = cctv.cctv_type || 'dome';
        const status = computeVisualStatus(cctv);
        const imgSrc = CCTV_IMAGES[type] ?? CCTV_IMAGES.dome;

        const pulseClass = status === 'error'   ? 'animate-pulse-fast'
                        : status === 'due'     ? 'animate-pulse-slow'
                        : status === 'overdue' ? 'animate-pulse-red-slow'
                        : '';

        const c = window.__STATUS_COLORS__;
        const statusGlow = status === 'error'   ? hexToRgba(c.error, 0.55)
                 : status === 'due'     ? hexToRgba(c.due, 0.55)
                 : status === 'overdue' ? hexToRgba(c.overdue, 0.55)
                 : '';

        const selectedGlow = isSelected ? 'rgba(250,204,21,0.75)' : '';
        const activeGlow = statusGlow;

        const highlightHtml = activeGlow ? `
            <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:30px;height:30px;z-index:0;pointer-events:none;">
                <div class="${pulseClass}" style="width:100%;height:100%;border-radius:50%;background:${activeGlow};box-shadow:0 0 12px 6px ${activeGlow};"></div>
            </div>
        ` : '';
        const selectedRing = isSelected ? `
            <div style="
                position:absolute;top:50%;left:50%;
                transform:translate(-50%,-50%);
                width:${SIZE + 8}px;height:${SIZE + 8}px;
                border-radius:50%;
                border:2.5px solid white;
                box-shadow:0 0 0 2px rgba(0,0,0,0.4);
                z-index:2;pointer-events:none;
            "></div>
        ` : '';


        const errorBadge = status === 'error' ? `
            <div class="animate-pulse-fast" style="
                position:absolute;top:-8px;right:-6px;
                font-size:16px;font-weight:900;color:#ef4444;
                z-index:3;line-height:1;
                text-shadow:0 0 4px rgba(0,0,0,0.8), 0 0 8px rgba(239,68,68,0.9);
            ">!</div>
            ` : '';

            return L.divIcon({
                className: '',
                html: `
                    <div style="position:relative;width:${SIZE}px;height:${SIZE}px;overflow:visible;">
                        ${highlightHtml}
                        ${selectedRing}
                        <img src="${imgSrc}" style="position:relative;z-index:1;width:${SIZE}px;height:${SIZE}px;object-fit:contain;" draggable="false">
                        ${errorBadge}
                    </div>
                `,
                iconSize: [SIZE, SIZE],
                iconAnchor: [SIZE / 2, SIZE / 2],
            });
            
    }
        function highlightMarker(cctvId) {

            cctvMarkers.forEach((marker, id) => {
                const cctv = currentFloor.cctvs.find(x => x.id === id);
                if (!cctv) return;

                const isSelected = Number(id) === Number(cctvId);
                marker.setIcon(makeCctvIcon(cctv, isSelected));
            });
        }

        function cctvToLatLng(cctv) {
            return L.latLng(cctv.y_norm * floorImageSize.h, cctv.x_norm * floorImageSize.w);
        }

        function latLngToNorm(latlng) {
            return {
                x_norm: Math.max(0, Math.min(1, latlng.lng / floorImageSize.w)),
                y_norm: Math.max(0, Math.min(1, latlng.lat / floorImageSize.h)),
            };
        }

        function renderFloorTabs() {
    const tabs = byId('floorTabs');
    tabs.innerHTML = '';

    floors.forEach((f) => {
        const cctvs    = f.cctvs || [];
        const hasError   = cctvs.some(c => computeVisualStatus(c) === 'error');
        const hasOverdue = cctvs.some(c => computeVisualStatus(c) === 'overdue');
        const hasDue     = cctvs.some(c => computeVisualStatus(c) === 'due');

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `
            relative px-4 py-2 rounded-lg text-sm font-medium border
            bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200
            border-gray-300 dark:border-white/10
        `;
        btn.dataset.floorId = f.id;

        btn.innerHTML = `
            <div class="flex items-center gap-2">
                <span>Lantai ${f.floor_number}${f.floor_name ? ' - ' + f.floor_name : ''}</span>
                ${hasError
                    ? `<span class="animate-pulse-fast flex-shrink-0" style="font-size:14px;font-weight:900;color:#ef4444;text-shadow:0 0 4px rgba(239,68,68,0.8);line-height:1;">!</span>`
                    : (hasOverdue || hasDue)
    ? `<span class="w-2.5 h-2.5 rounded-full animate-pulse-slow flex-shrink-0" style="background:${hasOverdue ? window.__STATUS_COLORS__.overdue : window.__STATUS_COLORS__.due}"></span>`
                        : ''
                }
            </div>
        `;

        btn.addEventListener('click', () => switchFloor(f.id));
        tabs.appendChild(btn);
    });
}
        function setActiveTab(floorId) {
            [...byId('floorTabs').querySelectorAll('button')].forEach(btn => {
                const active = Number(btn.dataset.floorId) === Number(floorId);
                btn.className = 'px-3 py-2 rounded-lg text-sm font-medium border ' +
                    (active
                        ? 'bg-amber-500 text-black border-amber-400'
                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-white/10');
            });
        }

        function clearCctvMarkers() {
            cctvMarkers.forEach(marker => leafletMap.removeLayer(marker));
            cctvMarkers.clear();
        }

        function renderCctvMarkers() {
            clearCctvMarkers();
            selectedCctv = null;
            selectedLeafletMarker = null;
            resetInfoPanel();

            (currentFloor.cctvs || []).forEach(cctv => addCctvMarkerToMap(cctv));
            if (_pendingSelectCctvId) {
                const target = currentFloor.cctvs?.find(c => Number(c.id) === _pendingSelectCctvId);
                if (target) {
                    _pendingSelectCctvId = null;
                    setTimeout(() => {
                        selectedCctv = target;
                        highlightMarker(target.id);
                        showCctvInfo(target);
                        const marker = cctvMarkers.get(target.id);
                        if (marker) leafletMap.flyTo(marker.getLatLng(),
                            Math.min(leafletMap.getZoom() + 1, leafletMap.getMaxZoom()),
                            { animate: true, duration: 0.6 });
                    }, 420);
                }
            }
        }

        function addCctvMarkerToMap(cctv) {
            const marker = L.marker(cctvToLatLng(cctv), {
                icon: makeCctvIcon(cctv),
            });

            marker.on('click', async () => {
                const latest = currentFloor.cctvs.find(x => x.id === cctv.id);
                if (!latest) return;
                selectedCctv = latest;
                selectedLeafletMarker = marker;
                highlightMarker(latest.id);
                const zoomTarget = Math.min(leafletMap.getZoom() + 0.5, leafletMap.getMaxZoom());

                leafletMap.flyTo(marker.getLatLng(), zoomTarget, {
                    animate: true,
                    duration: 0.5
                });
                showCctvInfo(latest);
            });

           marker.on('contextmenu', (e) => {
    @if(auth()->user()->hasRole('manajer', 'superadmin'))
        L.DomEvent.preventDefault(e);
        openDeleteModal(cctv, marker);
    @endif
});

            marker.addTo(leafletMap);
            cctvMarkers.set(cctv.id, marker);
        }

        function showCctvInfo(cctv) {
        cctv = { ...cctv, visual_status: computeVisualStatus(cctv) };
    // Isi data
    if (byId('selectedCctvId')) byId('selectedCctvId').value = cctv.id;
    if (byId('infoNameText')) byId('infoNameText').textContent = cctv.name || '-';
    if (byId('infoIpText')) byId('infoIpText').textContent = cctv.ip_address || '-';
    if (byId('infoStatusText')) {
        const c = window.__STATUS_COLORS__;
        const colorMap = {
            error:   c.error,
            overdue: c.overdue,
            due:     c.due,
            normal:  '#22c55e',
        };
        byId('infoStatusText').textContent  = visualStatusLabel(cctv);
        byId('infoStatusText').className    = 'font-semibold';
        byId('infoStatusText').style.color  = colorMap[cctv.visual_status] ?? '#22c55e';
    }

    if (byId('infoLastMaintenance')) byId('infoLastMaintenance').textContent = formatDateTime(cctv.last_maintenance_at) || '-';
    const photoWrap = byId('infoMaintenancePhotoWrap');
    const photoImg  = byId('infoMaintenancePhoto');
    const activePhotoUrl = cctv.is_error
        ? (cctv.error_photo_url || cctv.maintenance_photo_url)
        : cctv.maintenance_photo_url;

    if (activePhotoUrl && photoWrap && photoImg) {
        photoImg.src = activePhotoUrl;
        photoWrap.classList.remove('hidden');
        photoImg.onclick = () => window.open(activePhotoUrl, '_blank');
    } else {
        photoWrap?.classList.add('hidden');
        if (photoImg) photoImg.src = '';
    }
    const photoLabel = byId('infoPhotoLabel');
    if (photoLabel) {
        photoLabel.textContent = cctv.is_error && cctv.error_photo_url 
            ? 'Foto Error :' 
            : 'Foto Maintenance :';
    }
    const noteLabel = byId('infoMaintenanceNoteLabel');
    const noteValue = byId('infoMaintenanceNote');
    if (cctv.is_error && cctv.error_description) {
        if (noteLabel) noteLabel.textContent = 'Keterangan Error :';
        if (noteValue) noteValue.textContent = cctv.error_description;
    } else {
        if (noteLabel) noteLabel.textContent = 'Keterangan Maintenance :';
        if (noteValue) noteValue.textContent = cctv.last_maintenance_note || '-';
    }
    if (byId('infoMaintainer')) {
        byId('infoMaintainer').textContent = cctv.is_error
            ? (cctv.last_error_officer_name || '-')
            : (cctv.last_maintenance_officer_name || '-');
    }

    if (cctv.is_error && cctv.error_description) {
        byId('errorDescWrap')?.classList.remove('hidden');
        if (byId('infoErrorDesc')) byId('infoErrorDesc').textContent = cctv.error_description;
    } else {
        byId('errorDescWrap')?.classList.add('hidden');
        if (byId('infoErrorDesc')) byId('infoErrorDesc').textContent = '';
    }

    byId('errorFormWrap')?.classList.add('hidden');
    byId('errorDescription') && (byId('errorDescription').value = '');
const ackWrap = byId('ackWrap');
if (ackWrap) {
    const isAcknowledged = !!cctv.error_acknowledged_at;
    if (cctv.is_error && !isAcknowledged) {
        ackWrap.classList.remove('hidden');
    } else {
        ackWrap.classList.add('hidden');
    }
}

    byId('emptyInfoState')?.classList.add('hidden');
    byId('cctvInfoPanel')?.classList.remove('hidden');
    byId('btnCloseInfo')?.classList.remove('hidden');
    const wrapper = byId('infoPanelWrapper');
    wrapper.classList.add('panel-open');
    setTimeout(() => leafletMap?.invalidateSize(), 370);
}

function resetInfoPanel() {
    const wrapper = byId('infoPanelWrapper');
    wrapper.classList.remove('panel-open');
    setTimeout(() => {
        byId('emptyInfoState')?.classList.remove('hidden');
        byId('cctvInfoPanel')?.classList.add('hidden');
        byId('btnCloseInfo')?.classList.add('hidden');
        if (byId('maintenancePhotoName')) byId('maintenancePhotoName').textContent = '';
        if (byId('selectedCctvId')) byId('selectedCctvId').value = '';
        if (byId('errorDescription')) byId('errorDescription').value = '';
        if (byId('maintenanceNote')) byId('maintenanceNote').value = '';
        if (byId('technicianName')) byId('technicianName').value = '';
        byId('errorFormWrap')?.classList.add('hidden');
        highlightMarker(null);
        leafletMap?.invalidateSize();
    }, 370);

    selectedCctv = null;
    selectedLeafletMarker = null;
}

        async function switchFloor(floorId) {
            localStorage.setItem('activeFloorId', floorId); 
            const floor = floors.find(f => Number(f.id) === Number(floorId));
            if (!floor) return;

            currentFloor = floor;
            setActiveTab(floorId);

            byId('floorTitle').textContent = `{{ $building->name }} - Lantai ${floor.floor_number}` + (floor.floor_name ? ` (${floor.floor_name})` : '');

            if (!floor.plan_url) {
                alert(`Lantai ${floor.floor_number} belum memiliki denah.`);
                return;
            }

            const img = new Image();
            img.onload = () => {
                floorImageSize = { w: img.naturalWidth, h: img.naturalHeight };

                if (!leafletMap) {
                    initLeafletMap();
                }

                if (floorImageOverlay) {
                    leafletMap.removeLayer(floorImageOverlay);
                    floorImageOverlay = null;
                }

                const imageBounds = L.latLngBounds([[0, 0], [floorImageSize.h, floorImageSize.w]]);

                floorImageOverlay = L.imageOverlay(floor.plan_url, imageBounds).addTo(leafletMap);

                leafletMap.fitBounds(imageBounds, {
                    padding: [0, 0],
                    animate: false
                });

                leafletMap.setView(
                    [floorImageSize.h / 2, floorImageSize.w / 2],
                    leafletMap.getBoundsZoom(imageBounds, true)
                );

                leafletMap.invalidateSize(true);
                leafletMap.invalidateSize(true);
                leafletMap.setMaxBounds(imageBounds);
                const fitZoom = leafletMap.getBoundsZoom(imageBounds, true);
                leafletMap.setMinZoom(fitZoom);     



                setTimeout(() => {
                    leafletMap.invalidateSize();
                }, 200);

                renderCctvMarkers();
            };
            img.src = floor.plan_url;
        }

        let _pendingCoord = null;
    let _pendingSelectCctvId = _selectCctvId ? Number(_selectCctvId) : null;
    function initLeafletMap() {
        leafletMap = L.map('maintenanceMap', {
            crs: L.CRS.Simple,
            minZoom: -1,
            maxZoom: 2,
            zoomSnap: 0.25,
            zoomDelta: 0.25,
        });

        leafletMap.getContainer().addEventListener('contextmenu', (e) => e.preventDefault());

    leafletMap.on('contextmenu', (e) => {
        @if(auth()->user()->hasRole('manajer', 'superadmin'))
            if (!currentFloor) return;
            _pendingCoord = latLngToNorm(e.latlng);
            openAddModal();
        @endif
    });
    }

function openAddModal() {
    const modal = byId('modalAddCctv');
    const panel = byId('modalPanel');
    modal.classList.remove('hidden');
    requestAnimationFrame(() => {
        panel.classList.remove('scale-95', 'opacity-0');
        panel.classList.add('scale-100', 'opacity-100');
    });
    byId('modalCctvName').focus();
    updateModalPreview();
}

function closeAddModal() {
    const modal = byId('modalAddCctv');
    const panel = byId('modalPanel');
    panel.classList.remove('scale-100', 'opacity-100');
    panel.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        byId('modalCctvName').value = '';
        byId('modalCctvIp').value   = '';
        byId('modalCctvType').value = 'dome';
        _pendingCoord = null;
    }, 200);
}

function updateModalPreview() {
    const type   = byId('modalCctvType').value;
    const imgSrc = CCTV_IMAGES[type] ?? CCTV_IMAGES.dome;
    byId('modalIconPreview').innerHTML = `
        <img src="${imgSrc}" style="width:100px;height:100px;object-fit:contain;">
    `;
}

async function submitAddModal() {
    const name = byId('modalCctvName').value.trim();
    if (!name) {
        byId('modalCctvName').focus();
        byId('modalCctvName').classList.add('ring-2', 'ring-red-500');
        return;
    }
    byId('modalCctvName').classList.remove('ring-2', 'ring-red-500');

    const ip   = byId('modalCctvIp').value.trim();
    const type = byId('modalCctvType').value;

    try {
        const resp = await apiFetch(
            routeTemplate(window.__ROUTES__.storeCctvForFloor, currentFloor.id), {
            method: 'POST',
            body: JSON.stringify({
                name,
                ip_address: ip || null,
                cctv_type: type,
                x_norm: _pendingCoord.x_norm,
                y_norm: _pendingCoord.y_norm,
            }),
        });

        currentFloor.cctvs = currentFloor.cctvs || [];
        currentFloor.cctvs.push(resp.cctv);
        addCctvMarkerToMap(resp.cctv);
        renderFloorTabs();
        showToast('CCTV berhasil ditambahkan');
        closeAddModal();
    } catch (err) {
        showToast(err.message, 'error');
    }
}
let _pendingDelete = null;

function openDeleteModal(cctv, marker) {
    _pendingDelete = { cctv, marker };
    byId('deleteCctvName').textContent = cctv.name;

    const modal = byId('modalDeleteCctv');
    const panel = byId('modalDeletePanel');
    modal.classList.remove('hidden');
    requestAnimationFrame(() => {
        panel.classList.remove('scale-95', 'opacity-0');
        panel.classList.add('scale-100', 'opacity-100');
    });
}

function closeDeleteModal() {
    const modal = byId('modalDeleteCctv');
    const panel = byId('modalDeletePanel');
    panel.classList.remove('scale-100', 'opacity-100');
    panel.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        _pendingDelete = null;
    }, 200);
}

async function submitDeleteModal() {
    if (!_pendingDelete) return;
    const { cctv, marker } = _pendingDelete;

    try {
        await apiFetch(routeTemplate(window.__ROUTES__.deleteCctv, cctv.id), {
            method: 'DELETE',
        });

        currentFloor.cctvs = (currentFloor.cctvs || []).filter(x => x.id !== cctv.id);
        leafletMap.removeLayer(marker);
        cctvMarkers.delete(cctv.id);
        showToast('CCTV berhasil dihapus', 'warning');
        renderFloorTabs();

        if (selectedCctv && selectedCctv.id === cctv.id) {
            selectedCctv = null;
            selectedLeafletMarker = null;
            resetInfoPanel();
        }

        closeDeleteModal();
    } catch (err) {
        showToast(err.message, 'error');
        closeDeleteModal();
    }
}
        function replaceCctvInCurrentFloor(updatedCctv) {
            if (!currentFloor?.cctvs) return;
            currentFloor.cctvs = currentFloor.cctvs.map(c => c.id === updatedCctv.id ? updatedCctv : c);
        }

        function refreshSingleMarker(updatedCctv) {
            const marker = cctvMarkers.get(updatedCctv.id);
            if (!marker) return;

            marker.setLatLng(cctvToLatLng(updatedCctv));
            marker.setIcon(makeCctvIcon(updatedCctv));
        }

        function setFieldError(elementId, message) {
    const el = byId(elementId);
    if (!el) return;

    if (elementId === 'errorDescription') {
        const spanErr = byId('errorDescriptionError');
        if (spanErr) spanErr.textContent = '— ' + message;
        el.classList.add('border-red-500');
        return;
    }

    let errEl = el.parentElement.querySelector('.field-error');
    if (!errEl) {
        errEl = document.createElement('p');
        errEl.className = 'field-error text-xs text-red-500 mt-1';
        el.parentElement.appendChild(errEl);
    }
    errEl.textContent = message;
    el.classList.add('border-red-500');
}

function clearFieldError(elementId) {
    const el = byId(elementId);
    if (!el) return;

    if (elementId === 'errorDescription') {
        const spanErr = byId('errorDescriptionError');
        if (spanErr) spanErr.textContent = '';
        el.classList.remove('border-red-500');
        return;
    }

    const errEl = el.parentElement.querySelector('.field-error');
    if (errEl) errEl.textContent = '';
    el.classList.remove('border-red-500');
}

    async function markMaintenance() {
    if (!selectedCctv) return;
    const btn = byId('btnMarkMaintenance');
    if (!window.lockSubmit(btn, 'Menyimpan...')) return;

    let valid = true;
    clearFieldError('technicianName');
    const technicianName = byId('technicianName').value.trim();
    if (!technicianName) { setFieldError('technicianName', 'Nama petugas wajib diisi.'); valid = false; }
    const photoFile = byId('maintenancePhoto')?.files[0];
    if (!photoFile) {
        const uploadLabel = byId('maintenancePhoto')?.closest('label') || byId('maintenancePhoto')?.parentElement;
        let errEl = uploadLabel?.parentElement.querySelector('.field-error-photo');
        if (!errEl) { errEl = document.createElement('p'); errEl.className = 'field-error-photo text-xs text-red-500 mt-1'; uploadLabel?.parentElement.appendChild(errEl); }
        errEl.textContent = 'Foto dokumentasi wajib diisi.';
        valid = false;
    }
    if (!valid) { window.unlockSubmit(btn); return; }

    try {
        const formData = new FormData();
        formData.append('technician_name', technicianName);
        if (byId('maintenanceNote').value) formData.append('note', byId('maintenanceNote').value);
        formData.append('photo', photoFile);
        const resp = await apiFetch(routeTemplate(window.__ROUTES__.markMaintenance, selectedCctv.id), { method: 'POST', body: formData });
        byId('maintenancePhoto').value = '';
        byId('maintenancePhotoPreview').classList.add('hidden');
        selectedCctv = resp.cctv;
        replaceCctvInCurrentFloor(resp.cctv);
        refreshSingleMarker(resp.cctv);
        showCctvInfo(resp.cctv);
        showToast('Maintenance berhasil disimpan.', 'success');
        renderFloorTabs();
        byId('maintenanceNote').value = '';
        byId('errorDescription').value = '';
        byId('errorFormWrap')?.classList.add('hidden');
        byId('technicianName').value = '';
        clearFieldError('technicianName');
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        window.unlockSubmit(btn);
    }
}

async function markError() {
    if (!selectedCctv) return;
    const btn = byId('btnMarkError');
    if (!window.lockSubmit(btn, 'Melaporkan...')) return;

    let valid = true;
    clearFieldError('technicianName');
    clearFieldError('errorDescription');
    const technicianName = byId('technicianName').value.trim();
    if (!technicianName) { setFieldError('technicianName', 'Nama petugas wajib diisi.'); valid = false; }
    const description = byId('errorDescription').value.trim();
    if (!description) { setFieldError('errorDescription', 'Keterangan error wajib diisi.'); valid = false; }
    const photoFile = byId('errorPhoto')?.files[0];
    if (!photoFile) {
        const uploadLabel = byId('errorPhoto')?.closest('label') || byId('errorPhoto')?.parentElement;
        let errEl = uploadLabel?.parentElement.querySelector('.field-error-photo-error');
        if (!errEl) { errEl = document.createElement('p'); errEl.className = 'field-error-photo-error text-xs text-red-500 mt-1'; uploadLabel?.parentElement.appendChild(errEl); }
        errEl.textContent = 'Foto error wajib diisi.';
        valid = false;
    }
    if (!valid) { window.unlockSubmit(btn); return; }

    try {
        const formData = new FormData();
        formData.append('technician_name', technicianName);
        formData.append('description', description);
        formData.append('photo', photoFile);
        const resp = await apiFetch(routeTemplate(window.__ROUTES__.markError, selectedCctv.id), { method: 'POST', body: formData });
        byId('maintenancePhoto').value = '';
        byId('maintenancePhotoPreview')?.classList.add('hidden');
        byId('errorPhoto').value = '';
        byId('errorPhotoPreview')?.classList.add('hidden');
        selectedCctv = resp.cctv;
        replaceCctvInCurrentFloor(resp.cctv);
        refreshSingleMarker(resp.cctv);
        showCctvInfo(resp.cctv);
        renderFloorTabs();
        showToast('Error CCTV berhasil dilaporkan.', 'error');
        byId('maintenanceNote').value = '';
        byId('errorDescription').value = '';
        byId('errorFormWrap')?.classList.add('hidden');
        clearFieldError('errorDescription');
        byId('technicianName').value = '';
        clearFieldError('technicianName');
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        window.unlockSubmit(btn);
    }
}
        document.addEventListener('DOMContentLoaded', () => {
            renderFloorTabs();
            
            window.addEventListener('cctv:acknowledged', (e) => {
                const ackedId = Number(e.detail.id);
                if (selectedCctv && Number(selectedCctv.id) === ackedId) {
                    byId('ackWrap')?.classList.add('hidden');
                    selectedCctv = { ...selectedCctv, error_acknowledged_at: new Date().toISOString() };
                    replaceCctvInCurrentFloor(selectedCctv);
                }
            });
            (function initMaintenancePoll() {
                function poll() {
                    fetch('/api/cctv-stream', {
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(r => r.json())
                    .then(() => renderFloorTabs())
                    .catch(() => {})
                    .finally(() => setTimeout(poll, 10000));
                }
                poll();
            })();

           const savedFloor = localStorage.getItem('activeFloorId');
            if (_selectCctvId) {
                
                const targetFloor = floors.find(f =>
                    f.cctvs?.some(c => Number(c.id) === Number(_selectCctvId))
                );
                switchFloor(targetFloor?.id ?? floors[0]?.id);
            } else if (savedFloor && floors.find(f => Number(f.id) === Number(savedFloor))) {
                switchFloor(savedFloor);
            } else if (floors.length > 0) {
                switchFloor(floors[0].id);
            }
            
            byId('btnMarkMaintenance')?.addEventListener('click', markMaintenance);
            byId('btnCloseInfo')?.addEventListener('click', resetInfoPanel);
            byId('btnAcknowledge')?.addEventListener('click', async () => {
                if (!selectedCctv) return;
                const btn = byId('btnAcknowledge');
                if (!window.lockSubmit(btn, 'Menyimpan...')) return;
                try {
                    const r = await fetch(`/api/cctvs/${selectedCctv.id}/acknowledge-error`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    });
                        if (!r.ok) throw new Error('Gagal acknowledge');
                        byId('ackWrap')?.classList.add('hidden');
                        selectedCctv = { ...selectedCctv, error_acknowledged_at: new Date().toISOString() };
                        replaceCctvInCurrentFloor(selectedCctv);
                        window._ackError?.(selectedCctv.id);
                        showToast('Error sudah di-acknowledge.', 'success');
                } catch (err) {
                showToast('Gagal acknowledge: ' + err.message, 'error');
                } finally {
                    window.unlockSubmit(btn);
                }
            });
            byId('btnModalClose')?.addEventListener('click', closeAddModal);
            byId('btnModalCancel')?.addEventListener('click', closeAddModal);
            byId('btnModalSubmit')?.addEventListener('click', submitAddModal);
            byId('modalBackdrop')?.addEventListener('click', closeAddModal);
            byId('modalCctvType')?.addEventListener('change', updateModalPreview);


            byId('modalCctvName')?.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') submitAddModal();
            });
            byId('modalCctvIp')?.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') submitAddModal();
            });
            byId('btnDeleteCancel')?.addEventListener('click', closeDeleteModal);
            byId('btnDeleteConfirm')?.addEventListener('click', submitDeleteModal);
            byId('modalDeleteBackdrop')?.addEventListener('click', closeDeleteModal);
            byId('btnMarkError')?.addEventListener('click', markError);
            byId('btnToggleErrorForm')?.addEventListener('click', () => {

                const isHidden = byId('errorFormWrap').classList.contains('hidden');
                
                if (isHidden) {
                    byId('errorFormWrap').classList.remove('hidden');
                    byId('maintenancePhoto').value = '';
                    byId('maintenancePhotoImg').src = '';
                    byId('maintenancePhotoPreview').classList.add('hidden');
                    const errFoto = byId('maintenancePhoto')?.closest('label')?.parentElement?.querySelector('.field-error-photo');
                    if (errFoto) errFoto.textContent = '';
                } else {
                    byId('errorFormWrap').classList.add('hidden');
                    byId('errorPhoto').value = '';
                    byId('errorPhotoImg').src = '';
                    byId('errorPhotoPreview').classList.add('hidden');
                }
            });

            byId('technicianName')?.addEventListener('input', () => {
                hasUnsavedMaintenance = true;
            });

            byId('maintenanceNote')?.addEventListener('input', () => {
                hasUnsavedMaintenance = true;
            });

            document.addEventListener('keydown', function(e) {
                const addModalOpen  = !byId('modalAddCctv').classList.contains('hidden');
                const delModalOpen  = !byId('modalDeleteCctv').classList.contains('hidden');

                if (addModalOpen) {
                    if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        byId('btnModalSubmit')?.focus();
                    } else if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        byId('btnModalCancel')?.focus();
                    }
                    return;
                }

                if (delModalOpen) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        submitDeleteModal();
                    } else if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        byId('btnDeleteConfirm')?.focus();
                    } else if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        byId('btnDeleteCancel')?.focus();
                    }
                    return;
                }
                if (!selectedCctv) return;

                if (!byId('errorFormWrap').classList.contains('hidden')) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        markError();
                    }
                } else {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        markMaintenance();
                    }
                }
            });

            byId('maintenancePhoto')?.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;
                byId('maintenancePhotoImg').src = URL.createObjectURL(file);
                byId('maintenancePhotoPreview').classList.remove('hidden');
                 const errFoto = byId('maintenancePhoto')?.closest('label')?.parentElement?.querySelector('.field-error-photo');
                if (errFoto) errFoto.textContent = '';
            });
            byId('btnRemoveMaintenancePhoto')?.addEventListener('click', () => {
                byId('maintenancePhoto').value = '';
                byId('maintenancePhotoImg').src = '';
                byId('maintenancePhotoPreview').classList.add('hidden');
            });

            byId('errorPhoto')?.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;
                byId('errorPhotoImg').src = URL.createObjectURL(file);
                byId('errorPhotoPreview').classList.remove('hidden');
                const errFoto = byId('errorPhoto')?.closest('label')?.parentElement?.querySelector('.field-error-photo-error');
                if (errFoto) errFoto.textContent = '';
            });
            byId('btnRemoveErrorPhoto')?.addEventListener('click', () => {
                byId('errorPhoto').value = '';
                byId('errorPhotoImg').src = '';
                byId('errorPhotoPreview').classList.add('hidden');
            });

            byId('technicianName')?.addEventListener('input', () => {
                clearFieldError('technicianName');
            });

            byId('errorDescription')?.addEventListener('input', () => {
                clearFieldError('errorDescription');
            });

            byId('maintenancePhoto')?.addEventListener('change', (e) => {
                const errFoto = byId('maintenancePhoto')?.closest('label')?.parentElement?.querySelector('.field-error-photo');
                if (errFoto) errFoto.textContent = '';
            });

            byId('errorPhoto')?.addEventListener('change', (e) => {
                const errFoto = byId('errorPhoto')?.closest('label')?.parentElement?.querySelector('.field-error-photo-error');
                if (errFoto) errFoto.textContent = '';
            });

            setInterval(() => {
                if (!currentFloor) return;

                cctvMarkers.forEach((marker, id) => {
                    const cctv = currentFloor.cctvs.find(x => x.id === id);
                    if (!cctv) return;
                    const isSelected = selectedCctv && Number(selectedCctv.id) === Number(id);
                    marker.setIcon(makeCctvIcon(cctv, isSelected));
                });

                if (selectedCctv) {
                    const fresh = currentFloor.cctvs.find(x => x.id === selectedCctv.id);
                    if (fresh) {
                        const statusEl = byId('infoStatusText');
                        if (statusEl) {
                            const status = computeVisualStatus(fresh);
                            statusEl.textContent = visualStatusLabel({ visual_status: status });
                           const c = window.__STATUS_COLORS__;
                            const colorMap = { error: c.error, overdue: c.overdue, due: c.due, normal: '#22c55e' };
                            statusEl.textContent = visualStatusLabel({ visual_status: status });
                            statusEl.className   = 'font-semibold';
                            statusEl.style.color = colorMap[status] ?? '#22c55e';
                        const noteLabel = byId('infoMaintenanceNoteLabel');
                    if (noteLabel && !fresh.is_error) {
                        noteLabel.textContent = 'Keterangan Maintenance :';
                    }
                    }
                }
                }
            

                renderFloorTabs();
                setActiveTab(currentFloor.id);
            }, 5000);
        });

        function showToast(message, type = 'success') {
    const container = byId('toastContainer');
    const toast = document.createElement('div');
    toast.className =
        'px-4 py-3 rounded-lg shadow-lg text-sm font-semibold text-white transition-all duration-300 ' +
        (type === 'error'   ? 'bg-red-600' :
         type === 'warning' ? 'bg-amber-500 text-black' :
                              'bg-green-600');
    toast.textContent = message;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-10px)';
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}
        function formatDateTime(dateString) {
            if (!dateString) return '-';

            const date = new Date(dateString);

            return date.toLocaleString('id-ID', {
                timeZone: 'Asia/Jakarta',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    </script>

<div id="mobileBackdrop"></div>

<script>

(function() {
    const backdrop = document.getElementById('mobileBackdrop');
    const wrapper  = document.getElementById('infoPanelWrapper');
    if (!backdrop || !wrapper) return;

    const observer = new MutationObserver(() => {
        const isMobile = window.innerWidth < 768;
        const isOpen   = wrapper.classList.contains('panel-open');
        backdrop.classList.toggle('active', isMobile && isOpen);
    });
    observer.observe(wrapper, { attributes: true, attributeFilter: ['class'] });

    backdrop.addEventListener('click', () => {
        if (typeof resetInfoPanel === 'function') resetInfoPanel();
    });
})();
</script>
</x-app-layout>