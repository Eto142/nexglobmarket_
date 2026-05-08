<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'lname',
        'currency',
        'email',
        'phone',
        'country',
        'state',
        'pcode',
        'photo',
        'dob',
        'pin',
        'address',
        'usertype',
        'eth_address',
        'btc_address',
        'usdt_address',
        'btcImage',
        'ethImage',
        'usdtImage',
        'signal_strength',
        'update_escrow',
        'update_notification',
        'id_card',
        'user_status',
        'passport',
        'kyc_status',
        'is_activated',
        'bot_image',
        'withdrawal_code',
        'withdrawal_amount',
        'withdrawal_tax_amount',
        'withdrawal_percentage',
        'bot_status',
        'token',
        'withdrawal_tax_code',
        'profit_limit_status',
        'password',
        'show_password',
        'show_kyc_notice',
        'show_signal_strength',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function profits()
    {
        return $this->hasMany(Profit::class);
    }

    public function debitprofits()
    {
        return $this->hasMany(Debitprofit::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function refferals()
    {
        return $this->hasMany(Refferal::class);
    }

    public function kyc()
    {
        return $this->hasOne(Kyc::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
