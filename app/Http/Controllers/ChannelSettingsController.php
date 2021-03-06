<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel)
    {
        $this->authorize('edit',$channel); // this we can use because we created policy  as php artisan make:policy ChannelPolicy and wired that up in AuthServiceProvider.

        return view('channel.settings.edit',[
            'channel' => $channel
        ]);
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
        $this->authorize('update',$channel); // this we can use because we created policy  as php artisan make:policy ChannelPolicy and wired that up in AuthServiceProvider.

        $channel->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);

        if($request->file('image')){

            //move to temp location
            // dispatch job

            $request->file('image')->move(storage_path() . '/uploads', $fileId =  uniqid(true));

            $this->dispatch(new UploadImage($channel , $fileId));

        }

        return redirect()->to("/channel/{$channel->slug}/edit");
    }
}
