<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('admin.user.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
        ]);

        if ($request->role == 'Guru') {
            $countGuru = Guru::where('nip', $request->nomer)->count();
            $guruId = Guru::where('nip', $request->nomer)->get();
            foreach ($guruId as $val) {
                $guru = Guru::findorfail($val->id);
                $countWali = Kelas::where('guru_id', $val->id)->count();
            }
            if ($countGuru >= 1) {
                $user = User::create([
                    'name' => $guru->nama_guru,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $user->assignRole('guru');
                if ($countWali == 1) {
                    $user->assignRole('wali kelas');
                }
                $guru_data = [
                    'user_id' => $user->id,
                ];
                $guru->update($guru_data);

                return redirect()->back()->with('success', 'Berhasil menambahkan user Guru baru!');
            } else {
                return redirect()->back()->with('error', 'Maaf User dengan NIP ini tidak terdaftar sebagai guru!');
            }
        }
        if ($request->role == 'Operator') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('operator');

            return redirect()->back()->with('success', 'Berhasil menambahkan user Operator baru!');
        }
        if ($request->role == 'Admin') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('admin');

            return redirect()->back()->with('success', 'Berhasil menambahkan user Admin baru!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        if ($id == 3 && Auth::user()->getRoleNames()[0] == 'operator') {
            return back()->with('warning', 'Maaf halaman ini hanya bisa di akses oleh Admin!');
        } else {
            $role = Role::where('id', $id)->get();

            return view('admin.user.show', compact('role'));
        }
    }

    public function destroy($id)
    {
        $user = User::findorfail($id);
        if ($user->getRoleNames()[0] == 'Admin') {
            if ($user->id == Auth::user()->id) {
                $user->delete();

                return redirect()->back()->with('warning', 'Data user berhasil dihapus! (Silahkan cek trash data user)');
            } else {
                return redirect()->back()->with('error', 'Maaf user ini bukan milik anda!');
            }
        } elseif ($user->getRoleNames()[0] == 'Operator') {
            if ($user->id == Auth::user()->id || Auth::user()->getRoleNames()[0] == 'Admin') {
                $user->delete();

                return redirect()->back()->with('warning', 'Data user berhasil dihapus! (Silahkan cek trash data user)');
            } else {
                return redirect()->back()->with('error', 'Maaf user ini bukan milik anda!');
            }
        } else {
            $user->delete();

            return redirect()->back()->with('warning', 'Data user berhasil dihapus! (Silahkan cek trash data user)');
        }
    }

    public function trash()
    {
        $users = User::onlyTrashed()->paginate(10);

        return view('admin.user.trash', compact('users'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::withTrashed()->findorfail($id);
        $user->restore();

        return redirect()->back()->with('info', 'Data user berhasil direstore! (Silahkan cek data user)');
    }

    public function kill($id)
    {
        $user = User::withTrashed()->findorfail($id);
        $countGuru = Guru::where('user_id', $id)->count();
        $guruId = Guru::where('user_id', $id)->get();
        foreach ($guruId as $val) {
            $guru = Guru::findorfail($val->id);
        }
        if ($countGuru >= 1) {
            $guru_data = [
                'user_id' => null,
            ];
            $guru->update($guru_data);
        }
        $user->forceDelete();

        return redirect()->back()->with('success', 'Data user berhasil dihapus secara permanent');
    }

    public function email(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $countUser = User::where('email', $request->email)->count();
        if ($countUser >= 1) {
            return redirect()->route('reset.password', Crypt::encrypt($user->id))->with('success', 'Email ini sudah terdaftar!');
        } else {
            return redirect()->back()->with('error', 'Maaf email ini belum terdaftar!');
        }
    }

    public function password($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findorfail($id);

        return view('auth.passwords.reset', compact('user'));
    }

    public function update_password(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::findorfail($id);
        $user_data = [
            'password' => Hash::make($request->password),
        ];
        $user->update($user_data);

        return redirect()->route('login')->with('success', 'User berhasil diperbarui!');
    }

    public function profile()
    {
        return view('profile.index');
    }

    public function edit_profile()
    {
        return view('profile.edit');
    }

    public function ubah_profile(Request $request)
    {
        if (Auth::user()->getRoleNames()[0] == 'guru') {
            $this->validate($request, [
                'name' => 'required',
                'jk' => 'required',
            ]);
            $user = User::findorfail(Auth::user()->id);
            $guru = Guru::where('user_id', $user->id)->first();
            if ($user) {
                $user_data = [
                    'name' => $request->name,
                ];
                $user->update($user_data);
            }
            $guru_data = [
                'nama_guru' => $request->name,
                'jk' => $request->jk,
                'telp' => $request->telp,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
            ];
            $guru->update($guru_data);

            return redirect()->route('profile')->with('success', 'Profile anda berhasil diperbarui!');
        } else {
            $user = User::findorfail(Auth::user()->id);
            $data_user = [
                'name' => $request->name,
            ];
            $user->update($data_user);

            return redirect()->route('profile')->with('success', 'Profile anda berhasil diperbarui!');
        }
    }

    public function edit_email()
    {
        return view('profile.email');
    }

    public function ubah_email(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
        ]);
        $user = User::findorfail(Auth::user()->id);
        $cekUser = User::where('email', $request->email)->count();
        if ($cekUser >= 1) {
            return redirect()->back()->with('error', 'Maaf email ini sudah terdaftar!');
        } else {
            $user_email = [
                'email' => $request->email,
            ];
            $user->update($user_email);

            return redirect()->back()->with('success', 'Email anda berhasil diperbarui!');
        }
    }

    public function edit_password()
    {
        return view('profile.password');
    }

    public function ubah_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::findorfail(Auth::user()->id);
        if ($request->password_lama) {
            if (Hash::check($request->password_lama, $user->password)) {
                if ($request->password_lama == $request->password) {
                    return redirect()->back()->with('error', 'Maaf password yang anda masukkan sama!');
                } else {
                    $user_password = [
                        'password' => Hash::make($request->password),
                    ];
                    $user->update($user_password);

                    return redirect()->back()->with('success', 'Password anda berhasil diperbarui!');
                }
            } else {
                return redirect()->back()->with('error', 'Tolong masukkan password lama anda dengan benar!');
            }
        } else {
            return redirect()->back()->with('error', 'Tolong masukkan password lama anda terlebih dahulu!');
        }
    }
}
