<?php
namespace App\Application\Services;

use App\Domain\Services\PrixServiceInterface;
use App\Domain\Entities\Prix;
use App\Domain\Repositories\PrixRepositoryInterface;

class PrixService implements PrixServiceInterface
{

    /**
     * Constructeur du service.
     *
     * @param PrixRepositoryInterface $prixRepository Le repository pour interagir avec les prix.
     */
    public function __construct(private PrixRepositoryInterface $prixRepository){}

    /**
     * Met à jour ou crée un prix en fonction du type.
     *
     * @param string $type Le type de prix (ex: 'local', 'international').
     * @param float $amount Le montant du prix.
     * @return Prix L'entité Prix mise à jour ou créée.
     */
    public function updateOrCreatePrix(string $type, float $amount): Prix
    {
        return $this->prixRepository->updateOrCreate($type, $amount);
    }

    /**
     * Trouve un prix par son type.
     *
     * @param int $type Le type de prix.
     * @return Prix|null L'entité Prix correspondante, ou null si non trouvée.
     */
    public function findPrixByType(string $type): ?Prix
    {
        return $this->prixRepository->findByFlightType($type);
    }
}