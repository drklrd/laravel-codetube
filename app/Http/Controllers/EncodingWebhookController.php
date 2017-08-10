<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;


// USED ONLY IF TELESTREAM SERVER IS USED

class EncodingWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $event = camel_case($request->event); // event from telestream server

        if(method_exists($this,$event)){
            $this->{$event}{$request};
        }
    }

    protected function videoEncoded(Request $request)
    {
        $video = $this->getVideoByFilename($request->original_filename);

        $video->processed = true;
        $video->video_id = $request->encoding_ids[0];

        $video->save();
    }

    protected function encodingProgress(Request $request)
    {
        $video = $this->getVideoByFilename($request->original_filename);

        $video->processed_percentage = $request->progress;
        $video->save();
    }


    protected function getVideoByFilename($filename)
    {
        return Video::where('video_filename',$filename)->firstOrFail();
    }



}
