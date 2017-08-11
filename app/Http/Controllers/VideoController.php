<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Http\Requests\VideoUpdateRequest;

class VideoController extends Controller
{

    public function index(Request $request)
    {
        $videos = $request->user()->videos()->latestFirst()->paginate(10); // we can use latestFirst here as we build scopeLatestFirst in Video model
        return view('video.index',[
            'videos' => $videos
        ]);
    }

    public function edit(Video $video)
    {
        $this->authorize('edit',$video); // as registered in provider and defined in VideoPolicy

        return view('video.edit',[
            'video' => $video
        ]);
    }


    public function update(VideoUpdateRequest $request, Video $video)
    {
        $this->authorize('update',$video); // as registered in provider and defined in VideoPolicy

        $video->update([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments'),
        ]);

        if($request->ajax()){
            return response()->json(null,200);
        }

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $uid = uniqid(true);

        $channel = $request->user()->channel()->first();

        $video = $channel->videos()->create([
            'uid' => $uid,
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'video_filename' => "{$uid}.{$request->extension}",
            'processed' => true, // ONLY FOR NOW WHEN TELESTREAM IS NOT USED,
            'video_id' => uniqid(true) // ONLY FOR NOW WHEN TELESTREAM IS NOT USED

        ]);

        return response()->json([
            'data' => [
                'uid' => $uid
            ]
        ]);
    }

    public function delete(Video $video)
    {
        $this->authorize('delete',$video); // as registered in provider and defined in VideoPolicy

        $video->delete();

        return redirect()->back();

    }

}
