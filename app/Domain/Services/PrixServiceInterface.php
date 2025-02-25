<?php

namespace App\Domain\Services;

use App\Domain\Entities\Prix;

interface PrixServiceInterface
{
    /**
     * Met à jour ou crée un prix en fonction du type.
     *
     * @param string $type Le type de prix (ex: 'local', 'international').
     * @param float $amount Le montant du prix.
     * @return Prix L'entité Prix mise à jour ou créée.
     */
    public function updateOrCreatePrix(string $type, float $amount): Prix;

    /**
     * Trouve un prix par son type.
     *
     * @param int $type Le type de prix.
     * @return Prix|null L'entité Prix correspondante, ou null si non trouvée.
     */
    public function findPrixByType(string $type): ?Prix;
}