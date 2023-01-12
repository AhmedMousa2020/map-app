<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Image;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function imageStore(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $name = time().'.'.$request->image->extension();
        $path = 'image/'.$name;
        $request->image->move(public_path('image'), $name);

        $data = [
            'name'=>$name,
            'path' => $path
        ];

      //  return response($data, Response::HTTP_CREATED);
      return $data;
    }
}
