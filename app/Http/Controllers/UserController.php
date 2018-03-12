<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\User;
use Gate;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::findOrFail($id);
        foreach ($user->roles as $role) {
            $myRole = $role->name;
        }
        return view('users.show', compact(['user', 'myRole']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name', 'id');
        foreach ($user->roles as $role) {
            $current_role = $role->id;
        }
        return view('users.edit', compact(['user', 'roles', 'current_role']));
    }

    public function admin()
    {
        $users = User::all();
//        $roles = Role::orderBy('name')->pluck('name', 'id');
//        foreach ($roles as $role) {
//            $current_role = $role->name;
//        }
        return view('admin.index', compact('users'));
    }

    public function update(User $user, Request $request)
    {
        $data = $request->only('login', 'email', 'name', 'surname');
        if (Gate::allows('update-user-role')) {
            if (!$user->isAdmin()) {
                $role = $request->only('role');
                $user->roles()->sync($role);
                $data = $request->only('verified');
            }
        }
        $user->fill($data)->save();
        return redirect()->route('show_user', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // delete
        if (!$user->isAdmin()) {
        $user = User::findOrFail($user->id);
        $user->delete();
        }
        return redirect()->route('admin_panel');

    }

}
