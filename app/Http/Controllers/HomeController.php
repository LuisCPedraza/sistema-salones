<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Room;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard', [
            'usuarios' => User::latest()->take(5)->get(),
            'grupos'   => Group::all(),
            'salones'  => Room::all(),
        ]);
    }
}
