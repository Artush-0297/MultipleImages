<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Plupload;

class IndexController extends Controller
{
    public function index(){
        return view('index');
    }

    public function upload(Request $request) {
        $file = $request->allFiles();
        Plupload::receive('file', function ($file) {
            $path = time() . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $path);
        });
    }
}
