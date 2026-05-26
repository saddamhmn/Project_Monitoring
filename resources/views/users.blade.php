<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manajemen User</h2>
            <button id="btnToggleForm" type="button"
                class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium transition">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah User
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-600 dark:text-red-400 text-sm">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-600 dark:text-red-400 text-sm">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mt-0.5 flex-shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <ul class="space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            {{-- Form Tambah User --}}
            <div id="formTambah" class="hidden bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-white/10 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Tambah User Baru</h3>
                    </div>
                    <button id="btnCloseForm" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">✕</button>
                </div>
                <div class="p-6">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap"
                                    class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com"
                                    class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" placeholder="Min. 6 karakter"
                                    class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Role <span class="text-red-500">*</span></label>
                                <select name="role" class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="manajer" {{ old('role')=='manajer' ? 'selected':'' }}>Manajer</option>
                                    <option value="superadmin"   {{ old('role')=='superadmin'   ? 'selected':'' }}>Super Admin</option>
                                    <option value="petugas" {{ old('role')=='petugas' ? 'selected':'' }}>Petugas</option>
                                    <option value="security" {{ old('role')=='security' ? 'selected':'' }}>Security</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Foto Profil <span class="text-gray-400">(opsional)</span></label>
                                <input type="file" name="avatar" accept="image/*"
                                    class="w-full text-sm text-gray-600 dark:text-gray-300 file:mr-2 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-1.5 file:text-white file:text-xs file:cursor-pointer">
                                @error('avatar')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="flex items-center gap-2 px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium transition">
                                Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-white/10 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-600/20 flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Daftar User</h3>
                        <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-white/5 px-2.5 py-1 rounded-full">{{ $users->total() }} user</span>
                        <form method="GET" id="perPageFormUser" class="flex items-center gap-2 ml-auto">
                            @foreach(request()->except('per_page', 'page') as $key => $val)
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endforeach
                            <label class="text-xs text-gray-500 dark:text-gray-400">Tampilkan</label>
                            <select name="per_page" onchange="document.getElementById('perPageFormUser').submit()"
                                class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900
                                    text-gray-800 dark:text-gray-200 rounded-lg pl-2 pr-7 py-1.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach([10, 25, 50, 100] as $n)
                                    <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                            <label class="text-xs text-gray-500 dark:text-gray-400">data</label>
                        </form>
                    </div>

                    {{-- Search & Filter --}}
                    <form method="GET" class="flex items-center gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                            class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-52">
                        <select name="role" class="border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg pl-2 pr-7 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Role</option>
                            <option value="manajer" {{ request('role')=='manajer' ? 'selected':'' }}>Manajer</option>
                            <option value="superadmin"   {{ request('role')=='superadmin'   ? 'selected':'' }}>Super Admin</option>
                            <option value="petugas" {{ request('role')=='petugas' ? 'selected':'' }}>Petugas</option>
                        </select>
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-sm transition">Cari</button>
                        @if(request('search') || request('role'))
                            <a href="{{ route('users.index') }}" class="px-3 py-1.5 rounded-lg bg-gray-500 hover:bg-gray-400 text-white text-sm transition">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bergabung</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $users->firstItem() + $loop->index }}</td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="relative flex-shrink-0">
                                                @if($user->avatar)
                                                    <img src="{{ Storage::url($user->avatar) }}" class="w-9 h-9 rounded-full object-cover border-2 border-gray-200 dark:border-white/10">
                                                @else
                                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                @if($user->isOnline())
                                                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white dark:border-gray-800"></span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                                                    {{ $user->name }}
                                                    @if($user->id === auth()->id())
                                                        <span class="text-xs px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-300">Anda</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>

                                    <td class="px-6 py-4">
                                        @php
                                            $roleColors = [
                                                'manajer' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300',
                                                'superadmin'   => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                                'petugas' => 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300',
                                                'security'   => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300',
                                            ];
                                            $color = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize {{ $color }}">{{ $user->role }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($user->isOnline())
                                            <span class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-medium">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Online
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1.5 text-xs text-gray-400">
                                                <span class="w-2 h-2 rounded-full bg-gray-400"></span> Offline
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->avatar ? Storage::url($user->avatar) : '' }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 dark:bg-amber-500/10 dark:hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 text-xs font-medium transition">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                Edit
                                            </button>

                                            @if($user->id !== auth()->id())
                                                <button type="button"
                                                    onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 text-xs font-medium transition">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                                    Hapus
                                                </button>
                                            @else
                                                <span class="px-3 py-1.5 text-xs text-gray-400 dark:text-gray-500 cursor-not-allowed" title="Tidak dapat menghapus akun aktif">—</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                        <svg class="mx-auto mb-3 opacity-40" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                        Tidak ada user ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-white/10">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Edit User --}}
    <div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="relative z-10 w-full max-w-lg mx-4 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Edit User</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">✕</button>
            </div>
            <form id="formEdit" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf @method('PUT')

                <div class="flex items-center gap-4 mb-2">
                    <div id="editAvatarPreviewWrap" class="w-14 h-14 rounded-full overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                        <img id="editAvatarPreview" src="" class="hidden w-full h-full object-cover">
                        <span id="editAvatarInitial"></span>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Ganti Foto <span class="text-gray-400">(opsional)</span></label>
                        <input type="file" name="avatar" id="editAvatarInput" accept="image/*"
                            class="w-full text-sm text-gray-600 dark:text-gray-300 file:mr-2 file:rounded-lg file:border-0 file:bg-amber-600 file:px-3 file:py-1.5 file:text-white file:text-xs file:cursor-pointer">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="editName" required
                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="editEmail" required
                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Role <span class="text-red-500">*</span></label>
                        <select name="role" id="editRole"
                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="manajer">Manajer</option>
                            <option value="superadmin">Super Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="security">Security</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Password Baru <span class="text-gray-400">(opsional)</span></label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                            class="w-full rounded-lg border border-gray-300 dark:border-white/10 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 rounded-lg border border-gray-300 dark:border-white/10 text-gray-700 dark:text-gray-300 text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black text-sm font-semibold transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
        {{-- Modal Konfirmasi Hapus --}}
    <div id="modalDelete" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="relative z-10 w-full max-w-sm mx-4 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-white/10 overflow-hidden
                    transition-all duration-200 scale-95 opacity-0" id="modalDeletePanel">

            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center flex-shrink-0">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6M14 11v6"/>
                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Hapus User</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            Hapus <span id="deleteUserName" class="font-semibold text-gray-900 dark:text-white"></span>?
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>

                <form id="formDelete" method="POST">
                    @csrf @method('DELETE')
                    <div class="flex gap-2">
                        <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-white/10 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white text-sm font-semibold transition">
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<style>
@media (max-width: 767px) {
    .grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-5 {
        grid-template-columns: 1fr !important;
    }

    .px-6.py-4.border-b.flex.flex-wrap.items-center.justify-between.gap-3 {
        flex-direction: column !important;
        align-items: flex-start !important;
    }

    #perPageFormUser,
    .px-6.py-4 form.flex.items-center.gap-2 {
        width: 100% !important;
        flex-wrap: wrap !important;
    }

  
    .px-6.py-4 form input[type="text"] {
        width: 100% !important;
    }


    .flex.items-center.justify-center.gap-2 {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 0.25rem !important;
    }

    table thead tr th:nth-child(5),
    table tbody tr td:nth-child(5),
    table thead tr th:nth-child(6),
    table tbody tr td:nth-child(6) {
        display: none !important;
    }


    .overflow-x-auto { -webkit-overflow-scrolling: touch; }
}
</style>
    <script>
        const formTambah  = document.getElementById('formTambah');
        const btnToggle   = document.getElementById('btnToggleForm');
        const btnClose    = document.getElementById('btnCloseForm');

        btnToggle.addEventListener('click', () => {
            formTambah.classList.toggle('hidden');
            formTambah.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
        btnClose.addEventListener('click', () => formTambah.classList.add('hidden'));


        @if($errors->any())
            formTambah.classList.remove('hidden');
        @endif


        const modalEdit = document.getElementById('modalEdit');

        function openEditModal(id, name, email, role, avatarUrl) {
            document.getElementById('formEdit').action = `/users/${id}`;
            document.getElementById('editName').value  = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value  = role;

            const preview = document.getElementById('editAvatarPreview');
            const initial = document.getElementById('editAvatarInitial');

            if (avatarUrl) {
                preview.src = avatarUrl;
                preview.classList.remove('hidden');
                initial.classList.add('hidden');
            } else {
                preview.classList.add('hidden');
                initial.classList.remove('hidden');
                initial.textContent = name.charAt(0).toUpperCase();
            }

            modalEdit.classList.remove('hidden');
            modalEdit.classList.add('flex');
        }

        function closeEditModal() {
            modalEdit.classList.add('hidden');
            modalEdit.classList.remove('flex');
        }


        document.getElementById('editAvatarInput').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            const preview = document.getElementById('editAvatarPreview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            document.getElementById('editAvatarInitial').classList.add('hidden');
        });

  
let deleteChoice = 'cancel';

function openDeleteModal(id, name) {
    document.getElementById('formDelete').action = `/users/${id}`;
    document.getElementById('deleteUserName').textContent = name;
    deleteChoice = 'cancel';

    modalDelete.classList.remove('hidden');
    modalDelete.classList.add('flex');
    requestAnimationFrame(() => {
        modalDeletePanel.classList.remove('scale-95', 'opacity-0');
        modalDeletePanel.classList.add('scale-100', 'opacity-100');
        updateDeleteHighlight();
    });
}

function closeDeleteModal() {
    modalDeletePanel.classList.remove('scale-100', 'opacity-100');
    modalDeletePanel.classList.add('scale-95', 'opacity-0');
    document.querySelector('#formDelete button[type="button"]').style.outline = 'none';
    document.querySelector('#formDelete button[type="submit"]').style.outline  = 'none';
    deleteChoice = 'cancel';
    setTimeout(() => {
        modalDelete.classList.add('hidden');
        modalDelete.classList.remove('flex');
    }, 150);
}

function updateDeleteHighlight() {
    const cancelBtn  = document.querySelector('#formDelete button[type="button"]');
    const confirmBtn = document.querySelector('#formDelete button[type="submit"]');
    if (deleteChoice === 'cancel') {
        cancelBtn.style.outline  = '2px solid rgba(107,114,128,0.6)';
        cancelBtn.style.outlineOffset = '2px';
        confirmBtn.style.outline = 'none';
    } else {
        confirmBtn.style.outline = '2px solid #f87171';
        confirmBtn.style.outlineOffset = '2px';
        cancelBtn.style.outline  = 'none';
    }
}
        document.addEventListener('keydown', e => {
        const editOpen   = !modalEdit.classList.contains('hidden');
        const deleteOpen = !modalDelete.classList.contains('hidden');

        if (editOpen) {
            if (e.key === 'Escape') {
                closeEditModal();
            } else if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                // Enter submit form edit (kecuali di textarea)
                const activeEl = document.activeElement;
                const isBtn = activeEl?.tagName === 'BUTTON';
                if (!isBtn) {
                    e.preventDefault();
                    document.getElementById('formEdit').requestSubmit();
                }
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                document.querySelector('#formEdit button[type="submit"]')?.focus();
            } else if (e.key === 'ArrowLeft') {
                e.preventDefault();
                document.querySelector('#formEdit button[type="button"]')?.focus();
            }
            return;
        }

        if (deleteOpen) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    } else if (e.key === 'ArrowLeft') {
        e.preventDefault();
        deleteChoice = 'cancel';
        updateDeleteHighlight();
    } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        deleteChoice = 'confirm';
        updateDeleteHighlight();
    } else if (e.key === 'Enter') {
        e.preventDefault();
        if (deleteChoice === 'confirm') {
            document.querySelector('#formDelete button[type="submit"]')?.click();
        } else {
            closeDeleteModal();
        }
    }
    return;
}

    });
    </script>
</x-app-layout>