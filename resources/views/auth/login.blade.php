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