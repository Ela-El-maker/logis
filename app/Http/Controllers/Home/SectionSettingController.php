<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\SectionSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Carbon;

class SectionSettingController extends Controller
{
    //

    public function section()
    {
        $sections = SectionSetting::find(1);
        return view('admin.section_setting.section_setting', compact('sections'));
    }

    public function updateSection(Request $request)
    {
        $request->validate([
            'contact_us_email'=> ['required','email'],
            'contact_us_call'=> ['required','integer'],
            'contact_us_address'=> ['required'],
            'contact_us_map'=> ['required','url'],
            'feedback_image'=> ['image', 'mimes:jpeg,png,jpg,gif'],
        ]);
        $sectionId = $request->id;
        $findSection = SectionSetting::findOrFail($sectionId);
            // Process foreground image
    if ($request->file('feedback_image')) {
        $feedbackImagePath = $this->processImage($request->file('feedback_image'), $request->title_id, 'foreground');
        if (Str::startsWith($findSection->feedback_image, 'uploads/section_setting/')) {
            unlink(public_path($findSection->feedback_image));
        }
    } else {
        $feedbackImagePath = $findSection->feedback_image;
    }

    SectionSetting::findorfail($sectionId)->update([
            'contact_us_email'=> $request-> contact_us_email ,
            'contact_us_call'=> $request-> contact_us_call ,
            'contact_us_address'=> $request->  contact_us_address,
            'contact_us_map'=> $request-> contact_us_map ,
            'feedback_image'=>$feedbackImagePath,
        ]);
       
        $notification = [
            'message' => 'SectionSetting Updated Successfully',
            'alert-type' => 'success',
        ];
    return redirect()->back()->with($notification);

    }
    private function processImage($uploadedFile, $title, $type)
{
    $minWidth = 500;
    $maxWidth = 750;
    $minHeight = 800;
    $maxHeight = 1200;

    $currentTimestamp = time(); // Get the current timestamp
    $extension = $uploadedFile->getClientOriginalExtension(); // Get the original file extension

    // Generate a slug from the title
    $imageSlug = Str::slug($title);
    $imageName = $currentTimestamp . '.' . $extension;
    $uploadedFile->move('uploads/section_setting', $imageName);

    $imgManager = new ImageManager(new Driver());
    $thumbImage = $imgManager->read('uploads/section_setting/' . $imageName);

    // Construct the file name using the slug, timestamp, and original extension
    $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
    $publicDir = 'uploads/section_setting/' . $fileName; // Define the path to save the file

    // Get the current dimensions
    $currentWidth = $thumbImage->width();
    $currentHeight = $thumbImage->height();

    // Calculate the aspect ratio
    $aspectRatio = $currentWidth / $currentHeight;

    // Determine the new dimensions ensuring height > width
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

    // Ensure height is always greater than width
    if ($newHeight <= $newWidth) {
        $newHeight = $newWidth + 1; // Ensure height is at least 1 pixel more than width
    }

    // Resize the image
    $thumbImage->resize($newWidth, $newHeight);

    // Save the resized image to the specified path in the public directory
    $thumbImage->save(public_path($publicDir));
    unlink(public_path('uploads/section_setting/' . $imageName));

    return $publicDir;
}

}
