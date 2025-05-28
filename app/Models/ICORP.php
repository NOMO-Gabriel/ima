<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ICORP extends Model
{
    use HasFactory;

    protected $table = 'icorps';

    protected $fillable = [
        'name',
        'acronym',
        'description',
        'address',
        'email',
        'phone',
        'website',
        'logo',
    ];
}
