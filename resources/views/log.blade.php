<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
        Log CCTV Maintenance & Error
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- FILTER --}}
           <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 shadow rounded p-5 mb-6">
                <form id="filterForm" method="GET">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">

                        <select name="building" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm">
                            <option value="">Semua Gedung</option>
                            @foreach($buildings as $b)
                                <option value="{{ $b->id }}" {{ request('building') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>

                        <select name="floor" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm">
                            <option value="">Semua Lantai</option>
                            @foreach($floors as $f)
                                <option value="{{ $f->floor_number }}" {{ (string)request('floor') === (string)$f->floor_number ? 'selected' : '' }}>
                                    Lantai {{ $f->floor_number }}
                                </option>
                            @endforeach
                        </select>
                        <select name="cctv_type" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm">
                            <option value="">Semua Tipe CCTV</option>
                            <option value="dome"   {{ request('cctv_type')=='dome'   ? 'selected':'' }}>Dome</option>
                            <option value="bullet" {{ request('cctv_type')=='bullet' ? 'selected':'' }}>Bullet</option>
                            <option value="ptz"    {{ request('cctv_type')=='ptz'    ? 'selected':'' }}>PTZ</option>
                        </select>

                        <select name="log_type" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm">
                            <option value="">Semua Tipe Log</option>
                            <option value="maintenance" {{ request('log_type')=='maintenance' ? 'selected':'' }}>Maintenance</option>
                            <option value="error"       {{ request('log_type')=='error'       ? 'selected':'' }}>Error</option>
                        </select>

                        <select name="area" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm">
                            <option value="">Semua Area</option>
                            <option value="indoor"  {{ request('area')=='indoor'  ? 'selected':'' }}>🏢 Indoor</option>
                            <option value="outdoor" {{ request('area')=='outdoor' ? 'selected':'' }}>📷 Outdoor</option>
                        </select>

                        <select name="status" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm">
                            <option value="">Semua Data</option>
                            <option value="active"  {{ request('status')=='active'  ? 'selected':'' }}>Hanya Aktif</option>
                            <option value="deleted" {{ request('status')=='deleted' ? 'selected':'' }}>Hanya Dihapus</option>
                        </select>

                        <input type="text" name="petugas" placeholder="Nama Petugas" value="{{ request('petugas') }}"
                            class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm">

                        <select name="range" id="rangeSelect" class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-2 text-sm">
                            <option value="">Semua Tanggal</option>
                            <option value="week"    {{ request('range')=='week'    ? 'selected':'' }}>1 Minggu Ini</option>
                            <option value="month"   {{ request('range')=='month'   ? 'selected':'' }}>Bulan Ini</option>
                            <option value="3months" {{ request('range')=='3months' ? 'selected':'' }}>3 Bulan Terakhir</option>
                        </select>

                        <div class="flex items-center gap-2">
                            <input type="date" name="date_from" id="dateFrom" value="{{ request('date_from') }}"
                                class="flex-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-1 py-2 text-sm">
                            <span class="text-gray-400 text-xs">s/d</span>
                            <input type="date" name="date_to" id="dateTo" value="{{ request('date_to') }}"
                                class="flex-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg px-1 py-2 text-sm">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition">Filter</button>
                            <a href="{{ route('logs.index') }}" class="flex-1 text-center px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium transition">Reset</a>
                            <a href="{{ route('logs.export', request()->query()) }}" class="flex-1 text-center px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition">Export</a>
                        </div>

                    </div>
                </form>
            </div>
            

                {{-- TABEL LOG --}}
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded border border-gray-200 dark:border-white/10 overflow-hidden">
                    <div class="px-6 py-3 border-b border-gray-200 dark:border-white/10 flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $logs->total() }} log ditemukan
                        </span>
                        <form method="GET" id="perPageFormLog" class="flex items-center gap-2">
                            @foreach(request()->except('per_page', 'page') as $key => $val)
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endforeach
                            <label class="text-xs text-gray-500 dark:text-gray-400">Tampilkan</label>
                            <select name="per_page" onchange="document.getElementById('perPageFormLog').submit()"
                                class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-800
                                    text-gray-800 dark:text-gray-200 rounded-lg pl-2 pr-7 py-1 text-xs
                                    focus:outline-none focus:ring-1 focus:ring-blue-500">
                                @foreach([10, 25, 50, 100] as $n)
                                    <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                            <label class="text-xs text-gray-500 dark:text-gray-400">data</label>
                        </form>
                    </div>
                    <div id="logTable" class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10 text-sm">

                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">No</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Gedung</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Lantai</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">CCTV</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Tipe Log</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Petugas</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Keterangan</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Foto</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Tanggal</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-white/10">

                                @foreach ($logs as $index => $log)

                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">

                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $logs->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-2">
                                            @if($log->area === 'outdoor')
                                                <span class="px-1.5 py-0.5 text-xs rounded-full bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-300">
                                                    📷 Outdoor
                                                </span>
                                            @else
                                                {{ $log->building }}
                                                @if($log->building_deleted)
                                                    <span class="px-1.5 py-0.5 text-xs rounded bg-red-100 text-red-500 dark:bg-red-500/20">Dihapus</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                                        @if($log->area === 'outdoor')
                                            <span class="text-xs text-gray-400">—</span>
                                        @else
                                            {{ $log->floor }}
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-1 flex-wrap">
                                            {{ $log->cctv_name }}
                                            <span class="text-xs text-gray-400 capitalize">({{ $log->cctv_type }})</span>
                                            @if($log->cctv_deleted)
                                                <span class="px-1.5 py-0.5 text-xs rounded bg-red-100 text-red-500 dark:bg-red-500/20">
                                                    Dihapus
                                                </span>
                                            @endif
                                            @if($log->building_deleted && !$log->cctv_deleted)
                                                <span class="px-1.5 py-0.5 text-xs rounded bg-orange-100 text-orange-500 dark:bg-orange-500/20">
                                                    Gedung Dihapus
                                                </span>
                                            @endif
                                        </div>
                                    </td>


                                    <td class="px-6 py-4">

                                        @if($log->type == 'maintenance')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                            Maintenance
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">
                                            Error
                                            </span>
                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $log->petugas }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $log->keterangan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($log->photo)
                                            <a href="{{ Storage::url($log->photo) }}" target="_blank" class="block w-12 h-12 flex-shrink-0">
                                                <img
                                                    data-src="{{ Storage::url($log->photo) }}"
                                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48'%3E%3Crect width='48' height='48' fill='%23374151' rx='8'/%3E%3C/svg%3E"
                                                    width="48" height="48"
                                                    loading="lazy"
                                                    decoding="async"
                                                    class="log-img h-12 w-12 object-cover rounded-lg border border-gray-200 dark:border-white/10 shadow hover:opacity-80 transition"
                                                    title="Klik untuk lihat penuh">
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-6 py-4">
                        {{ $logs->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
        </div>
    </div>
<script>

const dateFrom    = document.getElementById('dateFrom');
const dateTo      = document.getElementById('dateTo');
const rangeSelect = document.getElementById('rangeSelect');

[dateFrom, dateTo].forEach(el => {
    el.addEventListener('change', () => {
        if (dateFrom.value || dateTo.value) rangeSelect.value = '';
    });
});

rangeSelect.addEventListener('change', () => {
    if (rangeSelect.value) { dateFrom.value = ''; dateTo.value = ''; }
});

document.querySelector("select[name='building']").addEventListener('change', () => {
    document.querySelector("select[name='floor']").value = '';
});
(function() {
    const imgs = document.querySelectorAll('img.log-img[data-src]');
    if (!imgs.length) return;

    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                obs.unobserve(img);
            });
        }, { rootMargin: '200px 0px' });

        imgs.forEach(img => io.observe(img));
    } else {
        imgs.forEach(img => { img.src = img.dataset.src; });
    }
})();
</script>
</x-app-layout>