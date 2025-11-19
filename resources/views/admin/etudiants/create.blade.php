<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un étudiant - Gescadmec</title>
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
            <h2 class="text-2xl font-semibold">Ajouter un étudiant</h2>
            <a href="{{ route('etudiants.index') }}" class="bg-gray-700 px-4 py-2 rounded">Retour à la liste</a>
        </div>

        @if($errors->any())
            <div class="bg-red-600 text-white p-4 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <form action="{{ route('etudiants.store') }}" method="POST" id="studentForm">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-3">
                        <label class="block text-gray-300">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-300">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-3">
                        <label class="block text-gray-300">Date de naissance</label>
                        <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-300">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-300">Adresse</label>
                    <textarea name="adresse" rows="2" class="w-full p-2 rounded bg-gray-700 text-white" required>{{ old('adresse') }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label for="niveau" class="block text-gray-300">Niveau</label>
                    <select id="niveau" name="niveau" class="w-full p-2 rounded bg-gray-700 text-white" required>
                        <option value="">Sélectionnez un niveau</option> 
                        <option value="Débutant" {{ old('niveau') == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                        <option value="Intermédiaire" {{ old('niveau') == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                        <option value="Avancé" {{ old('niveau') == 'Avancé' ? 'selected' : '' }}>Avancé</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-300">Session de cours</label>
                    <select name="sessioncours_id" id="sessioncours_id" class="w-full p-2 rounded bg-gray-700 text-white" required>
                        <option value="">Sélectionnez un cours</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}" data-prix="{{ $session->prix }}" {{ old('sessioncours_id') == $session->id ? 'selected' : '' }}>
                                {{ $session->nom_cours }} ({{ $session->date_debut }} au {{ $session->date_fin }}) 
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-300">Montant versé</label>
                    <input type="number" step="0.01" name="montant_verse" id="montant_verse" value="{{ old('montant_verse', 0) }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    <input type="hidden" name="montant_total" id="montant_total" value="{{ old('montant_total') }}">
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('etudiants.index') }}" class="bg-gray-600 px-4 py-2 rounded">Annuler</a>
                    <button type="submit" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const sessionSelect = document.getElementById('sessioncours_id');
        const montantTotalInput = document.getElementById('montant_total');

        // Récupérer le prix du cours automatiquement
        sessionSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const prix = selectedOption.getAttribute('data-prix');
            
            if (prix) {
                montantTotalInput.value = prix;
            } else {
                montantTotalInput.value = '';
            }
        });

        // Si une session est déjà sélectionnée (après erreur de validation), remplir le prix
        if (sessionSelect.value) {
            const selectedOption = sessionSelect.options[sessionSelect.selectedIndex];
            const prix = selectedOption.getAttribute('data-prix');
            if (prix) {
                montantTotalInput.value = prix;
            }
        }
    </script>
</body>
</html>
