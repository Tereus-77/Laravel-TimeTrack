<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function create()
    {
        $active_main = 'user';
        $active_sub = "user_create";

        return view('user.create', compact('active_main', 'active_sub'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3|max:30',
            'username' => 'required|string|max:30',
            'role' => 'required|string',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);

        } else {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'role' => $request->role,
                'first_visit' => $request->visit,
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('user.list');
    }

    public function list()
    {
        $active_main = 'user';
        $active_sub ='user_list';
        $users = User::all();

        return view('user.list', compact('active_main', 'active_sub', 'users'));
    }

    public function edit(Request $request, $id) 
    {
        $active_main = 'user';
        $active_sub ='user_edit';
        $user = User::find($id);

        return view('user.edit', compact('user', 'active_main', 'active_sub'));
    }

    public function update(Request $request, $id)
    {
        $info = User::find($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:3|max:30',
            'username' => 'required|string',
            'role' => 'required|string',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $info->name = $request->name;
            $info->username = $request->username;
            $info->role = $request->role;
            $info->password = Hash::make($request->password);
            $info->save();

            return redirect()->route('user.list');
        }
        return redirect()->route('user.list');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        return json_encode(true);
    }

    public function visit($id)
    {
        $user = User::find($id);
        $user->first_visit = "false";
        $user->save();

        return response()->json(true);
    }

    public function updateown(Request $request, $id)
    {
        $info = User::find($id);
        $validator = Validator::make($request->all(),[
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json(false);
        } else {
            $info->password = Hash::make($request->password);
            $info->save();

            return response()->json(true); 
        }
        
        return response()->json(true);
    }

}
