<x-app-layout>
{{-- DASHBOARD UTAMA --}}
<div class="flex flex-col overflow-hidden" style="height:calc(100vh - 4.1rem - var(--notif-bar-h, 0px)); transition: height 0.5s ease;">

    <div class="flex-shrink-0 px-4 sm:px-6 pt-3 pb-2 mb-1">
        <div class="max-w-auto mx-auto grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Total Gedung --}}
            <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/60 dark:bg-gray-800/60 backdrop-blur px-4 py-4 shadow-sm">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-500/15 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xs text-gray-500 dark:text-gray-400 leading-none mb-1">Total Gedung</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white leading-none">{{ $totalBuildings }}</div>
                </div>
            </div>

            {{-- Total CCTV --}}
            <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/60 dark:bg-gray-800/60 backdrop-blur px-4 py-4 shadow-sm">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-cyan-500/15 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xs text-gray-500 dark:text-gray-400 leading-none mb-1">Total CCTV</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white leading-none">{{ $totalCctvGabungan }}</div>
                    <div class="flex gap-2 text-[11px] text-gray-400 mt-1">
                        <span class="flex items-center gap-1">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/></svg>
                            Indoor: {{ $totalCctvAll }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            Outdoor: {{ $totalOutdoorAll }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- CCTV Error --}}
            <div class="flex items-center gap-3 rounded-2xl border border-red-500/20 bg-red-500/5 dark:bg-red-500/10 backdrop-blur px-4 py-4 shadow-sm">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-red-500/15 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#ef4444">
                        <path d="M12 2L1 21h22L12 2z"/><rect x="11" y="8" width="2" height="6" fill="white"/><rect x="11" y="16" width="2" height="2" fill="white"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xs text-gray-500 dark:text-gray-400 leading-none mb-1">CCTV Error</div>
                    <div id="statTotalError" class="text-2xl font-bold leading-none {{ $totalErrorGabungan > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">{{ $totalErrorGabungan }}</div>
                    <div class="flex gap-2 text-[11px] text-gray-400 mt-1">
                        <span class="flex items-center gap-1">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/></svg>
                            <span id="statIndoorError">Indoor: {{ $totalErrorAll }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            <span id="statOutdoorError">Outdoor: {{ $totalOutdoorError }}</span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Perlu Maintenance --}}
            <div class="flex items-center gap-3 rounded-2xl border border-amber-500/20 bg-amber-500/5 dark:bg-amber-500/10 backdrop-blur px-4 py-4 shadow-sm">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-amber-500/15 flex items-center justify-center">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xs text-gray-500 dark:text-gray-400 leading-none mb-1">Perlu Maintenance</div>
                    <div id="statTotalMaintenance" class="text-2xl font-bold leading-none {{ $totalUnmaintainedGabungan > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-900 dark:text-white' }}">{{ $totalUnmaintainedGabungan }}</div>
                    <div class="flex gap-2 text-[11px] text-gray-400 mt-1">
                        <span class="flex items-center gap-1">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/></svg>
                            <span id="statIndoorMaintenance">Indoor: {{ $totalUnmaintainedAll }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            <span id="statOutdoorMaintenance">Outdoor: {{ $totalUnmaintainedGabungan - $totalUnmaintainedAll }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="flex-1 min-h-0 px-4 sm:px-6 pb-3">
        <div class="max-w-[1700px] mx-auto h-full flex gap-3">

            {{-- MAP SECTION --}}
            <div class="flex-1 min-w-0 flex flex-col min-h-0 gap-2">
                @if(session('success'))
                    <div class="flex-shrink-0 rounded-lg border border-green-500/30 bg-green-500/10 text-green-200 px-3 py-1.5 text-sm">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="flex-shrink-0 rounded-lg border border-red-500/30 bg-red-500/10 text-red-200 px-3 py-1.5 text-sm">
                        @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                    </div>
                @endif
                <div id="mapShell" class="flex flex-1 min-h-0 gap-3">

            {{-- Map card--}}
            <div class="flex-1 min-w-0 overflow-hidden bg-gray-800/10 dark:bg-transparent backdrop-blur-md rounded-2xl shadow-xl border border-white/10 p-2.5 flex flex-col min-h-0">
                {{-- Toolbar --}}
                <div class="flex-shrink-0 flex items-center justify-between gap-2 flex-wrap mb-3">
                    <div class="flex items-center gap-3 min-w-0 flex-1 ml-2">
                        <span class="text-xl font-semibold text-gray-900 dark:text-gray-100 hidden sm:block whitespace-nowrap">
                            Lingkungan Bandara Dhoho
                        </span>

                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <div id="buildingControls" class="flex items-center gap-1.5">
                            @if(auth()->user()->hasRole('manajer', 'superadmin'))
                                <button id="btnAddBuilding" type="button"
                                    class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-medium flex items-center gap-1">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    <span class="hidden sm:inline">Tambah</span> Gedung
                                </button>
                                <button id="btnEditBuilding" type="button"
                                    class="px-3 py-1.5 rounded-lg bg-amber-600 hover:bg-amber-500 text-white text-xs font-medium flex items-center gap-1">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Ubah
                                </button>
                            @endif
                            <button id="btnCancelMode" type="button"
                                class="px-3 py-1.5 rounded-lg bg-gray-600 hover:bg-gray-500 text-white text-xs font-medium hidden">
                                Batal
                            </button>
                        </div>
                        <div class="flex items-center bg-gray-200 dark:bg-gray-700 rounded-lg p-0.5">
                            <button id="tabBtnBuildings" onclick="switchTab('buildings')"
                                class="tab-btn px-3 py-1.5 rounded-md text-xs font-medium transition inline-flex items-center gap-1.5 whitespace-nowrap">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/>
                                </svg>
                                Gedung
                            </button>
                            <button id="tabBtnOutdoor" onclick="switchTab('outdoor')"
                                class="tab-btn px-3 py-1.5 rounded-md text-xs font-medium transition inline-flex items-center gap-1.5 whitespace-nowrap">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>
                                </svg>
                                <span class="hidden sm:inline">CCTV</span> Outdoor
                            </button>
                        </div>
                    </div>
                </div>

                <div id="map" class="w-full rounded-xl border border-white/10 bg-gray-900 flex-1 min-h-0"></div>

                <div id="outdoorLegend" class="hidden mt-2 flex-shrink-0">
                    <div class="flex flex-wrap gap-3 text-xs text-gray-600 dark:text-gray-300">
                        <span class="flex items-center gap-1">
                            <span class="w-2.5 h-2.5 rounded-full inline-block"
                                style="background:{{ \App\Models\Setting::colorDue() }}"></span>
                            Perlu Maintenance (&gt;{{ \App\Models\Setting::dueHours() >= 24 ? (\App\Models\Setting::dueHours() / 24).' hari' : \App\Models\Setting::dueHours().' jam' }})
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2.5 h-2.5 rounded-full inline-block"
                                style="background:{{ \App\Models\Setting::colorOverdue() }}"></span>
                            Overdue (&gt;{{ \App\Models\Setting::overdueHours() >= 24 ? (\App\Models\Setting::overdueHours() / 24).' hari' : \App\Models\Setting::overdueHours().' jam' }})
                        </span>
                        <span class="flex items-center gap-1" style="font-size:13px;font-weight:900;color:#ef4444;text-shadow:0 0 4px rgba(239,68,68,0.8);">!</span>
                        <span class="text-gray-500 dark:text-gray-400">Error</span>
                    </div>
                    @if(auth()->user()->hasRole('manajer', 'superadmin'))
                    <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                        Klik kanan pada map untuk tambah CCTV. Klik kanan pada CCTV untuk hapus.
                    </div>
                    @endif
                </div>
            </div>

            {{--Panel kanan--}}
            <div class="flex-shrink-0 relative" style="width:340px;">

                {{-- LAYER 1: Daftar Gedung  --}}
                <div id="buildingListPanel"
                    class="absolute inset-0 bg-gray-800/10 backdrop-blur-md rounded-2xl shadow-xl border border-white/10
                        flex flex-col overflow-auto transition-all duration-300">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-white/10 flex-shrink-0">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Daftar Gedung</h3>
                        <span class="text-xs text-gray-400">Perlu Penanganan</span>
                    </div>
                    <div id="buildingListContent" class="flex-1 overflow-y-auto px-3 py-2 space-y-1.5">
                    </div>
                </div>

                {{-- LAYER 2: Daftar CCTV Outdoor --}}
                <div id="outdoorListPanel"
                    class="absolute inset-0 bg-gray-800/50 backdrop-blur-md rounded-2xl shadow-xl border border-white/10
                        flex flex-col overflow-auto transition-all duration-300 opacity-0 pointer-events-none">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-white/10 flex-shrink-0">
                        <h3 class="text-sm font-semibold text-white">CCTV Outdoor</h3>
                        <span class="text-xs text-gray-400">Perlu Penanganan</span>
                    </div>
                    <div id="outdoorListContent" class="flex-1 overflow-y-auto px-3 py-2 space-y-1.5">
                    </div>
                </div>

                {{-- LAYER 3: Form gedung --}}
                <div id="sidebarPanel"
                    class="absolute inset-0 bg-gray-800/50 backdrop-blur-md rounded-2xl shadow-xl border border-white/10
                        overflow-y-auto transition-all duration-300 opacity-0 pointer-events-none translate-x-4">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 id="sidebarTitle" class="text-sm font-semibold text-white">Form Gedung</h3>
                            <span id="sidebarBadge" class="text-xs px-2 py-0.5 rounded bg-gray-700 text-gray-200">Belum aktif</span>
                        </div>
                        <p id="sidebarHint" class="text-xs text-gray-300 mb-3">Klik <b>Tambah Gedung</b> untuk membuat marker.</p>
                        <form id="buildingForm" method="POST" action="{{ route('buildings.store') }}" enctype="multipart/form-data"
                            class="space-y-3 hidden"
                            data-store-url="{{ route('buildings.store') }}"
                            data-update-url-template="{{ url('/monitoring') }}/__ID__">
                            @csrf
                            <input type="hidden" name="_method" id="formMethod" value="POST">
                            <input type="hidden" name="marker_lat" id="marker_lat">
                            <input type="hidden" name="marker_lng" id="marker_lng">
                            <input type="hidden" name="half_lat_delta" id="half_lat_delta">
                            <input type="hidden" name="half_lng_delta" id="half_lng_delta">
                            <input type="hidden" name="rotation_deg" id="rotation_deg" value="0">
                            <input type="hidden" name="north" id="north">
                            <input type="hidden" name="south" id="south">
                            <input type="hidden" name="east" id="east">
                            <input type="hidden" name="west" id="west">
                            <div>
                                <label class="block text-xs font-medium text-gray-200 mb-1">Nama Gedung</label>
                                <input type="text" name="name" id="building_name" required class="w-full rounded-lg border border-white/10 bg-gray-900 text-white px-3 py-1.5 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-200 mb-1">Keterangan</label>
                                <textarea name="description" id="building_description" rows="2" class="w-full rounded-lg border border-white/10 bg-gray-900 text-white px-3 py-1.5 text-sm resize-none"></textarea>
                            </div>
                            <div class="border border-white/10 rounded-xl p-3 bg-gray-900/40 space-y-2">
                                <h4 class="text-xs font-semibold text-gray-100">Bentuk Marker</h4>
                                <div>
                                    <label class="block text-xs text-gray-300 mb-1">Lebar <span id="widthValue" class="text-gray-400"></span></label>
                                    <input type="range" id="widthRange" min="0.00005" max="0.00200" step="0.00001" value="0.00030" class="w-full">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-300 mb-1">Tinggi <span id="heightValue" class="text-gray-400"></span></label>
                                    <input type="range" id="heightRange" min="0.00005" max="0.00200" step="0.00001" value="0.00030" class="w-full">
                                </div>
                            </div>
                            <div class="border border-white/10 rounded-xl p-3 bg-gray-900/40">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-xs font-semibold text-gray-100">Denah Lantai</h4>
                                    <button type="button" id="btnAddFloor" class="px-2 py-1 rounded-md bg-emerald-600 hover:bg-emerald-500 text-white text-xs">+ Lantai</button>
                                </div>
                                <div id="floorsContainer" class="space-y-2"></div>
                                <p class="text-[11px] text-gray-400 mt-1">JPG/PNG/WEBP/PDF (max 10MB)</p>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium">Simpan</button>
                                <button type="button" id="btnResetForm" class="px-3 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white text-sm">Reset</button>
                                <button type="button" id="btnDeleteBuilding" class="px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white text-sm hidden">Hapus</button>
                            </div>
                        </form>
                        <div id="coordsPreview" class="mt-3 text-[11px] text-gray-400 space-y-0.5"><div>Pusat: -</div><div>Bounds: -</div></div>
                    </div>
                </div>

                {{-- LAYER 4: Info CCTV outdoor --}}
                <div id="outdoorInfoPanel"
                    class="absolute inset-0 rounded-2xl border border-gray-200 dark:border-white/10
                        bg-white/95 dark:bg-gray-800/95 shadow-2xl backdrop-blur-md
                        overflow-y-auto overflow-x-hidden
                        transition-all duration-300 opacity-0 pointer-events-none translate-x-4">
                    <div class="p-3">
                        <div class="flex items-center justify-between mb-3">
                            <button id="btnBackToOutdoorList"
                                class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                                </svg>
                                Kembali
                            </button>
                            <button id="btnCloseOutdoorInfo" class="hidden text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-lg leading-none">✕</button>
                        </div>
                        <div id="outdoorEmptyState" class="text-sm text-gray-600 dark:text-gray-300">Klik marker CCTV untuk melihat detail.</div>
                        <div id="outdoorCctvDetail" class="hidden space-y-3">
                            <div class="rounded-lg border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-gray-900/40 p-3 text-sm dark:text-white space-y-1.5">
                                <div><b>Nama :</b> <span id="oInfoName">-</span></div>
                                <div><b>IP :</b> <span id="oInfoIp">-</span></div>
                                <div><b>Status :</b> <span id="oInfoStatus"></span></div>
                                <div><b id="oInfoNoteLabel">Keterangan :</b> <span id="oInfoNote">-</span></div>
                                <div><b>Maintenance :</b> <span id="oInfoLastMaintenance">-</span></div>
                                <div><b>Petugas :</b> <span id="oInfoOfficer">-</span></div>
                                <div id="oInfoPhotoWrap" class="hidden">
                                    <b id="oInfoPhotoLabel" class="block mb-1">Foto :</b>
                                    <img id="oInfoPhoto" src="" class="max-h-20 object-cover rounded-lg border border-amber-400/50 shadow cursor-pointer">
                                </div>
                            </div>
                            {{-- Tombol acknowledge --}}
                            <div id="oAckWrap" class="hidden">
                                <button id="oBtnAcknowledge" type="button"
                                    class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg
                                        bg-blue-600/20 hover:bg-blue-600/30 border border-blue-500/30
                                        text-blue-400 dark:text-blue-300 text-xs font-semibold transition">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    Acknowledge — Sudah Diketahui
                                </button>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 text-center mt-1">
                                    Notifikasi alarm akan berhenti untuk CCTV ini
                                </p>
                            </div>
                            @if(auth()->user()->role !== 'security')
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Nama Petugas <span class="text-red-500">*</span></label>
                                <input id="oTechnicianName" type="text" class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" placeholder="Nama petugas">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Keterangan (opsional)</label>
                                <div class="relative">
                                    <textarea id="oMaintenanceNote" rows="3" class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm resize-none pr-28" placeholder="Catatan..."></textarea>
                                    <div id="oMaintenancePhotoPreview" class="hidden absolute bottom-4 right-4">
                                        <img id="oMaintenancePhotoImg" src="" class="h-16 w-16 object-cover rounded-lg border-2 border-amber-400 shadow">
                                        <button id="oBtnRemoveMaintenancePhoto" type="button" class="absolute -top-1.5 -right-1.5 w-4 h-4 rounded-full bg-red-500 text-white flex items-center justify-center shadow" style="font-size:9px">✕</button>
                                    </div>
                                </div>
                                <label class="cursor-pointer mt-1 flex items-center gap-1 px-2 py-1 rounded-lg border border-gray-300 dark:border-white/10 text-xs text-gray-500 dark:text-amber-500 w-fit">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Foto <input id="oMaintenancePhoto" type="file" accept="image/*" class="hidden">
                                </label>
                            </div>
                            @if(auth()->user()->role !== 'security')
                            <div class="flex gap-2">
                                <button id="oBtnMarkMaintenance" type="button" class="flex-1 px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black text-sm font-semibold">Tandai Maintenance</button>
                                <button id="oBtnToggleErrorForm" type="button" class="px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white font-semibold" title="Laporkan Error">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#ef4444"><path d="M12 2L1 21h22L12 2z"></path><rect x="11" y="8" width="2" height="6" fill="white"></rect><rect x="11" y="16" width="2" height="2" fill="white"></rect></svg>
                                </button>
                            </div>
                            @endif
                            <div id="oErrorFormWrap" class="hidden rounded-lg border border-red-300/40 dark:border-red-500/20 bg-red-50 dark:bg-red-500/10 p-3">
                                <label class="block text-xs text-red-700 dark:text-red-300 mb-1">Keterangan Error <span class="text-red-500">*</span><span id="oErrorDescriptionError" class="font-normal"></span></label>
                                <div class="relative">
                                    <textarea id="oErrorDescription" rows="3" class="w-full rounded-lg border border-red-300 dark:border-red-500/30 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm resize-none pr-28" placeholder="Jelaskan error..."></textarea>
                                    <div id="oErrorPhotoPreview" class="hidden absolute bottom-4 right-4">
                                        <img id="oErrorPhotoImg" src="" class="h-16 w-16 object-cover rounded-lg border border-red-300 shadow">
                                        <button id="oBtnRemoveErrorPhoto" type="button" class="absolute -top-1.5 -right-1.5 w-4 h-4 rounded-full bg-red-500 text-white flex items-center justify-center shadow" style="font-size:9px">✕</button>
                                    </div>
                                </div>
                                <label class="cursor-pointer mt-1 flex items-center gap-1 px-2 py-1 rounded-lg border border-red-300 text-xs text-red-500 w-fit">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Foto Error <input id="oErrorPhoto" type="file" accept="image/*" class="hidden">
                                </label>
                                <button id="oBtnMarkError" type="button" class="mt-2 w-full px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white text-sm font-semibold">Submit Error</button>
                            </div>
                            @else
                            <div class="rounded-lg border border-white/10 bg-gray-800/30 px-3 py-3 text-xs text-gray-400 text-center">
                                Anda hanya memiliki akses lihat. Hubungi petugas untuk maintenance.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

                </div>
            </div>

                    

        </div>
    </div>

</div>



<div id="toastContainer" class="fixed top-5 right-5 space-y-2 z-[9998]"></div>

{{-- MODAL HAPUS GEDUNG --}}
<div id="modalDeleteBuilding" class="fixed inset-0 z-[999] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteBuildingModal()"></div>
    <div id="modalDeleteBuildingPanel" class="relative z-10 w-full max-w-sm mx-4 bg-gray-900 rounded-2xl shadow-2xl border border-white/10 p-6 transition-all duration-200 scale-95 opacity-0">
        <div class="flex items-center gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
            </div>
            <div><h3 class="text-base font-semibold text-white">Hapus Gedung</h3><p class="text-sm text-gray-400 mt-0.5">Tindakan ini tidak dapat dibatalkan.</p></div>
        </div>
        <div class="flex gap-2">
            <button type="button" id="btnDeleteBuildingCancel" class="flex-1 px-4 py-2 rounded-lg border border-white/10 text-gray-300 hover:bg-white/5 text-sm font-medium">Batal</button>
            <button type="button" id="btnDeleteBuildingConfirm" class="flex-1 px-4 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white text-sm font-semibold">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH CCTV OUTDOOR --}}
