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
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust maximum file size as needed
    ]);

    // Retrieve the validated input data
    $validated = $request->validated();

    // Handle file upload
    if ($request->hasFile('image')) {
        // Get the file from the request
        $imageFile = $request->file('image');

        // Generate a unique name for the file
        $imageName = uniqid('image_') . '.' . $imageFile->getClientOriginalExtension();

        // Store the file in the designated directory
        $imageFile->storeAs('public/images', $imageName);

        // Save the image details in the database
        $image = ImageModel::create([
            'image' => 'images/' . $imageName,
            // Any other fields you may have in your ImageModel
        ]);

        return $image;
    } else {
        // Handle error if no file is uploaded
        return response()->json(['error' => 'No image uploaded'], 400);
    }
}


}
