<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Channel;
use App\Models\Video;


class SearchController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->q){
            return redirect('/');
        }

        $channels = Channel::search($request->q)->take(2)->get();

        return view('search.index',[
            'channels' => $channels
        ]);
    }
}