<div id="modalOutdoorAddCctv" class="fixed inset-0 z-[999] hidden items-center justify-center">
    <div id="oModalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div id="oModalPanel" class="relative z-10 w-full max-w-md mx-4 rounded-2xl border border-white/10 bg-gray-900 shadow-2xl p-6 space-y-4 transition-all duration-300 scale-95 opacity-0">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white">Tambah CCTV Outdoor</h3>
            <button onclick="closeOutdoorAddModal()" class="text-gray-400 hover:text-white text-xl">✕</button>
        </div>
        <div class="space-y-3">
            <div><label class="block text-xs text-gray-400 mb-1">Nama CCTV <span class="text-red-500">*</span></label><input id="oModalCctvName" type="text" class="w-full rounded-lg border border-white/10 bg-gray-800 text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="CCTV Gerbang Utara"></div>
            <div><label class="block text-xs text-gray-400 mb-1">IP Address</label><input id="oModalCctvIp" type="text" class="w-full rounded-lg border border-white/10 bg-gray-800 text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="192.168.1.x"></div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Tipe CCTV <span class="text-red-500">*</span></label>
                <select id="oModalCctvType" class="w-full rounded-lg border border-white/10 bg-gray-800 text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="dome">Dome — Kamera bulat plafon</option>
                    <option value="bullet">Bullet — Kamera silinder outdoor</option>
                    <option value="ptz">PTZ — Pan-Tilt-Zoom</option>
                </select>
            </div>
            <div class="flex items-center gap-3 rounded-lg bg-gray-800/60 border border-white/5 px-3 py-2">
                <div id="oModalIconPreview" class="w-10 h-10 flex items-center justify-center"></div>
                <span class="text-xs text-gray-400">Preview marker pada map</span>
            </div>
        </div>
        <div class="flex gap-2">
            <button id="oBtnModalCancel" type="button" class="flex-1 px-3 py-2 rounded-lg border border-white/10 text-gray-300 hover:bg-white/5 text-sm">Batal</button>
            <button id="oBtnModalSubmit" type="button" class="flex-1 px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black text-sm font-semibold">Tambahkan</button>
        </div>
    </div>
</div>

{{-- MODAL HAPUS CCTV OUTDOOR --}}
<div id="modalOutdoorDeleteCctv" class="fixed inset-0 z-[999] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeOutdoorDeleteModal()"></div>
    <div id="oModalDeletePanel" class="relative z-10 w-full max-w-sm mx-4 rounded-2xl border border-white/10 bg-gray-900 shadow-2xl p-6 space-y-4 transition-all duration-300 scale-95 opacity-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="#ef4444"><path d="M12 2L1 21h22L12 2z"/><rect x="11" y="8" width="2" height="6" fill="white"/><rect x="11" y="16" width="2" height="2" fill="white"/></svg></div>
            <div><h3 class="text-base font-bold text-white">Hapus CCTV Outdoor</h3><p class="text-sm text-gray-400">Hapus <span id="oDeleteCctvName" class="text-white font-semibold"></span>?</p></div>
        </div>
        <div class="flex gap-2">
            <button id="oBtnDeleteCctvCancel" type="button" class="flex-1 px-3 py-2 rounded-lg border border-white/10 text-gray-300 hover:bg-white/5 text-sm">Batal</button>
            <button id="oBtnDeleteCctvConfirm" type="button" class="flex-1 px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white text-sm font-semibold">Ya, Hapus</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
