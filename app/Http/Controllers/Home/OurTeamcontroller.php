<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurTeam;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Project;
use App\Models\HomeSlide;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class OurTeamcontroller extends Controller
{
    //

    public function allTeamMembers()
    {
        $allMembers = OurTeam::all();
        return view('admin.team_members.all_members', compact('allMembers'));
    }
    public function addTeamMembers()
    {
        return view('admin.team_members.add_members');
    }

    public function storeTeamMembers(Request $request)
    {
        // validate the request data
        
        $request->validate([
            'team_member_name'=> ['required', ],
            'team_member_image'=> ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            'team_member_position'=> ['required', ],
            'team_member_speech'=> ['required', ],
            'team_member_twitter'=> ['required', 'url'],
            'team_member_instagram'=> ['required', 'url'],
            'team_member_linkedIn'=> ['required', 'url'],
        ]);

        $processImagePath = $this->processImage($request->file('team_member_image'), $request->team_member_id,'profile');
        OurTeam::create([
            'team_member_name' => $request ->team_member_name,
            'team_member_image' =>$processImagePath,
            'team_member_position' => $request ->team_member_position,
            'team_member_speech' => $request ->team_member_speech,
            'team_member_twitter' => $request ->team_member_twitter,
            'team_member_instagram' => $request ->team_member_instagram,
            'team_member_linkedIn' => $request ->team_member_linkedIn,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Team Member Created Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('all.members')->with($notification);
    
    }

    public function editTeamMembers($id)
    {
        $editMembers = OurTeam::findorfail($id);
        return view('admin.team_members.edit_members',compact('editMembers'));
    }



    public function updateTeamMembers(Request $request)
{
    $memberId = $request->id;
    $member = OurTeam::findOrFail($memberId);

    $request->validate([
        'team_member_name' => ['required'],
        'team_member_image' => ['image', 'mimes:jpeg,png,jpg,gif'],
        'team_member_position' => ['required'],
        'team_member_speech' => ['required'],
        'team_member_twitter' => ['required', 'url'],
        'team_member_instagram' => ['required', 'url'],
        'team_member_linkedIn' => ['required', 'url'],
    ]);

    // Process project images
    

    // if ($request->hasFile('team_member_image')) {
    //     // Check if the current image is a valid path and delete it
    //     if ($processImagePath && Str::startsWith($processImagePath, 'uploads/team_members/')) {
    //         $oldImagePath = public_path($processImagePath);
    //         if (file_exists($oldImagePath)) {
    //             unlink($oldImagePath);
    //         }
    //     }

    //     // Process new image
    //     $processImagePath = $this->processImage($request->file('team_member_image'), $request->team_member_id, 'profile');
    // }

    $processImagePath = $member->team_member_image;
    if ($request->hasFile('team_member_image')) {
        if(Str::startsWith($member->team_member_image, 'uplaods/team_members/'))
        {
            unlink(public_path($member->team_member_image));
        }
        $processImagePath = $this->processImage($request->file('team_member_image'), $request->team_member_id,'profile');

    }

    OurTeam::findOrFail($memberId)->update([
        'team_member_name' => $request->team_member_name,
        'team_member_position' => $request->team_member_position,
        'team_member_speech' => $request->team_member_speech,
        'team_member_twitter' => $request->team_member_twitter,
        'team_member_instagram' => $request->team_member_instagram,
        'team_member_linkedIn' => $request->team_member_linkedIn,
        'team_member_image' => $processImagePath,
    ]);

    $notification = [
        'message' => 'Team Member Updated Successfully',
        'alert-type' => 'success',
    ];

    return redirect()->route('all.members')->with($notification);
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
        $uploadedFile->move('uploads/team_members', $imageName);
    
        $imgManager = new ImageManager(new Driver());
        $thumbImage = $imgManager->read('uploads/team_members/' . $imageName);
    
        // Construct the file name using the slug, timestamp, and original extension
        $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
        $publicDir = 'uploads/team_members/' . $fileName; // Define the path to save the file
    
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
        unlink(public_path('uploads/team_members/' . $imageName));
    
        return $publicDir;
    }

    public function deleteMember($id)
    {
         // Find the item by its ID and throw a 404 error if not found
    try {
        $item = OurTeam::findOrFail($id);
        

            // Check if the project has associated images
            if (Str::startsWith($item->team_member_image, 'uploads/team_members/')) {
                $imagePath = public_path($item->team_member_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
           


        if ($item->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Member deleted successfully.'
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

    return redirect()->route('all.members')->with($notification);

    }



}
