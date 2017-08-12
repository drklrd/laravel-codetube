<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Video;

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

    
}