#sidebarPanel,
#buildingListPanel,
#outdoorListPanel,
#outdoorInfoPanel {
}


.panel-layer-active {
    opacity: 1 !important;
    pointer-events: auto !important;
    transform: translateX(0) !important;
}
.panel-layer-hidden {
    opacity: 0 !important;
    pointer-events: none !important;
}

.leaflet-control-attribution { font-size:9px!important;opacity:0.6; }
.leaflet-div-icon { background:transparent!important;border:none!important; }
.leaflet-marker-icon,.leaflet-marker-pane { overflow:visible!important; }
.building-label-wrap {
    background:rgba(0,0,0,0.72);color:#fff;font-size:11px;
    padding:2px 7px;border-radius:4px;border:1px solid rgba(255,255,255,0.2);
    white-space:nowrap;pointer-events:none;display:inline-block;
}
@keyframes odrPulseSlow { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.45;transform:scale(1.08)} }
@keyframes odrPulseFast { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.15;transform:scale(1.15)} }
.odr-pulse-slow{animation:odrPulseSlow 1.8s infinite}
.odr-pulse-fast{animation:odrPulseFast 0.55s infinite}
.odr-pulse-red{animation:odrPulseSlow 1.8s infinite}
.leaflet-tile { border:none!important; }
.leaflet-control-container { display:none!important; }

@media (max-width: 767px) {

    .flex.flex-col.overflow-hidden[style*="height:calc"] {
        height: auto !important;
        overflow-y: auto !important;
    }
    .grid[class*="grid-cols-2"] {
        gap: 0.4rem !important;
    }
    .grid[class*="grid-cols-2"] > div {
        padding: 0.5rem 0.625rem !important;
        gap: 0.4rem !important;
        align-items: flex-start !important;
    }
    .grid[class*="grid-cols-2"] [class*="text-2xl"] {
        font-size: 1.05rem !important;
        line-height: 1.2 !important;
    }
    .grid[class*="grid-cols-2"] [class*="w-10"][class*="h-10"] {
        width: 1.75rem !important;
        height: 1.75rem !important;
        flex-shrink: 0 !important;
    }


    [class*="gap-2"][class*="mt-1"][class*="text-gray-400"] {
        flex-direction: column !important;
        gap: 1px !important;
        font-size: 9px !important;
        line-height: 1.4 !important;
        margin-top: 2px !important;
        flex-wrap: nowrap !important;
    }

    [class*="gap-2"][class*="mt-1"][class*="text-gray-400"] svg {
        display: none !important;
    }

    [class*="gap-2"][class*="mt-1"][class*="text-gray-400"] > span {
        display: flex !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        max-width: 100% !important;
    }

    .flex-1.min-h-0.px-4[class*="pb-3"] {
        height: auto !important;
        overflow: visible !important;
    }
    [class*="max-w-"][class*="h-full"][class*="flex"][class*="gap-3"] {
        height: auto !important;
    }


    #mapShell {
        flex-direction: column !important;
        height: auto !important;
        overflow: visible !important;
    }
    #mapShell > div:first-child {
        min-height: 340px !important;
        height: 340px !important;
        flex: none !important;
    }
    #map { min-height: 250px !important; }


    #mapShell > div:first-child > div:first-child > div:first-child {
        display: none !important;
    }

    #mapShell > div:first-child > div:first-child > div:last-child {
        width: 100% !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        gap: 0.3rem !important;
        flex-wrap: nowrap !important;
    }
 
    #buildingControls {
        
        gap: 0.25rem !important;
        flex-shrink: 0 !important;
    }
    #buildingControls button {
        font-size: 11px !important;
        padding: 0.25rem 0.45rem !important;
        white-space: nowrap !important;
    }
    #mapShell .flex.items-center[class*="bg-gray-"] {
        flex-shrink: 0 !important;
    }
    .tab-btn {
        font-size: 11px !important;
        padding: 0.3rem 0.45rem !important;
        gap: 0.2rem !important;
        white-space: nowrap !important;
    }

    #mapShell > div:last-child {
        width: 100% !important;
        height: 280px !important;
        position: relative !important;
        flex-shrink: 0 !important;
        margin-top: 0.4rem !important;
    }
    #buildingListPanel,
    #outdoorListPanel,
    #sidebarPanel,
    #outdoorInfoPanel {
        position: absolute !important;
        width: 100% !important;
    }

    #outdoorLegend [class*="flex"][class*="flex-wrap"] {
        gap: 0.25rem 0.6rem !important;
        font-size: 10px !important;
    }

    #errorNotifList { max-height: 56px !important; }
}

@media (max-width: 480px) {
    #mapShell > div:first-child {
        min-height: 300px !important;
        height: 300px !important;
    }
    #mapShell > div:last-child { height: 250px !important; }
    #map { min-height: 200px !important; }
}
</style>

<script>
    window.__STATUS_COLORS__ = {
    due:     '{{ \App\Models\Setting::colorDue() }}',
    overdue: '{{ \App\Models\Setting::colorOverdue() }}',
    error:   '#ef4444', // selalu merah
};
    window.__BUILDINGS__      = @json($mapBuildings ?? []);
    window.__OUTDOOR_CCTVS__  = @json($outdoorCctvs ?? []);
    window.__OUTDOOR_ROUTES__ = {
        index:           "{{ route('outdoor.cctvs.index') }}",
        store:           "{{ url('/outdoor-cctvs') }}",
        destroy:         "{{ url('/outdoor-cctvs') }}/__ID__",
        markMaintenance: "{{ url('/outdoor-cctvs') }}/__ID__/mark-maintenance",
        markError:       "{{ url('/outdoor-cctvs') }}/__ID__/mark-error",
    };
    const CCTV_IMAGES_OUTDOOR = {
        dome:   '{{ asset("images/cctv/dome.png") }}',
        bullet: '{{ asset("images/cctv/bullet.png") }}',
        ptz:    '{{ asset("images/cctv/ptz.png") }}',
    };

    const _stats = {
        totalOutdoorError:        {{ $totalOutdoorError }},
        totalOutdoorUnmaintained: {{ $totalOutdoorUnmaintained }},
        totalErrorGabungan:       {{ $totalErrorGabungan }},
        totalUnmaintainedGabungan:{{ $totalUnmaintainedGabungan }},
    };

window.__THRESHOLDS__ = {
    dueSeconds:     {{ \App\Models\Setting::dueHours() * 3600 }},
    overdueSeconds: {{ \App\Models\Setting::overdueHours() * 3600 }},
};
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-rotate@0.2.0/dist/leaflet-rotate-src.js"></script>
<script>

// STATE GLOBAL
window.map    = null;
let mode      = 'view';
let overlays  = [];
let activeDraft = null;
let floorRowIndex = 0;
let activeTab     = 'buildings';
let outdoorCctvs  = window.__OUTDOOR_CCTVS__ || [];
let outdoorMarkers = new Map();
let selectedOutdoor = null;
const canEditOutdoor = {{ auth()->user()->hasRole('manajer','superadmin') ? 'true' : 'false' }};
const $ = id => document.getElementById(id);
let _blockNextMove = false;
let _savedMapState = null;


// LIVE STAT UPDATE
function updateStatDisplay() {
    const errEl   = $('statTotalError');
    const maintEl = $('statTotalMaintenance');
    if (errEl) {
        errEl.textContent = _stats.totalErrorGabungan;
        errEl.className = `text-2xl font-bold leading-none ${_stats.totalErrorGabungan > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white'}`;
    }
    if (maintEl) {
        maintEl.textContent = _stats.totalUnmaintainedGabungan;
        maintEl.className = `text-2xl font-bold leading-none ${_stats.totalUnmaintainedGabungan > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-900 dark:text-white'}`;
    }
    const oe = $('statOutdoorError');
    if (oe)  oe.textContent = 'Outdoor: ' + _stats.totalOutdoorError;         // ← tambah prefix

    const om = $('statOutdoorMaintenance');
    if (om)  om.textContent = 'Outdoor: ' + _stats.totalOutdoorUnmaintained;  // ← tambah prefix
}

function updateOutdoorStatsFromChange(oldCctv, newCctv) {
    const oldStatus = computeOutdoorVisualStatus(oldCctv);
    const newStatus = computeOutdoorVisualStatus(newCctv);
    const wasError  = oldStatus === 'error';
    const isError   = newStatus === 'error';
    if (wasError  && !isError)  { _stats.totalOutdoorError--;        _stats.totalErrorGabungan--; }
    if (!wasError && isError)   { _stats.totalOutdoorError++;        _stats.totalErrorGabungan++; }
    const wasUnmaintained = (oldStatus==='due'||oldStatus==='overdue') && !wasError;
    const isUnmaintained  = (newStatus==='due'||newStatus==='overdue') && !isError;
    if (wasUnmaintained && !isUnmaintained) { _stats.totalOutdoorUnmaintained--; _stats.totalUnmaintainedGabungan--; }
    if (!wasUnmaintained && isUnmaintained) { _stats.totalOutdoorUnmaintained++; _stats.totalUnmaintainedGabungan++; }
    updateStatDisplay();
}



// MAP INIT

function initMap() {
    window.map = L.map('map', {
        center: [-7.750807, 111.943602],
        zoom: 15.48, minZoom: 15, maxZoom: 18,
        rotate: true,
        maxBounds: [[-7.785, 111.9119], [-7.715, 111.975]],
        maxBoundsViscosity: 0.9,
        zoomControl: false,
        rotateControl: false,
    });
    map.setBearing(-55);

    window.map.on('movestart', function() {
        if (_blockNextMove && _savedMapState) {
            window.map.stop();
            const s = _savedMapState;
            requestAnimationFrame(() => { window.map.setView(s.center, s.zoom, { animate: false }); });
        }
    });

    const CENTER = L.latLng(-7.750807, 111.943602);
    let _boundaryPanning = false;
    window.map.on('moveend', () => {
        if (_boundaryPanning) return;
        if (window.map.getCenter().distanceTo(CENTER) / 1000 > 3) {
            _boundaryPanning = true;
            window.map.panTo(CENTER, { animate: true, duration: 0.5 });
            setTimeout(() => { _boundaryPanning = false; }, 600);
        }
    });

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri', maxZoom: 18,
    }).addTo(window.map);

    renderSavedBuildings();
    initOutdoorMarkers();

    window.map.on('click', e => { if (mode !== 'add') return; createDraftAt(e.latlng); });
    window.map.on('contextmenu', e => {
        if (activeTab !== 'outdoor' || !canEditOutdoor) return;
        L.DomEvent.preventDefault(e);
        openOutdoorAddModal(e.latlng.lat, e.latlng.lng);
    });

    bindBuildingUI();
    initOutdoorTabListeners();
    initOutdoorKeyboard();
    setMode('view');
    switchTab('buildings');
}



