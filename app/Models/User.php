<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaction; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specifies your custom table name
    protected $table = 'paythru_users';

    // Fields that are mass-assignable
    protected $fillable = [
        'full_name',
        'email',
        'account_number',
        'phone_number',
        'mpin',
        'balance',
    ];

    // Security: keep sensitive data out of arrays/JSON
    protected $hidden = [
        'mpin',
        'remember_token',
    ];

    /**
     * Tells Laravel to use 'mpin' as the password during login
     */
    public function getAuthPassword()
    {
        return $this->mpin;
    }

    /**
     * Tells the Notification system which email to send to.
     * This ensures the PaymentReceived notification finds the user's email.
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    /**
     * Relationship: A user has many transaction records
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }
}