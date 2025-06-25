<?php

namespace App\Http\Controllers\Ams;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class InstallJobsController extends Controller
{
    //This is the controller for the install jobs
    public function index()
    {
        // Get list of unique counties
        $counties = \DB::table('county')
            ->select('county', \DB::raw('MIN(id) as id'))
            ->groupBy('county')
            ->get();

        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();    
        $cities = \DB::table('county')->orderBy('city', 'asc')->get();
        // List of install jobs
        $installGallery = \DB::table('install_gallery')->get();

        return view('ams.install_upload', compact('counties', 'majCategories', 'installGallery', 'cities'));
    }
    //This is the function to add the watermark
    public function add(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'header' => 'required|string|max:255',
            'caption' => 'required|string',
            'filename' => 'required|file|mimes:jpeg,png,jpg,gif|max:10240',
            'majorcategories_id' => 'required|integer|exists:majorcategories,id', // Important: Added exists rule
            'county_id' => 'required|integer|exists:county,id',
        ]);
        // Remove spaces from header and replace with dash
        $meta_filename = str_replace(' ', '-', $validatedData['header']);

        if ($request->hasFile('filename')) {
            // Process the uploaded image
            $image = Image::make($request->file('filename')->getRealPath());

            $watermarkPath = public_path('/assets/images/logo.png');
            if (!file_exists($watermarkPath)) {
                throw new \Exception("File not found at path: $watermarkPath");
            }
            $watermark = Image::make($watermarkPath);

            // Resize watermark to 10% of the original image size
            $watermark->resize($image->width() * 0.1, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Position watermark at bottom-right
            $image->insert($watermark, 'bottom-right', 10, 10);

            // Generate a unique filename for the watermarked image
            $timestamp = now()->format('YmdHis');
            $watermarkedFilename = $meta_filename . "_wm_{$timestamp}.png";

            // Save the watermarked image to the public directory
            $image->save(public_path("storage/install-jobs/{$watermarkedFilename}"));

            // Create a square thumbnail of the image
            $thumbnail = Image::make($request->file('filename')->getRealPath());
            $thumbnail->fit(150, 150); // Create a 150x150 square thumbnail

            // Save the thumbnail to the thumbnail folder
            $thumbnailFilename = $meta_filename . "_{$timestamp}.png";
            $thumbnail->save(public_path("storage/install-jobs/thumbnail/{$thumbnailFilename}"));

            // Save the validated data along with the watermarked image filename to the database
            \DB::table('install_gallery')->insert([
                'header' => $validatedData['header'],
                'caption' => $validatedData['caption'],
                'majorcategories_id' => $validatedData['majorcategories_id'],
                'county_id' => $validatedData['county_id'],
                'img_large' => $watermarkedFilename,
                'filename' => $thumbnailFilename,
            ]);

            return back()->with('success', 'Image watermarked and data saved successfully!');
        }

        return back()->withErrors(['filename' => 'File upload failed. Please try again.']);
    
        
        return view('ams.install_upload', compact('request'));
      


        return back()->with('success', 'Image watermarked successfully!');
    }
}
