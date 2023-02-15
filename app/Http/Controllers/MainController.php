<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\FlareClient\View;

class MainController extends Controller
{
    public function __invoke()
    {
        return view('main');
    }
}
