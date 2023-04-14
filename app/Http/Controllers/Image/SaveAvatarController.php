<?php

namespace App\Http\Controllers\Image;

use App\Http\Requests\Dictionary\StoreRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SaveAvatarController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        try{
            $data = $request->all();
            $image = $data['image'];
            $user =  $data['user'];
            $name = md5(Carbon::now() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $filePath = Storage::disk('public_uploads')->putFileAs('/avatars', $image, $name);
            $filePath = explode('/', $filePath);
            User::where('id', $user)->update([
                'avatar' => $filePath[1],
            ]);
            return $name;
        }  catch (\Exception $e) {
            return 'Произошла ошибка: ' . $e->getMessage();
        }
    }
}