<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Besoins des étudiants - Gescadmec</title>
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
            <a href="{{ route('etudiants.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-user-graduate mr-3"></i> Étudiants
            </a>
            <a href="{{ route('paiements.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-money-bill-wave mr-3"></i> Paiements
            </a>
            <a href="{{ route('besoins.index') }}" class="flex items-center py-3 px-4 rounded-lg bg-blue-600 text-white">
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
        <h2 class="text-3xl font-bold text-white">Besoins des étudiants</h2>
    </div>

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
        <div class="flex items-center mb-6">
            <i class="fas fa-plus-circle text-blue-400 mr-3 text-xl"></i>
            <h3 class="text-xl font-semibold">Ajouter un besoin</h3>
        </div>
        <form action="{{ route('besoins.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-gray-300 mb-2 font-medium">Étudiant</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-500"></i>
                    </div>
                    <select name="etudiant_id" class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach($etudiants as $etudiant)
                            <option value="{{ $etudiant->id }}">{{ $etudiant->prenom }} {{ $etudiant->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-gray-300 mb-2 font-medium">Description du besoin</label>
                <div class="relative">
                    <div class="absolute top-3 left-3">
                        <i class="fas fa-align-left text-gray-500"></i>
                    </div>
                    <textarea name="description" rows="4" class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex: Inscription au cours Excel, demande d'attestation..."></textarea>
                </div>
            </div>
            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition flex items-center shadow-lg">
                <i class="fas fa-save mr-2"></i> Enregistrer le besoin
            </button>
        </form>
    </div>

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <div class="flex items-center mb-6">
            <i class="fas fa-tasks text-blue-400 mr-3 text-xl"></i>
            <h3 class="text-xl font-semibold">Liste des besoins</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-700 text-gray-200">
                    <tr>
                        <th class="p-4">Étudiant</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($besoins as $besoin)
                        <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                    {{ $besoin->etudiant->prenom }} {{ $besoin->etudiant->nom }}
                                </div>
                            </td>
                            <td class="p-4">{{ $besoin->description }}</td>
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar text-xs"></i>
                                    </div>
                                    {{ $besoin->created_at->format('d/m/Y') }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-clipboard-list text-4xl text-gray-600 mb-4"></i>
                                    <h3 class="text-xl font-medium mb-2">Aucun besoin enregistré</h3>
                                    <p class="text-gray-500">Utilisez le formulaire ci-dessus pour ajouter un besoin</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $besoins->links() }}
        </div>
    </div>
    </main>
</body>
</html>