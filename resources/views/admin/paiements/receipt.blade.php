<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; color: black; }
            .print-border { border: 2px solid black; padding: 20px; }
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
<div class="max-w-2xl mx-auto bg-white text-gray-900 p-8 mt-8 rounded-lg shadow print-border">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold">GESCADMEC</h1>
        <p class="text-sm text-gray-600">Portail de gestion des inscriptions</p>
        <hr class="my-4 border-gray-300">
        <h2 class="text-xl font-bold">REÇU DE PAIEMENT</h2>
        <p class="text-sm">N° {{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <p class="text-sm text-gray-600">Date d'émission</p>
            <p class="font-semibold">{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y à H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-600">Reçu de</p>
            <p class="font-semibold">{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</p>
        </div>
    </div>

    <div class="bg-gray-100 p-4 rounded mb-6">
        <h3 class="font-bold mb-2">Détails du paiement</h3>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span>Inscription N°:</span>
                <span class="font-semibold">{{ str_pad($inscription->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Session de cours:</span>
                <span class="font-semibold">{{ optional($inscription->sessionCours)->statut_session ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Niveau:</span>
                <span class="font-semibold">{{ $inscription->etudiant->niveau }}</span>
            </div>
        </div>
    </div>

    <div class="border-t-2 border-b-2 border-gray-300 py-4 mb-6">
        <div class="flex justify-between items-center">
            <span class="text-lg">Montant versé ce jour:</span>
            <span class="text-2xl font-bold">{{ number_format($paiement->montant_verse, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <div class="bg-blue-50 p-4 rounded mb-6">
        <h3 class="font-bold mb-3">Récapitulatif financier</h3>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span>Montant total des frais:</span>
                <span class="font-semibold">{{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="flex justify-between">
                <span>Total déjà versé:</span>
                <span class="font-semibold text-green-600">{{ number_format($inscription->montant_verse, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="flex justify-between border-t-2 pt-2">
                <span class="text-lg font-bold">Reste à payer:</span>
                <span class="text-lg font-bold {{ $inscription->reste_payer > 0 ? 'text-red-600' : 'text-green-600' }}">
                    {{ number_format($inscription->reste_payer, 0, ',', ' ') }} FCFA
                </span>
            </div>
            <div class="flex justify-between">
                <span>Statut:</span>
                <span class="font-semibold {{ $inscription->statut_paiement === 'soldé' ? 'text-green-600' : 'text-orange-600' }}">
                    {{ strtoupper($inscription->statut_paiement) }}
                </span>
            </div>
        </div>
    </div>

    @if($inscription->reste_payer > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
        <p class="text-sm text-yellow-800">
            <strong>Rappel:</strong> Il reste {{ number_format($inscription->reste_payer, 0, ',', ' ') }} FCFA à payer pour solder cette inscription.
        </p>
    </div>
    @endif

    <div class="text-center text-xs text-gray-500 mt-8">
        <p>Ce reçu certifie le paiement effectué à la date indiquée</p>
        <p class="mt-2">Signature: ________________</p>
    </div>

    <div class="mt-8 flex justify-between no-print">
        <a href="{{ route('paiements.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Retour aux paiements</a>
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Imprimer le reçu</button>
    </div>
</div>
</body>
</html>
