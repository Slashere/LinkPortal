<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Link;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Gate;
use Illuminate\Support\Facades\File;

class LinkController extends Controller
{
    protected $link;

    public function __construct()
    {
    }

    public function gallery(Request $request)
    {

        if (Auth::user()) {
            $imageLink = Link::where(function ($query) {
                $query->where('private', '=', false)
                    ->orWhere('user_id', '=', Auth::user()->id);
                     })->whereNotNull('image')->paginate(5);
        } else {
            $imageLink = Link::whereNotNull('image')->where('private', '=', false)->paginate(5);
        }

        if (Gate::allows('list-private-links')) {
            $imageLink = Link::whereNotNull('image')->paginate(5);
        }

        if ($request->ajax()) {
            return view('links.pregallery', ['imageLink' => $imageLink])->render();
        }

        return view('links.gallery', compact('imageLink'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allMyLinks = Link::where('user_id', '=', Auth::user()->id)->paginate(3);
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

    public function store(LinkRequest $request)
    {
        $data = $request->all();
        $path = public_path() . '/images';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = '(' . uniqid() . ')' . $image->getClientOriginalName();
            $image->move($path, $data['image']);
        }
        $data['user_id'] = auth()->user()->id;

        $link = Link::create($data);
        return redirect()->route('list_links')->with('success', 'Link was created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        if (Gate::allows('show-private-link', $link) or $link->private == 0) {
            $link = Link::findOrFail($link->id);
            return view('links.show', compact('link'));
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    public function update(Link $link, LinkRequest $request)
    {
        $data = $request->all();

        $path = public_path() . '/images/';
        if ($request->hasFile('image')) {
            if (File::exists($path . $link->image)) { // unlink or remove previous image from folder
                unlink($path . $link->image);
            }
            $image = $request->file('image');
            $data['image'] = '(' . uniqid() . ')' . $image->getClientOriginalName();
            $image->move($path, $data['image']);
        }
        $data['user_id'] = auth()->user()->id;

        $link->fill($data)->save();
        return redirect()->route('show_link', ['id' => $link->id])->with('success', 'Link was updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        // delete
        $link = Link::findOrFail($link->id);
        $link->delete();

        return redirect()->route('main')->with('delete', 'Link was deleted');
    }
}
