<section>
    <header>
        <div class="inline-flex rounded-full bg-[#EAF4EE] px-3 py-1 text-[0.72rem] font-bold uppercase tracking-[0.18em] text-[#235347]">
            Sécurité
        </div>

        <h2 class="mt-4 font-['Playfair_Display'] text-2xl font-bold text-[#0D1F1E]">
            Modifier le mot de passe
        </h2>

        <p class="mt-2 text-sm leading-7 text-[#6B7D75]">
            Utilisez un mot de passe long et difficile à deviner pour mieux protéger votre compte.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" class="text-sm font-semibold text-[#0D1F1E]" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" class="text-sm font-semibold text-[#0D1F1E]" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le mot de passe')" class="text-sm font-semibold text-[#0D1F1E]" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-full bg-[#235347] px-6 py-3 text-sm font-bold text-white shadow-none hover:bg-[#1B4338] focus:bg-[#1B4338] active:bg-[#16362E]">
                Mettre à jour
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-[#2E7D53]"
                >Enregistré.</p>
            @endif
        </div>
    </form>
</section>
