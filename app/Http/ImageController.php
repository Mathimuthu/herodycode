<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function create()
    {
        return view('images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = base_path('assets/uploads');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);

            Image::create(['filename' => $filename]);

            return redirect()->back()->with('success', 'Image uploaded successfully!')->with('filename', $filename);
        }

        return redirect()->back()->with('error', 'No image uploaded.');
    }

    public function show($filename)
    {
        $path = base_path('assets/uploads/' . $filename);
        if (file_exists($path)) {
            return response()->file($path);
        }
        abort(404);
    }
}