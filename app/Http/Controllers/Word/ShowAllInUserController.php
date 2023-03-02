<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\Controller;
use App\Models\Word;

class ShowAllInUserController extends Controller
{
    public function __invoke($user_id)
    {
        $words = Word::all()->where('user_id', $user_id);
        return $words;
    }
}
