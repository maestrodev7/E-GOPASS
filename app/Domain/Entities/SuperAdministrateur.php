<?php

namespace App\Domain\Entities;

class SuperAdministrateur
{
    public function __construct(
        public ?int $id,
        public string $nom,
        public ?string $postnom = null,
        public ?string $prenom = null,
        public string $telephone,
        public string $email,
        public string $fonction,
        public string $poste_de_travail,
        public string $password,
        public string $created_at,
        public string $updated_at
    ) {}
}
