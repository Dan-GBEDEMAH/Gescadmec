<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiements - Gescadmec</title>
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
            <a href="{{ route('paiements.index') }}" class="flex items-center py-3 px-4 rounded-lg bg-blue-600 text-white">
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
            <h2 class="text-3xl font-bold text-white">Liste des paiements</h2>
            <button onclick="openPaymentModal()" class="bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold px-5 py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition flex items-center shadow-lg">
                <i class="fas fa-plus mr-2"></i> Enregistrer un paiement
            </button>
        </div>

        <!-- Modal Formulaire de paiement -->
        <div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-gray-800 p-8 rounded-xl shadow-2xl max-w-lg w-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold text-white">Enregistrer un paiement</h3>
                    <button onclick="closePaymentModal()" class="text-gray-400 hover:text-white text-2xl rounded-full w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form action="{{ route('paiements.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">Étudiant</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <select name="etudiant_id" id="etudiant_select" onchange="loadInscriptions()" class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Sélectionnez un étudiant</option>
                                @foreach(\App\Models\Etudiant::orderBy('prenom')->orderBy('nom')->get() as $etu)
                                    <option value="{{ $etu->id }}">{{ $etu->prenom }} {{ $etu->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">Inscription</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-graduation-cap text-gray-500"></i>
                            </div>
                            <select name="inscription_id" id="inscription_select" class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Sélectionnez d'abord un étudiant</option>
                            </select>
                        </div>
                        <p id="inscription_info" class="text-xs text-gray-400 mt-2 ml-10"></p>
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">Montant versé</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-coins text-gray-500"></i>
                            </div>
                            <input type="number" step="0.01" name="montant_verse" class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex: 50000" required />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-4">
                        <button type="button" onclick="closePaymentModal()" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                            <i class="fas fa-times mr-2"></i> Annuler
                        </button>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition font-medium flex items-center shadow-lg">
                            <i class="fas fa-save mr-2"></i> Enregistrer et générer le reçu
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
            <div class="flex items-center mb-6">
                <i class="fas fa-receipt text-blue-400 mr-3 text-xl"></i>
                <h3 class="text-xl font-semibold">Historique des paiements</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-700 text-gray-200">
                        <tr>
                            <th class="p-4">Date</th>
                            <th class="p-4">Étudiant</th>
                            <th class="p-4">Inscription</th>
                            <th class="p-4">Montant versé</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                            <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                            <i class="fas fa-calendar text-xs"></i>
                                        </div>
                                        {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="p-4 font-medium">{{ $paiement->inscription->etudiant->prenom }} {{ $paiement->inscription->etudiant->nom }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-purple-900 text-purple-200 rounded-full text-sm">Inscription #{{ $paiement->inscription->id }}</span>
                                </td>
                                <td class="p-4 font-semibold text-green-400">{{ number_format($paiement->montant_verse, 0, ',', ' ') }} FCFA</td>
                                <td class="p-4">
                                    @if($paiement->inscription->statut_paiement === 'soldé')
                                        <span class="px-3 py-1 bg-green-900 text-green-200 rounded-full text-sm">Soldé</span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-900 text-yellow-200 rounded-full text-sm">Non soldé</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('paiements.receipt', $paiement->id) }}" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-block" target="_blank" title="Voir reçu">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-money-bill-wave text-4xl text-gray-600 mb-4"></i>
                                        <h3 class="text-xl font-medium mb-2">Aucun paiement enregistré</h3>
                                        <p class="text-gray-500">Cliquez sur "Enregistrer un paiement" pour commencer</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $paiements->links() }}
            </div>
        </div>
    </main>

    <script>
        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        async function loadInscriptions() {
            const etudiantId = document.getElementById('etudiant_select').value;
            const inscriptionSelect = document.getElementById('inscription_select');
            const inscriptionInfo = document.getElementById('inscription_info');
            
            if (!etudiantId) {
                inscriptionSelect.innerHTML = '<option value="">Sélectionnez d\'abord un étudiant</option>';
                inscriptionInfo.textContent = '';
                return;
            }

            try {
                const response = await fetch(`/api/etudiants/${etudiantId}/inscriptions`);
                const inscriptions = await response.json();
                
                if (inscriptions.length === 0) {
                    inscriptionSelect.innerHTML = '<option value="">Aucune inscription trouvée</option>';
                    inscriptionInfo.textContent = '';
                    return;
                }

                inscriptionSelect.innerHTML = inscriptions.map(ins => {
                    const reste = ins.reste_payer;
                    return `<option value="${ins.id}">Inscription #${ins.id} (Total: ${formatNumber(ins.montant_total)} | Versé: ${formatNumber(ins.montant_verse)} | Reste: ${formatNumber(reste)} FCFA)</option>`;
                }).join('');

                inscriptionSelect.onchange = function() {
                    const selectedIns = inscriptions.find(i => i.id == this.value);
                    if (selectedIns) {
                        inscriptionInfo.textContent = `Reste à payer: ${formatNumber(selectedIns.reste_payer)} FCFA`;
                    }
                };
                inscriptionSelect.onchange();
            } catch (error) {
                console.error('Erreur:', error);
                inscriptionSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            }
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('fr-FR').format(num);
        }
    </script>
</body>
</html>