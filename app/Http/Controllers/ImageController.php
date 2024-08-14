<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    // Show form to upload image and website link
    public function create()
    {
        return view('images.create');
    }

    // Store uploaded image and website link
    public function store(Request $request)
    {
        $request->validate([
            'website_link' => 'required|url',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Handle image upload
        $imagePath = $request->file('image')->store('images', 'public');
    
        // Save data to database
        Image::create([
            'website_link' => $request->input('website_link'),
            'image_path' => $imagePath,
        ]);
    
        return redirect()->route('images.index')->with('success', 'Image and link saved successfully!');
    }
    

    // Display all images
    public function index()
    {
        $images = Image::all();
        return view('images.index', compact('images'));
    }
}

