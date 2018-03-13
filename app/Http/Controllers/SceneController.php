<?php

namespace App\Http\Controllers;

use App\Http\Requests\SceneRequest;
use App\Scene;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Knowfox\Crud\Services\Crud;

class SceneController extends Controller
{
    protected $crud;

    public function __construct(Crud $crud)
    {
        //parent::__construct();

        $this->crud = $crud;
        $crud->setup('storylab.scene');
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
    public function store(SceneRequest $request)
    {
        list($scene, $response) = $this->crud->store($request);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function show(Scene $scene)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function edit(Scene $scene)
    {
        return $this->crud->edit($scene);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function update(SceneRequest $request, Scene $scene)
    {
        return $this->crud->update($request, $scene);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scene $scene)
    {
        //
    }
}
