<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants - Gescadmec</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<div class="p-8 text-white">

    <!-- Titre -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Étudiant ajouté avec succès </h2>
        <a href="{{ route('etudiants.index') }}" 
           class="bg-[#e8ded1] text-[#3d3b37] px-4 py-2 rounded-lg hover:bg-[#d9ccbb] transition">
            Retour à la liste
        </a>
    </div>

    <!-- Carte principale -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-4xl mx-auto">

        <h3 class="text-xl font-semibold mb-4 border-b border-gray-700 pb-2 text-[#e8ded1]">
            Informations de l'étudiant
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-gray-400 text-sm">Nom complet</p>
                <p class="text-lg font-semibold">{{ $etudiant->prenom }} {{ $etudiant->nom }}</p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Email</p>
                <p class="text-lg font-semibold">{{ $etudiant->user->email }}</p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Téléphone</p>
                <p class="text-lg font-semibold">{{ $etudiant->telephone ?? 'Non renseigné' }}</p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Date de naissance</p>
                <p class="text-lg font-semibold">
                    {{ $etudiant->date_naissance ? $etudiant->date_naissance->format('d/m/Y') : 'Non renseignée' }}
                </p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Adresse</p>
                <p class="text-lg font-semibold">{{ $etudiant->adresse ?? 'Non renseignée' }}</p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Niveau</p>
                <p class="text-lg font-semibold">{{ $etudiant->niveau ?? 'Non défini' }}</p>
            </div>

            <div>
                <p class="text-gray-400 text-sm">Session de cours</p>
                <p class="text-lg font-semibold">
                    {{ $etudiant->sessioncours->intitule ?? 'Aucune session associée' }}
                </p>
            </div>
        </div>

        <hr class="my-6 border-gray-700">

        <!-- Section paiements -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3 text-[#e8ded1]">Paiements récents</h3>
            @if($etudiant->paiements && $etudiant->paiements->count() > 0)
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 border-b border-gray-700">
                            <th class="py-2">Date</th>
                            <th>Montant</th>
                            <th>Mode</th>
                            <th>Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($etudiant->paiements as $paiement)
                            <tr class="border-b border-gray-700 hover:bg-gray-700">
                                <td class="py-2">{{ $paiement->created_at->format('d/m/Y') }}</td>
                                <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                <td>{{ ucfirst($paiement->mode) }}</td>
                                <td>{{ $paiement->note ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-400">Aucun paiement enregistré pour le moment.</p>
            @endif
        </div>

        <!-- Section besoins -->
        <div>
            <h3 class="text-xl font-semibold mb-3 text-[#e8ded1]">Besoins exprimés</h3>
            @if($etudiant->besoins && $etudiant->besoins->count() > 0)
                <ul class="list-disc list-inside text-gray-300">
                    @foreach ($etudiant->besoins as $besoin)
                        <li>{{ $besoin->description }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-400">Aucun besoin exprimé pour le moment.</p>
            @endif
        </div>

        <!-- Boutons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('etudiants.show', $etudiant->id) }}" 
               class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white font-semibold">
                Voir le profil complet
            </a>

            <a href="{{ route('paiements.create', ['etudiant' => $etudiant->id]) }}" 
               class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white font-semibold">
                Enregistrer un paiement
            </a>
        </div>
    </div>
</div>
</body>
</html>
