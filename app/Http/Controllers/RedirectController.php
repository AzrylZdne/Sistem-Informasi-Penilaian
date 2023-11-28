<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function cek()
    {
        if (Auth::user()->role == 'admin') {
            return redirect('/dashboard');
        } else if (Auth::user()->role == 'juri') {
            return redirect('/juri-dashboard');
        }
    }
}
