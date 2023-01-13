<?php

namespace App\Http\Controllers\Auth;

use App\Guru;
use App\Http\Controllers\Controller;
use App\Kelas;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //cek input role
        if ($data['role'] == 'Guru') {
            //cek guru ada atau tidak
            $guru = Guru::where('nip', $data['nomer'])->count();
            $guruId = Guru::where('nip', $data['nomer'])->get();
            if ($guru >= 1) {
                // guru sudah terdaftar sebagai user apa belum
                foreach ($guruId as $val) {
                    $user = User::where('id', $val->user_id)->count();
                }
                if ($user >= 1) {
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                        'guru' => ['required'],
                    ]);
                } else {
                    // sukses
                    return Validator::make($data, [
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'role' => ['required'],
                        'nomer' => ['required'],
                    ]);
                }
            } else {
                return Validator::make($data, [
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'role' => ['required'],
                    'nomer' => ['required'],
                    'nip' => ['required'],
                ]);
            }
        } else {
            return Validator::make($data, [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required'],
                'nomer' => ['required'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if ($data['role'] == 'Guru') {
            $guruId = Guru::where('nip', $data['nomer'])->get();
            foreach ($guruId as $val) {
                $guru = Guru::findorfail($val->id);
                $countWali = Kelas::where('guru_id', $val->id)->count();
            }

            $user = User::create([
                'name' => $guru->nama_guru,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->assignRole('guru');
            if ($countWali == 1) {
                $user->assignRole('wali kelas');
            }
            $guru_data = [
                'user_id' => $user->id,
            ];
            $guru->update($guru_data);

            return $user;
        }
    }
}
