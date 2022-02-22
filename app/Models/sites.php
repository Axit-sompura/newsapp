<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sites extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'domain',
        'status',
    ];
    protected $hidden = [
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
