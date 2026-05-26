@php use Illuminate\Support\Facades\Storage; @endphp

<div id="avatarModal" class="fixed inset-0 z-[9999] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeAvatarModal()"></div>
    <div id="avatarModalPanel" class="relative z-10 w-full max-w-sm mx-4 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-white/10 p-6 space-y-4 transition-all duration-200 scale-95 opacity-0">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Foto Profil</h3>
            <button onclick="closeAvatarModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl leading-none">✕</button>
        </div>
        <div class="flex justify-center">
            @if(Auth::user()->avatar)
                <img src="{{ Storage::url(Auth::user()->avatar) }}"
                    class="w-24 h-24 rounded-full object-cover border-4 border-blue-400 shadow-lg">
            @else
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <form method="POST" action="{{ route('avatar.update') }}" enctype="multipart/form-data" id="avatarUploadForm">
            @csrf
            <label class="block w-full cursor-pointer">
                <div class="w-full px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold text-center transition">
                    <span id="avatarBtnText">Pilih Foto Baru</span>
                </div>
                <input type="file" name="avatar" accept="image/*" class="hidden"
                    onchange="document.getElementById('avatarBtnText').textContent = this.files[0]?.name ?? 'Pilih Foto Baru'; document.getElementById('avatarUploadForm').submit();">
            </label>
        </form>
        @if(Auth::user()->avatar)
            <form method="POST" action="{{ route('avatar.delete') }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="return"
                    class="w-full px-4 py-2.5 rounded-lg border border-red-300 dark:border-red-500/30 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 text-sm font-semibold transition">
                    Hapus Foto
                </button>
            </form>
        @endif
    </div>
</div>

<script>
function openAvatarModal() {
    const m = document.getElementById('avatarModal');
    const p = document.getElementById('avatarModalPanel');
    m.classList.remove('hidden');
    m.classList.add('flex');
    requestAnimationFrame(() => {
        p.classList.remove('scale-95', 'opacity-0');
        p.classList.add('scale-100', 'opacity-100');
    });
}
function closeAvatarModal() {
    const m = document.getElementById('avatarModal');
    const p = document.getElementById('avatarModalPanel');
    p.classList.remove('scale-100', 'opacity-100');
    p.classList.add('scale-95', 'opacity-0');
    setTimeout(() => { m.classList.add('hidden'); m.classList.remove('flex'); }, 200);
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeAvatarModal(); });
</script>