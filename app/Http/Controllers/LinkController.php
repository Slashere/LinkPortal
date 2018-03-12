<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Gate;

class LinkController extends Controller
{
    protected $link;

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allMyLinks = Link::where('user_id','=', Auth::user()->id)->get();
        return view('links.index', compact('allMyLinks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('links.create');
    }

    public function store(Request $request)
    {
        $data            = $request->only('link','title', 'description','private');
        $data['user_id'] = auth()->user()->id;
        $link            = Link::create($data);
        return redirect()->route('list_links');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        if(Gate::allows('show-private-link', $link) or $link->private == 0) {
            $link = Link::findOrFail($link->id);
            return view('links.show', compact('link'));
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    public function update(Link $link, Request $request)
    {
        $data = $request->only('link','title', 'description','private');
        $link->fill($data)->save();
        return redirect()->route('show_link', ['id' => $link->id]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        // delete
        $link = Link::findOrFail($link->id);
        $link->delete();

        return redirect()->route('main');
    }
}
