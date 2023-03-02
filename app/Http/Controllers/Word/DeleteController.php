<?php

namespace App\Http\Controllers\Word;

use App\Http\Requests\Dictionary\StoreRequest;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use App\Http\Controllers\Controller;
use App\Models\Word;
use App\Models\Sentence;

class DeleteController extends Controller
{
    public function __invoke(Word $word)
    {
        Sentence::where('word_id', $word->id)->delete();
        $word->delete();
        return true;
    }
}
