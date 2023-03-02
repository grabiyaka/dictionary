<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\Controller;
use App\Models\Word;
use App\Models\Sentence;
use App\Models\Association;

class ShowController extends Controller
{
    public function __invoke(Word $word)
    {
        $sentences = Sentence::where('word_id', $word->id)->get();
        $association = Association::where('word_id', $word->id)->get();
        $response = [$word, $sentences, $association];
        return $response;
    }
}
