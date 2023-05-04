<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\User;
class AuthController extends Controller
{
    
    public function prosesregister(request $request){
        $rules = [
            'name'                  => 'required|alpha|min:5',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'
        ];
  
        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.alpha'           => 'Nama harus berisi huruf',
            'name.min'              => 'Nama lengkap minimal 5 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->tokennya = Hash::make($request->email);
        $user->password = Hash::make($request->password);
        $user->role_id = 4;
        $user->email_verified_at = \Carbon\Carbon::now();
        $simpan = $user->save();
        return redirect('login');
    }

    public function proseslogin(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];
  
        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
  
        Auth::attempt($data);
  
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('/');
  
        } else { // false
  
            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }
  
    }
    public function simpan(request $request){
        $rules = [
            'nama'                 => 'required|max:10',
            'notelepon'              => 'required'
        ];
  
        $messages = [
            'nama.required'        => 'nama wajib diisi',
            'nama.max'        => 'nama maxsimal 10 karakter',
            'notelepon.required'     => 'notelepon wajib diisi',
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
    }
    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }

    
}
