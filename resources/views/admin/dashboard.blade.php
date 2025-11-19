<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord </title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans bg-gray-900 text-gray-100 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 p-6 shadow-lg flex flex-col">
        <div class="mb-10 text-center">
            <h1 class="font-bold text-xl text-blue-400">Gescadmec</h1>
            <p class="text-xs text-gray-400 mt-1">Portail d'inscription</p>
        </div>

        <nav class="space-y-2 flex-grow">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg bg-blue-600 text-white">
                <i class="fas fa-home mr-3"></i> Tableau de bord
            </a>
            <a href="{{ route('etudiants.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-user-graduate mr-3"></i> Étudiants
            </a>
            <a href="{{ route('paiements.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-money-bill-wave mr-3"></i> Paiements
            </a>
            <a href="{{ route('besoins.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-list mr-3"></i> Besoins
            </a>
            <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-receipt mr-3"></i> Reçus
            </a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit" class="w-full py-3 bg-red-600 rounded-lg hover:bg-red-700 transition flex items-center justify-center">
                <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
            </button>
        </form>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-white">Tableau de bord</h2>
            <button class="bg-gradient-to-r from-green-500 to-green-600 px-5 py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition flex items-center shadow-lg">
                <i class="fas fa-print mr-2"></i> Imprimer un reçu
            </button>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-gradient-to-br from-blue-700 to-blue-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-600 mr-4">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <div>
                        <p class="text-blue-200 text-sm">Inscrits (mois)</p>
                        <h3 class="text-2xl font-bold">{{ $inscritsMois }}</h3>
                    </div>
                </div>
                <p class="text-xs text-blue-300 mt-2">Étudiants ajoutés ce mois</p>
            </div>

            <div class="bg-gradient-to-br from-green-700 to-green-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-600 mr-4">
                        <i class="fas fa-coins text-xl"></i>
                    </div>
                    <div>
                        <p class="text-green-200 text-sm">Total encaissé</p>
                        <h3 class="text-2xl font-bold">{{ number_format($totalEncaisse, 0, ',', ' ') }} FCFA</h3>
                    </div>
                </div>
                <p class="text-xs text-green-300 mt-2">Somme des paiements</p>
            </div>

            <div class="bg-gradient-to-br from-orange-700 to-orange-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-orange-600 mr-4">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                    <div>
                        <p class="text-orange-200 text-sm">Soldes en attente</p>
                        <h3 class="text-2xl font-bold">{{ number_format($soldesAttente, 0, ',', ' ') }} FCFA</h3>
                    </div>
                </div>
                <p class="text-xs text-orange-300 mt-2">Montant restant dû</p>
            </div>

            <div class="bg-gradient-to-br from-purple-700 to-purple-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-purple-600 mr-4">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div>
                        <p class="text-purple-200 text-sm">Sessions actives</p>
                        <h3 class="text-2xl font-bold">{{ $sessionsActives }}</h3>
                    </div>
                </div>
                <p class="text-xs text-purple-300 mt-2">Cours en cours</p>
            </div>
        </div>

        <!-- Paiements récents -->
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
            <div class="flex items-center mb-6">
                <i class="fas fa-history text-blue-400 mr-3 text-xl"></i>
                <h3 class="text-xl font-semibold">Paiements récents</h3>
            </div>

            <table class="w-full text-left">
                <thead class="text-gray-300 border-b border-gray-700">
                    <tr>
                        <th class="py-3">Étudiant</th>
                        <th>Niveau</th>
                        <th>Payé</th>
                        <th>Reste</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paiementsRecents as $paiement)
                        <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                            <td class="py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                    {{ $paiement->inscription->etudiant->prenom }} {{ $paiement->inscription->etudiant->nom }}
                                </div>
                            </td>
                            <td>{{ $paiement->inscription->etudiant->niveau ?? '-' }}</td>
                            <td class="font-semibold text-green-400">{{ number_format($paiement->montant_verse, 0, ',', ' ') }} FCFA</td>
                            <td class="font-semibold text-orange-400">{{ number_format($paiement->inscription->reste_payer, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $paiement->date_paiement->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr class="border-b border-gray-700 hover:bg-gray-750">
                            <td class="py-3 text-center" colspan="5">
                                <div class="flex flex-col items-center py-8">
                                    <i class="fas fa-inbox text-3xl text-gray-500 mb-3"></i>
                                    <p class="text-gray-400">Aucun paiement</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>