<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $table = 'photos';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'photo',
       
 
    ];

    public function user()
    {
       return $this->belongsTo(User::class, 'user_id','id');
    }
}
