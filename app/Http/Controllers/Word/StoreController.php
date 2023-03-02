<?php

namespace App\Http\Controllers\Word;

use App\Http\Requests\Dictionary\StoreRequest;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use App\Http\Controllers\Controller;
use App\Models\Word;
use App\Models\Sentence;
use App\Models\Association;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        if ($data['sentences'][0] != '' && count($data['sentences']) != 1) {
            $sentences = $data['sentences'];
        }
        if ($data['associations'][0] != '' && count($data['associations']) != 1) {
            $associations = $data['associations'];
        }

        unset($data['associations']);
        unset($data['sentences']);

        $data = Word::create($data);

        $word_id = $data['id'];

        if (isset($sentences)) {
            $array = [];
            foreach ($sentences as $sentence) {
                $array['content'] = $sentence;
                $array['word_id'] = $word_id;
                Sentence::create($array);
            }
        }
        if (isset($associations)) {
            $array = [];
            foreach ($associations as $associations) {
                $array['content'] = $associations;
                $array['word_id'] = $word_id;
                Association::create($array);
            }
        }

        return $data;
    }
}
