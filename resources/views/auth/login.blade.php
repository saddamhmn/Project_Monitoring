<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-semibold tracking-widest text-cyan-400/80 uppercase">
                Email
            </label>
            <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    required autofocus autocomplete="username"
                    class="w-full bg-[#0a1628]/80 border border-cyan-500/20 text-gray-100 text-sm rounded-lg
                           px-4 py-3 pl-10
                           placeholder-gray-600
                           focus:outline-none focus:border-cyan-400/60 focus:ring-1 focus:ring-cyan-400/30
                           transition-all duration-200">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-cyan-500/50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>
            @error('email')
                <p class="text-xs text-red-400 flex items-center gap-1 mt-1">
                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2z"/><rect x="11" y="8" width="2" height="6" fill="white"/><rect x="11" y="16" width="2" height="2" fill="white"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="space-y-1.5">
            <label for="password" class="block text-xs font-semibold tracking-widest text-cyan-400/80 uppercase">
                Password
            </label>
            <div class="relative">
                <input id="password" type="password" name="password"
                    required autocomplete="current-password"
                    class="w-full bg-[#0a1628]/80 border border-cyan-500/20 text-gray-100 text-sm rounded-lg
                           px-4 py-3 pl-10
                           placeholder-gray-600
                           focus:outline-none focus:border-cyan-400/60 focus:ring-1 focus:ring-cyan-400/30
                           transition-all duration-200">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-cyan-500/50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            @error('password')
                <p class="text-xs text-red-400 flex items-center gap-1 mt-1">
                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2z"/><rect x="11" y="8" width="2" height="6" fill="white"/><rect x="11" y="16" width="2" height="2" fill="white"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="pt-2">
            <button type="submit"
                class="w-full relative py-3 rounded-lg text-sm font-bold tracking-widest uppercase
                       text-[#0a1628] bg-cyan-400
                       hover:bg-cyan-300
                       shadow-[0_0_20px_rgba(34,211,238,0.35)]
                       hover:shadow-[0_0_30px_rgba(34,211,238,0.55)]
                       transition-all duration-300 overflow-hidden group">
                <span class="relative z-10">Log In</span>
            </button>
        </div>
    </form>
</x-guest-layout>