// SSE — Real-time stat & building list updates
function initSse() {
    function poll() {
        fetch('/api/cctv-stream', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(r => r.json())
        .then(d => {
            _stats.totalOutdoorError         = d.totalOutdoorError;
            _stats.totalOutdoorUnmaintained  = d.totalOutdoorUnmaintained;
            _stats.totalErrorGabungan        = d.totalErrorGabungan;
            _stats.totalUnmaintainedGabungan = d.totalUnmaintainedGabungan;
            updateStatDisplay();

            const ie = $('statIndoorError');
            if (ie) ie.textContent = 'Indoor: ' + d.totalIndoorError;
            const im = $('statIndoorMaintenance');
            if (im) im.textContent = 'Indoor: ' + d.totalIndoorUnmaintained;

            if (d.buildingStats && window.__BUILDINGS__) {
                window.__BUILDINGS__ = window.__BUILDINGS__.map(b => {
                    const s = d.buildingStats[b.id];
                    return s ? { ...b, total_error: s.total_error, total_unmaintained: s.total_unmaintained } : b;
                });
                if (activeTab === 'buildings') renderBuildingList();
            }
        })
        .catch(() => {})
        .finally(() => {
            setTimeout(poll, 10000);
        });
    }

    poll(); 
}


function startTimeBasedRecalc() {
    setInterval(() => {
        if (activeTab === 'outdoor') {
            outdoorMarkers.forEach(({ marker }, id) => {
                const cctv = outdoorCctvs.find(c => c.id === id);
                if (!cctv) return;
                marker.setIcon(makeOutdoorIcon(cctv, selectedOutdoor && Number(selectedOutdoor.id) === Number(id)));
            });
            renderOutdoorList();
        }
    }, 60000);

    
    setInterval(() => refreshOutdoorMarkers(), 30000);
}

// HELPERS
function formatDateTime(str) {
    if (!str) return '-';
    return new Date(str).toLocaleString('id-ID', { timeZone:'Asia/Jakarta', year:'numeric', month:'2-digit', day:'2-digit', hour:'2-digit', minute:'2-digit' });
}

function computeOutdoorVisualStatus(cctv) {
    if (cctv.is_error) return 'error';
    if (!cctv.last_maintenance_at) return 'overdue';
    const diffSeconds = (new Date() - new Date(cctv.last_maintenance_at)) / 1000;
    if (diffSeconds >= window.__THRESHOLDS__.overdueSeconds) return 'overdue';
    if (diffSeconds >= window.__THRESHOLDS__.dueSeconds)     return 'due';
    return 'normal';
}

function outdoorStatusColor(s) {
    const c = window.__STATUS_COLORS__;
    if (s === 'error')   return c.error;
    if (s === 'overdue') return c.overdue;
    if (s === 'due')     return c.due;
    return '';
}

async function apiFetch(url, options = {}) {
    window.showLoading?.();
    try {
        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            ...(options.body && !(options.body instanceof FormData) ? {'Content-Type':'application/json'} : {}),
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

function showToast(message, type = 'success') {
    const bg = type === 'error' ? 'bg-red-600' : type === 'warning' ? 'bg-amber-500' : 'bg-green-600';
    const t = document.createElement('div');
    t.className = `flex items-center gap-2 px-4 py-3 rounded-xl shadow-2xl text-sm font-semibold text-white ${bg}`;
    t.innerHTML = `<span>${message}</span>`;
    t.style.cssText = 'transform:translateY(-10px);opacity:0;transition:all 0.25s ease;';
    $('toastContainer').appendChild(t);
    requestAnimationFrame(() => { t.style.transform='translateY(0)'; t.style.opacity='1'; });
    setTimeout(() => { t.style.opacity='0'; t.style.transform='translateY(-10px)'; setTimeout(()=>t.remove(),300); }, 3500);
}


// GEOMETRY
function rotatedBoxLatLngs(cLat, cLng, hLat, hLng, angleDeg) {
    const a = angleDeg * Math.PI / 180;
    return [[-hLng,hLat],[hLng,hLat],[hLng,-hLat],[-hLng,-hLat]].map(([x,y]) => ([
        cLat + x*Math.sin(a) + y*Math.cos(a), cLng + x*Math.cos(a) - y*Math.sin(a),
    ]));
}
function getBoundsFromLatLngs(latlngs) {
    let n=-Infinity,s=Infinity,e=-Infinity,w=Infinity;
    latlngs.forEach(([la,ln]) => { if(la>n)n=la;if(la<s)s=la;if(ln>e)e=ln;if(ln<w)w=ln; });
    return {north:n,south:s,east:e,west:w};
}
function getMapRotation() { return -55; }


// BUILDING OVERLAY
function makeLabelIcon(text) {
    return L.divIcon({ className:'', html:`<div class="building-label-wrap">${text||'Gedung'}</div>`, iconAnchor:[19,14] });
}

function createBuildingOverlay(data) {
    const cLat=Number(data.marker_lat), cLng=Number(data.marker_lng);
    let hLat=Number(data.half_lat_delta??0), hLng=Number(data.half_lng_delta??0);
    if (!hLat||!hLng) { hLat=Math.abs((Number(data.north)-Number(data.south))/2)||0.00015; hLng=Math.abs((Number(data.east)-Number(data.west))/2)||0.00015; }
    const rotation=getMapRotation();
    const latlngs=rotatedBoxLatLngs(cLat,cLng,hLat,hLng,rotation);
    const polygon=L.polygon(latlngs,{color:'#00E5FF',weight:3,opacity:1,fillColor:'#00E5FF',fillOpacity:0.20,interactive:true});
    const labelMarker=L.marker([cLat,cLng],{icon:makeLabelIcon(data.name||'Gedung'),interactive:false,zIndexOffset:100});
    const overlay={
        id:data.id??null, isExisting:!!data.id, data, polygon, labelMarker,
        center:[cLat,cLng], halfLat:hLat, halfLng:hLng, rotation, _dragMarker:null,
        addToMap(){ this.polygon.addTo(window.map); this.labelMarker.addTo(window.map); },
        removeFromMap(){ window.map.removeLayer(this.polygon); window.map.removeLayer(this.labelMarker); },
        refreshPolygon(){ const pts=rotatedBoxLatLngs(this.center[0],this.center[1],this.halfLat,this.halfLng,this.rotation); this.polygon.setLatLngs(pts); this.labelMarker.setLatLng(this.center); syncHiddenGeometryFromOverlay(this); },
        setLabelText(t){ this.labelMarker.setIcon(makeLabelIcon(t)); },
        setEditableMode(enabled){
            if(enabled&&!this._dragMarker){
                this._dragMarker=L.marker(this.center,{icon:L.divIcon({className:'',html:'<div style="width:20px;height:20px;border-radius:50%;background:#facc15;border:2px solid white;cursor:move;box-shadow:0 0 0 2px rgba(0,0,0,0.4);"></div>',iconSize:[20,20],iconAnchor:[10,10]}),draggable:true,zIndexOffset:2000}).addTo(window.map);
                this._dragMarker.on('drag',e=>{const ll=e.target.getLatLng();this.center=[ll.lat,ll.lng];this.refreshPolygon();});
            }
            if(!enabled&&this._dragMarker){window.map.removeLayer(this._dragMarker);this._dragMarker=null;}
        },
        remove(){ this.removeFromMap(); if(this._dragMarker){window.map.removeLayer(this._dragMarker);this._dragMarker=null;} },
    };
    polygon.on('click',()=>{
        if(mode==='edit-select'){openEditOverlay(overlay);return;}
        if(mode==='view')window.location.href=overlay.data.maintenance_url;
    });
    return overlay;
}

function renderSavedBuildings() { overlays.forEach(o=>o.remove()); overlays=[]; (window.__BUILDINGS__||[]).forEach(b=>{const o=createBuildingOverlay(b);o.addToMap();overlays.push(o);}); }
function disableOverlayInteractions() { overlays.forEach(o=>o.setEditableMode(false)); if(activeDraft&&!activeDraft.isExisting)activeDraft.setEditableMode(false); }
function clearTemporaryDraft() { if(activeDraft&&!activeDraft.isExisting){activeDraft.remove();activeDraft=null;} }

function createDraftAt(latlng) {
    clearTemporaryDraft();
    const d={id:null,name:'Gedung Baru',marker_lat:latlng.lat,marker_lng:latlng.lng,half_lat_delta:0.00015,half_lng_delta:0.00015,rotation_deg:0,north:latlng.lat+0.00015,south:latlng.lat-0.00015,east:latlng.lng+0.00015,west:latlng.lng-0.00015};
    activeDraft=createBuildingOverlay(d); activeDraft.isExisting=false;
    activeDraft.addToMap(); activeDraft.setEditableMode(true);
    prepareCreateForm(); $('building_name').value='';
    applyOverlayToFormAndSliders(activeDraft); setMode('editing');
}
function openEditOverlay(overlay) { clearTemporaryDraft(); disableOverlayInteractions(); activeDraft=overlay; activeDraft.setEditableMode(true); prepareEditForm(overlay.data); applyOverlayToFormAndSliders(activeDraft); setMode('editing'); }


// OUTDOOR MARKER
function makeOutdoorIcon(cctv, isSelected=false) {
    const status=computeOutdoorVisualStatus(cctv);
    const imgSrc=CCTV_IMAGES_OUTDOOR[cctv.cctv_type]??CCTV_IMAGES_OUTDOOR.dome;
    const color=outdoorStatusColor(status), SIZE=36;
    const pulse=status==='error'?'odr-pulse-fast':status==='due'?'odr-pulse-slow':status==='overdue'?'odr-pulse-red':'';
    function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1,3),16);
    const g = parseInt(hex.slice(3,5),16);
    const b = parseInt(hex.slice(5,7),16);
    return `rgba(${r},${g},${b},${alpha})`;
}
const c = window.__STATUS_COLORS__;
const glow = status==='error'   ? hexToRgba(c.error, 0.55)
           : status==='overdue' ? hexToRgba(c.overdue, 0.55)
           : status==='due'     ? hexToRgba(c.due, 0.55)
           : '';
    const highlightHtml=glow?`<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:${SIZE}px;height:${SIZE}px;z-index:0;pointer-events:none;"><div class="${pulse}" style="width:100%;height:100%;border-radius:50%;background:${glow};box-shadow:0 0 12px 6px ${glow};"></div></div>`:'';
    const selectedRing=isSelected?`<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:${SIZE+8}px;height:${SIZE+8}px;border-radius:50%;border:2.5px solid white;box-shadow:0 0 0 2px rgba(0,0,0,0.4);z-index:2;pointer-events:none;"></div>`:'';
    const errorBadge=status==='error'?`<div class="odr-pulse-fast" style="position:absolute;top:-8px;right:-4px;font-size:14px;font-weight:900;color:#ef4444;z-index:3;line-height:1;text-shadow:0 0 4px rgba(0,0,0,0.8),0 0 8px rgba(239,68,68,0.9);">!</div>`:'';
    const html=`<div style="position:relative;width:${SIZE}px;height:${SIZE}px;overflow:visible;cursor:pointer;">${highlightHtml}${selectedRing}<img src="${imgSrc}" style="position:relative;z-index:1;width:${SIZE}px;height:${SIZE}px;object-fit:contain;filter:drop-shadow(0 0 4px ${color});" draggable="false">${errorBadge}</div>`;
    return L.divIcon({className:'',html,iconSize:[SIZE,SIZE],iconAnchor:[SIZE/2,SIZE/2]});
}

