<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

abstract class Controller
{
    /** @var User|null */
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
}
