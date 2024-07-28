<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Carbon;
use App\Models\About;
use App\Models\OurTeam;
use App\Models\HomeSlide;
use App\Models\AboutItems;
use Illuminate\Support\Facades\Log;


class AboutController extends Controller
{
    //
    public function AboutPage()
    {
        $aboutPage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutPage'));
        
        
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
        $uploadedFile->move('uploads/home_about', $imageName);
    
        $imgManager = new ImageManager(new Driver());
        $thumbImage = $imgManager->read('uploads/home_about/' . $imageName);
    
        // Construct the file name using the slug, timestamp, and original extension
        $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
        $publicDir = 'uploads/home_about/' . $fileName; // Define the path to save the file
    
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
        unlink(public_path('uploads/home_about/' . $imageName));
    
        return $publicDir;
    }

    public function updateAbout(Request $request)
    {
        $aboutId = $request->id;
        $findAbout = About::findOrFail($aboutId);
        
        // Process foreground image
    if ($request->file('foreground_image')) {
        $foregroundImagePath = $this->processImage($request->file('foreground_image'), $request->title_id, 'foreground');
        if (Str::startsWith($findAbout->foreground_image, 'uploads/home_about/')) {
            unlink(public_path($findAbout->foreground_image));
        }
    } else {
        $foregroundImagePath = $findAbout->foreground_image;
    }

            About::findOrFail($aboutId)->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'foreground_image' => $foregroundImagePath,
            ]);

            $notification = [
                'message' => 'About Page Updated with image Successfully.',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
       
    }



    public  function HomeAbout()
    {
        $about = About::find(1);
        $home_slide = HomeSlide::find(1);
        $teamMembers = OurTeam::inrandomorder()->limit(3)->get();
        $aboutItems = AboutItems::inRandomOrder()->limit(4)->get();
        return view('frontend.home_all.about', compact('about', 'aboutItems','teamMembers','home_slide'));
        
    }

    public function aboutItem()
    {

        return view('admin.about_page.add_about_items');
    }

    public function storeItem(Request $request)
    {
        $validatedData = $request->validate([
            'item_icon' => ['required','max:200'],
            'item_title' => ['required', 'max:500'],
            'item_description' => ['required', 'max:700'],
        ]);

           // Create a new item instance and fill it with the validated data
    $item = new AboutItems();
    $item->item_icon = $validatedData['item_icon'];
    $item->item_title = $validatedData['item_title'];
    $item->item_description = $validatedData['item_description'];

    // Save the item to the database
    $item->save();

    // Optionally, you can redirect or return a response
    $notification = [
        'message' => 'About Item Created Successfully.',
        'alert-type' => 'success',
    ];

    return redirect()->route('all.item')->with($notification);
}

public function allItem()
{
    $allItems = AboutItems::all();
    return view('admin.about_page.about_items', compact('allItems'));
}

public function editItem($id)
{
    $editItems = AboutItems::findorfail($id);
    return view('admin.about_page.edit_about_items', compact('editItems'));
}


       
public function updateItem(Request $request)
{


$itemId = $request->id;
$validatedData = $request->validate([
    'item_icon' => ['required','max:200'],
    'item_title' => ['required', 'max:500'],
    'item_description' => ['required', 'max:700'],
]);

$item = AboutItems::findorfail($itemId);
$item->item_icon = $validatedData['item_icon'];
$item->item_title = $validatedData['item_title'];
$item->item_description = $validatedData['item_description'];

// Save the item to the database
$item->save();

// Optionally, you can redirect or return a response
$notification = [
'message' => 'About Item Updated Successfully.',
'alert-type' => 'success',
];

return redirect()->route('all.item')->with($notification);
}


public function deleteItem($id)
{
    // Find the item by its ID and throw a 404 error if not found
    try {
        $item = AboutItems::findOrFail($id);

        if ($item->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Item deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete the item.'
            ], 500);
        }
    } catch (\Exception $e) {
        Log::error('Error deleting item: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while deleting the item.'
        ], 500);
    }

    return redirect()->route('all.item')->with($notification);
}

        
    }



