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

    // public function UpdateSlider(Request $request)
    // {
    //     $slideId = $request->id;
    //     if ($request->file('home_slide')) {
    //         $findHomeSlide = HomeSlide::findOrFail($slideId);
    //         $width = 636; // Maximum width for the image
    //         $height = 852; // Maximum height for the image

    //         $currentTimestamp = time(); // Get the current timestamp, e.g., 1631703954
    //         $uploadedFile = $request->file('home_slide'); // Retrieve the uploaded file from the request
    //         $extension = $uploadedFile->getClientOriginalExtension(); // Get the original file extension

    //         // Generate a slug from the title
    //         $imageSlug = Str::slug($request->title);
    //         $imageName = time().'.'.$extension;
    //         $uploadedFile->move('uploads/home_slide',$imageName);

    //         $imgManager = new ImageManager(new Driver());
    //         $thumbImage= $imgManager->read('uploads/home_slide/'.$imageName);

    //         // Construct the file name using the slug, timestamp, and original extension
    //         $fileName = $imageSlug . '-' . $currentTimestamp . '.' . $extension;
    //         $originalPublicDir = 'uploads/home_slide/' . $fileName; // Define the path to save the file

    //         // Create an instance of the image from the uploaded file and correct its orientation

    //         // Determine whether to set width or height to null for aspect ratio resizing
    //         $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);

    //         // Resize the image while maintaining the aspect ratio
    //         $thumbImage->resize($width, $height, function ($constraint) {
    //             $constraint->aspectRatio();
    //         });

    //         // Save the resized image to the specified path in the public directory
    //         $thumbImage->save(public_path($originalPublicDir));
    //         if (Str::startsWith($findHomeSlide->home_slide, 'uploads/home_slide/')) {
    //             unlink(public_path($findHomeSlide->home_slide));
    //         }
    //         unlink(public_path('uploads/home_slide/'.$imageName));

    //         HomeSlide::findOrFail($slideId)->update([
    //             'title' => $request->title,
    //             'sub_title' => $request->sub_title,
    //             'foregroundImage' => $originalPublicDir,
    //             'backgroundImage' => $originalPublicDir,

    //         ]);

    //         $notification = [
    //             'message' => 'Home Slide Updated with images Successfully.',
    //             'alert-type' => 'success',
    //         ];

    //         return redirect()->back()->with($notification);
    //     } else {
    //         HomeSlide::findorfail($slideId)->update([
    //             'title' => $request->title,
    //             'sub_title' => $request->sub_title,
    //             'video_url' => $request->video_url,
    //         ]);

    //         $notification = [
    //             'message' => 'Home Slide Updated without images Successfully.',
    //             'alert-type' => 'success',
    //         ];

    //         return redirect()->back()->with($notification);
    //     }
    // }

    public function UpdateSlider(Request $request)
{

    
    $slideId = $request->id;

    $findHomeSlide = HomeSlide::findOrFail($slideId);

    // Process foreground image
    if ($request->file('foregroundImage')) {
        $foregroundImagePath = $this->processImage($request->file('foregroundImage'), $request->title, 'foreground');
        if (Str::startsWith($findHomeSlide->foregroundImage, 'uploads/home_slide/')) {
            unlink(public_path($findHomeSlide->foregroundImage));
        }
    } else {
        $foregroundImagePath = $findHomeSlide->foregroundImage;
    }

    // Process background image
    if ($request->file('backgroundImage')) {
        $backgroundImagePath = $this->processImage($request->file('backgroundImage'), $request->title, 'background');
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
    $width = 636; // Maximum width for the image
    $height = 852; // Maximum height for the image

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

    // Determine whether to set width or height to null for aspect ratio resizing
    $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);

    // Resize the image while maintaining the aspect ratio
    $thumbImage->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    });

    // Save the resized image to the specified path in the public directory
    $thumbImage->save(public_path($publicDir));
    unlink(public_path('uploads/home_slide/' . $imageName));

    return $publicDir;
}

}