function addOutdoorMarker(cctv, addToMap=false) {
    const marker=L.marker([Number(cctv.lat),Number(cctv.lng)],{icon:makeOutdoorIcon(cctv,false)});
    marker.on('mousedown',()=>{_savedMapState={center:window.map.getCenter(),zoom:window.map.getZoom()};_blockNextMove=true;setTimeout(()=>{_blockNextMove=false;_savedMapState=null;},300);});
    marker.on('click',(e)=>{L.DomEvent.stopPropagation(e);e.originalEvent?.stopPropagation();selectOutdoorCctv(cctv);setTimeout(()=>{window.map?.panTo([Number(cctv.lat),Number(cctv.lng)],{animate:true,duration:0.5});},320);});
    if(canEditOutdoor){marker.on('contextmenu',(e)=>{L.DomEvent.preventDefault(e);L.DomEvent.stopPropagation(e);e.originalEvent?.stopPropagation();openOutdoorDeleteModal(cctv);});}
    if(addToMap)marker.addTo(window.map);
    outdoorMarkers.set(cctv.id,{marker});
}

function highlightOutdoorMarker(selectedId) {
    outdoorMarkers.forEach(({marker},id)=>{const cctv=outdoorCctvs.find(c=>c.id===id);if(!cctv)return;marker.setIcon(makeOutdoorIcon(cctv,Number(id)===Number(selectedId)));});
}
function selectOutdoorCctv(cctv) { selectedOutdoor=cctv; highlightOutdoorMarker(cctv.id); showOutdoorInfo(cctv); }

function refreshOutdoorMarkers() {
    fetch(window.__OUTDOOR_ROUTES__.index).then(r => r.json()).then(data => {
        outdoorCctvs = data;
        outdoorMarkers.forEach(({ marker }) => window.map.removeLayer(marker));
        outdoorMarkers.clear();
        data.forEach(cctv => addOutdoorMarker(cctv, activeTab === 'outdoor'));
        if (selectedOutdoor) {
            const fresh = data.find(c => c.id === selectedOutdoor.id);
            if (fresh) { selectedOutdoor = fresh; highlightOutdoorMarker(fresh.id); }
        }
        if (activeTab === 'outdoor') renderOutdoorList();
    });
}
function initOutdoorMarkers() { outdoorCctvs.forEach(cctv=>addOutdoorMarker(cctv,false));}


// TAB SWITCHER
function switchTab(tab) {
    activeTab = tab;
    const clsActive = 'tab-btn px-3 py-1.5 rounded-md text-xs font-medium bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow transition inline-flex items-center gap-1.5 whitespace-nowrap';
    const clsIdle   = 'tab-btn px-3 py-1.5 rounded-md text-xs font-medium text-gray-600 dark:text-gray-300 transition inline-flex items-center gap-1.5 whitespace-nowrap';

    if (tab === 'buildings') {
        $('tabBtnBuildings').className = clsActive;
        $('tabBtnOutdoor').className   = clsIdle;
        $('buildingControls').classList.remove('hidden');
        $('outdoorLegend').classList.add('hidden');
        overlays.forEach(o => { if (!window.map.hasLayer(o.polygon)) o.addToMap(); });
        outdoorMarkers.forEach(({ marker }) => { if (window.map.hasLayer(marker)) window.map.removeLayer(marker); });
        closeOutdoorInfo();
        setMode('view');
        renderBuildingList();
        showRightPanel('buildingList');
    } else {
        $('tabBtnOutdoor').className   = clsActive;
        $('tabBtnBuildings').className = clsIdle;
        $('buildingControls').classList.add('hidden');
        $('outdoorLegend').classList.remove('hidden');
        overlays.forEach(o => {
            if (window.map.hasLayer(o.polygon)) o.removeFromMap();
            if (o._dragMarker && window.map.hasLayer(o._dragMarker)) { window.map.removeLayer(o._dragMarker); o._dragMarker = null; }
        });
        $('btnCancelMode').classList.add('hidden');
        outdoorMarkers.forEach(({ marker }) => { if (!window.map.hasLayer(marker)) marker.addTo(window.map); });
        renderOutdoorList();
        showRightPanel('outdoorList');
    }
    setTimeout(() => window.map?.invalidateSize(), 350);
}


// INFO PANEL OUTDOOR
function showOutdoorInfo(cctv) {
    selectedOutdoor = cctv;
    const status = computeOutdoorVisualStatus(cctv);
    const c      = window.__STATUS_COLORS__;
    const overdueH = Math.round((window.__THRESHOLDS__?.overdueSeconds || 259200) / 3600);
    const dueH     = Math.round((window.__THRESHOLDS__?.dueSeconds     || 86400) / 3600);
    const fmtH     = h => h >= 24 ? (h / 24) + ' hari' : h + ' jam';
    $('oInfoName').textContent = cctv.name || '-';
    $('oInfoIp').textContent   = cctv.ip_address || '-';
    const sm = {
        error:   { label: 'Error',                                   color: c.error   },
        overdue: { label: `Overdue (>${fmtH(overdueH)})`,  color: c.overdue },
        due:     { label: `Perlu Maintenance (>${fmtH(dueH)})`,      color: c.due     },
        normal:  { label: 'Normal',                                  color: '#22c55e' },
    };

    const { label, color } = sm[status] || sm.normal;
    const statusEl = $('oInfoStatus');
    statusEl.textContent  = label;
    statusEl.style.color  = color;
    statusEl.className    = 'font-semibold';

    const nl = $('oInfoNoteLabel'), nv = $('oInfoNote');
    if (cctv.is_error && cctv.error_description) { nl.textContent = 'Keterangan Error :'; nv.textContent = cctv.error_description; }
    else { nl.textContent = 'Keterangan Maintenance :'; nv.textContent = cctv.last_maintenance_note || '-'; }
    $('oInfoLastMaintenance').textContent = formatDateTime(cctv.last_maintenance_at);
    $('oInfoOfficer').textContent = cctv.is_error ? (cctv.last_error_officer || '-') : (cctv.last_maintenance_officer || '-');
    const pUrl = cctv.is_error ? (cctv.error_photo_url || cctv.maintenance_photo_url) : cctv.maintenance_photo_url;
    const pw = $('oInfoPhotoWrap'), pi = $('oInfoPhoto');
    if (pUrl) { pi.src = pUrl; pi.onclick = () => window.open(pUrl, '_blank'); pw.classList.remove('hidden'); }
    else { pw.classList.add('hidden'); }
    $('oInfoPhotoLabel').textContent = (cctv.is_error && cctv.error_photo_url) ? 'Foto Error :' : 'Foto Maintenance :';
    $('outdoorEmptyState').classList.add('hidden');
    $('outdoorCctvDetail').classList.remove('hidden');
    $('btnCloseOutdoorInfo').classList.remove('hidden');
    $('oErrorFormWrap')?.classList.add('hidden');
const ackWrap = $('oAckWrap');
if (ackWrap) {
    const alreadyAcked = !!cctv.error_acknowledged_at || (window._isAcknowledged?.(cctv.id) ?? false);
    if (cctv.is_error && !alreadyAcked) {
        ackWrap.classList.remove('hidden');
    } else {
        ackWrap.classList.add('hidden');
    }
}
    showRightPanel('outdoorInfo');
}

function closeOutdoorInfo() {
    selectedOutdoor = null;
    highlightOutdoorMarker(null);
    $('outdoorEmptyState').classList.remove('hidden');
    $('outdoorCctvDetail').classList.add('hidden');
    $('btnCloseOutdoorInfo').classList.add('hidden');
    showRightPanel('outdoorList');
}


// FIELD ERROR HELPERS
function setOutdoorFieldError(id,msg){const el=$(id);if(!el)return;if(id==='oErrorDescription'){const s=$('oErrorDescriptionError');if(s)s.textContent='— '+msg;el.classList.add('border-red-500');return;}let e=el.parentElement.querySelector('.o-field-error');if(!e){e=document.createElement('p');e.className='o-field-error text-xs text-red-500 mt-1';el.parentElement.appendChild(e);}e.textContent=msg;el.classList.add('border-red-500');}
function clearOutdoorFieldError(id){const el=$(id);if(!el)return;if(id==='oErrorDescription'){const s=$('oErrorDescriptionError');if(s)s.textContent='';el.classList.remove('border-red-500');return;}const e=el.parentElement.querySelector('.o-field-error');if(e)e.textContent='';el.classList.remove('border-red-500');}
function setOutdoorPhotoError(inputId,cls,msg){const el=$(inputId),label=el?.closest('label')||el?.parentElement;let e=label?.parentElement.querySelector(cls);if(!e){e=document.createElement('p');e.className=cls.replace('.','') + ' text-xs text-red-500 mt-1';label?.parentElement.appendChild(e);}e.textContent=msg;}
function clearOutdoorPhotoError(inputId,cls){const el=$(inputId),label=el?.closest('label')||el?.parentElement;const e=label?.parentElement.querySelector(cls);if(e)e.textContent='';}


// MARK MAINTENANCE — update stat live
async function outdoorMarkMaintenance() {
    if (!selectedOutdoor) return;
    const btn = $('oBtnMarkMaintenance');
    if (!window.lockSubmit(btn, 'Menyimpan...')) return;

    let valid = true;
    clearOutdoorFieldError('oTechnicianName');
    clearOutdoorPhotoError('oMaintenancePhoto', '.o-field-error-photo');
    const name  = $('oTechnicianName')?.value.trim();
    const photo = $('oMaintenancePhoto')?.files[0];
    if (!name)  { setOutdoorFieldError('oTechnicianName', 'Nama petugas wajib diisi.'); valid = false; }
    if (!photo) { setOutdoorPhotoError('oMaintenancePhoto', '.o-field-error-photo', 'Foto dokumentasi wajib diisi.'); valid = false; }
    if (!valid) { window.unlockSubmit(btn); return; }

    const fd = new FormData();
    fd.append('technician_name', name);
    fd.append('photo', photo);
    if ($('oMaintenanceNote')?.value) fd.append('note', $('oMaintenanceNote').value);
    try {
        const oldCctv = { ...selectedOutdoor };
        const resp = await apiFetch(window.__OUTDOOR_ROUTES__.markMaintenance.replace('__ID__', selectedOutdoor.id), { method: 'POST', body: fd });
        outdoorCctvs = outdoorCctvs.map(c => c.id === resp.cctv.id ? resp.cctv : c);
        const ex = outdoorMarkers.get(resp.cctv.id);
        if (ex) { window.map.removeLayer(ex.marker); outdoorMarkers.delete(resp.cctv.id); }
        addOutdoorMarker(resp.cctv, activeTab === 'outdoor');
        highlightOutdoorMarker(resp.cctv.id);
        showOutdoorInfo(resp.cctv);
        showToast('Maintenance berhasil disimpan.', 'success');
        if ($('oTechnicianName'))   $('oTechnicianName').value = '';
        if ($('oMaintenanceNote'))  $('oMaintenanceNote').value = '';
        if ($('oMaintenancePhoto')) $('oMaintenancePhoto').value = '';
        $('oMaintenancePhotoPreview')?.classList.add('hidden');
        $('oErrorFormWrap')?.classList.add('hidden');
        updateOutdoorStatsFromChange(oldCctv, resp.cctv);
        renderOutdoorList();
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        window.unlockSubmit(btn);
    }
}

