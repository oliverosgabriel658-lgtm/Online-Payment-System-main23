<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // This tells Laravel which table to use
    protected $table = 'transactions';

    // These are the columns that can be filled
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'reference_number',
        'status'
    ];
}