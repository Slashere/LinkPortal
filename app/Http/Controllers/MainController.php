<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Support\Facades\Auth;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MainController extends Controller
{
    public function index(Request $request)
    {

        if (Auth::user()) {
            $allLinks = Link::where('private', '=', false)->orWhere('user_id', '=', Auth::user()->id)->paginate(5);
        } else {
            $allLinks = Link::where('private', '=', false)->paginate(5);
        }

        $currentPage = URL::current();;

        if (Gate::allows('list-private-links')) {
            $allLinks = Link::paginate(5);
        }

        if ($request->ajax()) {
            return view('prewelcome', ['allLinks' => $allLinks])->render();
        }

        return view('welcome', compact(['allLinks','currentPage']));
    }
}