async function outdoorMarkError() {
    if (!selectedOutdoor) return;
    const btn = $('oBtnMarkError');
    if (!window.lockSubmit(btn, 'Melaporkan...')) return;

    let valid = true;
    clearOutdoorFieldError('oTechnicianName');
    clearOutdoorFieldError('oErrorDescription');
    clearOutdoorPhotoError('oErrorPhoto', '.o-field-error-photo-error');
    const name  = $('oTechnicianName')?.value.trim();
    const desc  = $('oErrorDescription')?.value.trim();
    const photo = $('oErrorPhoto')?.files[0];
    if (!name)  { setOutdoorFieldError('oTechnicianName', 'Nama petugas wajib diisi.'); valid = false; }
    if (!desc)  { setOutdoorFieldError('oErrorDescription', 'Keterangan error wajib diisi.'); valid = false; }
    if (!photo) { setOutdoorPhotoError('oErrorPhoto', '.o-field-error-photo-error', 'Foto error wajib diisi.'); valid = false; }
    if (!valid) { window.unlockSubmit(btn); return; }

    const fd = new FormData();
    fd.append('technician_name', name);
    fd.append('description', desc);
    fd.append('photo', photo);
    try {
        const oldCctv = { ...selectedOutdoor };
        const resp = await apiFetch(window.__OUTDOOR_ROUTES__.markError.replace('__ID__', selectedOutdoor.id), { method: 'POST', body: fd });
        outdoorCctvs = outdoorCctvs.map(c => c.id === resp.cctv.id ? resp.cctv : c);
        const ex = outdoorMarkers.get(resp.cctv.id);
        if (ex) { window.map.removeLayer(ex.marker); outdoorMarkers.delete(resp.cctv.id); }
        addOutdoorMarker(resp.cctv, activeTab === 'outdoor');
        highlightOutdoorMarker(resp.cctv.id);
        showOutdoorInfo(resp.cctv);
        showToast('Error CCTV berhasil dilaporkan.', 'error');
        if ($('oTechnicianName'))   $('oTechnicianName').value = '';
        if ($('oErrorDescription')) $('oErrorDescription').value = '';
        if ($('oErrorPhoto'))       $('oErrorPhoto').value = '';
        $('oErrorPhotoPreview')?.classList.add('hidden');
        $('oErrorFormWrap')?.classList.add('hidden');
        clearOutdoorFieldError('oErrorDescription');
        updateOutdoorStatsFromChange(oldCctv, resp.cctv);
        renderOutdoorList();
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        window.unlockSubmit(btn);
    }
}

// TAMBAH & HAPUS CCTV OUTDOOR
let _pendingLL=null;
function updateOutdoorModalPreview(){const type=$('oModalCctvType').value;$('oModalIconPreview').innerHTML=`<img src="${CCTV_IMAGES_OUTDOOR[type]||CCTV_IMAGES_OUTDOOR.dome}" style="width:40px;height:40px;object-fit:contain;">`;}
function openOutdoorAddModal(lat,lng){_pendingLL={lat,lng};$('oModalCctvName').value='';$('oModalCctvIp').value='';$('oModalCctvType').value='dome';const m=$('modalOutdoorAddCctv'),p=$('oModalPanel');m.classList.remove('hidden');m.classList.add('flex');requestAnimationFrame(()=>{p.classList.remove('scale-95','opacity-0');p.classList.add('scale-100','opacity-100');});updateOutdoorModalPreview();$('oModalCctvName').focus();}
function closeOutdoorAddModal(){const m=$('modalOutdoorAddCctv'),p=$('oModalPanel');p.classList.remove('scale-100','opacity-100');p.classList.add('scale-95','opacity-0');setTimeout(()=>{m.classList.add('hidden');m.classList.remove('flex');_pendingLL=null;},200);}
async function submitOutdoorAddModal(){
    const name=$('oModalCctvName').value.trim();
    if(!name){$('oModalCctvName').focus();$('oModalCctvName').classList.add('ring-2','ring-red-500');return;}
    $('oModalCctvName').classList.remove('ring-2','ring-red-500');
    try {
        const resp=await apiFetch(window.__OUTDOOR_ROUTES__.store,{method:'POST',body:JSON.stringify({name,ip_address:$('oModalCctvIp').value.trim()||null,cctv_type:$('oModalCctvType').value,lat:_pendingLL.lat,lng:_pendingLL.lng})});
        outdoorCctvs.push(resp.cctv); addOutdoorMarker(resp.cctv,true);
        showToast('CCTV outdoor berhasil ditambahkan.'); closeOutdoorAddModal();
    } catch(err){ showToast(err.message,'error'); }
}
let _pendingDel=null;
function openOutdoorDeleteModal(cctv){_pendingDel=cctv;$('oDeleteCctvName').textContent=cctv.name;const m=$('modalOutdoorDeleteCctv'),p=$('oModalDeletePanel');m.classList.remove('hidden');m.classList.add('flex');requestAnimationFrame(()=>{p.classList.remove('scale-95','opacity-0');p.classList.add('scale-100','opacity-100');});}
function closeOutdoorDeleteModal(){const m=$('modalOutdoorDeleteCctv'),p=$('oModalDeletePanel');p.classList.remove('scale-100','opacity-100');p.classList.add('scale-95','opacity-0');setTimeout(()=>{m.classList.add('hidden');m.classList.remove('flex');_pendingDel=null;},200);}
async function submitOutdoorDeleteModal(){
    if(!_pendingDel)return; const cctv=_pendingDel;
    try {
        const oldStatus=computeOutdoorVisualStatus(cctv);
        await apiFetch(window.__OUTDOOR_ROUTES__.destroy.replace('__ID__',cctv.id),{method:'DELETE'});
        const ex=outdoorMarkers.get(cctv.id); if(ex){window.map.removeLayer(ex.marker);outdoorMarkers.delete(cctv.id);}
        outdoorCctvs=outdoorCctvs.filter(c=>c.id!==cctv.id);
        if(selectedOutdoor?.id===cctv.id)closeOutdoorInfo();
        // Kurangi stat yang relevan
        if(oldStatus==='error'){_stats.totalOutdoorError--;_stats.totalErrorGabungan--;}
        else if(oldStatus==='due'||oldStatus==='overdue'){_stats.totalOutdoorUnmaintained--;_stats.totalUnmaintainedGabungan--;}
        updateStatDisplay();
        showToast('CCTV outdoor berhasil dihapus.','warning'); closeOutdoorDeleteModal();
    } catch(err){ showToast(err.message,'error'); closeOutdoorDeleteModal(); }
}



// KEYBOARD
function initOutdoorKeyboard(){
    document.addEventListener('keydown',e=>{
        const addOpen=!$('modalOutdoorAddCctv').classList.contains('hidden');
        const delOpen=!$('modalOutdoorDeleteCctv').classList.contains('hidden');
        if(addOpen){if(e.key==='Enter'){e.preventDefault();submitOutdoorAddModal();}if(e.key==='Escape')closeOutdoorAddModal();if(e.key==='ArrowRight'){e.preventDefault();$('oBtnModalSubmit')?.focus();}if(e.key==='ArrowLeft'){e.preventDefault();$('oBtnModalCancel')?.focus();}return;}
        if(delOpen){if(e.key==='Enter'){e.preventDefault();submitOutdoorDeleteModal();}if(e.key==='Escape')closeOutdoorDeleteModal();if(e.key==='ArrowRight'){e.preventDefault();$('oBtnDeleteCctvConfirm')?.focus();}if(e.key==='ArrowLeft'){e.preventDefault();$('oBtnDeleteCctvCancel')?.focus();}return;}
        if(activeTab==='outdoor'&&selectedOutdoor&&e.key==='Enter'&&!e.shiftKey){e.preventDefault();$('oErrorFormWrap').classList.contains('hidden')?outdoorMarkMaintenance():outdoorMarkError();}
    });
}


