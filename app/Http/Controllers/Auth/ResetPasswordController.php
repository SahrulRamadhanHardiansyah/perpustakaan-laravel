<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Ke mana harus mengalihkan pengguna setelah mereset kata sandi mereka.
     *
     * @var string
     */
    protected $redirectTo = '/';
}