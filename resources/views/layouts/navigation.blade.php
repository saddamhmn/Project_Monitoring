@php use Illuminate\Support\Facades\Storage; @endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 backdrop-blur bg-gray-200 dark:bg-gray-800 border-b border-gray-400/50 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class=" flex items-center ">
                    <a href="{{ route('dashboard') }}">
                        <div class="relative items-center" style="width:42px;height:42px;">
                        <x-application-logo class=" text-gray-800 dark:text-gray-200" />
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')"
                        :active="request()->routeIs('dashboard') || request()->routeIs('dashboard.buildings.*')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('buildings.monitoring')"
                        :active="request()->routeIs('buildings.*')">
                        {{ __('Monitoring') }}
                    </x-nav-link>
                    @if(auth()->user()->role !== 'security')
                    <x-nav-link :href="route('logs.index')" :active="request()->routeIs('logs.index')">
                    Log CCTV
                    </x-nav-link>
                    @endif
                    @if(auth()->user()->hasRole('manajer', 'superadmin'))
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            User
                        </x-nav-link>
                    @endif
                    @if(auth()->user()->role === 'superadmin')
                        <x-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                            {{ __('Pengaturan') }}
                        </x-nav-link>
                    @endif
                                        
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            @if(Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}"
                                    onclick="event.stopPropagation(); openAvatarModal()"
                                    class="w-7 h-7 rounded-full object-cover border border-gray-300 dark:border-white/20 flex-shrink-0 cursor-pointer hover:opacity-80 transition">
                            @else
                                <div onclick="event.stopPropagation(); openAvatarModal()"
                                    class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 cursor-pointer hover:opacity-80 transition">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif

                            <span>{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>                   
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('buildings.monitoring')" :active="request()->routeIs('buildings.*')">
                        {{ __('Monitoring') }}
            </x-responsive-nav-link>

            @if(auth()->user()->role !== 'security')
            <x-responsive-nav-link :href="route('logs.index')" :active="request()->routeIs('logs.index')">
                Log CCTV
            </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('manajer', 'superadmin'))
                 <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    User
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->role === 'superadmin')
                <x-responsive-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                    {{ __('Pengaturan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 flex items-center gap-3 cursor-pointer" onclick="openAvatarModal()">
                @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}"
                    class="w-9 h-9 rounded-full object-cover border-2 border-blue-400">
                @else
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
               

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>


    <div id="topLoadingBar"
        style="position:fixed;top:0;left:0;width:100%;height:3px;z-index:99999;
            opacity:0;pointer-events:none;transition:opacity 0.15s ease;">
        <div id="topLoadingBarFill"
            style="height:100%;width:0%;background:#00e5ff;
                box-shadow:0 0 8px #00e5ff,0 0 2px #00e5ff;
                transition:width 0.4s cubic-bezier(.4,0,.2,1);">
        </div>
    </div>

<script>
window.__loadingCount = 0;

window.showLoading = function() {
    window.__loadingCount++;
    const bar  = document.getElementById('topLoadingBar');
    const fill = document.getElementById('topLoadingBarFill');
    if (bar)  bar.style.opacity = '1';
    if (fill) { fill.style.width = '0%'; requestAnimationFrame(() => { fill.style.width = '75%'; }); }
};

window.hideLoading = function() {
    window.__loadingCount = Math.max(0, window.__loadingCount - 1);
    if (window.__loadingCount > 0) return;
    const fill = document.getElementById('topLoadingBarFill');
    const bar  = document.getElementById('topLoadingBar');
    if (fill) fill.style.width = '100%';
    setTimeout(() => {
        if (bar)  bar.style.opacity = '0';
        setTimeout(() => { if (fill) fill.style.width = '0%'; }, 150);
    }, 350);
};

window.__submitting = false;

window.lockSubmit = function(btn, loadingText = 'Menyimpan...') {
    if (window.__submitting) return false;
    window.__submitting = true;
    if (btn) {
        btn._origText = btn.innerHTML;
        btn.disabled = true;
        btn.style.opacity = '0.6';
        btn.style.cursor  = 'not-allowed';
        btn.innerHTML = `<svg class="inline w-3.5 h-3.5 animate-spin mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>${loadingText}`;
    }
    return true;
};

window.unlockSubmit = function(btn) {
    window.__submitting = false;
    if (btn && btn._origText) {
        btn.disabled = false;
        btn.style.opacity = '';
        btn.style.cursor  = '';
        btn.innerHTML = btn._origText;
    }
};
</script>
</nav>
