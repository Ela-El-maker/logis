<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\HomeSlide;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class ContactUsController extends Controller
{
    //
    //
    public function contactUs()
    {
        $home_slide = HomeSlide::find(1);
        return view('frontend.home_all.contact', compact('home_slide'));
    }

    public function storeContact(Request $request)
    {
        ContactUs::insert([
            'contact_name' => $request ->contact_name,
            'contact_email' => $request ->contact_email,
            'contact_subject' => $request ->contact_subject,
            'contact_message'=>$request->contact_message,
            'created_at' => Carbon::now(),


        ]);
        $notification = [
            'message' => 'Message Received Successfully.',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);

    }
    public function getMessages(){
        $allMessages = ContactUs::all();
        return view('admin.contacts.all_messages',compact('allMessages'));
    }

    public function deleteMessages($id)
    {
        try {
            $item = ContactUs::findOrFail($id);
            
    
                
    
    
            if ($item->delete()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Message deleted successfully.'
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
    
        return redirect()->route('get.messages')->with($notification);
    
         
    }
}
