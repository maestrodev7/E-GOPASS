<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class SuperAdminModel extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'super_admin_model';

    protected $fillable = [
        'nom', 'postnom', 'prenom', 'telephone', 'email', 
        'fonction', 'poste_de_travail', 'password'
    ];

    protected $hidden = ['password'];
}
