<?php

namespace App\Http\Controllers\Word;

use App\Http\Requests\Dictionary\UpdateRequest;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use App\Http\Controllers\Controller;
use App\Models\Word;
use App\Models\Sentence;
use App\Models\Association;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request)
    {
        $data = $request->validated();
        if($data['name'] == 'sentence'){
            Sentence::where('id', $data['id'])->update(['content' => $data['value']]);
        } else if($data['name'] == 'association') {
            Association::where('id', $data['id'])->update(['content' => $data['value']]);
        } else{ 
            Word::where('id', $data['id'])->update([$data['name'] => $data['value']]);
        }
        return $data;
    }
}
