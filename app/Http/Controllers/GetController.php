<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\FlareClient\View;

class GetController extends Controller
{
    public function __invoke($word)
    {
        $response = "https://api.dictionaryapi.dev/api/v2/entries/en/".$word ;
        return file_get_contents($response); 
    }
}
