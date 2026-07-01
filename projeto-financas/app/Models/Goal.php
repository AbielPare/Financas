<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'name',
        'target_amount',
        'current_amount',
        'image_url',
        'user_id', // Adicione esta linha para permitir o preenchimento em massa do user_id
    ];
}