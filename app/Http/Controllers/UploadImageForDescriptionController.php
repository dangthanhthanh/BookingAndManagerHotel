<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UploadImageForDescriptionController extends Controller
{
    public function uploadImageForDescription(Request $request){
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('media'), $fileName);
            $url = asset('media/' . $fileName);
            return Response::json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
        return Response::json([ 'uploaded'=> 0, 'error' => 'No file uploaded.']);
    }
}
