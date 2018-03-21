<?php

namespace App\Console\Commands;

use App\Http\Resources\SceneResource;
use App\Scene;
use App\Story;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Knowfox\Story\Services\Story as StoryService;

class ExportScenes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:scenes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export scenes to textual representation';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = app(StoryService::class);

        Auth::loginUsingId(2);

        foreach (Story::all() as $story) {
            $this->info($story->title);
            $scenes = SceneResource::collection($story->legacyScenes)->resolve();
            $this->info(' - ' . count($scenes) . ' scenes');
            if ($story->textual_scenes === null) {
                $story->textual_scenes = $service->dump($scenes);
                $story->save();
            }
            else {
                $this->warn(" - übersprungen");
            }
        }
    }
}
