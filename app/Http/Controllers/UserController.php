<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Redirect;

/*
    Controller used for user operations not related to authentication or creation
*/
class UserController extends Controller
{
    // Deletes an user
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
