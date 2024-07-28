<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logos;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class LogosController extends Controller
{
    //
    public function logosIndex()
    {
        $logos = Logos::find(1);
        return view('admin.settings.logos.logos', compact('logos'));
    }

    
    public function updateLogos(Request $request)
{
    $logoid = $request->id;
    $findLogo = Logos::findOrFail($logoid);

    // Process logo image
    if ($request->file('logo_image')) {
        $logoImagePath = $this->processLogo($request->file('logo_image'), $request->logo_id, 'logo');
        if (Str::startsWith($findLogo->logo_image, 'uploads/logos/')) {
            unlink(public_path($findLogo->logo_image));
        }
    } else {
        $logoImagePath = $findLogo->logo_image;
    }

    // Process footer image
    if ($request->file('footer_image')) {
        $footerImagePath = $this->processLogo($request->file('footer_image'), $request->footer_id, 'footer');
        if (Str::startsWith($findLogo->footer_image, 'uploads/logos/')) {
            unlink(public_path($findLogo->footer_image));
        }
    } else {
        $footerImagePath = $findLogo->footer_image;
    }

    // Process favicon image
    if ($request->file('favicon_image')) {
        $faviconImagePath = $this->processLogo($request->file('favicon_image'), $request->favicon_id, 'favicon');
        if (Str::startsWith($findLogo->favicon_image, 'uploads/logos/')) {
            unlink(public_path($findLogo->favicon_image));
        }
    } else {
        $faviconImagePath = $findLogo->favicon_image;
    }

    // Update the record
    $findLogo->update([
        'logo_image' => $logoImagePath,
        'footer_image' => $footerImagePath,
        'favicon_image' => $faviconImagePath,
    ]);

    $notification = [
        'message' => 'Images Updated Successfully.',
        'alert-type' => 'success',
    ];

    return redirect()->back()->with($notification);
}
    private function processLogo($uploadedFile, $title, $type)
{
    $maxWidth = 300;  // Define the maximum width for logos
    $maxHeight = 300; // Define the maximum height for logos

    $currentTimestamp = time(); // Get the current timestamp
    $extension = $uploadedFile->getClientOriginalExtension(); // Get the original file extension

    // Generate a slug from the title
    $imageSlug = Str::slug($title);
    $imageName = $currentTimestamp . '.' . $extension;
    $uploadedFile->move('uploads/logos', $imageName);

    $imgManager = new ImageManager(new Driver());
    $logoImage = $imgManager->read('uploads/logos/' . $imageName);

    // Construct the file name using the slug, timestamp, and original extension
    $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
    $publicDir = 'uploads/logos/' . $fileName; // Define the path to save the file

    // Get the current dimensions
    $currentWidth = $logoImage->width();
    $currentHeight = $logoImage->height();

    // Calculate the aspect ratio
    $aspectRatio = $currentWidth / $currentHeight;

    // Determine the new dimensions to fit within the bounding box while maintaining the aspect ratio
    if ($currentWidth > $currentHeight) {
        $newWidth = $maxWidth;
        $newHeight = $maxWidth / $aspectRatio;
    } else {
        $newHeight = $maxHeight;
        $newWidth = $maxHeight * $aspectRatio;
    }

    // Ensure the new dimensions do not exceed the maximum width and height
    if ($newWidth > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = $newWidth / $aspectRatio;
    }
    if ($newHeight > $maxHeight) {
        $newHeight = $maxHeight;
        $newWidth = $newHeight * $aspectRatio;
    }

    // Resize the image
    $logoImage->resize($newWidth, $newHeight);

    // Save the resized image to the specified path in the public directory
    $logoImage->save(public_path($publicDir));
    unlink(public_path('uploads/logos/' . $imageName));

    return $publicDir;
}

}
