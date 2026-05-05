<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'plan_name',
        'plan_duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
