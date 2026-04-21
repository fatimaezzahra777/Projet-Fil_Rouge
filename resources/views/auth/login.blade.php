<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Second Chance</title>
    @vite('resources/css/app.css')
</head>
<body class="flex min-h-screen bg-gd font-sans">

<!-- LEFT -->
<div class="hidden md:flex w-1/2 bg-gdp relative p-16 flex-col justify-end">

    <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773"
         class="absolute inset-0 w-full h-full object-cover opacity-30"/>

    <div class="relative z-10 text-white">

        <h1 class="text-4xl font-bold mb-4">
            Chaque jour est une 
            <span class="text-gl">nouvelle chance</span>
        </h1>

        <p class="text-sm text-white/60 mb-6">
            Rejoignez notre communauté solidaire
        </p>

        <div class="flex gap-8">
            <div>
                <div class="text-gl text-xl font-bold">500+</div>
                <div class="text-xs text-white/40">Patients</div>
            </div>
            <div>
                <div class="text-gl text-xl font-bold">80+</div>
                <div class="text-xs text-white/40">Médecins</div>
            </div>
        </div>

    </div>
</div>

<!-- RIGHT -->
<div class="w-full md:w-1/2 bg-cr flex items-center justify-center p-10">

<div class="w-full max-w-md">

    <h2 class="text-2xl font-bold text-td mb-2">Connexion</h2>
    <p class="text-sm text-tm mb-6">Accédez à votre espace</p>

    <a href="{{ route('auth.google.redirect') }}" class="mb-4 flex w-full items-center justify-center gap-3 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-[#235347] hover:text-[#235347]">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5">
            <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12S17.4 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.3-.4-3.5z"/>
            <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 18.9 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
            <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.3 0-9.8-3.3-11.5-8l-6.5 5C9.3 39.6 16.1 44 24 44z"/>
            <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.1 5.6l.1-.1 6.2 5.2C37 38.4 44 33 44 24c0-1.3-.1-2.3-.4-3.5z"/>
        </svg>
        Continuer avec Google
    </a>

    <div class="mb-4 flex items-center gap-3 text-xs text-gray-400">
        <span class="h-px flex-1 bg-gray-300"></span>
        <span>ou</span>
        <span class="h-px flex-1 bg-gray-300"></span>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <input type="email" name="email"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gl outline-none"
            placeholder="Email">

        <input type="password" name="password"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gl outline-none"
            placeholder="Mot de passe">

       
         <button class="w-full bg-gm text-white py-3 rounded-full font-semibold hover:bg-gl hover:text-gd transition">
            Se connecter →
        </button>

    </form>

    <a href="{{ route('register') }}"><button class="w-full bg-white text-gd py-3 rounded-full font-semibold  transition">
            S'inscrire →
        </button></a>

</div>
</div>

</body>
</html>
