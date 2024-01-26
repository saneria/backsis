<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\ImageModel;

class ImageController extends Controller
{

public function store(ImageRequest $request)
{
    // Validate the incoming request
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

    // retrieve the validated input data
    $validated = $request->validated();

    // handle file upload
    if ($request->hasFile('image')) {
        // gets the file from the request
        $imageFile = $request->file('image');

        // generates unique name for the file
        $imageName = uniqid('image_') . '.' . $imageFile->getClientOriginalExtension();

        
        // store the file in the designated directory
        $imageFile->storeAs('public/images', $imageName);

        $image = ImageModel::create([
            'image' => 'images/' . $imageName,

        ]);

        return $image;
    } else {
        return response()(['error' => 'No image uploaded']);
    }
}


}
