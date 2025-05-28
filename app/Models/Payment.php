<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'start_weeks',
        'image_path',
        'transaction_id',
    ];

    protected $casts = [
        'start_weeks' => 'array',
    ];
}
