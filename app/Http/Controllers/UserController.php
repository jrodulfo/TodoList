<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function drop()
    {
        $user = auth()->user();

        if ($user != null) {
            User::find($user->id)->delete();
            return Redirect::to("/register");
        } else {
            return view('nouser');
        }
    }


}
