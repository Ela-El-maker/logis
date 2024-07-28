<?php

namespace App\Http\Controllers\Home;

use App\Models\HomeSlide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class HomeSliderController extends Controller
{

    // //
    public function HomeSlider()
    {
        $homeSlide = HomeSlide::find(1);
        return view('admin.home_slide.home_slide_all', compact('homeSlide'));
    }

    
    public function UpdateSlider(Request $request)
{

    
    $slideId = $request->id;

    $findHomeSlide = HomeSlide::findOrFail($slideId);

    // Process foreground image
    if ($request->file('foregroundImage')) {
        $foregroundImagePath = $this->processImage($request->file('foregroundImage'), $request->title_id, 'foreground');
        if (Str::startsWith($findHomeSlide->foregroundImage, 'uploads/home_slide/')) {
            unlink(public_path($findHomeSlide->foregroundImage));
        }
    } else {
        $foregroundImagePath = $findHomeSlide->foregroundImage;
    }

    // Process background image
    if ($request->file('backgroundImage')) {
        $backgroundImagePath = $this->processImage($request->file('backgroundImage'), $request->title_id, 'background');
        if (Str::startsWith($findHomeSlide->backgroundImage, 'uploads/home_slide/')) {
            unlink(public_path($findHomeSlide->backgroundImage));
        }
    } else {
        $backgroundImagePath = $findHomeSlide->backgroundImage;
    }

    // Update the home slide with the new data
    HomeSlide::findOrFail($slideId)->update([
        'title' => $request->title,
        'sub_title' => $request->sub_title,
        'foregroundImage' => $foregroundImagePath,
        'backgroundImage' => $backgroundImagePath,
    ]);

    $notification = [
        'message' => 'Home Slide Updated Successfully.',
        'alert-type' => 'success',
    ];

    return redirect()->back()->with($notification);
}

private function processImage($uploadedFile, $title, $type)
    {
        $minWidth = 800;
        $maxWidth = 1200;
        $minHeight = 500;
        $maxHeight = 750;
    
        $currentTimestamp = time(); // Get the current timestamp
        $extension = $uploadedFile->getClientOriginalExtension(); // Get the original file extension
    
        // Generate a slug from the title
        $imageSlug = Str::slug($title);
        $imageName = $currentTimestamp . '.' . $extension;
        $uploadedFile->move('uploads/home_slide', $imageName);
    
        $imgManager = new ImageManager(new Driver());
        $thumbImage = $imgManager->read('uploads/home_slide/' . $imageName);
    
        // Construct the file name using the slug, timestamp, and original extension
        $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
        $publicDir = 'uploads/home_slide/' . $fileName; // Define the path to save the file
    
        // Get the current dimensions
        $currentWidth = $thumbImage->width();
        $currentHeight = $thumbImage->height();
    
        // Calculate the aspect ratio
        $aspectRatio = $currentWidth / $currentHeight;
    
        // Determine the new dimensions
        $newWidth = $currentWidth;
        $newHeight = $currentHeight;
    
        if ($newWidth < $minWidth || $newHeight < $minHeight) {
            // If either dimension is too small, scale up proportionally
            if ($newWidth < $minWidth) {
                $newWidth = $minWidth;
                $newHeight = $newWidth / $aspectRatio;
            }
            if ($newHeight < $minHeight) {
                $newHeight = $minHeight;
                $newWidth = $newHeight * $aspectRatio;
            }
        } elseif ($newWidth > $maxWidth || $newHeight > $maxHeight) {
            // If either dimension is too large, scale down proportionally
            if ($newWidth > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = $newWidth / $aspectRatio;
            }
            if ($newHeight > $maxHeight) {
                $newHeight = $maxHeight;
                $newWidth = $newHeight * $aspectRatio;
            }
        }
    
        // Resize the image
        $thumbImage->resize($newWidth, $newHeight);
    
        // Save the resized image to the specified path in the public directory
        $thumbImage->save(public_path($publicDir));
        unlink(public_path('uploads/home_slide/' . $imageName));
    
        return $publicDir;
    }


}
