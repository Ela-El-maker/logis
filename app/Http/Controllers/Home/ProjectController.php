<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\HomeSlide;

class ProjectController extends Controller
{
    //
    public function allProjects()
    {
        $allItems = Project::all();
        return view('admin.project_page.all_projects', compact('allItems'));
    }

    public function projectItem()
    {
        $projectCategories = ProjectCategory::orderBy('project_category','ASC')->get();
        return view('admin.project_page.add_project', compact('projectCategories'));
    }

    public function storeProject(Request $request)
    {
        // Validate the request data
    $request->validate([
        'project_category_id' => ['required', 'max:100'],
        'project_name' => ['required', 'max:50'],
        'project_icon' => ['required'],
        'project_title' => ['required','max:300'],
        'project_sub_title' => ['required','max:400'],
        'project_description' => ['required'],
        'project_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        'project_image_1' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        'project_image_2' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],

    ],[
        'project_name.required' => 'Project Name is Required',
        'project_title.required' => 'Project Title is Required',
        'project_sub_title.required' => 'Project Sub Title is Required',
        'project_description.required' => 'Project Description is Required',
        'project_image.required' => 'Project Image is Required',
        'project_image_1.required' => 'Additional Project Image 1 is Required',
        'project_image_2.required' => 'Additional Project Image 2 is Required',
    ]);

      // Process blog images
      $projectImagePath = $this->processImage($request->file('project_image'), $request->project_id, 'main');
      $projectImage1Path = $this->processImage($request->file('project_image_1'), $request->project_id, 'image1');
      $projectImage2Path = $this->processImage($request->file('project_image_2'), $request->project_id, 'image2');
  


        // Insert the portfolio item into the database
        Project::create([
            'project_category_id' => $request->project_category_id,
            'project_name' => $request->project_name,
            'project_icon' => $request->project_icon,
            'project_title' => $request->project_title,
            'project_sub_title' => $request->project_sub_title,
            'project_description' => $request->project_description,
            'project_image' => $projectImagePath,
            'project_image_1' => $projectImage1Path,
            'project_image_2' => $projectImage2Path,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Project Item Added Successfully with Image.',
            'alert-type' => 'success',
        ];
    

    return redirect()->route('all.projects')->with($notification);

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
        $uploadedFile->move('uploads/projects', $imageName);
    
        $imgManager = new ImageManager(new Driver());
        $thumbImage = $imgManager->read('uploads/projects/' . $imageName);
    
        // Construct the file name using the slug, timestamp, and original extension
        $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
        $publicDir = 'uploads/projects/' . $fileName; // Define the path to save the file
    
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
        unlink(public_path('uploads/projects/' . $imageName));
    
        return $publicDir;
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
    //     $uploadedFile->move('uploads/projects', $imageName);
    
    //     $imgManager = new ImageManager(new Driver());
    //     $thumbImage = $imgManager->read('uploads/projects/' . $imageName);
    
    //     // Construct the file name using the slug, timestamp, and original extension
    //     $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
    //     $publicDir = 'uploads/projects/' . $fileName; // Define the path to save the file
    
    //     // Determine whether to set width or height to null for aspect ratio resizing
    //     $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);
    
    //     // Resize the image while maintaining the aspect ratio
    //     $thumbImage->resize($width, $height, function ($constraint) {
    //         $constraint->aspectRatio();
    //     });
    
    //     // Save the resized image to the specified path in the public directory
    //     $thumbImage->save(public_path($publicDir));
    //     unlink(public_path('uploads/projects/' . $imageName));
    
    //     return $publicDir;
    // }



    public function editProject($id)
    {
        $editProject = Project::findorfail($id);
        $projectCategories = ProjectCategory::orderBy('project_category','ASC')->get();

        return view('admin.project_page.editproject', compact('editProject','projectCategories'));
    }

    public function updateProject(Request $request)
    {
        $projectId = $request->id;
        $project = Project::findOrFail($projectId);

        // Validate the request data
        $request->validate([
            'project_category_id' => ['required', 'max:100'],
            'project_name' => ['required', 'max:50'],
            'project_icon' => ['required'],
            'project_title' => ['required', 'max:300'],
            'project_sub_title' => ['required', 'max:400'],
            'project_description' => ['required'],
            'project_image' => ['image', 'mimes:jpeg,png,jpg,gif'],
            'project_image_1' => ['image', 'mimes:jpeg,png,jpg,gif'],
            'project_image_2' => ['image', 'mimes:jpeg,png,jpg,gif'],
        ]);

        // Process project images
        $projectImagePath = $project->project_image;
        if ($request->hasFile('project_image')) {
            if (Str::startsWith($project->project_image, 'uploads/projects/')) {
                unlink(public_path($project->project_image));
            }
            $projectImagePath = $this->processImage($request->file('project_image'), $request->project_id, 'main');
        }

        $projectImage1Path = $project->project_image_1;
        if ($request->hasFile('project_image_1')) {
            if (Str::startsWith($project->project_image_1, 'uploads/projects/')) {
                unlink(public_path($project->project_image_1));
            }
            $projectImage1Path = $this->processImage($request->file('project_image_1'), $request->project_id, 'image1');
        }

        $projectImage2Path = $project->project_image_2;
        if ($request->hasFile('project_image_2')) {
            if (Str::startsWith($project->project_image_2, 'uploads/projects/')) {
                unlink(public_path($project->project_image_2));
            }
            $projectImage2Path = $this->processImage($request->file('project_image_2'), $request->project_id, 'image2');
        }

        Project::findOrFail($projectId)->update([
            'project_category_id' => $request->project_category_id,
            'project_name' => $request->project_name,
            'project_icon' => $request->project_icon,
            'project_title' => $request->project_title,
            'project_sub_title' => $request->project_sub_title,
            'project_description' => $request->project_description,
            'project_image' => $projectImagePath,
            'project_image_1' => $projectImage1Path,
            'project_image_2' => $projectImage2Path,
        ]);

        $notification = [
            'message' => 'Project Item Updated Successfully with Image.',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.projects')->with($notification);
    }


    public function deleteProject($id)
    {
         // Find the item by its ID and throw a 404 error if not found
    try {
        $item = Project::findOrFail($id);
        

            // Check if the project has associated images
            if (Str::startsWith($item->project_image, 'uploads/projects/')) {
                $imagePath = public_path($item->project_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            if (Str::startsWith($item->project_image_1, 'uploads/projects/')) {
                $imagePath1 = public_path($item->project_image_1);
                if (file_exists($imagePath1)) {
                    unlink($imagePath1);
                }
            }
            if (Str::startsWith($item->project_image_2, 'uploads/projects/')) {
                $imagePath2 = public_path($item->project_image_2);
                if (file_exists($imagePath2)) {
                    unlink($imagePath2);
                }
            }


        if ($item->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Project Item deleted successfully.'
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

    return redirect()->route('all.projects')->with($notification);

    }




    public function HomeProjectDetails($id)
{
    $projectItems = Project::findorfail($id);
    $homeSlide = HomeSlide::find(1);
    $projectCategories = ProjectCategory::orderBy('project_category','ASC')->get();
    $projectCategory = $projectItems->category; // Adjust as needed to fetch category
    return view('frontend.home_all.project', compact('projectItems', 'homeSlide','projectCategories','projectCategory'));
}

public function CategoryProject($id)
{
    $projects = Project::inRandomOrder()->limit(3)->get();
    $allProjects = Project::latest()->limit(5)->get();
    $projectPost = Project::where('project_category_id',$id)->orderBy('id','DESC')->get();
    $projectCategories = ProjectCategory::orderBy('project_category','ASC')->get();
    $categoryName = ProjectCategory::findorfail($id);
    return view('frontend.home_all.category_project_details', compact('projects','projectPost','projectCategories','allProjects','categoryName'));
}


public function projectsPage()
{
    $projects = Project::all();
    $homeSlide = HomeSlide::find(1);

    return view('frontend.home_all.all_projects', compact('projects','homeSlide'));
}

}
