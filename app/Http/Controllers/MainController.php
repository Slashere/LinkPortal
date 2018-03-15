<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use Illuminate\Support\Facades\Auth;
use Gate;

class MainController extends Controller
{
    public function index()
    {

        if (Auth::user()) {
            $allLinks = Link::where('private', '=', false)->orWhere('user_id', '=', Auth::user()->id)->paginate(3);
        } else {
            $allLinks = Link::where('private', '=', false)->paginate(3);
        }


        if (Gate::allows('list-private-links')) {
            $allLinks = Link::paginate(3);
        }

        return view('welcome', compact('allLinks'));
    }
}
