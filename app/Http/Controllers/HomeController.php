<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Page d'accueil marketing (SSR pour le SEO).
     */
    public function index(): View
    {
        return view('home');
    }
}
