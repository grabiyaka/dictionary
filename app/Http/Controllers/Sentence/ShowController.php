<?php

namespace App\Http\Controllers\Word;

use App\Http\Requests\Dictionary\StoreRequest;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use App\Http\Controllers\Controller;
use App\Http\Resources\Word\WordResource;
use App\Models\Word;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function __invoke($user_id)
    {
        $words = Word::all()->where('user_id', $user_id);
        return $words;
    }
}
