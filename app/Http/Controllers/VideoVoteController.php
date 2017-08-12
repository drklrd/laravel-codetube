<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Video;
use App\Http\Requests\CreateVoteRequest;

class VideoVoteController extends Controller
{
    public function index(Request $request, Video $video)
    {
        $response = [
            'up' => null,
            'down' => null,
            'can_vote' => $video->votesAllowed(),
            'user_vote' => null
        ];

        if($video->votesAllowed()){
            $response['up'] = $video->upVotes()->count();
            $response['down'] = $video->downVotes()->count();
        }

        if($request->user()){
            $voteFromUser = $video->voteFromUser($request->user())->first();
            $response['user_vote'] = $voteFromUser ? $voteFromUser->type : null;
        }

        return response()->json([
            'data' => $response
        ]);
    }

    public function create(CreateVoteRequest $request, Video $video){
        $this->authorize('vote',$video); // can be used since defined in Video Policy

        $video->voteFromUser($request->user())->delete();

        $video->votes()->create([
            'type' => $request->type,
            'user_id' => $request->user()->id,
        ]);

        return response()->json(null,200);


    }

    public function remove(CreateVoteRequest $request, Video $video){
        $this->authorize('vote',$video); // can be used since defined in Video Policy

        $video->votesFromUser($request->user())->delete();

        return response()->json(null,200);



    }


}