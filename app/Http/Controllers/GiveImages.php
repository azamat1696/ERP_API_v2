<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class GiveImages extends Controller
{
public function index($path,$fileName)
{
    $path = public_path("uploads/".$path."/".$fileName);
    $file = File::get($path);
    return \response()->file($path) ;
}
}
