<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThuvienController extends Controller
{
    public function displayThuvien(){
        $trangName =["Web Hoc Tap", "abc", "dggd"];
        return(view('Thuvien',compact('trangName')));
    }
}
