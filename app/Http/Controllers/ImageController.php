<?php

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function addWatermark(Request $request)
    {
        $image = Image::make($request->file('image')->getRealPath());
        $watermark = Image::make(public_path('images/logo.png'));

        // Position watermark at bottom-right
        $image->insert($watermark, 'bottom-right', 10, 10);

        // Save the watermarked image
        $timestamp = now()->format('YmdHis');
        $image->save(public_path("assets/images/watermarkimage_{$timestamp}.png"));

        return back()->with('success', 'Image watermarked successfully!');
    }

}
