<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil étudiant - Gescadmec</title>
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
            <a href="{{ route('etudiants.index') }}" class="block py-2 px-3 rounded bg-blue-600">Étudiants</a>
            <a href="{{ route('paiements.index') }}" class="block py-2 px-3 rounded hover:bg-blue-500">Paiements</a>
            <a href="{{ route('besoins.index') }}" class="block py-2 px-3 rounded hover:bg-blue-500">Besoins</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-10">
            @csrf
            <button type="submit" class="w-full py-2 bg-red-600 rounded hover:bg-red-700">Déconnexion</button>
        </form>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Profil de l'étudiant</h2>
            <a href="{{ route('etudiants.index') }}" class="bg-gray-700 px-4 py-2 rounded">Retour à la liste</a>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-xl font-semibold mb-4 text-[#e8ded1]">Informations personnelles</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-400 text-sm">Nom complet</p>
                    <p class="text-lg font-semibold">{{ $etudiant->prenom }} {{ $etudiant->nom }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Téléphone</p>
                    <p class="text-lg">{{ $etudiant->telephone ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Date de naissance</p>
                    <p class="text-lg">{{ $etudiant->date_naissance ?? 'Non renseignée' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Niveau</p>
                    <p class="text-lg">{{ $etudiant->niveau ?? 'Non défini' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-400 text-sm">Adresse</p>
                    <p class="text-lg">{{ $etudiant->adresse ?? 'Non renseignée' }}</p>
                </div>
            </div>
        </div>

        <!-- Résumé financier -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-xl font-semibold mb-4 text-[#e8ded1]">Résumé financier global</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-900 p-4 rounded">
                    <p class="text-gray-400 text-sm">Total dû</p>
                    <p class="text-2xl font-bold">{{ number_format($totalDu, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="bg-green-900 p-4 rounded">
                    <p class="text-gray-400 text-sm">Total versé</p>
                    <p class="text-2xl font-bold text-green-400">{{ number_format($totalVerse, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="bg-red-900 p-4 rounded">
                    <p class="text-gray-400 text-sm">Reste à payer</p>
                    <p class="text-2xl font-bold text-red-400">{{ number_format($totalReste, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <!-- Inscriptions et paiements -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-xl font-semibold mb-4 text-[#e8ded1]">Inscriptions et paiements</h3>
            @forelse($etudiant->inscriptions as $inscription)
                <div class="bg-gray-700 p-4 rounded mb-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="font-semibold">Inscription #{{ $inscription->id }}</p>
                            <p class="text-sm text-gray-400">Session: {{ optional($inscription->sessionCours)->statut_session ?? 'N/A' }}</p>
                        </div>
                        @php
                            // Calculer le total réel des paiements depuis la base de données
                            $totalPaiements = $inscription->paiements->sum('montant_verse');
                            $resteReel = max(0, $inscription->montant_total - $totalPaiements);
                            
                            $statusClass = 'bg-red-600';
                            $statusText = 'Non payé';
                            if ($inscription->montant_total > 0 && $resteReel <= 0) {
                                $statusClass = 'bg-green-600';
                                $statusText = 'Payé';
                            } elseif ($totalPaiements > 0) {
                                $statusClass = 'bg-yellow-600';
                                $statusText = 'Partiel';
                            }
                        @endphp
                        <span class="px-3 py-1 rounded text-sm {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-4 mb-3">
                        <div>
                            <p class="text-xs text-gray-400">Montant total</p>
                            <p class="font-semibold">{{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Versé</p>
                            <p class="font-semibold text-green-400">{{ number_format($totalPaiements, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Reste</p>
                            <p class="font-semibold text-red-400">{{ number_format($resteReel, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                    
                    @if($inscription->paiements->count() > 0)
                        <details class="mt-3">
                            <summary class="cursor-pointer text-sm text-blue-400 hover:underline">Voir les {{ $inscription->paiements->count() }} paiement(s)</summary>
                            <div class="mt-2 space-y-2">
                                @foreach($inscription->paiements as $paiement)
                                    <div class="bg-gray-600 p-2 rounded flex justify-between text-sm">
                                        <span>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y H:i') }}</span>
                                        <span class="font-semibold">{{ number_format($paiement->montant_verse, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @else
                        <p class="text-sm text-gray-400 mt-2">Aucun paiement enregistré</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-400">Aucune inscription pour cet étudiant.</p>
            @endforelse
        </div>

        <!-- Actions -->
        <div class="flex space-x-4">
            <button id="openEnrollModal" class="bg-yellow-600 px-6 py-3 rounded hover:bg-yellow-700">
                Ajouter une inscription
            </button>
            <a href="{{ route('paiements.create', ['etudiant' => $etudiant->id]) }}" class="bg-green-600 px-6 py-3 rounded hover:bg-green-700">
                Enregistrer un paiement
            </a>
            <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="bg-blue-600 px-6 py-3 rounded hover:bg-blue-700">
                Modifier l'étudiant
            </a>
            <a href="{{ route('besoins.index') }}" class="bg-purple-600 px-6 py-3 rounded hover:bg-purple-700">
                Ajouter un besoin
            </a>
        </div>

        <!-- Modal: Ajouter une inscription -->
        <div id="enrollModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
            <div class="bg-gray-800 p-6 rounded-lg w-full max-w-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Ajouter une inscription</h3>
                    <button id="closeEnrollModal" class="text-gray-400 hover:text-white">&times;</button>
                </div>
                <form action="{{ route('etudiants.inscriptions.store', $etudiant->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-300">Session de cours</label>
                        <select name="sessioncours_id" class="w-full p-2 rounded bg-gray-700 text-white" required>
                            @forelse($sessions as $sess)
                                <option value="{{ $sess->id }}">
                                    Session #{{ $sess->id }} ({{ $sess->date_debut }} → {{ $sess->date_fin }}) - {{ optional($sess->niveau)->profil }}
                                </option>
                            @empty
                                <option value="">Aucune session disponible</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-300">Montant total</label>
                        <input type="number" step="0.01" name="montant_total" class="w-full p-2 rounded bg-gray-700 text-white" required />
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelEnroll" class="bg-gray-600 px-4 py-2 rounded">Annuler</button>
                        <button type="submit" class="bg-yellow-600 px-4 py-2 rounded">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            (function(){
                const openBtn = document.getElementById('openEnrollModal');
                const modal = document.getElementById('enrollModal');
                const closeBtn = document.getElementById('closeEnrollModal');
                const cancelBtn = document.getElementById('cancelEnroll');
                const toggle = (show) => {
                    if (show) { modal.classList.remove('hidden'); modal.classList.add('flex'); }
                    else { modal.classList.add('hidden'); modal.classList.remove('flex'); }
                };
                openBtn && openBtn.addEventListener('click', () => toggle(true));
                closeBtn && closeBtn.addEventListener('click', () => toggle(false));
                cancelBtn && cancelBtn.addEventListener('click', () => toggle(false));
            })();
        </script>
    </main>
</body>
</html>
