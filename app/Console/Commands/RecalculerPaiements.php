<?php

namespace App\Console\Commands;

use App\Models\Inscription;
use Illuminate\Console\Command;

class RecalculerPaiements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paiements:recalculer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculer les montants versés et restes à payer pour toutes les inscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début du recalcul des paiements...');

        $inscriptions = Inscription::with(['paiements', 'sessionCours'])->get();
        $compteur = 0;

        foreach ($inscriptions as $inscription) {
            // Si le montant_total est 0, essayer de le récupérer depuis la session de cours
            if ($inscription->montant_total == 0 && $inscription->sessionCours) {
                $inscription->montant_total = $inscription->sessionCours->prix ?? 0;
                $this->warn("Inscription #{$inscription->id}: montant_total était 0, mis à jour avec le prix de la session: {$inscription->montant_total}");
            }
            
            // Calculer le total versé en sommant tous les paiements
            $totalVerse = $inscription->paiements->sum('montant_verse');
            
            // Calculer le reste à payer
            $reste = max(0, $inscription->montant_total - $totalVerse);
            
            // Déterminer le statut
            $statut = $reste <= 0 ? 'soldé' : 'non soldé';

            // Mettre à jour l'inscription
            $inscription->update([
                'montant_total' => $inscription->montant_total,
                'montant_verse' => $totalVerse,
                'reste_payer' => $reste,
                'statut_paiement' => $statut,
            ]);

            $this->line("Inscription #{$inscription->id}: Total={$inscription->montant_total}, Versé={$totalVerse}, Reste={$reste}, Statut={$statut}");
            $compteur++;
        }

        $this->info("✅ Recalcul terminé ! {$compteur} inscription(s) mise(s) à jour.");
        
        return Command::SUCCESS;
    }
}
