<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class authPracticeController extends Controller
{
    function create(Request $request) {
        return User::create([
            'user_name' => $request->user_name,
            'api_token' => Str::random(60)
        ]);
    }

    public function update(Request $request)
    {
        $token = Str::random(60);
//        dd(User::where('user_name', $request->user_name)->first());
        $request = User::where('user_name', $request->user_name)->first();
//        $request->user()->forceFill([
//            'api_token' => hash('sha256', $token),
//        ])->save();

        $request->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();
        return ['token' => $token];
    }


    function featureA() {

        $user_name = session('user_name');
        dd($user_name);
        return response('success');
    }
}
