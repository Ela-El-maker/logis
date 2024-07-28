<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Project;
use App\Models\HomeSlide;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    //
    public function allServices()
    {
        $allItems = Service::all();
        return view('admin.services.all_services', compact('allItems'));
    }

    public function serviceItem()
    {
        $serviceCategories = ServiceCategory::orderBy('service_category','ASC')->get();
        return view('admin.services.add_service', compact('serviceCategories'));
    }

    public function storeService(Request $request)
    {
        // Validate the request data
    $request->validate([
        'service_category_id' => ['required', 'max:100'],
        'service_title' => ['required','max:300'],
        'service_sub_title' => ['required'],
        'service_description' => ['required'],
        'service_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],

    ],[
        'service_title.required' => 'Service Title is Required',
        'service_sub_title.required' => 'Service Sub Title is Required',
        'service_description.required' => 'Service Description is Required',
        'service_image.required' => 'Service Image is Required',
    ]);

      
      $serviceImagePath = $this->processImage($request->file('service_image'), $request->service_id, 'main');
  


        // Insert the portfolio item into the database
        Service::create([
            'service_category_id' => $request->service_category_id,
            'service_title' => $request->service_title,
            'service_sub_title' => $request->service_sub_title,
            'service_description' => $request->service_description,
            'service_image' => $serviceImagePath,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Service Item Added Successfully with Image.',
            'alert-type' => 'success',
        ];
    

    return redirect()->route('all.services')->with($notification);

    }

    // private function processImage($uploadedFile, $title, $type)
    // {
    //     $height = 636; // Maximum width for the image
    //     $width = 852; // Maximum height for the image
    
    //     $currentTimestamp = time(); // Get the current timestamp
    //     $extension = $uploadedFile->getClientOriginalExtension(); // Get the original file extension
    
    //     // Generate a slug from the title
    //     $imageSlug = Str::slug($title);
    //     $imageName = $currentTimestamp . '.' . $extension;
    //     $uploadedFile->move('uploads/service', $imageName);
    
    //     $imgManager = new ImageManager(new Driver());
    //     $thumbImage = $imgManager->read('uploads/service/' . $imageName);
    
    //     // Construct the file name using the slug, timestamp, and original extension
    //     $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
    //     $publicDir = 'uploads/service/' . $fileName; // Define the path to save the file
    
    //     // Determine whether to set width or height to null for aspect ratio resizing
    //     $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);
    
    //     // Resize the image while maintaining the aspect ratio
    //     $thumbImage->resize($width, $height, function ($constraint) {
    //         $constraint->aspectRatio();
    //     });
    
    //     // Save the resized image to the specified path in the public directory
    //     $thumbImage->save(public_path($publicDir));
    //     unlink(public_path('uploads/service/' . $imageName));
    
    //     return $publicDir;
    // }

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
        $uploadedFile->move('uploads/service', $imageName);
    
        $imgManager = new ImageManager(new Driver());
        $thumbImage = $imgManager->read('uploads/service/' . $imageName);
    
        // Construct the file name using the slug, timestamp, and original extension
        $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
        $publicDir = 'uploads/service/' . $fileName; // Define the path to save the file
    
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
        unlink(public_path('uploads/service/' . $imageName));
    
        return $publicDir;
    }



    public function editService($id)
    {
        $editService = Service::findorfail($id);
        $serviceCategories = ServiceCategory::orderBy('service_category','ASC')->get();

        return view('admin.services.edit_service', compact('editService','serviceCategories'));
    }

    public function updateService(Request $request)
    {
        $serviceId = $request->id;
        $service = Service::findOrFail($serviceId);

        // Validate the request data
        $request->validate([
            'service_category_id' => ['required', 'max:100'],
            'service_title' => ['required', 'max:300'],
            'service_sub_title' => ['required'],
            'service_description' => ['required'],
            'service_image' => ['image', 'mimes:jpeg,png,jpg,gif'],
        
        ]);

        // Process service images
        $serviceImagePath = $service->service_image;
        if ($request->hasFile('service_image')) {
            if (Str::startsWith($service->service_image, 'uploads/services/')) {
                unlink(public_path($service->service_image));
            }
            $serviceImagePath = $this->processImage($request->file('service_image'), $request->service_id, 'main');
        }


        Service::findOrFail($serviceId)->update([
            'service_category_id' => $request->service_category_id,
            'service_title' => $request->service_title,
            'service_sub_title' => $request->service_sub_title,
            'service_description' => $request->service_description,
            'service_image' => $serviceImagePath,
        ]);

        $notification = [
            'message' => 'Service Item Updated Successfully with Image.',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.services')->with($notification);
    }


    public function deleteService($id)
    {
         // Find the item by its ID and throw a 404 error if not found
    try {
        $item = Service::findOrFail($id);
        

            // Check if the service has associated images
            if (Str::startsWith($item->service_image, 'uploads/service/')) {
                $imagePath = public_path($item->service_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }


        if ($item->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Service Item deleted successfully.'
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

    return redirect()->route('all.services')->with($notification);

    }


    public function HomeServiceDetails($id)
{
    $serviceItems = Service::findorfail($id);
    $homeSlide = HomeSlide::find(1);
    $serviceCategories = ServiceCategory::orderBy('service_category','ASC')->get();
    $serviceCategory = $serviceItems->category; // Adjust as needed to fetch category
    return view('frontend.home_all.service', compact('serviceItems', 'homeSlide','serviceCategories','serviceCategory'));
}

public function CategoryService($id)
{
    $projects = Project::inRandomOrder()->limit(3)->get();
    $allServices = Service::latest()->limit(5)->get();
    $servicePost = Service::where('service_category_id',$id)->orderBy('id','DESC')->get();
    $serviceCategories = ServiceCategory::orderBy('service_category','ASC')->get();
    $categoryName = ServiceCategory::findorfail($id);
    return view('frontend.home_all.category_service_details', compact('projects','servicePost','serviceCategories','allServices','categoryName'));
}


public function servicesPage()
{
    $services = Service::all();
    $serviceCategories = ServiceCategory::orderBy('service_category','ASC')->get();

    $homeSlide = HomeSlide::find(1);
    return view('frontend.home_all.all_services', compact('serviceCategories','homeSlide','services'));
}
}
