<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Permitir o preenchimento em massa destes campos
    protected $fillable = [
        'description',
        'amount',
        'type',
        'category',
        'date',
        'user_id', // Adicione esta linha para permitir o preenchimento em massa do user_id
        'is_recurring',
        'total_installments',
        'installment_number',
        'recurrence_group'
    ];
}