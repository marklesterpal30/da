<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Purpose;

class UserOutgoingController extends Controller
{
    public function showCreatorOutgoing(){
        $purposes = Purpose::all()->where('purpose_type', 'incoming');

        return view('user.outgoing.outgoing', compact(
            'purposes'
        ));
    }
}
