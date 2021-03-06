<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Http\Requests\StoryRequest;
use App\Http\Resources\ImageResource;
use App\Http\Resources\StoryCollection;
use App\Http\Resources\StoryResource;
use App\Passage;
use App\Scene;
use App\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function published(Request $request)
    {
        return $this->crud->index($request, Story::withoutGlobalScope('author_circle_owner')
            ->where('public', true)
            ->where('status', 'complete')
        );
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
    public function show($id)
    {
        $story = Story::withoutGlobalScope('author_circle_owner')
            ->where('id', $id)->firstOrFail();
        if (!$story->public) {
            $story->load('author');
            if (!$story->author) {
                return Redirect::back()->with('error', 'You are not allowed to access this story');
            }
        }
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

    public function images(Story $story)
    {
        return ImageResource::collection($story->getMedia('images'));
    }

    public function apiList(Circle $circle)
    {
        if ($circle->id) {
            return new StoryCollection($circle->stories()->paginate());
        }
        else {
            return new StoryCollection(Story::orderBy('updated_at', 'desc')
                ->where('status', 'complete')
                ->paginate());
        }
    }

    public function apiShow(Story $story)
    {
        return new StoryResource($story);
    }

    public function first()
    {
        $story = Story::orderBy('updated_at', 'desc')->firstOrFail();
        return response()->redirectToRoute('story.show', ['story' => $story]);
    }

    public function download(Story $story)
    {
        $dir = '/tmp/storylab/' . $story->id;
        shell_exec("rm -rf $dir");
        mkdir($dir . '/lib', 0755, true);

        foreach (glob(base_path('static') . '/lib/*') as $f) {
            $fname = pathinfo($f, PATHINFO_BASENAME);
            copy($f, $dir . "/lib/$fname");
        }

        $story_json = json_encode([
            'title' => $story->title,
            'summary' => $story->summary,
            'updated_at' => strftime('%Y-%m-%d %H:%M:%S', strtotime($story->updated_at)),
        ], JSON_PRETTY_PRINT);

        $scenes = [];
        foreach ($story->scenes() as $title => $scene) {
            if (isset($scene->vars['image'])) {
                $scene->vars['image'] = pathinfo($scene->vars['image'], PATHINFO_BASENAME);
            }
            $scenes[$title] = $scene;
        }

        $scenes_json = json_encode($scenes, JSON_PRETTY_PRINT);

        $index = preg_replace([
            '/%%STORY%%/',
            '/%%SCENES%%/',
        ], [
            $story_json,
            $scenes_json,
        ], file_get_contents(base_path('static') . '/index.html'));

        file_put_contents($dir . '/index.html', $index);

        foreach ($story->getMedia('images') as $image) {
            $f = $image->getPath('preview');
            $fname = pathinfo($f, PATHINFO_BASENAME);
            copy($f, $dir . "/$fname");
        }

        $filename = "story{$story->id}.zip";
        shell_exec("cd $dir; rm -f ../$filename; zip ../$filename * lib/*");

        return response()->download("/tmp/storylab/$filename", $filename);
    }
}
