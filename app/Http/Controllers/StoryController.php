<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Http\Requests\StoryRequest;
use App\Passage;
use App\Scene;
use App\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Knowfox\Crud\Services\Crud;
use Symfony\Component\Yaml\Yaml;

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
        /*
        $scenes_data = Yaml::parse($request->yaml_scenes);
        if ($scenes_data === null) {
            return back()
                ->with('error', __('Could not parse scenes'));
        }

        $story->scenes()->get()->each(function ($scene) { $scene->delete(); });

        $scenes = [];

        // Create all the scenes first
        foreach ($scenes_data as $i => $scene_data) {
            $scene = Scene::create($scene_data + ['story_id' => $story->id]);
            $scenes[$scene->title] = [
                'scene' => $scene,
                'passages' => $scene_data['passages'],
            ];
        }

        // Create the passages, allow for forward references
        foreach ($scenes as $scene) {
            foreach ($scene['passages'] as $passage_data) {
                if (!isset($scenes[$passage_data['target']])) {
                    return back()
                        ->with('error', __('No such scene ":scene"', ['scene' => $passage_data['title']]));
                }

                $target_scene = $scenes[$passage_data['target']]['scene'];

                Passage::create([
                    'title' => $passage_data['title'],
                    'scene_id' => $scene['scene']->id,
                    'target_id' => $target_scene->id,
                ]);
            }
        }
        */
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

    public function first()
    {
        $story = Story::firstOrFail();
        return response()->redirectToRoute('story.show', ['story' => $story]);
    }
}
