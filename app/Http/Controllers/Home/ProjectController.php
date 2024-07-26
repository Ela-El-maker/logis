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
        'project_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'project_image_1' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'project_image_2' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

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
      $projectImagePath = $this->processImage($request->file('project_image'), $request->blog_title, 'main');
      $projectImage1Path = $this->processImage($request->file('project_image_1'), $request->blog_title, 'image1');
      $projectImage2Path = $this->processImage($request->file('project_image_2'), $request->blog_title, 'image2');
  


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
        $height = 636; // Maximum width for the image
        $width = 852; // Maximum height for the image
    
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
    
        // Determine whether to set width or height to null for aspect ratio resizing
        $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);
    
        // Resize the image while maintaining the aspect ratio
        $thumbImage->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
    
        // Save the resized image to the specified path in the public directory
        $thumbImage->save(public_path($publicDir));
        unlink(public_path('uploads/projects/' . $imageName));
    
        return $publicDir;
    }



    public function editProject($id)
    {
        $editProject = Project::findorfail($id);
        $projectCategories = ProjectCategory::orderBy('project_category','ASC')->get();

        return view('admin.project_page.editproject', compact('editProject','projectCategories'));
    }

    public function updateProject(Request $request)
    {
        $projectId = $request->id;
        if ($request->file('project_image')) {
            $findProject = Project::findOrFail($projectId);
            $width = 636; // Maximum width for the image
            $height = 852; // Maximum height for the image

            $currentTimestamp = time(); // Get the current timestamp, e.g., 1631703954
            $uploadedFile = $request->file('project_image'); // Retrieve the uploaded file from the request
            $extension = $uploadedFile->getClientOriginalExtension(); // Get the original file extension

            // Generate a slug from the title
            $imageSlug = Str::slug($request->title);
            $imageName = time().'.'.$extension;
            $uploadedFile->move('uploads/projects',$imageName);

            $imgManager = new ImageManager(new Driver());
            $thumbImage= $imgManager->read('uploads/projects/'.$imageName);

            // Construct the file name using the slug, timestamp, and original extension
            $fileName = $imageSlug . '-' . $currentTimestamp . '.' . $extension;
            $originalPublicDir = 'uploads/projects/' . $fileName; // Define the path to save the file

            // Create an instance of the image from the uploaded file and correct its orientation

            // Determine whether to set width or height to null for aspect ratio resizing
            $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);

            // Resize the image while maintaining the aspect ratio
            $thumbImage->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Save the resized image to the specified path in the public directory
            $thumbImage->save(public_path($originalPublicDir));
            if (Str::startsWith($findProject->project_image, 'uploads/projects/')) {
                unlink(public_path($findProject->project_image));
            }
            unlink(public_path('uploads/projects/'.$imageName));

            Project::findOrFail($projectId)->update([
            'project_name' => $request->project_name,
            'project_icon' => $request->project_icon,
            'project_title' => $request->project_title,
            'project_sub_title' => $request->project_sub_title,
            'project_description' => $request->project_description,
            'project_image' => $originalPublicDir,
            ]);

            $notification = [
                'message' => 'Project Item Updated with image Successfully.',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.projects')->with($notification);
        } else {
            Project::findorfail($projectId)->update([
                'project_name' => $request->project_name,
            'project_icon' => $request->project_icon,
            'project_title' => $request->project_title,
            'project_sub_title' => $request->project_sub_title,
            'project_description' => $request->project_description,
            ]);

            $notification = [
                'message' => 'Project Item Updated without image Successfully.',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.projects')->with($notification);
        }
    }


    public function deleteProject($id)
    {
         // Find the item by its ID and throw a 404 error if not found
    try {
        $item = Project::findOrFail($id);
        
        // Check if the project has an associated image
        if (Str::startsWith($item->project_image, 'uploads/projects/')) {
            $imagePath = public_path($item->project_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
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

}
