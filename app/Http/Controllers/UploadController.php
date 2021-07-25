<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    function upload(Request $request){
        // $image = $request->file('image');
        // if($request->hasFile('image')){
        //     $new_name = rand().'.'.$image->getClientOriginalExtension();
        //     $image->move(public_path('/uploads/images'),$new_name);
        //     return response()->json($new_name);
        // }else{
        //     return response()->json('image null');
        // }

        $image = $request->file('image');
        $imageName='';
        foreach($image as $image){
            $new_name = rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/images'),$new_name);
            $imageName=$imageName.$new_name.",";
        }
        $imagedb=$imageName;
        return response()->json($imagedb);
    }
}
