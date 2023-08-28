<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $user = User::paginate(10);
        return view('user.index')->with('user',$user);
    }

    public function create() {
        $user = User::all();
        return view('user.create')->with('user',$user); 
    }
    
    public function store(Request $request){
        $request->validate([
            'name' => ['required','string'],
            'jabatan' => ['required','string'],
            'hp' => ['required','numeric','digits_between:11 ,13','unique:users'],
            'email' => ['required','email','unique:users'],
            'password' => ['required','string','min:5'],
            'role' => ['required'],
        ]);
        try{
            $user= new User;
            $user->name = $request->name;
            $user->jabatan = $request->jabatan;
            $user->hp = $request->hp;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;   
            $user->save();
        }
        catch(\Exception $e ){
            return redirect()->back()->with(['errors','User gagal disimpan']);
        }
        return redirect('user')->with('sukses','User berhasil disimpan');
    }
    
    public function edit($id){
        $user = User::findOrFail($id);
        return view('user.edit')->withuser($user);
    }
    
    public function update(Request $request, $id){
        $request->validate([
            'name' => ['required','string'],
            'jabatan' => ['required','string'],
            'hp' => ['required'],
            'email' => ['required','email','unique:users,email,'.$id],
            'role' => ['required'],
        ]);
        try{
            $user= User::find($id);
            $user->name = $request->name;
            $user->jabatan = $request->jabatan;
            $user->hp = $request->hp;
            $user->email = $request->email;
            if($request->password <> ''){
                $user->password = Hash::make($request->password);
            }
            $user->role = $request->role;
            $user->save();
        }
        catch(\Exception $e ){
            return redirect()->back()->with(['errors','User gagal disimpan']);
        }
        return redirect('user')->with('sukses','User berhasil disimpan');
    }
    
    public function destroy($id){
        DB::beginTransaction();
    
        try {
            if(\Auth::user()->id == $id){
                return redirect()->back()->withErrors('Anda tidak dapat menghapus diri sendiri');
            }
    
            $user = User::findOrFail($id);
            $user->delete();
            
            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors('User gagal dihapus');
        }
        return redirect('user')->with('sukses','User berhasil dihapus');
    }
}
