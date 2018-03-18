<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Http\Requests\StoryRequest;
use App\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Knowfox\Crud\Services\Crud;

class StoryController extends Controller
{
    protected $crud;

    public function __construct(Crud $crud)
    {
        //parent::__construct();

        $this->crud = $crud;
        $crud->setup('storylab.story');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->crud->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->crud->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoryRequest $request)
    {
        $request->merge(['owner_id' => Auth::id()]);
        list($story, $response) = $this->crud->store($request);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        $story->load('scenes.passages');
        return view('story.show', ['story' => $story]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        return $this->crud->edit($story);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(StoryRequest $request, Story $story)
    {
        return $this->crud->update($request, $story);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        //
    }

    public function apiList(Circle $circle)
    {
        if ($circle->id) {
            return $circle->stories()->paginate();
        }
        else {
            return Story::whereHas('author.circle', function($q) {
                return $q->where('owner_id', Auth::id());
            })->paginate();
        }
    }

    public function apiShow(Story $story)
    {
        $story->load('scenes.passages');
        return $story;
    }
}
