<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    public $timestamps = false;

    // FIXED: Added 'description' and 'reference_number' so Laravel allows saving/reading them
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'reference_number',
        'description', 
        'status',
        'created_at',
        'updated_at'
    ];
}