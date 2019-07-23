<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{

    private $path = 'users';

    public function profile()
    {
        return view('users.profile');
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        if ($request->email)
            unset($data['email']);

        if ($request->password) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }


        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($user->image) {
                if (Storage::exists("{$this->path}/$user->image")) {
                    Storage::delete("{$this->path}/$user->image");
                }
            }

            $name = Str::kebab($request->name) . $user->id;
            $extension = $request->image->extension();
            $nameImage = "{$name}.{$extension}";
            $data['image'] = $nameImage;

            $upload = $request->image->storeAs($this->path, $nameImage);

            if (!$upload)
                return redirect()->route('profile')->with('error', 'Falha ao fazer upload!');
        }


        $user->update($data);

        return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');
    }
}
