<nav x-data="{ open: false }" class="border-b border-white/60 bg-white/80 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            <div class="flex items-center gap-8">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#235347] text-white shadow-sm">
                                <x-application-logo class="block h-6 w-auto fill-current text-white" />
                            </div>
                            <div class="hidden sm:block">
                                <div class="font-['Playfair_Display'] text-lg font-bold text-[#0D1F1E]">Second<span class="text-[#235347]">Chance</span></div>
                                <div class="text-xs uppercase tracking-[0.18em] text-[#7A9E93]">Espace securise</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="hidden items-center gap-2 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @auth
                        @if (auth()->user()->hasRole('patient') || auth()->user()->hasRole('association'))
                            <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                                {{ __('Messagerie') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-full border border-[#D9E8E0] bg-white px-3 py-2 text-sm font-medium text-[#3A5A52] shadow-sm transition hover:border-[#8EB69B] hover:text-[#235347] focus:outline-none">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#DAF1DE] text-sm font-semibold text-[#235347]">
                                @auth
                                    {{ strtoupper(substr(auth()->user()->prenom ?? auth()->user()->email ?? 'U', 0, 1) . substr(auth()->user()->nom ?? '', 0, 1)) ?: 'U' }}
                                @else
                                    U
                                @endauth
                            </div>
                            <div class="text-left leading-tight">
                                <div class="text-sm font-semibold text-[#0D1F1E]">
                                    @auth
                                        {{ trim((auth()->user()->prenom ?? '') . ' ' . (auth()->user()->nom ?? '')) ?: auth()->user()->email }}
                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}">Login</a>
                                    @endguest
                                </div>
                                @auth
                                    <div class="text-xs text-[#7A9E93]">{{ ucfirst(auth()->user()->role ?? 'Utilisateur') }}</div>
                                @endauth
                            </div>

                            <div class="ms-1 text-[#7A9E93]">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-[#3A5A52] hover:bg-[#DAF1DE] hover:text-[#235347] focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 px-4 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @auth
                @if (auth()->user()->hasRole('patient') || auth()->user()->hasRole('association'))
                    <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                        {{ __('Messagerie') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="border-t border-[#E3ECE7] px-4 pb-4 pt-4">
            <div class="px-4">
                <div class="font-medium text-base text-[#0D1F1E]">@auth
                                                                    {{ trim((auth()->user()->prenom ?? '') . ' ' . (auth()->user()->nom ?? '')) ?: auth()->user()->email }}
                                                                @endauth

                                                                @guest
                                                                    <a href="{{ route('login') }}">Login</a>
                                                                @endguest</div>
                <div class="font-medium text-sm text-[#7A9E93]">@auth
                                                                    {{ auth()->user()->email }}
                                                                @endauth

                                                                @guest
                                                                    <a href="{{ route('login') }}">Login</a>
                                                                @endguest</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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
</nav>
