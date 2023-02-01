<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FileDownloader extends Controller
{
     public function downloadFile($folder,$fileName) {
         
         $path = public_path().'/uploads/'.$folder."/".$fileName;
         $headers = [ 'Content-Type: '.mime_content_type( $path) ];
         if (file_exists($path)) {
             return  Response::download($path,$fileName,$headers);
         } else {
             return \response()->json('File not found.',404);
         }
        
 
     }
}
