<x-app-layout>
    @php
        $patients = $conversations->where('role', 'patient')->values();
        $associations = $conversations->where('role', 'association')->values();
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Messagerie</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Recherchez un patient ou une association et ouvrez une conversation rapidement.
                </p>
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-800"
            >
                Retour au dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (isset($messagesTableExists) && ! $messagesTableExists)
                <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    La table <strong>messages</strong> n existe pas encore. Lance `php artisan migrate` puis recharge la page.
                </div>
            @endif

            <div class="space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Tous les contacts</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Cette page affiche les patients et les associations disponibles dans la messagerie.
                            </p>
                        </div>

                        <form method="GET" action="{{ route('messages.index') }}" class="w-full lg:max-w-md">
                            <label for="search" class="sr-only">Rechercher un contact</label>
                            <div class="flex gap-2">
                                <input
                                    id="search"
                                    name="search"
                                    type="text"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Nom, email ou role"
                                    class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                >
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800"
                                >
                                    Rechercher
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $conversations->count() }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-sm text-gray-500">Patients</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $patients->count() }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-sm text-gray-500">Associations</p>
                            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $associations->count() }}</p>
                        </div>
                    </div>

                    @if (($search ?? '') !== '')
                        <div class="mt-4 rounded-lg border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                            Resultat de recherche pour : <strong>{{ $search }}</strong>
                        </div>
                    @endif
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Patients</h3>
                            <p class="mt-1 text-sm text-gray-500">Liste des patients affiches.</p>
                        </div>
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                            {{ $patients->count() }}
                        </span>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @forelse ($patients as $conversation)
                            @php
                                $name = $conversation['name'] ?? 'Utilisateur';
                                $initials = strtoupper(
                                    collect(explode(' ', $name))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn ($part) => mb_substr($part, 0, 1))
                                        ->implode('')
                                );
                            @endphp

                            <a
                                href="{{ route('messages.show', $conversation['id'] ?? 1) }}"
                                class="block rounded-xl border border-gray-200 bg-white p-5 transition hover:border-emerald-300 hover:shadow-md"
                            >
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700">
                                        {{ $initials ?: 'P' }}
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h4 class="truncate text-base font-semibold text-gray-900">{{ $name }}</h4>
                                        <p class="mt-1 text-sm text-gray-500">{{ $conversation['email'] ?? 'Email non disponible' }}</p>
                                        <p class="mt-3 text-sm text-gray-600">
                                            {{ $conversation['preview'] ?? 'Commencer une nouvelle conversation.' }}
                                        </p>
                                        <div class="mt-4 flex items-center justify-between">
                                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                                Patient
                                            </span>
                                            @if (!empty($conversation['time']))
                                                <span class="text-xs text-gray-400">{{ $conversation['time'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="md:col-span-2 xl:col-span-3 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center">
                                <p class="text-sm font-medium text-gray-900">Aucun patient trouve.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Associations</h3>
                            <p class="mt-1 text-sm text-gray-500">Liste des associations affichees.</p>
                        </div>
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                            {{ $associations->count() }}
                        </span>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @forelse ($associations as $conversation)
                            @php
                                $name = $conversation['name'] ?? 'Association';
                                $initials = strtoupper(
                                    collect(explode(' ', $name))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn ($part) => mb_substr($part, 0, 1))
                                        ->implode('')
                                );
                            @endphp

                            <a
                                href="{{ route('messages.show', $conversation['id'] ?? 1) }}"
                                class="block rounded-xl border border-gray-200 bg-white p-5 transition hover:border-emerald-300 hover:shadow-md"
                            >
                                <div class="flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700">
                                        {{ $initials ?: 'A' }}
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h4 class="truncate text-base font-semibold text-gray-900">{{ $name }}</h4>
                                        <p class="mt-1 text-sm text-gray-500">{{ $conversation['email'] ?? 'Email non disponible' }}</p>
                                        <p class="mt-3 text-sm text-gray-600">
                                            {{ $conversation['preview'] ?? 'Commencer une nouvelle conversation.' }}
                                        </p>
                                        <div class="mt-4 flex items-center justify-between">
                                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                                Association
                                            </span>
                                            @if (!empty($conversation['time']))
                                                <span class="text-xs text-gray-400">{{ $conversation['time'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="md:col-span-2 xl:col-span-3 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center">
                                <p class="text-sm font-medium text-gray-900">Aucune association trouvee.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
