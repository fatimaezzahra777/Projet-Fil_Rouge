<section class="space-y-6">
    <header>
        <div class="inline-flex rounded-full bg-[#FDECEC] px-3 py-1 text-[0.72rem] font-bold uppercase tracking-[0.18em] text-[#A33B3B]">
            Zone sensible
        </div>

        <h2 class="mt-4 font-['Playfair_Display'] text-2xl font-bold text-[#7A1F1F]">
            Supprimer le compte
        </h2>

        <p class="mt-2 text-sm leading-7 text-[#8A4A4A]">
            Cette action est définitive. Toutes les données liées à votre compte seront supprimées de manière permanente.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-full bg-[#C84B4B] px-6 py-3 text-sm font-bold text-white shadow-none hover:bg-[#B63E3E] focus:bg-[#B63E3E] active:bg-[#9E3434]"
    >Supprimer mon compte</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-['Playfair_Display'] text-2xl font-bold text-[#7A1F1F]">
                Confirmer la suppression
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#6F5555]">
                Une fois le compte supprimé, il ne pourra pas être restauré. Saisissez votre mot de passe pour confirmer cette action.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Mot de passe') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border-[#E8C9C9] bg-[#FFF9F9] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#D66B6B] focus:ring-[#D66B6B] sm:w-3/4"
                    placeholder="{{ __('Mot de passe') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-full border-[#D8E4DD] px-5 py-3 text-[#3A5A52] shadow-none">
                    Annuler
                </x-secondary-button>

                <x-danger-button class="ms-3 rounded-full bg-[#C84B4B] px-5 py-3 text-white shadow-none hover:bg-[#B63E3E] focus:bg-[#B63E3E] active:bg-[#9E3434]">
                    Supprimer définitivement
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
