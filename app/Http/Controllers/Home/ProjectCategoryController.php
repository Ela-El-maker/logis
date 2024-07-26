<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class ProjectCategoryController extends Controller
{
    //
     //
     public function allProjectCategory()
     {
         $projectCategory = ProjectCategory::latest()->get();
         return view('admin.project_category.all_project_caregory', compact('projectCategory'));
     }
     public function addProjectCategory()
     {
         
         return view('admin.blog_category.add_project_caregory');
     }
 
     public function storeProjectCategory(Request $request)
     {
         
     // Validate the request data
     $request->validate([
         'project_category' => ['required', 'max:100'],
         
     ],[
         'project_category.required' => 'Project Category Name is Required',
        
     ]);
 
         // Insert the project item into the database
         ProjectCategory::create([
             'project_category' => $request->project_category,
            
             'created_at' => Carbon::now(),
         ]);
 
         $notification = [
             'message' => 'Project Category Added Successfully.',
             'alert-type' => 'success',
         ];
     
     
 
     return redirect()->route('all.project.category')->with($notification);
     }
 
     public function editProjectCategory($id)
     {
         $projectCategory = ProjectCategory::findorfail($id);
         return view('admin.project_category.edit_project_caregory', compact('projectCategory'));
     }
 
     public function updateProjectCategory(Request $request)
     {
         
         $projectCategoryId = $request->id;
     // Validate the request data
     $request->validate([
         'project_category' => ['required', 'max:100'],
         
     ],[
         'project_category.required' => 'Project Category Name is Required',
        
     ]);
 
         // Insert the project item into the database
         ProjectCategory::findorfail($projectCategoryId)->update([
             'project_category' => $request->project_category,
            
             'created_at' => Carbon::now(),
         ]);
 
         $notification = [
             'message' => 'Project Category Updated Successfully.',
             'alert-type' => 'success',
         ];
     
     
 
     return redirect()->route('all.project.category')->with($notification);
     }
 
 
     public function deleteProjectCategory($id)
 {
     // Find the item by its ID and throw a 404 error if not found
     try {
         $item = ProjectCategory::findOrFail($id);
 
         if ($item->delete()) {
             return response()->json([
                 'status' => 'success',
                 'message' => 'Project Category Item deleted successfully.'
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
 
     return redirect()->route('all.project.category')->with($notification);
 
 }
}
