<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un étudiant - Gescadmec</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900">
<div class="max-w-lg mx-auto bg-gray-800 p-6 rounded-lg shadow mt-10">
    <h2 class="text-xl font-bold mb-4 text-white">Modifier un étudiant</h2>

    <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="block text-gray-300">Nom</label>
            <input type="text" name="nom" value="{{ old('nom', $etudiant->nom) }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
            @error('nom')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-gray-300">Prénom</label>
            <input type="text" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
            @error('prenom')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="block text-gray-300">Date de naissance</label>
            <input type="date" name="date_naissance" value="{{ old('date_naissance', $etudiant->date_naissance) }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
            @error('date_naissance')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-gray-300">Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
            @error('telephone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-gray-300">Adresse</label>
            <textarea name="adresse" rows="2" class="w-full p-2 rounded bg-gray-700 text-white" required>{{ old('adresse', $etudiant->adresse) }}</textarea>
            @error('adresse')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="niveau" class="block text-gray-300">Niveau</label>
            <select id="niveau" name="niveau" class="w-full p-2 rounded bg-gray-700 text-white" required>
                <option value="">Sélectionnez un niveau</option> 
                <option value="Débutant" {{ old('niveau', $etudiant->niveau) == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                <option value="Intermédiaire" {{ old('niveau', $etudiant->niveau) == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                <option value="Avancé" {{ old('niveau', $etudiant->niveau) == 'Avancé' ? 'selected' : '' }}>Avancé</option>
            </select>
            @error('niveau')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700 text-white">Mettre à jour</button>
            <a href="{{ route('etudiants.index') }}" class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-700 text-white inline-block">Annuler</a>
        </div>
    </form>
</div>
</body>
</html>
