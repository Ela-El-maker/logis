<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Carbon;
use App\Models\About;
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

    public function updateAbout(Request $request)
    {
        $aboutId = $request->id;
        if ($request->file('foreground_image')) {
            $findAbout = About::findOrFail($aboutId);
            $width = 700; // Maximum width for the image
            $height = 950; // Maximum height for the image

            $currentTimestamp = time(); // Get the current timestamp, e.g., 1631703954
            $uploadedFile = $request->file('foreground_image'); // Retrieve the uploaded file from the request
            $extension = $uploadedFile->getClientOriginalExtension(); // Get the original file extension

            // Generate a slug from the title
            $imageSlug = Str::slug($request->title);
            $imageName = time().'.'.$extension;
            $uploadedFile->move('uploads/home_about',$imageName);

            $imgManager = new ImageManager(new Driver());
            $thumbImage= $imgManager->read('uploads/home_about/'.$imageName);

            // Construct the file name using the slug, timestamp, and original extension
            $fileName = $imageSlug . '-' . $currentTimestamp . '.' . $extension;
            $originalPublicDir = 'uploads/home_about/' . $fileName; // Define the path to save the file

            // Create an instance of the image from the uploaded file and correct its orientation

            // Determine whether to set width or height to null for aspect ratio resizing
            $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);

            // Resize the image while maintaining the aspect ratio
            $thumbImage->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Save the resized image to the specified path in the public directory
            $thumbImage->save(public_path($originalPublicDir));
            if (Str::startsWith($findAbout->foreground_image, 'uploads/home_about/')) {
                unlink(public_path($findAbout->foreground_image));
            }
            unlink(public_path('uploads/home_about/'.$imageName));

            About::findOrFail($aboutId)->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'foreground_image' => $originalPublicDir,
            ]);

            $notification = [
                'message' => 'About Page Updated with image Successfully.',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } else {
            About::findorfail($aboutId)->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                
            ]);

            $notification = [
                'message' => 'About Page Updated without image Successfully.',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        }
    }



    public  function HomeAbout()
    {
        $about = About::find(1);
    $aboutItems = AboutItems::inRandomOrder()->limit(4)->get();
    return view('frontend.home_all.about', compact('about', 'aboutItems'));
        // return view('frontend.home_all.about');
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
    // Validate the request data
//     $validatedData = $request->validate([
//         'item_icon' => ['required', 'max:200'],
//         'item_title' => ['required', 'max:500'],
//         'item_description' => ['required', 'max:700'],
//     ]);

//     // Find the item by its ID
//     $item = AboutItems::findOrFail($id);

//     // Update the item with the validated data
//     $item->icon = $validatedData['item_icon'];
//     $item->title = $validatedData['item_title'];
//     $item->description = $validatedData['item_description'];

//     // Save the updated item to the database
//     $item->save();

//     // Optionally, you can redirect or return a response
//     return redirect()->route('items.index')->with('success', 'Item updated successfully.');
// }

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



