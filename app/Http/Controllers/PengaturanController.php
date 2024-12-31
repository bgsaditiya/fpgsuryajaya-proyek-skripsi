<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Arsip;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PengaturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('menu.pengaturan.index',[
            'title' => 'Pengaturan',
            'active' => 'pengaturan',
        ]);
    }

    public function password()
    {
        //
        // dd(auth()->user()->username);

        return view('menu.pengaturan.password',[
            'title' => 'Ganti Password Akun',
            'active' => 'pengaturan',
        ]);
    }

    public function gantiPassword(Request $request) {
    
        // dd($request->password);
        
        if (Hash::check($request->password_lama, auth()->user()->password)){
            // dd("true");
            $this->validate($request, [
                'password_lama'          => 'required',
                'password'              => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ],[
                'password.min' => 'Masukkan password baru minimal 8 karakter!', 
                'password.confirmed' => 'Password baru dan konfirmasi password tidak sama!', 
            ]);

            User::find(auth()->user()->username)->update(['password' => bcrypt($request->password)]);
            return redirect()->back()->with(['success' => 'Password berhasil dirubah!']);
        }else{
            // dd("false");
            return redirect()->back()->withErrors('Password lama salah!');
        }
    }

    public function admin()
    {
        //
        $admin = User::select('username', 'password', 'nama', 'jenis')
        ->where('jenis', '=', 'admin')
        ->paginate(10);

        return view('menu.pengaturan.admin.index',[
            'title' => 'Kelola Akun Admin',
            'active' => 'pengaturan',
        ], compact('admin'));
    }
    
    public function adminEdit(User $admin, $username)
    {
        //
        $adminedit = $admin->find($username);

        return view('menu.pengaturan.admin.edit',[
            'title' => 'Edit Akun Admin',
            'active' => 'pengaturan',
        ],with([
            'username' => $username,
            'nama' => $adminedit->nama,
        ]));
    }

    public function adminUpdate(Request $request, $username)
    {

        if (Auth::user()->username == $username){
            $this->validate($request, [
                'password' => 'required|min:8|confirmed',
                'nama' => 'required|max:255',
            ],[
                'password.confirmed' => 'Password baru dan konfirmasi password tidak sama!',
                'password.min' => 'Masukkan password baru minimal 8 karakter!',
                'nama.max' => 'Nama yang dimasukkan terlalu panjang!',
            ]);

            User::findOrFail($username)->update([
                'password' => bcrypt($request->password),
                'nama' => $request->nama,
                'jenis' => 'admin',
            ]);

        }else{
            $this->validate($request, [
                'username' => 'required|min:6|'.Rule::unique('tbuser', 'username')->ignore($username, 'username'),
                'password' => 'required|min:8|confirmed',
                'nama' => 'required|max:255',
            ],[
                'username.min' => 'Masukkan username baru minimal 6 karakter!',
                'username.unique' => 'Username sudah terpakai!',
                'password.confirmed' => 'Password baru dan konfirmasi password tidak sama!',
                'password.min' => 'Masukkan password baru minimal 8 karakter!',
                'nama.max' => 'Nama yang dimasukkan terlalu panjang!',
            ]);

            if (Arsip::where('username', $username)->exists()) {
                User::findOrFail($username)->update([
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                    'nama' => $request->nama,
                    'jenis' => 'admin',
                ]);
                
                Arsip::where('username', $username)->update([
                    'username' => $request->username,
                ]);
                
            }else{
                User::findOrFail($username)->update([
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                    'nama' => $request->nama,
                    'jenis' => 'admin',
                ]);
            }
        }
        // return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
        return redirect()->route('admin')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function adminCreate()
    {
        return view('menu.pengaturan.admin.tambah', [
            'title' => 'Tambah Akun Admin',
            'active' => 'pengaturan',
        ]);
    }

    public function adminStore(Request $request)
    {
        //validate form
        $this->validate($request, [
            'username'     => 'required|unique:tbuser|min:6',
            'password'     => 'required|min:8|confirmed',
            'nama'   => 'required|max:255'
        ],[
            'username.unique' => 'Username sudah terpakai!',
            'username.min' => 'Masukkan username baru minimal 6 karakter!',
            'password.min' => 'Masukkan password baru minimal 8 karakter!',
            'password.confirmed' => 'Password baru dan konfirmasi password tidak sama!',
            'nama.max' => 'Nama yang dimasukkan terlalu panjang!',
        ]);

        //create post
        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'nama' => $request->nama,
            'jenis' => 'admin',
        ]);

        //redirect to index
        return redirect()->route('admin')->with(['success' => 'Data Berhasil Ditambah!']);
    }

    public function adminSearch()
    {
        //
        $admin = User::paginate(10);

        return view('menu.pengaturan.adminedit',[
            'title' => 'Kelola Akun Admin',
            'active' => 'pengaturan',
        ], compact('admin'));
    }

    public function adminHapus($username)
    {
        //
        if (Auth::user()->username == $username){
            return redirect()->back()->withErrors('Anda tidak bisa menghapus akun yang sedang anda gunakan!');
        }else{
            $del = User::findOrFail($username);
            $del->delete();
            return redirect()->back()->with(['success' => 'Akun Berhasil Dihapus!']);
        }
    }

    public function pegawai()
    {
        //
        $pegawai = User::select('username', 'password', 'nama', 'jenis')
        ->where('jenis', '=', 'pegawai')
        ->paginate(10);

        return view('menu.pengaturan.pegawai.index',[
            'title' => 'Kelola Akun Pegawai',
            'active' => 'pengaturan',
        ], compact('pegawai'));
    }

    public function pegawaiCreate()
    {
        return view('menu.pengaturan.pegawai.tambah', [
            'title' => 'Tambah Akun Pegawai',
            'active' => 'pengaturan',
        ]);
    }

    public function pegawaiStore(Request $request)
    {
        //validate form
        $this->validate($request, [
            'username'     => 'required|unique:tbuser|min:6',
            'password'     => 'required|min:8|confirmed',
            'nama'   => 'required|max:255',
        ],[
            'username.unique' => 'Username sudah terpakai!',
            'username.min' => 'Masukkan username baru minimal 6 karakter!',
            'password.min' => 'Masukkan password baru minimal 8 karakter!',
            'password.confirmed' => 'Password baru dan konfirmasi password tidak sama!',
            'nama.max' => 'Nama yang dimasukkan terlalu panjang!',
        ]);

        //create post
        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'nama' => $request->nama,
            'jenis' => 'pegawai',
        ]);

        //redirect to index
        return redirect()->route('pegawai')->with(['success' => 'Data Berhasil Ditambah!']);
    }

    public function pegawaiEdit(User $pegawai, $username)
    {
        //
        $pegawaiedit = $pegawai->find($username);

        return view('menu.pengaturan.pegawai.edit',[
            'title' => 'Edit Akun Pegawai',
            'active' => 'pengaturan',
        ],with([
            'username' => $username,
            'nama' => $pegawaiedit->nama,
        ]));
    }

    public function pegawaiUpdate(Request $request, $username)
    {
        //
        //validate form
        $this->validate($request, [
            'username' => 'required|min:6|'.Rule::unique('tbuser', 'username')->ignore($username, 'username'),
            'password' => 'required|min:8|confirmed',
            'nama' => 'required|max:255',
        ],[
            'username.min' => 'Masukkan username baru minimal 6 karakter!',
            'username.unique' => 'Username sudah terpakai!',
            'password.confirmed' => 'Password baru dan konfirmasi password tidak sama!',
            'password.min' => 'Masukkan password baru minimal 8 karakter!',
            'nama.max' => 'Nama yang dimasukkan terlalu panjang!',
        ]);

        User::findOrFail($username)->update([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'nama' => $request->nama,
            'jenis' => 'pegawai',
        ]);

        // return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
        return redirect()->route('pegawai')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function pegawaiHapus($username)
    {
        //
        $del = User::findOrFail($username);

        //delete post
        $del->delete();

        //redirect to index
        return redirect()->back()->with(['success' => 'Akun Berhasil Dihapus!']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}