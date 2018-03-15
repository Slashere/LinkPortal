<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\User;
use App\Link;
use Gate;
use Illuminate\Support\Facades\Auth;

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

        $links = Link::where('private', '=', false)->where('user_id', '=', $id)->paginate(3);


        if (Gate::allows('list-private-links')) {
            $links = Link::where('user_id', '=', $id)->paginate(3);
        }


        return view('users.show', compact(['user', 'links']));
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

        return view('users.edit', compact(['user', 'roles']));
    }

    public function admin()
    {
        $users = User::paginate(3);
        return view('admin.index', compact('users'));
    }

    public function update(User $user, Request $request)
    {
        $data = $request->only('login', 'name', 'surname');
        if (Gate::allows('update-user-status-and-role')) {
            $user->verified = $request->verified;
            $user->role_id = $request->role;
        }
        $user->fill($data)->save();
        return redirect()->route('show_user', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
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
