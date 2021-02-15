<?php

namespace App\Http\Controllers;

use App\User;
use App\User_contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        $data = User::find($user_id);
        $data->name = $request['name'];
        $data->email = $request['email'];
        $data->update();

        $contact = User_contact::where('user_id',$user_id)->first();
        $contact->no_hp = $request['phone'];
        $contact->update();

    }
}
