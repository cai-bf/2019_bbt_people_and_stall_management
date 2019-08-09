<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Detail;
use Illuminate\Support\Facades\Storage;

class DetailController extends Controller
{
    public function uploadAvatar(Request $request) {
        if (!in_array($request->file('avatar')->extension(), ['png', 'jpg', 'gif']))
            return $this->response->errorBadRequest('目前只支持jpg, png, gif格式');
        
        $user = auth()->user();
        $detail = $user->detail;

        $path = $request->file('avatar')->store('avatars', 'public');
        
        $detail->update(['avatar' => Storage::url($path)]);

        return $this->response->array([
            'avatar' => $detail->avatar
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'sex' => 'required|in:男,女,不明',
            'dormitory' => 'string',
            'room' => 'string',
            'major' => 'string',
            'college_id' => 'integer',
            'class' => 'string',
            'birth' => 'required|date',
            'origin' => 'string',
            'politics' => 'string',
            'mobile' => 'required|string|size:11',
            'shortMobile' => 'string',
            'qq' => 'string',
            'weibo' => 'string'
        ]);

        $detail = auth()->user()->detail;

        $detail->update($request->all());

        return $this->response->array($detail->toArray());
    }
}
