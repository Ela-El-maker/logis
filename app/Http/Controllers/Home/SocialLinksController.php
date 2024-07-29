<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialLinks;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SocialLinksController extends Controller
{
    //
    public function allSocials()
    {
        $allItems = SocialLinks::all();
        return view('admin.settings.footer.social_links.index', compact('allItems'));
    }

    public function socialItem()
    {
        return view('admin.settings.footer.social_links.create');
    }
    public function storeSocial(Request $request)
    {
        // Validate the request data
    $request->validate([
        
        'social_icon' => ['required'],
        'social_url' => ['required','url'],
    ]);

     

        // Insert the portfolio item into the database
        SocialLinks::create([
            'social_icon' => $request->social_icon,
            'social_url' => $request->social_url,
            
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Social Media Added Successfully .',
            'alert-type' => 'success',
        ];
    

    return redirect()->route('all.socials')->with($notification);

    }


    public function editSocial($id)
    {
        $editSocial = SocialLinks::findorfail($id);
        return view('admin.settings.footer.social_links.edit', compact('editSocial'));

    }

    public function updateSocial(Request $request)
    {
        $socialid = $request->id;

        // Validate the request data
        $request->validate([
        
            'social_icon' => ['required'],
            'social_url' => ['required','url'],
        ]);

        
        SocialLinks::findOrFail($socialid)->update([
            'social_icon' => $request->social_icon,
            'social_url' => $request->social_url,
        ]);

        $notification = [
            'message' => 'Social Media Updated Successfully.',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.socials')->with($notification);
    }


    public function deleteSocial($id)
    {
         // Find the item by its ID and throw a 404 error if not found
    try {
        $item = SocialLinks::findOrFail($id);
        

            

        if ($item->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Social media deleted successfully.'
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

    return redirect()->route('all.socials')->with($notification);

    }


}
