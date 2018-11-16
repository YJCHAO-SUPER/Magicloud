<?php

namespace App\Http\Controllers;

use App\DesktopModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesktopController extends Controller
{
    public function show(Request $req){
        $desktop = DesktopModel::desktopApp($req->token);
        return $desktop;
    }

}
