<?php
namespace App\Domain\Entities;

class Admin
{
    public function __construct(
        public ?int $id,
        public string $nom,
        public ?string $postnom = null,
        public ?string $prenom = null,
        public ?string $telephone = null,
        public ?string $email,
        public string $fonction,
        public string $poste_de_travail,
        public ?string $nbr_egopass_desactiver = null,
        public ?string $password,
        public ?string $created_at = null,
        public ?string $updated_at = null
    ) {}
}
