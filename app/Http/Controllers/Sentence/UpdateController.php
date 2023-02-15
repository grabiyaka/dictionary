<?php

namespace App\Http\Controllers\Word;

use App\Http\Requests\Dictionary\StoreRequest;
use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use App\Http\Controllers\Controller;
use App\Models\Word;

class UpdateController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        Word::create($data);
        return $data;
    }
}
