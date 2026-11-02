<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PublicDocsController extends Controller
{
    public function index(): View
    {
        return view('public.docs');
    }
}
