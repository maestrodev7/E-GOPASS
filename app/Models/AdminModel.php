<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class AdminModel extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'nom', 'postnom', 'prenom', 'telephone', 'email', 
        'fonction', 'poste_de_travail','nbr_egopass_desactiver', 'password'
    ];

    protected $hidden = ['password'];
}
