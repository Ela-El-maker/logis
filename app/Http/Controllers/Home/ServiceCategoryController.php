<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\ServiceCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class ServiceCategoryController extends Controller
{
    //
     //
     public function allServiceCategory()
     {
         $serviceCategory = ServiceCategory::latest()->get();
         return view('admin.service_category.all_service_category', compact('serviceCategory'));
     }
     public function addServiceCategory()
     {
         
         return view('admin.service_category.add_service_category');
     }
 
     public function storeServiceCategory(Request $request)
     {
         
     // Validate the request data
     $request->validate([
         'service_category' => ['required', 'max:100'],
         'service_category_description'=>['required', 'max:5000'],
        'service_category_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

     ],[
         'service_category.required' => 'Service Category Name is Required',
        'service_category_description.required' => 'Service Description is required',
        'service_category_image.required' => 'Service Category Image is Required',

     ]);
     $serviceImagePath = $this->processImage($request->file('service_category_image'), $request->service_category, 'main');

 
         // Insert the service item into the database
         ServiceCategory::create([
             'service_category' => $request->service_category,
             'service_category_description' => $request->service_category_description,
             'service_category_image' => $serviceImagePath,

            
             'created_at' => Carbon::now(),
         ]);
 
         $notification = [
             'message' => 'Service Category Added Successfully.',
             'alert-type' => 'success',
         ];
     
     
 
     return redirect()->route('all.service.category')->with($notification);
     }

     private function processImage($uploadedFile, $title, $type)
    {
        $height = 636; // Maximum width for the image
        $width = 852; // Maximum height for the image
    
        $currentTimestamp = time(); // Get the current timestamp
        $extension = $uploadedFile->getClientOriginalExtension(); // Get the original file extension
    
        // Generate a slug from the title
        $imageSlug = Str::slug($title);
        $imageName = $currentTimestamp . '.' . $extension;
        $uploadedFile->move('uploads/services', $imageName);
    
        $imgManager = new ImageManager(new Driver());
        $thumbImage = $imgManager->read('uploads/services/' . $imageName);
    
        // Construct the file name using the slug, timestamp, and original extension
        $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
        $publicDir = 'uploads/services/' . $fileName; // Define the path to save the file
    
        // Determine whether to set width or height to null for aspect ratio resizing
        $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);
    
        // Resize the image while maintaining the aspect ratio
        $thumbImage->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
    
        // Save the resized image to the specified path in the public directory
        $thumbImage->save(public_path($publicDir));
        unlink(public_path('uploads/services/' . $imageName));
    
        return $publicDir;
    }
 
     public function editServiceCategory($id)
     {
         $serviceCategory = ServiceCategory::findorfail($id);
         return view('admin.service_category.edit_service_category', compact('serviceCategory'));
     }
 
     public function updateServiceCategory(Request $request)
     {
         
         $serviceCategoryId = $request->id;
        $service = ServiceCategory::findOrFail($serviceCategoryId);

     // Validate the request data
     $request->validate([
        'service_category' => ['required', 'max:100'],
        'service_category_description'=>['required', 'max:5000'],
       'service_category_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

    ],[
        'service_category.required' => 'Service Category Name is Required',
       'service_category_description.required' => 'Service Description is required',
       'service_category_image.required' => 'Service Category Image is Required',

    ]);
      // Process project images
      $serviceImagePath = $service->service_category_image;
      if ($request->hasFile('service_category_image')) {
          if (Str::startsWith($service->service_category_image, 'uploads/services/')) {
              unlink(public_path($service->service_category_image));
          }
          $serviceImagePath = $this->processImage($request->file('service_category_image'), $request->service_category, 'main');
      }
 
         // Insert the service item into the database
         ServiceCategory::findorfail($serviceCategoryId)->update([
             'service_category' => $request->service_category,
             'service_category_description' => $request->service_category_description,
             'service_category_image' => $serviceImagePath,

            
             'created_at' => Carbon::now(),
         ]);
 
         $notification = [
             'message' => 'Service Category Updated Successfully.',
             'alert-type' => 'success',
         ];
     
     
 
     return redirect()->route('all.service.category')->with($notification);
     }
 
 
     public function deleteServiceCategory($id)
 {
     // Find the item by its ID and throw a 404 error if not found
     try {
         $item = ServiceCategory::findOrFail($id);

          // Check if the Service has associated images
          if (Str::startsWith($item->service_category_image, 'uploads/services/')) {
            $imagePath = public_path($item->service_category_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
 
         if ($item->delete()) {
             return response()->json([
                 'status' => 'success',
                 'message' => 'Service Category Item deleted successfully.'
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
 
     return redirect()->route('all.service.category')->with($notification);
 
 }
}
