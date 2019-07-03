<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class authPracticeController extends Controller
{
    function featureA() {

        $user_name = session('user_name');
        dd($user_name);
        return response('success');
    }
}
