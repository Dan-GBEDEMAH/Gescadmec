<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants - Gescadmec</title>
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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-home mr-3"></i> Tableau de bord
            </a>
            <a href="{{ route('etudiants.index') }}" class="flex items-center py-3 px-4 rounded-lg bg-blue-600 text-white">
                <i class="fas fa-user-graduate mr-3"></i> Étudiants
            </a>
            <a href="{{ route('paiements.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-money-bill-wave mr-3"></i> Paiements
            </a>
            <a href="{{ route('besoins.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-list mr-3"></i> Besoins
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
        <h2 class="text-3xl font-bold text-white">Liste des étudiants</h2>
        <a href="{{ route('etudiants.create') }}" class="bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold px-5 py-3 rounded-lg hover:from-amber-600 hover:to-amber-700 transition flex items-center shadow-lg">
            <i class="fas fa-plus mr-2"></i> Ajouter un étudiant
        </a>
    </div>

    <!-- Filtres -->
    <form method="GET" action="{{ route('etudiants.index') }}" class="mb-8 bg-gray-800 p-6 rounded-xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <label class="block text-gray-300 text-sm mb-2">Rechercher</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input type="text" name="search" placeholder="Rechercher un étudiant..." value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            <div>
                <label class="block text-gray-300 text-sm mb-2">Niveau</label>
                <select name="niveau" class="w-full py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none">
                    <option value="">Tous les niveaux</option>
                    <option value="Débutant" {{ request('niveau') == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                    <option value="Intermédiaire" {{ request('niveau') == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                    <option value="Avancé" {{ request('niveau') == 'Avancé' ? 'selected' : '' }}>Avancé</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-300 text-sm mb-2">Statut paiement</label>
                <select name="statut_paiement" class="w-full py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none">
                    <option value="">Tous</option>
                    <option value="paye" {{ request('statut_paiement') == 'paye' ? 'selected' : '' }}>Payé</option>
                    <option value="reste" {{ request('statut_paiement') == 'reste' ? 'selected' : '' }}>Reste à payer</option>
                </select>
            </div>

            <div class="flex items-end">
                <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition flex items-center justify-center shadow">
                    <i class="fas fa-filter mr-2"></i> Filtrer
                </button>
            </div>
        </div>
    </form>

    <!-- Table des étudiants -->
    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-700 text-gray-200">
                    <tr>
                        <th class="p-4">Nom complet</th>
                        <th class="p-4">Niveau</th>
                        <th class="p-4">Paiement</th>
                        <th class="p-4">Cours</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etudiants as $etudiant)
                        <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                    <span class="font-medium">{{ $etudiant->prenom }} {{ $etudiant->nom }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($etudiant->niveau)
                                    <span class="px-3 py-1 bg-blue-900 text-blue-200 rounded-full text-sm">{{ $etudiant->niveau }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @php
                                    // Calculer le total dû pour toutes les inscriptions
                                    $totalDu = $etudiant->inscriptions->sum('montant_total');
                                    
                                    // Calculer le total réellement payé en sommant tous les paiements
                                    $totalPaye = 0;
                                    foreach ($etudiant->inscriptions as $ins) {
                                        $totalPaye += $ins->paiements->sum('montant_verse');
                                    }
                                    
                                    // Calculer le reste à payer
                                    $resteTotal = max(0, $totalDu - $totalPaye);
                                @endphp
                                @if($totalDu > 0 && $resteTotal <= 0)
                                    <span class="px-3 py-1 bg-green-900 text-green-200 rounded-full text-sm">Payé</span>
                                @elseif($totalPaye > 0)
                                    <span class="px-3 py-1 bg-yellow-900 text-yellow-200 rounded-full text-sm">Partiel</span>
                                @else
                                    <span class="px-3 py-1 bg-red-900 text-red-200 rounded-full text-sm">Non payé</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if(optional($etudiant->inscriptions->first())->sessionCours->nom_cours)
                                    <span class="px-3 py-1 bg-purple-900 text-purple-200 rounded-full text-sm">
                                        {{ optional($etudiant->inscriptions->first())->sessionCours->nom_cours }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Aucun</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('etudiants.show', $etudiant->id) }}" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="p-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('paiements.create', ['etudiant' => $etudiant->id]) }}" class="p-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" title="Paiement">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </a>
                                    <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-4xl text-gray-600 mb-4"></i>
                                    <h3 class="text-xl font-medium mb-2">Aucun étudiant trouvé</h3>
                                    <p class="text-gray-500">Essayez de modifier vos filtres ou ajoutez un nouvel étudiant</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </main>
</body>
</html>