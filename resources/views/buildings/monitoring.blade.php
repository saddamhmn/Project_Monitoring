<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Data Gedung & CCTV') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

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
                <div class="stat-sublabel flex gap-2 text-[11px] text-gray-400 mt-1">
                    <span class="flex items-center gap-1">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/>
                        </svg>
                        Indoor: {{ $totalCctvAll }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                            <circle cx="12" cy="13" r="4"/>
                        </svg>
                        Outdoor: {{ $totalOutdoorAll }}
                    </span>
                </div>
            </div>
        </div>

        {{-- CCTV Error --}}
        <div class="flex items-center gap-3 rounded-2xl border border-red-500/20 bg-red-500/5 dark:bg-red-500/10 backdrop-blur px-4 py-4 shadow-sm">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-red-500/15 flex items-center justify-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#ef4444">
                    <path d="M12 2L1 21h22L12 2z"/>
                    <rect x="11" y="8" width="2" height="6" fill="white"/>
                    <rect x="11" y="16" width="2" height="2" fill="white"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-gray-500 dark:text-gray-400 leading-none mb-1">CCTV Error</div>
                <div class="text-2xl font-bold leading-none {{ $totalErrorGabungan > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                    {{ $totalErrorGabungan }}
                </div>
                <div class="stat-sublabel flex gap-2 text-[11px] text-gray-400 mt-1">
                    <span class="flex items-center gap-1">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/>
                        </svg>
                        Indoor: {{ $totalErrorAll }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                            <circle cx="12" cy="13" r="4"/>
                        </svg>
                        Outdoor: {{ $totalOutdoorError }}
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
                <div class="text-2xl font-bold leading-none {{ $totalUnmaintainedGabungan > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-900 dark:text-white' }}">
                    {{ $totalUnmaintainedGabungan }}
                </div>
                <div class="stat-sublabel flex gap-2 text-[11px] text-gray-400 mt-1">
                    <span class="flex items-center gap-1">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/>
                        </svg>
                        Indoor: {{ $totalUnmaintainedAll }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                            <circle cx="12" cy="13" r="4"/>
                        </svg>
                        Outdoor: {{ $totalOutdoorUnmaintained }}
                    </span>
                </div>
            </div>
        </div>
    </div>

            {{-- LIST GEDUNG --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded border border-gray-200 dark:border-white/10 overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex flex-wrap items-center justify-between gap-3">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Gedung</h3>
                    <div class="flex flex-wrap items-center gap-2">
                        <form method="GET" class="flex items-center gap-2">
                            @foreach(request()->except('search_building', 'page') as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <input type="text" name="search_building" value="{{ $searchBuilding }}"
                                placeholder="Cari nama gedung..."
                                class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 w-40">
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs">Cari</button>
                            @if($searchBuilding)
                                <a href="{{ url()->current() }}?{{ http_build_query(request()->except(['search_building','page'])) }}"
                                class="px-3 py-1.5 rounded-lg bg-gray-500 hover:bg-gray-400 text-white text-xs">Reset</a>
                            @endif
                        </form>
                        <form method="GET" id="perPageFormGedung" class="flex items-center gap-2">
                            @foreach(request()->except('per_page', 'page') as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <label class="text-xs text-gray-500 dark:text-gray-400">Tampilkan</label>
                            <select name="per_page" onchange="document.getElementById('perPageFormGedung').submit()"
                                class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-lg pl-2 pr-7 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                                @foreach([10, 25, 50, 100] as $n)
                                    <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                            <label class="text-xs text-gray-500 dark:text-gray-400">data</label>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="tabel-gedung min-w-full divide-y divide-gray-200 dark:divide-white/10 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">No</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Nama Gedung</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">Total CCTV</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">CCTV Error</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">Perlu Maintenance</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">Status</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">Aksi</th>
                            </tr>
                        </thead>

                        {{-- BODY --}}
                        <tbody class="divide-y divide-gray-200 dark:divide-white/10">

                            @foreach ($buildings as $index => $building)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ $buildings->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $building['name'] }}
                                    </td>

                                    <td class="px-6 py-4 text-center font-semibold text-gray-900 dark:text-white">
                                        {{ $building['total_cctv'] }}
                                    </td>

                                    <td class="px-6 py-4 text-center font-semibold text-red-600">
                                        {{ $building['total_error'] }}
                                    </td>

                                    <td class="px-6 py-4 text-center font-semibold text-yellow-500">
                                        {{ $building['total_unmaintained'] }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-6 py-4 text-center">
                                        @if ($building['total_error'] > 0)
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600 dark:bg-red-500/20">
                                                Ada Error
                                            </span>
                                        @elseif ($building['total_unmaintained'] > 0)
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-500/20">
                                                Perlu Maintenance
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600 dark:bg-green-500/20">
                                                Normal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('buildings.maintenance', ['building' => $building['id'], 'from' => 'buildings']) }}"
                                        class="px-3 py-1 text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                                            Lihat
                                        </a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                        

                    </table>
                    <div class="mt-8 px-8 py-5">
                        {{ $buildings->links() }}
                    </div>
                </div>
            
            </div>

<div class="mt-8 bg-white dark:bg-gray-800 shadow rounded border border-gray-200 dark:border-white/10 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex flex-wrap items-center justify-between gap-3">
        
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">CCTV Indoor 
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $indoorCctvs->total() }} CCTV</span> 
        </h3>
        
        
        <div class="flex flex-wrap items-center gap-2">
            {{-- Search indoor --}}
            <form method="GET" class="flex items-center gap-2">
                @foreach(request()->except('search_indoor', 'indoor_page') as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <input type="text" name="search_indoor" value="{{ $searchIndoor }}"
                    placeholder="Nama / IP address..."
                    class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 w-40">
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs">Cari</button>
                @if($searchIndoor)
                    <a href="{{ url()->current() }}?{{ http_build_query(request()->except(['search_indoor','indoor_page'])) }}"
                       class="px-3 py-1.5 rounded-lg bg-gray-500 hover:bg-gray-400 text-white text-xs">Reset</a>
                @endif
            </form>
            {{-- Per page --}}
            <form method="GET" id="perPageFormIndoor" class="flex items-center gap-2">
                @foreach(request()->except('indoor_per_page', 'indoor_page') as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <label class="text-xs text-gray-500 dark:text-gray-400">Tampilkan</label>
                <select name="indoor_per_page" onchange="document.getElementById('perPageFormIndoor').submit()"
                    class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-lg pl-2 pr-7 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @foreach([10, 25, 50, 100] as $n)
                        <option value="{{ $n }}" {{ $indoorPerPage == $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
                <label class="text-xs text-gray-500 dark:text-gray-400">data</label>
            </form>
            
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="tabel-indoor min-w-full divide-y divide-gray-200 dark:divide-white/10 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Nama CCTV</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Gedung</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Lantai</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Tipe</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">IP Address</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Terakhir Maintenance</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                @forelse($indoorCctvs as $i => $cctv)
                    @php
                        $status   = $cctv->visual_status;
                        $cDue     = \App\Models\Setting::colorDue();
                        $cOverdue = \App\Models\Setting::colorOverdue();
                        $bgDue = sprintf('rgba(%d,%d,%d,0.15)',
                            hexdec(substr($cDue,1,2)), hexdec(substr($cDue,3,2)), hexdec(substr($cDue,5,2)));
                        $bgOvr = sprintf('rgba(%d,%d,%d,0.15)',
                            hexdec(substr($cOverdue,1,2)), hexdec(substr($cOverdue,3,2)), hexdec(substr($cOverdue,5,2)));
                        $statusConfig = match($status) {
                            'error'   => ['label' => 'Error',            'style' => 'background:rgba(239,68,68,0.15);color:#ef4444;',     'dotStyle' => 'background:#ef4444',   'dotClass' => 'animate-ping'],
                            'overdue' => ['label' => 'Overdue',          'style' => "background:{$bgOvr};color:{$cOverdue};",              'dotStyle' => "background:{$cOverdue}",'dotClass' => ''],
                            'due'     => ['label' => 'Perlu Maintenance','style' => "background:{$bgDue};color:{$cDue};",                  'dotStyle' => "background:{$cDue}",   'dotClass' => ''],
                            default   => ['label' => 'Normal',           'style' => 'background:rgba(34,197,94,0.15);color:#22c55e;',      'dotStyle' => 'background:#22c55e',   'dotClass' => ''],
                        };
                        $building  = $cctv->floor?->building;
                        $floor     = $cctv->floor;
                        $floorLabel = 'Lantai ' . ($floor?->floor_number ?? '-')
                            . ($floor?->floor_name ? ' — ' . $floor->floor_name : '');
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">
                            {{ $indoorCctvs->firstItem() + $loop->index }}
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $cctv->name }}</td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $building?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs whitespace-nowrap">{{ $floorLabel }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 capitalize">{{ $cctv->cctv_type }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 font-mono text-xs">{{ $cctv->ip_address ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                  style="{{ $statusConfig['style'] }}">
                                <span class="w-1.5 h-1.5 rounded-full inline-block flex-shrink-0 {{ $statusConfig['dotClass'] }}"
                                      style="{{ $statusConfig['dotStyle'] }}"></span>
                                {{ $statusConfig['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 text-xs">
                            {{ $cctv->last_maintenance_at
                                ? $cctv->last_maintenance_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i')
                                : '-' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                        @if($building)
                            <a href="{{ route('buildings.maintenance', [
                                    'building'   => $building->id,
                                    'from'       => 'buildings',
                                    'select_cctv'=> $cctv->id,
                            ]) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg
                                    bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-500/10 dark:hover:bg-indigo-500/20
                                    text-indigo-700 dark:text-indigo-400 text-xs font-medium transition">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 22V12h6v10"/><path d="M3 9h18"/>
                                </svg>
                                Lihat Denah
                            </a>
                        @endif
                    </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500">
                            @if($searchIndoor)
                                Tidak ada CCTV indoor yang cocok dengan "<strong>{{ $searchIndoor }}</strong>".
                            @else
                                Belum ada CCTV indoor terdaftar.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($indoorCctvs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-white/10">
            {{ $indoorCctvs->links() }}
        </div>
    @endif
</div>

        
<div class="mt-8 bg-white dark:bg-gray-800 shadow rounded border border-gray-200 dark:border-white/10 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex flex-wrap items-center justify-between gap-3">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">CCTV Outdoor
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $outdoorCctvs->total() }} CCTV</span>
    </h3>
    <div class="flex flex-wrap items-center gap-2">
        <form method="GET" class="flex items-center gap-2">
            @foreach(request()->except('search_outdoor', 'outdoor_page') as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <input type="text" name="search_outdoor" value="{{ $searchOutdoor }}"
                placeholder="Nama / IP address..."
                class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 w-40">
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs">Cari</button>
            @if($searchOutdoor)
                <a href="{{ url()->current() }}?{{ http_build_query(request()->except(['search_outdoor','outdoor_page'])) }}"
                   class="px-3 py-1.5 rounded-lg bg-gray-500 hover:bg-gray-400 text-white text-xs">Reset</a>
            @endif
        </form>
        <form method="GET" id="perPageFormOutdoor" class="flex items-center gap-2">
            @foreach(request()->except('outdoor_per_page', 'outdoor_page') as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <label class="text-xs text-gray-500 dark:text-gray-400">Tampilkan</label>
            <select name="outdoor_per_page" onchange="document.getElementById('perPageFormOutdoor').submit()"
                class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-lg pl-2 pr-7 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                @foreach([10, 25, 50, 100] as $n)
                    <option value="{{ $n }}" {{ $outdoorPerPage == $n ? 'selected' : '' }}>{{ $n }}</option>
                @endforeach
            </select>
            <label class="text-xs text-gray-500 dark:text-gray-400">data</label>
        </form>
    </div>
</div>

    <div class="overflow-x-auto">
        <table class="tabel-outdoor min-w-full divide-y divide-gray-200 dark:divide-white/10 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">No</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Nama CCTV</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Tipe</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">IP Address</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">Status</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Terakhir Maintenance</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                @forelse($outdoorCctvs as $i => $cctv)
                    @php
                        $status   = $cctv->visual_status;
                        $cDue     = \App\Models\Setting::colorDue();
                        $cOverdue = \App\Models\Setting::colorOverdue();
                        $bgDue = sprintf('rgba(%d,%d,%d,0.15)',
                            hexdec(substr($cDue,1,2)), hexdec(substr($cDue,3,2)), hexdec(substr($cDue,5,2)));
                        $bgOvr = sprintf('rgba(%d,%d,%d,0.15)',
                            hexdec(substr($cOverdue,1,2)), hexdec(substr($cOverdue,3,2)), hexdec(substr($cOverdue,5,2)));

                        $statusConfig = match($status) {
                            'error'   => [
                                'label'    => 'Error',
                                'style'    => 'background:rgba(239,68,68,0.15);color:#ef4444;',
                                'dotStyle' => 'background:#ef4444',
                                'dotClass' => 'animate-ping',
                            ],
                            'overdue' => [
                                'label'    => 'Overdue',
                                'style'    => "background:{$bgOvr};color:{$cOverdue};",
                                'dotStyle' => "background:{$cOverdue}",
                                'dotClass' => '',
                            ],
                            'due'     => [
                                'label'    => 'Perlu Maintenance',
                                'style'    => "background:{$bgDue};color:{$cDue};",
                                'dotStyle' => "background:{$cDue}",
                                'dotClass' => '',
                            ],
                            default   => [
                                'label'    => 'Normal',
                                'style'    => 'background:rgba(34,197,94,0.15);color:#22c55e;',
                                'dotStyle' => 'background:#22c55e',
                                'dotClass' => '',
                            ],
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $outdoorCctvs->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $cctv->name }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 capitalize">{{ $cctv->cctv_type }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-mono text-xs">{{ $cctv->ip_address ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                style="{{ $statusConfig['style'] }}">
                                <span class="w-1.5 h-1.5 rounded-full inline-block flex-shrink-0 {{ $statusConfig['dotClass'] }}"
                                    style="{{ $statusConfig['dotStyle'] }}"></span>
                                {{ $statusConfig['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm">
                            {{ $cctv->last_maintenance_at
                                ? $cctv->last_maintenance_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i')
                                : '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('dashboard') }}?outdoor_cctv={{ $cctv->id }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                      bg-cyan-50 hover:bg-cyan-100 dark:bg-cyan-500/10 dark:hover:bg-cyan-500/20
                                      text-cyan-700 dark:text-cyan-400 text-xs font-medium transition">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                                </svg>
                                Lihat di Map
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500">
                            Belum ada CCTV outdoor terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($outdoorCctvs->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-white/10">
        {{ $outdoorCctvs->links() }}
    </div>
@endif
</div>
        </div>
    </div>
<style>
@media (max-width: 767px) {
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
    .stat-sublabel {
        flex-direction: column !important;
        gap: 1px !important;
        font-size: 9px !important;
        line-height: 1.4 !important;
        margin-top: 2px !important;
    }
    .stat-sublabel svg {
        display: none !important;
    }
    .stat-sublabel > span {
        display: flex !important;
        align-items: center !important;
        gap: 0 !important;
    }

    .overflow-x-auto { -webkit-overflow-scrolling: touch; }


}
</style>
<script>
(function() {
    function poll() {
        fetch('/api/cctv-stream', {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(d => {
            const errEl = document.getElementById('gedungStatError');
            const mntEl = document.getElementById('gedungStatMaintenance');
            if (errEl) errEl.textContent = d.totalErrorGabungan;
            if (mntEl) mntEl.textContent = d.totalUnmaintainedGabungan;
        })
        .catch(() => {})
        .finally(() => setTimeout(poll, 10000));
    }
    poll();
})();
</script>
</x-app-layout>