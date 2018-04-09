<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Link;
use Gate;
use App\Services\LinkService;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Resources\Link as LinkResource;



class LinkController extends Controller
{
    private $linkservice;

    public function __construct(LinkService $linkservice)
    {
        $this->linkservice = $linkservice;
    }

    public function index()
    {

    }

    public function showMyLinks()
    {

    }

    public function show(Link $link)
    {
        $this->linkservice->show($link);
        return new LinkResource($link);
    }

    public function store(Request $request)
    {
        return $this->linkservice->create($request);
    }

    public function update(Link $link, Request $request)
    {

        return $this->linkservice->update($link, $request);

    }

    public function destroy(Link $link)
    {
        $this->linkservice->destroy($link);
    }

}