<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pengaturan Sistem</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash --}}
            @if(session('success'))
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-600 dark:text-red-400 text-sm">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mt-0.5 flex-shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <ul class="space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            {{--SECTION 1 — THRESHOLD CCTV--}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-white/10 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-500/15 flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Threshold Status CCTV</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Atur kapan status CCTV berubah berdasarkan waktu terakhir maintenance</p>
                    </div>
                </div>

                <div class="p-6 space-y-6">


                    <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-gray-900/40 p-4">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider">Preview Status Timeline</div>
                        <div class="flex items-stretch gap-0 rounded-lg overflow-hidden text-xs font-semibold text-white">
                            <div class="flex-1 bg-emerald-500 px-3 py-2.5 flex flex-col gap-0.5 min-w-0">
                                <span class="truncate">Normal</span>
                            </div>
                            <div class="w-0 h-0 self-center border-t-[20px] border-b-[20px] border-l-[10px] border-t-transparent border-b-transparent border-l-emerald-500 flex-shrink-0"></div>
                            <div id="timelineDueBlock" class="flex-1 px-3 py-2.5 flex flex-col gap-0.5 min-w-0"
                                style="background:{{ \App\Models\Setting::colorDue() }}">
                                <span class="truncate">Perlu Maintenance</span>
                                <span class="font-normal text-white/80 text-[10px]"><span id="previewDue2">—</span> — <span id="previewOverdue">—</span></span>
                            </div>
                            <div id="timelineDueArrow" class="w-0 h-0 self-center border-t-[20px] border-b-[20px] border-l-[10px] border-t-transparent border-b-transparent flex-shrink-0"
                                style="border-left-color:{{ \App\Models\Setting::colorDue() }}"></div>
                            <div id="timelineOverdueBlock" class="flex-1 px-3 py-2.5 flex flex-col gap-0.5 min-w-0"
                                style="background:{{ \App\Models\Setting::colorOverdue() }}">
                                <span class="truncate">Overdue</span>
                                <span class="font-normal text-white/80 text-[10px]">&gt; <span id="previewOverdue2">—</span></span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('settings.threshold') }}" method="POST" class="space-y-5">
                        @csrf @method('PUT')

                        @php
                            function hoursToDisplay(int $h): array {
                                if ($h >= 720 && $h % 720 === 0) return ['value' => $h / 720, 'unit' => 'bulan'];
                                if ($h >= 24  && $h % 24  === 0) return ['value' => $h / 24,  'unit' => 'hari'];
                                return ['value' => $h, 'unit' => 'jam'];
                            }
                            $due     = hoursToDisplay($thresholdDueHours);
                            $overdue = hoursToDisplay($thresholdOverdueHours);
                        @endphp

                        {{-- Due --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Perlu Maintenance (Due)
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Waktu sejak maintenance terakhir hingga status berubah menjadi <span class="text-amber-500 font-semibold">Perlu Maintenance</span></p>
                            </div>
                            <div class="flex gap-2">
                                <input type="number" name="due_value" id="dueValue"
                                    value="{{ old('due_value', $due['value']) }}"
                                    min="1" max="9999"
                                    class="flex-1 min-w-0 rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 @error('due_value') border-red-500 @enderror">
                                <select name="due_unit" id="dueUnit"
                                    class="rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <option value="jam"   {{ old('due_unit',  $due['unit'])  === 'jam'   ? 'selected' : '' }}>Jam</option>
                                    <option value="hari"  {{ old('due_unit',  $due['unit'])  === 'hari'  ? 'selected' : '' }}>Hari</option>
                                    <option value="bulan" {{ old('due_unit',  $due['unit'])  === 'bulan' ? 'selected' : '' }}>Bulan</option>
                                </select>
                            </div>
                        </div>

                        {{-- Overdue --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Overdue
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Waktu sejak maintenance terakhir hingga status berubah menjadi <span class="text-red-500 font-semibold">Overdue</span></p>
                            </div>
                            <div class="flex gap-2">
                                <input type="number" name="overdue_value" id="overdueValue"
                                    value="{{ old('overdue_value', $overdue['value']) }}"
                                    min="1" max="9999"
                                    class="flex-1 min-w-0 rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 @error('overdue_value') border-red-500 @enderror">
                                <select name="overdue_unit" id="overdueUnit"
                                    class="rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="jam"   {{ old('overdue_unit', $overdue['unit']) === 'jam'   ? 'selected' : '' }}>Jam</option>
                                    <option value="hari"  {{ old('overdue_unit', $overdue['unit']) === 'hari'  ? 'selected' : '' }}>Hari</option>
                                    <option value="bulan" {{ old('overdue_unit', $overdue['unit']) === 'bulan' ? 'selected' : '' }}>Bulan</option>
                                </select>
                            </div>
                        </div>

                        @error('overdue')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="flex justify-end pt-2">
                            <button type="submit" id="btnSaveThreshold"
                                class="flex items-center gap-2 px-5 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black text-sm font-semibold transition">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                Simpan Threshold
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>

{{-- SECTION — WARNA STATUS --}}
<div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-white/10 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-purple-500/15 flex items-center justify-center flex-shrink-0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2">
                <circle cx="13.5" cy="6.5" r=".5" fill="#a855f7"/>
                <circle cx="17.5" cy="10.5" r=".5" fill="#a855f7"/>
                <circle cx="8.5"  cy="7.5"  r=".5" fill="#a855f7"/>
                <circle cx="6.5"  cy="12.5" r=".5" fill="#a855f7"/>
                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
            </svg>
        </div>
        <div>
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Warna Status Marker</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Atur warna marker CCTV di peta dan denah. Status error selalu merah.</p>
        </div>
    </div>
    <div class="p-6">
        <form action="{{ route('settings.colors') }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            {{-- Preview --}}
            <div class="rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-gray-900/40 p-4">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider">Preview Marker</div>
                <div class="flex items-center gap-6 flex-wrap">
                    <div class="flex items-center gap-2">
                        <div id="previewDueDot" class="w-4 h-4 rounded-full border-2 border-white shadow" style="background:{{ $colorDue }}"></div>
                        <span class="text-xs text-gray-600 dark:text-gray-300">Perlu Maintenance</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div id="previewOverdueDot" class="w-4 h-4 rounded-full border-2 border-white shadow" style="background:{{ $colorOverdue }}"></div>
                        <span class="text-xs text-gray-600 dark:text-gray-300">Overdue</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full border-2 border-white shadow bg-red-500"></div>
                        <span class="text-xs text-gray-600 dark:text-gray-300">Error (tetap merah)</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Warna Due --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Warna Perlu Maintenance
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color_due" id="colorDue"
                            value="{{ old('color_due', $colorDue) }}"
                            class="w-12 h-10 rounded-lg border border-gray-300 dark:border-white/10 cursor-pointer p-0.5 bg-white dark:bg-gray-900">
                        <input type="text" id="colorDueHex"
                            value="{{ old('color_due', $colorDue) }}"
                            maxlength="7" pattern="^#[0-9a-fA-F]{6}$"
                            class="flex-1 rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900
                                   text-gray-900 dark:text-white px-3 py-2 text-sm font-mono
                                   focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <p class="text-xs text-gray-500">Default: <span class="font-mono">#f97316</span> (orange)</p>
                </div>

                {{-- Warna Overdue --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Warna Overdue
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color_overdue" id="colorOverdue"
                            value="{{ old('color_overdue', $colorOverdue) }}"
                            class="w-12 h-10 rounded-lg border border-gray-300 dark:border-white/10 cursor-pointer p-0.5 bg-white dark:bg-gray-900">
                        <input type="text" id="colorOverdueHex"
                            value="{{ old('color_overdue', $colorOverdue) }}"
                            maxlength="7" pattern="^#[0-9a-fA-F]{6}$"
                            class="flex-1 rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900
                                   text-gray-900 dark:text-white px-3 py-2 text-sm font-mono
                                   focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <p class="text-xs text-gray-500">Default: <span class="font-mono">#ef4444</span> (merah)</p>
                </div>
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" id="btnSaveColors"
                    class="flex items-center gap-2 px-5 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold transition">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Warna
                </button>
            </div>
        </form>
    </div>
</div>

            {{-- SECTION 1b — RESET ACKNOWLEDGE --}}
<div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-white/10 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-blue-500/15 flex items-center justify-center flex-shrink-0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div>
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Reset Pengingat Harian</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Notifikasi error CCTV yang sudah di-acknowledge akan muncul kembali setiap hari pada jam ini
            </p>
        </div>
    </div>
    <div class="p-6">
        <form action="{{ route('settings.ack_reset') }}" method="POST" class="flex items-center gap-4">
            @csrf @method('PUT')
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Reset Harian</label>
                <input type="time" name="ack_reset_time"
                    value="{{ old('ack_reset_time', \App\Models\Setting::get('ack_reset_time', '10:00')) }}"
                    class="rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900
                           text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Semua acknowledge akan direset, alarm akan berbunyi kembali jika masih ada error</p>
            </div>
            <button type="submit" id="btnSaveAckReset"
                class="flex items-center gap-2 px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold transition self-end">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan
            </button>
        </form>
    </div>
</div>

            {{-- SECTION 3 — INFO SISTEM --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-white/10 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-500/15 flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-500">
                            <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Informasi Sistem</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Read-only</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php
                            $infos = [
                                ['label' => 'PHP Version',     'value' => phpversion()],
                                ['label' => 'Laravel Version', 'value' => app()->version()],
                                ['label' => 'Environment',     'value' => app()->environment()],
                                ['label' => 'Debug Mode',      'value' => config('app.debug') ? 'Aktif' : 'Nonaktif'],
                                ['label' => 'Timezone',        'value' => config('app.timezone')],
                                ['label' => 'Database',        'value' => config('database.default')],
                            ];
                        @endphp
                        @foreach($infos as $info)
                            <div class="rounded-lg bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-white/10 px-4 py-3">
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $info['label'] }}</div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-white font-mono">{{ $info['value'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
    (function () {
        const unitMultiplier = { jam: 1, hari: 24, bulan: 720 };

        function formatHours(h) {
            if (h >= 720 && h % 720 === 0) return (h / 720) + ' Bulan';
            if (h >= 24  && h % 24  === 0) return (h / 24)  + ' Hari';
            return h + ' Jam';
        }

        function updatePreview() {
            const dueVal  = parseInt(document.getElementById('dueValue')?.value)     || 0;
            const dueUnit =          document.getElementById('dueUnit')?.value       || 'jam';
            const ovrVal  = parseInt(document.getElementById('overdueValue')?.value) || 0;
            const ovrUnit =          document.getElementById('overdueUnit')?.value   || 'jam';

            const dueH = dueVal * (unitMultiplier[dueUnit] ?? 1);
            const ovrH = ovrVal * (unitMultiplier[ovrUnit] ?? 1);

            const dueStr = formatHours(dueH);
            const ovrStr = formatHours(ovrH);

            ['previewDue2'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = dueStr;
            });
            ['previewOverdue', 'previewOverdue2'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = ovrStr;
            });
        }

    
    function syncColor(pickerId, hexId, dotId) {
        const picker = document.getElementById(pickerId);
        const hex    = document.getElementById(hexId);
        const dot    = document.getElementById(dotId);
        if (!picker || !hex) return;


        const timelineMap = {
            'colorDue': [
                { id: 'timelineDueBlock',  prop: 'backgroundColor' },
                { id: 'timelineDueArrow',  prop: 'borderLeftColor' },
            ],
            'colorOverdue': [
                { id: 'timelineOverdueBlock', prop: 'backgroundColor' },
            ],
        };

        function applyColor(color) {
            if (dot) dot.style.background = color;
            (timelineMap[pickerId] || []).forEach(({ id, prop }) => {
                const el = document.getElementById(id);
                if (el) el.style[prop] = color;
            });
        }

        picker.addEventListener('input', () => {
            hex.value = picker.value;
            applyColor(picker.value);
        });
        hex.addEventListener('input', () => {
            if (/^#[0-9a-fA-F]{6}$/.test(hex.value)) {
                picker.value = hex.value;
                applyColor(hex.value);
            }
        });
    }
    syncColor('colorDue',     'colorDueHex',     'previewDueDot');
    syncColor('colorOverdue', 'colorOverdueHex', 'previewOverdueDot');
        document.addEventListener('DOMContentLoaded', () => {
            [
                { formSelector: 'form[action*="threshold"]', btnId: 'btnSaveThreshold', label: 'Menyimpan...' },
                { formSelector: 'form[action*="profile"]',   btnId: 'btnSaveProfile',   label: 'Menyimpan...' },
            ].forEach(({ formSelector, btnId, label }) => {
                const form = document.querySelector(formSelector);
                const btn  = document.getElementById(btnId);
                if (!form || !btn) return;
                form.addEventListener('submit', function(e) {
                    if (this.dataset.submitting === '1') { e.preventDefault(); return; }
                    this.dataset.submitting = '1';
                    setTimeout(() => { btn.disabled = true; btn.style.opacity = '0.6'; btn.textContent = label; }, 0);
                });
            });
        });

        ['dueValue','dueUnit','overdueValue','overdueUnit'].forEach(id => {
            document.getElementById(id)?.addEventListener('input', updatePreview);
            document.getElementById(id)?.addEventListener('change', updatePreview);
        });


        updatePreview();
    })();
    </script>
</x-app-layout>