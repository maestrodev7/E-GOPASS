<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AgentDeleteReason extends Model
{
    use HasFactory;

    protected $table = 'agent_delete_reasons';

    protected $fillable = [
        'agent_model_id','reason'
    ];
}
