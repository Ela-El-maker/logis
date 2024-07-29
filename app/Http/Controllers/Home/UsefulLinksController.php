<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsefulLinks;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UsefulLinksController extends Controller
{
    //
        //
        public function allUsefuls()
        {
            $allItems = UsefulLinks::all();
            return view('admin.settings.footer.useful_links.index', compact('allItems'));
        }
    
        public function usefulItem()
        {
            return view('admin.settings.footer.useful_links.create');
        }
        public function storeUseful(Request $request)
        {
            // Validate the request data
        $request->validate([
            
            'useful_title' => ['required'],
            'useful_url' => ['required','url'],
        ]);
    
         
    
            // Insert the portfolio item into the database
            UsefulLinks::create([
                'useful_title' => $request->useful_title,
                'useful_url' => $request->useful_url,
                
                'created_at' => Carbon::now(),
            ]);
    
            $notification = [
                'message' => 'Useful Links Added Successfully .',
                'alert-type' => 'success',
            ];
        
    
        return redirect()->route('all.usefuls')->with($notification);
    
        }
    
    
        public function editUseful($id)
        {
            $editUseful = UsefulLinks::findorfail($id);
            return view('admin.settings.footer.useful_links.edit', compact('editUseful'));
    
        }
    
        public function updateUseful(Request $request)
        {
            $usefulid = $request->id;
    
            // Validate the request data
            $request->validate([
            
                'useful_title' => ['required'],
                'useful_url' => ['required','url'],
            ]);
    
            
            UsefulLinks::findOrFail($usefulid)->update([
                'useful_title' => $request->useful_title,
                'useful_url' => $request->useful_url,
            ]);
    
            $notification = [
                'message' => 'Useful Links Updated Successfully.',
                'alert-type' => 'success',
            ];
    
            return redirect()->route('all.usefuls')->with($notification);
        }
    
    
        public function deleteUseful($id)
        {
             // Find the item by its ID and throw a 404 error if not found
        try {
            $item = UsefulLinks::findOrFail($id);
            
    
                
    
            if ($item->delete()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Useful Links deleted successfully.'
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
    
        return redirect()->route('all.usefuls')->with($notification);
    
        }
    
    
}
