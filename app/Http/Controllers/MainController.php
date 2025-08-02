<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index(){
        if(Auth::user() !== null) {
            $authUser = Auth::user()->name;
        }
        if(Auth::guest()){
            return redirect()->route('platform.login');
        } elseif(Auth::user()->permissions == null){
            return view('welcome', compact('authUser'));
        }
        return redirect()->route('platform.main');
    }
}