// EVENT LISTENERS OUTDOOR
function initOutdoorTabListeners(){
    $('btnCloseOutdoorInfo')?.addEventListener('click',closeOutdoorInfo);
    $('oBtnMarkMaintenance')?.addEventListener('click',outdoorMarkMaintenance);
    $('oBtnMarkError')?.addEventListener('click',outdoorMarkError);
    $('oBtnToggleErrorForm')?.addEventListener('click', () => {
    const wrap = $('oErrorFormWrap');
    if (!wrap) return;
    const isH = wrap.classList.contains('hidden');
    if (isH) {
        wrap.classList.remove('hidden');
        $('oMaintenancePhoto')?.value && ($('oMaintenancePhoto').value = '');
        if ($('oMaintenancePhotoImg')) $('oMaintenancePhotoImg').src = '';
        $('oMaintenancePhotoPreview')?.classList.add('hidden');
        clearOutdoorPhotoError('oMaintenancePhoto', '.o-field-error-photo');
    } else {
        wrap.classList.add('hidden');
        if ($('oErrorPhoto')) $('oErrorPhoto').value = '';
        if ($('oErrorPhotoImg')) $('oErrorPhotoImg').src = '';
        $('oErrorPhotoPreview')?.classList.add('hidden');
    }
});
    $('oMaintenancePhoto')?.addEventListener('change',e=>{const f=e.target.files[0];if(!f)return;$('oMaintenancePhotoImg').src=URL.createObjectURL(f);$('oMaintenancePhotoPreview').classList.remove('hidden');clearOutdoorPhotoError('oMaintenancePhoto','.o-field-error-photo');});
    $('oBtnRemoveMaintenancePhoto')?.addEventListener('click',()=>{$('oMaintenancePhoto').value='';$('oMaintenancePhotoImg').src='';$('oMaintenancePhotoPreview').classList.add('hidden');});
    $('oErrorPhoto')?.addEventListener('change',e=>{const f=e.target.files[0];if(!f)return;$('oErrorPhotoImg').src=URL.createObjectURL(f);$('oErrorPhotoPreview').classList.remove('hidden');clearOutdoorPhotoError('oErrorPhoto','.o-field-error-photo-error');});
    $('oBtnRemoveErrorPhoto')?.addEventListener('click',()=>{$('oErrorPhoto').value='';$('oErrorPhotoImg').src='';$('oErrorPhotoPreview').classList.add('hidden');});
    $('oTechnicianName')?.addEventListener('input',()=>clearOutdoorFieldError('oTechnicianName'));
    $('oErrorDescription')?.addEventListener('input',()=>clearOutdoorFieldError('oErrorDescription'));
    $('oBtnModalCancel')?.addEventListener('click',closeOutdoorAddModal);
    $('oBtnModalSubmit')?.addEventListener('click',submitOutdoorAddModal);
    $('oModalBackdrop')?.addEventListener('click',closeOutdoorAddModal);
    $('oModalCctvType')?.addEventListener('change',updateOutdoorModalPreview);
    $('oModalCctvName')?.addEventListener('keydown',e=>{if(e.key==='Enter'){e.stopPropagation();submitOutdoorAddModal();}});
    $('oBtnDeleteCctvCancel')?.addEventListener('click',closeOutdoorDeleteModal);
    $('oBtnDeleteCctvConfirm')?.addEventListener('click',submitOutdoorDeleteModal);
    $('btnBackToOutdoorList')?.addEventListener('click', () => {
    selectedOutdoor = null;
    highlightOutdoorMarker(null);
    $('outdoorEmptyState').classList.remove('hidden');
    $('outdoorCctvDetail').classList.add('hidden');
    renderOutdoorList();
    showRightPanel('outdoorList');
});
$('oBtnAcknowledge')?.addEventListener('click', async () => {
    if (!selectedOutdoor?.is_error) return;
    const btn = $('oBtnAcknowledge');
    if (!window.lockSubmit(btn, 'Menyimpan...')) return;
    try {
        await fetch(`/api/cctvs/${selectedOutdoor.id}/acknowledge-error`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
        showToast('Error sudah di-acknowledge. Alarm berhenti.', 'success');
        $('oAckWrap')?.classList.add('hidden');
        const ackedId = selectedOutdoor.id;
        selectedOutdoor = { ...selectedOutdoor, error_acknowledged_at: new Date().toISOString() };
        outdoorCctvs = outdoorCctvs.map(c =>
            c.id === ackedId ? { ...c, error_acknowledged_at: new Date().toISOString() } : c
        );
        window._ackError?.(ackedId);
    } catch(err) {
        showToast('Gagal acknowledge.', 'error');
    } finally {
        window.unlockSubmit(btn);
    }
});
}

// SIDEBAR GEDUNG
function toggleSidebar(show = false) {
    if (show) {
        showRightPanel('form');
    } else {
        showRightPanel('buildingList');
    }
}
function setSidebarIdle(){$('sidebarTitle').textContent='Form Gedung';$('sidebarBadge').textContent='Belum aktif';$('sidebarBadge').className='text-xs px-2 py-0.5 rounded bg-gray-700 text-gray-200';$('sidebarHint').innerHTML='Klik <b>Tambah Gedung</b> untuk membuat marker.';$('buildingForm').classList.add('hidden');clearForm();}
function setSidebarMessage(msg){$('sidebarTitle').textContent='Form Gedung';$('sidebarBadge').textContent='Menunggu';$('sidebarBadge').className='text-xs px-2 py-0.5 rounded bg-amber-700 text-amber-100';$('sidebarHint').textContent=msg;$('buildingForm').classList.add('hidden');}
function showSidebarFor(kind){$('buildingForm').classList.remove('hidden');if(kind==='create'){$('sidebarTitle').textContent='Tambah Gedung';$('sidebarBadge').textContent='Tambah';$('sidebarBadge').className='text-xs px-2 py-0.5 rounded bg-blue-700 text-blue-100';$('sidebarHint').textContent='Klik map → posisi, atur ukuran, simpan.';}else{$('sidebarTitle').textContent='Ubah Gedung';$('sidebarBadge').textContent='Ubah';$('sidebarBadge').className='text-xs px-2 py-0.5 rounded bg-amber-700 text-amber-100';$('sidebarHint').textContent='Geser titik kuning, atur ukuran, simpan.';}}


// MODE GEDUNG
function setMode(next){
    mode=next;
    if(next==='view'){$('btnCancelMode').classList.add('hidden');disableOverlayInteractions();clearTemporaryDraft();activeDraft=null;toggleSidebar(false);setSidebarIdle();return;}
    if(next==='add'){$('btnCancelMode').classList.remove('hidden');disableOverlayInteractions();clearTemporaryDraft();toggleSidebar(true);prepareCreateForm();return;}
    if(next==='edit-select'){$('btnCancelMode').classList.remove('hidden');disableOverlayInteractions();clearTemporaryDraft();activeDraft=null;toggleSidebar(true);setSidebarMessage('Pilih gedung dari map.');return;}
    if(next==='editing'){$('btnCancelMode').classList.remove('hidden');toggleSidebar(true);}
}


// FLOOR ROWS
function escapeHtml(v){return String(v??'').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');}
function addFloorRow(data = {}) {
    const idx = floorRowIndex++;
    const w = document.createElement('div');
    w.className = 'rounded-lg border border-white/10 bg-gray-800/50 p-2.5';
    w.dataset.floorRow = idx;

    const ep = data.existing_plan_url
        ? `<div class="text-xs text-gray-300 mb-1">Denah: <a href="${data.existing_plan_url}" target="_blank" class="text-blue-300 underline">Lihat</a></div>`
        : '';

    const floorLabel = data.floor_number !== undefined && data.floor_number !== ''
        ? `Lantai ${data.floor_number}${data.floor_name ? ' — ' + data.floor_name : ''}`
        : 'Lantai Baru';

    w.innerHTML = `
        <input type="hidden" name="floors[${idx}][floor_id]"     value="${escapeHtml(data.floor_id ?? '')}">
        <input type="hidden" name="floors[${idx}][existing_plan]" value="${escapeHtml(data.existing_plan ?? '')}">
        <div class="flex items-center justify-between gap-2 mb-2">
            <div class="text-xs font-semibold text-gray-100">${floorLabel}</div>
            <button type="button" class="text-xs px-2 py-0.5 rounded bg-red-600 hover:bg-red-500 text-white"
                    onclick="removeFloorRow(${idx})">Hapus</button>
        </div>
        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <label class="block text-xs text-gray-300 mb-1">No. Lantai <span class="text-gray-400 text-[10px]">(0 = ground floor)</span></label>
                <input type="number" min="0" name="floors[${idx}][floor_number]"
                       value="${escapeHtml(data.floor_number ?? '')}"
                       oninput="updateFloorRowLabel(this, ${idx})"
                       class="w-full rounded-md border border-white/10 bg-gray-900 text-white px-2 py-1 text-xs">
            </div>
            <div>
                <label class="block text-xs text-gray-300 mb-1">Nama <span class="text-gray-400 text-[10px]">(wajib jika no. sama)</span></label>
                <input type="text" name="floors[${idx}][floor_name]"
                       value="${escapeHtml(data.floor_name ?? '')}"
                       oninput="updateFloorRowLabel(this, ${idx})"
                       placeholder="cth: A, B, Mezzanine..."
                       class="w-full rounded-md border border-white/10 bg-gray-900 text-white px-2 py-1 text-xs">
            </div>
        </div>
        ${ep}
        <div>
            <label class="block text-xs text-gray-300 mb-1">Upload Denah</label>
            <input type="file" name="floors[${idx}][plan_file]" accept=".jpg,.jpeg,.png,.webp,.pdf"
                   class="w-full text-xs text-gray-200 file:mr-2 file:rounded file:border-0 file:bg-blue-600 file:px-2 file:py-1 file:text-white">
        </div>`;

    $('floorsContainer').appendChild(w);
}


function updateFloorRowLabel(input, idx) {
    const row    = document.querySelector(`[data-floor-row="${idx}"]`);
    if (!row) return;
    const numInput  = row.querySelector(`input[name="floors[${idx}][floor_number]"]`);
    const nameInput = row.querySelector(`input[name="floors[${idx}][floor_name]"]`);
    const labelEl   = row.querySelector('.text-xs.font-semibold.text-gray-100');
    if (!labelEl) return;
    const num  = numInput?.value ?? '';
    const name = nameInput?.value ?? '';
    labelEl.textContent = num !== ''
        ? `Lantai ${num}${name ? ' — ' + name : ''}`
        : 'Lantai Baru';
}
window.removeFloorRow = removeFloorRow;
function removeFloorRow(idx){const e=document.querySelector(`[data-floor-row="${idx}"]`);if(e)e.remove();}
window.removeFloorRow=removeFloorRow;


// FORM
function clearForm(){const f=$('buildingForm');f.reset();$('formMethod').value='POST';f.action=f.dataset.storeUrl;['marker_lat','marker_lng','half_lat_delta','half_lng_delta','rotation_deg','north','south','east','west'].forEach(id=>$(id).value='');$('floorsContainer').innerHTML='';floorRowIndex=0;$('widthRange').value='0.00030';$('heightRange').value='0.00030';$('rotation_deg').value=0;syncSliderTexts();updateCoordsPreview();$('btnDeleteBuilding').classList.add('hidden');}
function prepareCreateForm(){clearForm();showSidebarFor('create');$('btnDeleteBuilding').classList.add('hidden');addFloorRow();}
function prepareEditForm(d) {
    clearForm();
    showSidebarFor('edit');
    const f = $('buildingForm');
    f.action = f.dataset.updateUrlTemplate.replace('__ID__', d.id);
    $('formMethod').value = 'PUT';
    $('building_name').value = d.name || '';
    $('building_description').value = d.description || '';
    $('widthRange').value  = String((d.half_lng_delta ?? 0.00015) * 2);
    $('heightRange').value = String((d.half_lat_delta ?? 0.00015) * 2);
    $('rotation_deg').value = 0;
    syncSliderTexts();

    (d.floors || []).forEach(fl => addFloorRow({
        floor_id:          fl.id,          
        floor_number:      fl.floor_number,  
        floor_name:        fl.floor_name  || '',
        existing_plan:     fl.plan_path   || '',
        existing_plan_url: fl.plan_url    || '',
    }));

    if (!(d.floors || []).length) addFloorRow();
    $('btnDeleteBuilding').classList.remove('hidden');
}
function syncHiddenGeometryFromOverlay(overlay){$('marker_lat').value=overlay.center[0];$('marker_lng').value=overlay.center[1];$('half_lat_delta').value=overlay.halfLat;$('half_lng_delta').value=overlay.halfLng;$('rotation_deg').value=0;const lls=overlay.polygon.getLatLngs()[0];const pts=lls.map(p=>[p.lat,p.lng]);const b=getBoundsFromLatLngs(pts);$('north').value=b.north;$('south').value=b.south;$('east').value=b.east;$('west').value=b.west;updateCoordsPreview();}
function syncSliderTexts(){const w=Number($('widthRange')?.value||0),h=Number($('heightRange')?.value||0);if($('widthValue'))$('widthValue').textContent=`(${w.toFixed(5)})`;if($('heightValue'))$('heightValue').textContent=`(${h.toFixed(5)})`;}
function applyOverlayToFormAndSliders(overlay){$('widthRange').value=String((overlay.halfLng*2).toFixed(5));$('heightRange').value=String((overlay.halfLat*2).toFixed(5));syncSliderTexts();syncHiddenGeometryFromOverlay(overlay);}
function applySlidersToActiveOverlay(){if(!activeDraft)return;activeDraft.halfLng=Number($('widthRange').value||0.00030)/2;activeDraft.halfLat=Number($('heightRange').value||0.00030)/2;activeDraft.refreshPolygon();syncSliderTexts();}
function updateCoordsPreview(){const la=$('marker_lat').value,ln=$('marker_lng').value,n=$('north').value,s=$('south').value,e=$('east').value,w=$('west').value;$('coordsPreview').innerHTML=`<div>Pusat: ${la&&ln?`${Number(la).toFixed(6)}, ${Number(ln).toFixed(6)}`:'-'}</div><div>Bounds: ${n&&s&&e&&w?`N:${Number(n).toFixed(6)} S:${Number(s).toFixed(6)} E:${Number(e).toFixed(6)} W:${Number(w).toFixed(6)}`:'-'}</div>`;}


// BIND UI GEDUNG
function bindBuildingUI(){
    $('btnAddBuilding')?.addEventListener('click',()=>setMode('add'));
    $('btnEditBuilding')?.addEventListener('click',()=>setMode('edit-select'));
    $('btnCancelMode')?.addEventListener('click',()=>setMode('view'));
    $('btnAddFloor')?.addEventListener('click',()=>addFloorRow());
    $('btnResetForm')?.addEventListener('click',()=>{if(!activeDraft){clearForm();return;}if(activeDraft.isExisting){prepareEditForm(activeDraft.data);applyOverlayToFormAndSliders(activeDraft);}else{prepareCreateForm();applyOverlayToFormAndSliders(activeDraft);}});
    $('building_name')?.addEventListener('input',e=>{if(activeDraft)activeDraft.setLabelText(e.target.value||'Gedung');});
    ['widthRange','heightRange'].forEach(id=>{const e=$(id);if(e)e.addEventListener('input',applySlidersToActiveOverlay);});
    $('btnDeleteBuilding')?.addEventListener('click',()=>{if(!activeDraft||!activeDraft.id)return;openDeleteBuildingModal();});

    let delBldChoice='cancel';
    function openDeleteBuildingModal(){const m=$('modalDeleteBuilding'),p=$('modalDeleteBuildingPanel');delBldChoice='cancel';m.classList.remove('hidden');m.classList.add('flex');requestAnimationFrame(()=>{p.classList.remove('scale-95','opacity-0');p.classList.add('scale-100','opacity-100');updateDelBldHighlight();});}
    function updateDelBldHighlight(){const c=$('btnDeleteBuildingCancel'),cf=$('btnDeleteBuildingConfirm');if(delBldChoice==='cancel'){c.style.outline='2px solid rgba(255,255,255,0.5)';c.style.outlineOffset='2px';cf.style.outline='none';}else{cf.style.outline='2px solid #f87171';cf.style.outlineOffset='2px';c.style.outline='none';}}
    function closeDeleteBuildingModal(){const m=$('modalDeleteBuilding'),p=$('modalDeleteBuildingPanel');p.classList.remove('scale-100','opacity-100');p.classList.add('scale-95','opacity-0');$('btnDeleteBuildingCancel').style.outline='none';$('btnDeleteBuildingConfirm').style.outline='none';delBldChoice='cancel';setTimeout(()=>{m.classList.add('hidden');m.classList.remove('flex');},150);}
    $('btnDeleteBuildingCancel')?.addEventListener('click',closeDeleteBuildingModal);
    $('btnDeleteBuildingConfirm')?.addEventListener('click',()=>{if(!activeDraft||!activeDraft.id)return;const f=document.createElement('form');f.method='POST';f.action=`/gedung/${activeDraft.id}`;const c=document.createElement('input');c.type='hidden';c.name='_token';c.value=document.querySelector('meta[name="csrf-token"]').content;const m=document.createElement('input');m.type='hidden';m.name='_method';m.value='DELETE';f.appendChild(c);f.appendChild(m);document.body.appendChild(f);f.submit();});
    document.addEventListener('keydown',e=>{const open=!$('modalDeleteBuilding').classList.contains('hidden');if(!open)return;if(e.key==='Escape')closeDeleteBuildingModal();else if(e.key==='ArrowLeft'){e.preventDefault();delBldChoice='cancel';updateDelBldHighlight();}else if(e.key==='ArrowRight'){e.preventDefault();delBldChoice='confirm';updateDelBldHighlight();}else if(e.key==='Enter'){e.preventDefault();if(delBldChoice==='confirm')$('btnDeleteBuildingConfirm')?.click();else closeDeleteBuildingModal();}});
}
    // PANEL LAYER MANAGEMENT
function showLayer(id) {
    const el = $(id);
    if (!el) return;
    el.classList.add('panel-layer-active');
    el.classList.remove('panel-layer-hidden');
    el.style.opacity = '1';
    el.style.pointerEvents = 'auto';
    el.style.transform = 'translateX(0)';
}
function hideLayer(id) {
    const el = $(id);
    if (!el) return;
    el.classList.remove('panel-layer-active');
    el.classList.add('panel-layer-hidden');
    el.style.opacity = '0';
    el.style.pointerEvents = 'none';
}

function showRightPanel(layer) {
    hideLayer('buildingListPanel');
    hideLayer('sidebarPanel');
    hideLayer('outdoorListPanel');
    hideLayer('outdoorInfoPanel');

    if (layer === 'buildingList')  { showLayer('buildingListPanel'); }
    else if (layer === 'form')     { showLayer('sidebarPanel'); }
    else if (layer === 'outdoorList') { showLayer('outdoorListPanel'); }
    else if (layer === 'outdoorInfo') { showLayer('outdoorInfoPanel'); }

    setTimeout(() => window.map?.invalidateSize(), 350);
}

// BUILDING LIST
function renderBuildingList() {
    const container = $('buildingListContent');
    if (!container) return;

    const buildings = window.__BUILDINGS__ || [];
    const c = window.__STATUS_COLORS__;
    function hexBg(hex, a = 0.15) {
        const r = parseInt(hex.slice(1,3),16), g = parseInt(hex.slice(3,5),16), b = parseInt(hex.slice(5,7),16);
        return `rgba(${r},${g},${b},${a})`;
    }

    const problemBuildings = buildings
        .filter(b => (b.total_error ?? 0) > 0 || (b.total_unmaintained ?? 0) > 0)
        .sort((a, b) => {
            const errDiff = (b.total_error ?? 0) - (a.total_error ?? 0);
            if (errDiff !== 0) return errDiff;

            return (b.total_unmaintained ?? 0) - (a.total_unmaintained ?? 0);
        });

    if (problemBuildings.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8">
                <div class="w-10 h-10 rounded-full bg-emerald-500/15 flex items-center justify-center mx-auto mb-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Semua gedung normal</div>
            </div>`;
        return;
    }

    container.innerHTML = problemBuildings.map(b => {
        const hasError       = (b.total_error ?? 0) > 0;
        const hasMaintenance = (b.total_unmaintained ?? 0) > 0;

        const statusDot = hasError
            ? `<span class="w-2 h-2 rounded-full flex-shrink-0 odr-pulse-fast" style="background:${c.error}"></span>`
            : `<span class="w-2 h-2 rounded-full flex-shrink-0 odr-pulse-slow" style="background:${c.due}"></span>`;

        const badges = [];
        if (hasError)
            badges.push(`<span class="px-1.5 py-0.5 rounded text-[10px] font-semibold"
                style="background:${hexBg(c.error)};color:${c.error};">${b.total_error} Error</span>`);
        if (hasMaintenance)
            badges.push(`<span class="px-1.5 py-0.5 rounded text-[10px] font-semibold"
                style="background:${hexBg(c.due)};color:${c.due};">${b.total_unmaintained} Perlu Maintenance</span>`);

        const totalCctv = b.total_cctv ?? 0;

        return `<div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl border
                   ${hasError ? 'border-red-500/20 bg-red-500/5 dark:bg-red-500/10' : 'border-amber-500/20 bg-amber-500/5 dark:bg-amber-500/10'}
                   cursor-pointer hover:bg-white/10 dark:hover:bg-white/5 transition group"
            onclick="window.location.href='${b.maintenance_url}'">
            ${statusDot}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-semibold text-gray-900 dark:text-white truncate group-hover:text-blue-400 transition">${b.name}</span>
                    <span class="text-[10px] text-gray-500 dark:text-gray-500 flex-shrink-0">${totalCctv} CCTV</span>
                </div>
                <div class="flex gap-1.5 mt-0.5 flex-wrap">${badges.join('')}</div>
            </div>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-500 flex-shrink-0"><path d="M9 18l6-6-6-6"/></svg>
        </div>`;
    }).join('');
}

// OUTDOOR LIST
function renderOutdoorList() {
    const container = $('outdoorListContent');
    if (!container) return;

    const statusOrder = { error: 0, overdue: 1, due: 2 };
const c = window.__STATUS_COLORS__;

    function hexBg(hex, a = 0.15) {
        const r = parseInt(hex.slice(1,3),16);
        const g = parseInt(hex.slice(3,5),16);
        const b = parseInt(hex.slice(5,7),16);
        return `rgba(${r},${g},${b},${a})`;
    }

    const statusMap = {
        error:   {
            label:      'Error',
            badgeStyle: `background:${hexBg(c.error)};color:${c.error};`,
            dotCls:     'odr-pulse-fast',
            dotColor:   c.error,
        },
        overdue: {
            label:      'Overdue',
            badgeStyle: `background:${hexBg(c.overdue)};color:${c.overdue};`,
            dotCls:     'odr-pulse-red',
            dotColor:   c.overdue,
        },
        due:     {
            label:      'Perlu Maintenance',
            badgeStyle: `background:${hexBg(c.due)};color:${c.due};`,
            dotCls:     'odr-pulse-slow',
            dotColor:   c.due,
        },
    };

    const problemCctvs = outdoorCctvs
        .filter(c => computeOutdoorVisualStatus(c) !== 'normal')
        .sort((a, b) => {
            const sa = statusOrder[computeOutdoorVisualStatus(a)] ?? 9;
            const sb = statusOrder[computeOutdoorVisualStatus(b)] ?? 9;
            if (sa !== sb) return sa - sb;
            // Terbaru: last_maintenance_at null = paling overdue, taruh paling atas
            const da = a.last_maintenance_at ? new Date(a.last_maintenance_at) : new Date(0);
            const db = b.last_maintenance_at ? new Date(b.last_maintenance_at) : new Date(0);
            return da - db; // yang paling lama maintenance = paling atas
        });

    if (problemCctvs.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8">
                <div class="w-10 h-10 rounded-full bg-emerald-500/15 flex items-center justify-center mx-auto mb-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Semua CCTV outdoor normal</div>
            </div>`;
        return;
    }

    container.innerHTML = problemCctvs.map(cctv => {
        const status = computeOutdoorVisualStatus(cctv);
        const { label, badgeStyle, dotCls, dotColor } = statusMap[status] || statusMap.due;
        const imgSrc = CCTV_IMAGES_OUTDOOR[cctv.cctv_type] ?? CCTV_IMAGES_OUTDOOR.dome;

        return `<div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl border border-white/10
                   bg-white/5 dark:bg-gray-700/30 cursor-pointer hover:bg-white/10 dark:hover:bg-white/5 transition group"
            onclick="selectOutdoorCctvFromList(${cctv.id})">
            <div class="relative flex-shrink-0">
                <img src="${imgSrc}" class="w-8 h-8 object-contain">
                <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full ${dotCls}"
                      style="background:${dotColor}"></span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-xs font-semibold text-gray-900 dark:text-white truncate group-hover:text-amber-400 transition">${cctv.name}</div>
                <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-semibold mt-0.5"
                      style="${badgeStyle}">${label}</span>
            </div>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 class="text-gray-500 flex-shrink-0"><path d="M9 18l6-6-6-6"/></svg>
        </div>`;
    }).join('');
}

function selectOutdoorCctvFromList(cctvId) {
    const cctv = outdoorCctvs.find(c => c.id === cctvId);
    if (!cctv) return;
    selectOutdoorCctv(cctv);
    setTimeout(() => window.map?.panTo([Number(cctv.lat), Number(cctv.lng)], { animate: true, duration: 0.5 }), 100);
}

document.addEventListener('DOMContentLoaded', () => {
    initMap();
    window.addEventListener('cctv:acknowledged', (e) => {
    window.addEventListener('cctv:acknowledged', (e) => {
    const ackedId = Number(e.detail.id);
        outdoorCctvs = outdoorCctvs.map(c =>
            c.id === ackedId ? { ...c, error_acknowledged_at: new Date().toISOString() } : c
        );
        if (selectedOutdoor && Number(selectedOutdoor.id) === ackedId) {
            selectedOutdoor = { ...selectedOutdoor, error_acknowledged_at: new Date().toISOString() };
            $('oAckWrap')?.classList.add('hidden');
        }
    });
});
    (function() {
    const params = new URLSearchParams(window.location.search);
    const outdoorId = params.get('outdoor_cctv');
    if (!outdoorId) return;
    setTimeout(() => {
        switchTab('outdoor');
        setTimeout(() => {
            const cctv = outdoorCctvs.find(c => Number(c.id) === Number(outdoorId));
            if (!cctv) return;
            selectOutdoorCctv(cctv);
            window.map?.panTo([Number(cctv.lat), Number(cctv.lng)], { animate: true, duration: 0.8 });
            history.replaceState({}, '', window.location.pathname);
        }, 400);
    }, 800);
})();
    initSse();
    startTimeBasedRecalc();
    renderBuildingList();
    showRightPanel('buildingList'); 
});
</script>
</x-app-layout>