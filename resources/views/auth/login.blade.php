<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gescadmec</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-100 to-gray-300">
    <div class="flex w-full max-w-6xl h-screen shadow-2xl rounded-none overflow-hidden">
        <!-- Section formulaire -->
        <div class="w-1/2 bg-white p-12 flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full">
                <div class="text-center mb-10">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Connexion à votre compte</h2>
                    <p class="text-gray-600 mt-2">Bienvenue ! Connectez-vous pour accéder à votre espace personnel</p>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 mb-6 rounded-lg border border-red-200 flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
                        <div>
                            <strong>Erreur de connexion</strong>
                            <p class="text-sm mt-1">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" required 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" required 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 shadow-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center text-gray-600">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2">Se souvenir de moi</span>
                        </label>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm transition duration-200 flex items-center">
                            <i class="fas fa-question-circle mr-1"></i> Mot de passe oublié ?
                        </a>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-300 font-semibold shadow-lg flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                    </button>
                </form>
            </div>
        </div>

        <!-- Section logo + slogan -->
        <div class="w-1/2 flex flex-col items-center justify-center text-white p-12" style="background: linear-gradient(135deg, #6984a3 0%, #4a678a 100%);">
            <div class="text-center max-w-md">
                <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-white text-4xl"></i>
                </div>
                <h1 class="text-4xl font-bold mb-6">Gescadmec</h1>
                <p class="text-xl mb-8 leading-relaxed italic">
                    "Apprendre une langue, c'est ouvrir une fenêtre sur le monde"
                </p>
                <div class="mt-8 pt-6 border-t border-blue-200 border-opacity-30">
                    <p class="text-blue-100 text-sm">
                        Tous droits réservés © Gescadmec 2025
                    </p>
                    <p class="text-blue-200 text-xs mt-1">
                        Design by GBEDEMAH Daniel
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>