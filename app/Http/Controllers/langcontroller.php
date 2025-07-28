<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class langcontroller extends Controller
{
    public function setLocale($locale){
        App::setLocale($locale);
        session::put('locale',$locale);
        return back();


    }
}
