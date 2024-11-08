<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable =[
        'subscription_id', 'price'
    ];
    
    protected $cast = [
        'subscription_id' => 'integer',
        'price' => 'decimal',
    ];

    public function user(){
    return $this->belongsTo(User::class);
    }
}
