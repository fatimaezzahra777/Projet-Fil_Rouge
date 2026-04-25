<x-app-layout>
    @php
        $currentUser = auth()->user();
        $contact = $contact ?? [
            'id' => 1,
            'name' => 'Association Entraide Plus',
            'role' => 'association',
        ];

        $messages = collect($messages ?? [
            [
                'sender_id' => $contact['id'],
                'sender_name' => $contact['name'],
                'message' => 'Bonjour. Nous avons bien recu votre message. Voulez-vous participer au prochain atelier de groupe ?',
                'created_at' => now()->subHours(3),
            ],
            [
                'sender_id' => $currentUser?->id,
                'sender_name' => trim(($currentUser->prenom ?? '') . ' ' . ($currentUser->nom ?? '')),
                'message' => 'Bonjour, oui avec plaisir. Est-ce que je peux venir accompagne ?',
                'created_at' => now()->subHours(2),
            ],
            [
                'sender_id' => $contact['id'],
                'sender_name' => $contact['name'],
                'message' => 'Oui, bien sur. Merci de nous prevenir a l avance pour preparer l accueil dans de bonnes conditions.',
                'created_at' => now()->subMinutes(35),
            ],
        ]);

        $contactInitials = strtoupper(
            collect(explode(' ', $contact['name'] ?? 'Contact'))
                ->filter()
                ->take(2)
                ->map(fn ($part) => mb_substr($part, 0, 1))
                ->implode('')
        );
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Conversation</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Suivez la discussion et envoyez vos messages dans une interface simple et lisible.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a
                    href="{{ route('messages.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Retour aux conversationsèyt
                </a>
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-800"
                >
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-5 py-4">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-base font-semibold text-emerald-700">
                                {{ $contactInitials ?: 'C' }}
                            </div>

                            <div>
                                <h2 class="text-base font-semibold text-gray-900">{{ $contact['name'] ?? 'Contact' }}</h2>
                                <p class="text-xs text-gray-500">
                                    @if (($contact['role'] ?? null) === 'association')
                                        Association
                                    @elseif (($contact['role'] ?? null) === 'patient')
                                        Patient
                                    @else
                                        Utilisateur
                                    @endif
                                </p>
                            </div>
                        </div>

                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-medium text-emerald-700">
                            Conversation active
                        </span>
                    </div>
                </div>

                <div class="space-y-4 bg-gray-50 px-5 py-5 min-h-[300px] max-h-[420px] overflow-y-auto">
                    <div class="flex justify-center">
                        <span class="rounded-full border border-gray-200 bg-white px-3 py-1 text-[11px] font-medium uppercase tracking-wide text-gray-500">
                            Aujourd hui
                        </span>
                    </div>

                    @forelse ($messages as $message)
                        @php
                            $isSelf = (int) ($message['sender_id'] ?? 0) === (int) ($currentUser?->id ?? 0);
                            $time = $message['created_at'] instanceof \Carbon\CarbonInterface
                                ? $message['created_at']->format('H:i')
                                : \Illuminate\Support\Carbon::parse($message['created_at'])->format('H:i');
                        @endphp

                        <div class="flex {{ $isSelf ? 'justify-end' : 'justify-start' }}">
                            <div class="w-fit max-w-[18%] rounded-2xl px-3 py-1 shadow-sm {{ $isSelf ? 'bg-emerald-700 text-white rounded-br-md' : 'border border-gray-200 bg-white text-gray-900 rounded-bl-md' }}">
                                
                                <div class="whitespace-pre-wrap break-words text-15 leading-1">
                                    {{ $message['message'] ?? '' }}
                                </div>
                                <div class="text-right text-[10px] {{ $isSelf ? 'text-emerald-100' : 'text-gray-400' }}">
                                    {{ $time }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-300 bg-white px-6 py-10 text-center">
                            <p class="text-sm font-medium text-gray-900">Conversation vide</p>
                            <p class="mt-2 text-sm text-gray-500">
                                Les messages apparaitront ici une fois la conversation demarree.
                            </p>
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-gray-100 bg-white px-5 py-4">
                    <form method="POST" action="{{ route('messages.store', $contact['id'] ?? 1) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="message" class="sr-only">Message</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="3"
                                placeholder="Ecrire un message bienveillant, clair et confidentiel..."
                                class="block w-full rounded-2xl border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >{{ old('message') }}</textarea>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-emerald-800"
                            >
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
