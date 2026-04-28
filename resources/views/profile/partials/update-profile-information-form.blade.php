<section>
    <header>
        <div class="inline-flex rounded-full bg-[#DAF1DE] px-3 py-1 text-[0.72rem] font-bold uppercase tracking-[0.18em] text-[#235347]">
            Informations
        </div>

        <h2 class="mt-4 font-['Playfair_Display'] text-2xl font-bold text-[#0D1F1E]">
            Informations du profil
        </h2>

        <p class="mt-2 text-sm leading-7 text-[#6B7D75]">
            Mettez à jour les informations principales de votre compte et votre adresse email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="prenom" :value="__('Prenom')" class="text-sm font-semibold text-[#0D1F1E]" />
                <x-text-input id="prenom" name="prenom" type="text" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('prenom', $user->prenom)" required autofocus autocomplete="given-name" />
                <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
            </div>

            <div>
                <x-input-label for="nom" :value="__('Nom')" class="text-sm font-semibold text-[#0D1F1E]" />
                <x-text-input id="nom" name="nom" type="text" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('nom', $user->nom)" required autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('nom')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Adresse email')" class="text-sm font-semibold text-[#0D1F1E]" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 rounded-2xl border border-[#F1E2AE] bg-[#FFF9E8] px-4 py-4">
                    <p class="text-sm text-[#7A621A]">
                        Votre adresse email n’est pas encore vérifiée.

                        <button form="send-verification" class="ml-1 font-semibold underline decoration-[#C89D22] underline-offset-4 transition hover:text-[#5F4A12] focus:outline-none focus:ring-2 focus:ring-[#E8A838] focus:ring-offset-2">
                            Renvoyer l’email de vérification
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-[#2E7D53]">
                            Un nouveau lien de vérification a été envoyé.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="telephone" :value="__('Telephone')" class="text-sm font-semibold text-[#0D1F1E]" />
                <x-text-input id="telephone" name="telephone" type="text" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('telephone', $user->telephone)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
            </div>

            <div>
                <x-input-label for="ville" :value="__('Ville')" class="text-sm font-semibold text-[#0D1F1E]" />
                <x-text-input id="ville" name="ville" type="text" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('ville', $user->ville)" autocomplete="address-level2" />
                <x-input-error class="mt-2" :messages="$errors->get('ville')" />
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="date_naissance" :value="__('Date de naissance')" class="text-sm font-semibold text-[#0D1F1E]" />
                <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('date_naissance', $user->date_naissance)" />
                <x-input-error class="mt-2" :messages="$errors->get('date_naissance')" />
            </div>

            <div>
                <x-input-label for="genre" :value="__('Genre')" class="text-sm font-semibold text-[#0D1F1E]" />
                <select id="genre" name="genre" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]">
                    <option value="">Selectionner</option>
                    <option value="Homme" @selected(old('genre', $user->genre) === 'Homme')>Homme</option>
                    <option value="Femme" @selected(old('genre', $user->genre) === 'Femme')>Femme</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('genre')" />
            </div>
        </div>

        @if ($user->hasRole('patient'))
            <div>
                <x-input-label for="type_addiction" :value="__('Type d addiction')" class="text-sm font-semibold text-[#0D1F1E]" />
                <x-text-input id="type_addiction" name="type_addiction" type="text" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('type_addiction', $user->patient?->type_addiction)" />
                <x-input-error class="mt-2" :messages="$errors->get('type_addiction')" />
            </div>
        @endif

        @if ($user->hasRole('medecin'))
            <div>
                <x-input-label for="specialite" :value="__('Specialite')" class="text-sm font-semibold text-[#0D1F1E]" />
                <x-text-input id="specialite" name="specialite" type="text" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('specialite', $user->medecin?->specialite)" />
                <x-input-error class="mt-2" :messages="$errors->get('specialite')" />
            </div>
        @endif

        @if ($user->hasRole('association'))
            <div class="grid gap-6">
                <div>
                    <x-input-label for="association_nom" :value="__('Nom de l association')" class="text-sm font-semibold text-[#0D1F1E]" />
                    <x-text-input id="association_nom" name="association_nom" type="text" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]" :value="old('association_nom', $user->association?->nom)" />
                    <x-input-error class="mt-2" :messages="$errors->get('association_nom')" />
                </div>

                <div>
                    <x-input-label for="association_description" :value="__('Description')" class="text-sm font-semibold text-[#0D1F1E]" />
                    <textarea id="association_description" name="association_description" rows="4" class="mt-2 block w-full rounded-2xl border-[#D6E2DB] bg-[#FBFDFC] px-4 py-3 text-[#0D1F1E] shadow-none focus:border-[#8EB69B] focus:ring-[#8EB69B]">{{ old('association_description', $user->association?->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('association_description')" />
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-full bg-[#235347] px-6 py-3 text-sm font-bold text-white shadow-none hover:bg-[#1B4338] focus:bg-[#1B4338] active:bg-[#16362E]">
                Enregistrer
            </x-primary-button>

            @if (session('status') === 'profile-updated')
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
