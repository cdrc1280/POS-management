<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(25);


        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $users = new User;

        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->password = md5($request->name);
        $users->is_admin = $request->is_admin;
        $users->save();

        if ($users) {
            return redirect()->back()->with('success', 'Users created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create User');
        }
    }

    public function update(Request $request, $id)
    {
        $users = User::find($id);

        if (!$users) {
            return back()->with('Error', 'Users not found');
        }


        $users->update($request->all());

        return back()->with('Success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $users = User::find($id);

        if (!$users) {
            return back()->with('Error', 'User not found');
        }

        $users->delete();

        return back()->with('Success', 'User deleted successfully');
    }
}
