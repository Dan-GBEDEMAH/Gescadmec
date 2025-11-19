<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 p-6">
        <div class="mb-10">
            <h1 class="text-center font-semibold text-lg">Gescadmec</h1>
            <p class="text-center text-xs text-gray-400">Portail d'inscription</p>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-blue-500">Tableau de bord</a>
            <a href="{{ route('etudiants.index') }}" class="block py-2 px-3 rounded hover:bg-blue-500">Étudiants</a>
            <a href="{{ route('paiements.index') }}" class="block py-2 px-3 rounded bg-blue-600">Paiements</a>
            <a href="{{ route('besoins.index') }}" class="block py-2 px-3 rounded hover:bg-blue-500">Besoins</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-10">
            @csrf
            <button type="submit" class="w-full py-2 bg-red-600 rounded hover:bg-red-700">Déconnexion</button>
        </form>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-8">
<div class="max-w-lg mx-auto bg-gray-800 p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Enregistrer un paiement</h2>

    <form action="{{ route('paiements.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-300">Étudiant</label>
            <p class="text-gray-200">{{ $etudiant->prenom }} {{ $etudiant->nom }}</p>
        </div>

        <div>
            <label class="block text-gray-300">Inscription</label>
            <select name="inscription_id" class="w-full p-2 rounded bg-gray-700 text-white" required>
                @forelse($etudiant->inscriptions as $ins)
                    <option value="{{ $ins->id }}">Inscription #{{ $ins->id }} (Total: {{ number_format($ins->montant_total, 0, ',', ' ') }} | Versé: {{ number_format($ins->montant_verse, 0, ',', ' ') }})</option>
                @empty
                    <option value="">Aucune inscription disponible</option>
                @endforelse
            </select>
        </div>

        <div>
            <label class="block text-gray-300">Montant versé</label>
            <input type="number" step="0.01" name="montant_verse" class="w-full p-2 rounded bg-gray-700 text-white" required />
        </div>

        <button type="submit" class="bg-green-600 px-4 py-2 rounded">Valider et générer le reçu</button>
    </form>
</div>
    </main>
</body>
</html>
