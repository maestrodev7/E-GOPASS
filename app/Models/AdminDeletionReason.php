<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminDeletionReason extends Model
{

    use HasFactory;

    protected $table = 'admin_deletion_reasons';

    protected $fillable = [
        'admin_id','reason'
    ];
}
