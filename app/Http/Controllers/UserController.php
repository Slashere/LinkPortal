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

        if (Auth::check()) {
            if (Auth::user()->id == $id) {
                $links = Link::where('user_id', '=', Auth::user()->id)->paginate(3);
            }
        } else {
            $links = Link::where('private', '=', false)->where('user_id', '=', $id)->paginate(3);
        }

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
        $user->login = $request->input('login');
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');

        if (Gate::allows('update-user-status-and-role')) {
            $user->verified = $request->input('verified');
            $user->role_id = $request->input('role');
        }

        $user->save();
        return redirect()->route('show_user', $user)->with('success', 'User was updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = User::findOrFail($user->id);
        $user->delete();
        return redirect()->route('admin_panel')->with('delete', 'User was deleted');

    }

}
