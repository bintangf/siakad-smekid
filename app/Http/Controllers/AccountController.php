<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;

class AccountController extends Controller
{
    public function changePassword()
    {
        return view('auth.passwords.change');
    }
    public function updatePassword()
    {
        request()->validate([
        	'old_password' => 'required',
        	'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        //password dari db
        $currentPassword = auth()->user()->password;
        //password lama dari input untuk check
        $old_password = request('old_password');

        if(hash::check($old_password, $currentPassword)){
        	auth()->user()->update([
        		'password' => bcrypt(request('password')),
        	]);
        	return back()->with('success', "Password berhasil diganti");
        }else{
        	return back()->withErrors(['old_password' => 'Anda harus memasukan password lama!']);
        }
    }
}
