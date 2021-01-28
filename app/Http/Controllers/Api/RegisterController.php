<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Classes\{UploadClass};
use App\Models\User;

class RegisterController extends Controller
{
    public function signup(Request $request){
        $this->validate($request, [
            'first_name'    => 'required|string|min:2|max:25',
            'last_name'     => 'required|string|min:2|max:25',
            'tel'           =>  'required|string|min:11|max:15|unique:users',
            'email'         => 'required|string|email|max:55|unique:users',
            'password'      => 'required|string|min:8',
            'gender'        => 'required|string|min:2|max:6',
            'country'       => 'required|string|min:2|max:20',
            'state'         => 'required|string|min:2|max:20',
            'place'         => 'required|string|min:2|max:255'
        ]);
        $user = new User;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->tel          = $request->tel;

        $user->password     = Hash::make($request->password);
        $user->email        = $request->email;
        $user->gender        = $request->gender;
        $user->country        = $request->country;
        $user->state        = $request->state;
        $user->place        = $request->place;
        if($user->save()){
            if($request->file('dp')){
                $uploadClass = new UploadClass('images/profile_images/',$user->id);
                $uploadClass->upload($request->file('dp'));
            }
            return ['response' => "Account Created successfully"];
        }
    }
}
