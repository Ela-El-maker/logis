<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\HelpLinks;

class HelpLinksController extends Controller
{
    //
        //
        public function allHelps()
        {
            $allItems = HelpLinks::all();
            return view('admin.settings.footer.help_links.index', compact('allItems'));
        }
    
        public function helpItem()
        {
            return view('admin.settings.footer.help_links.create');
        }
        public function storeHelp(Request $request)
        {
            // Validate the request data
        $request->validate([
            
            'help_title' => ['required'],
            'help_url' => ['required','url'],
        ]);
    
         
    
            // Insert the portfolio item into the database
            HelpLinks::create([
                'help_title' => $request->help_title,
                'help_url' => $request->help_url,
                
                'created_at' => Carbon::now(),
            ]);
    
            $notification = [
                'message' => 'Help Links Added Successfully .',
                'alert-type' => 'success',
            ];
        
    
        return redirect()->route('all.helps')->with($notification);
    
        }
    
    
        public function editHelp($id)
        {
            $editHelp = HelpLinks::findorfail($id);
            return view('admin.settings.footer.help_links.edit', compact('editHelp'));
    
        }
    
        public function updateHelp(Request $request)
        {
            $helpid = $request->id;
    
            // Validate the request data
            $request->validate([
            
                'help_title' => ['required'],
                'help_url' => ['required','url'],
            ]);
    
            
            HelpLinks::findOrFail($helpid)->update([
                'help_title' => $request->help_title,
                'help_url' => $request->help_url,
            ]);
    
            $notification = [
                'message' => 'Help Links Updated Successfully.',
                'alert-type' => 'success',
            ];
    
            return redirect()->route('all.helps')->with($notification);
        }
    
    
        public function deleteHelp($id)
        {
             // Find the item by its ID and throw a 404 error if not found
        try {
            $item = HelpLinks::findOrFail($id);
            
    
                
    
            if ($item->delete()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Help Links deleted successfully.'
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
    
        return redirect()->route('all.helps')->with($notification);
    
        }
    
    
}