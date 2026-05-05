<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Deposit extends Model
{
    use HasFactory;
    protected $table = 'deposits';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'bot',
        'payment_method',
        'trading_name',
        'image',
        'status',
    ];

    public function user()
    {
       return $this->belongsTo(User::class, 'user_id','id');
    }
}
