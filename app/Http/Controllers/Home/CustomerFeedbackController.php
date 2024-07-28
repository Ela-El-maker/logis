<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerFeedback;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CustomerFeedbackController extends Controller
{
    //
    public function feedbackUs()
    {
        return view('frontend.home_all.feedback');
    }

    public function storeFeedback(Request $request)
    {
        CustomerFeedback::insert([
            'feedback_name' => $request ->feedback_name,
            'feedback_email' => $request ->feedback_email,
            'feedback_company' => $request ->feedback_company,
            'feedback_position' => $request ->feedback_position,
            'feedback_phone' => $request ->feedback_phone,
            'feedback_message'=>$request->feedback_message,
            'created_at' => Carbon::now(),


        ]);
        $notification = [
            'message' => 'Feedback Received Successfully.',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);

    }

    public function getFeedbacks(){
        $allFeedbacks = CustomerFeedback::all();
        return view('admin.feedbacks.all_feedbacks',compact('allFeedbacks'));
    }

    public function deleteFeedbacks($id)
    {
        try {
            $item = CustomerFeedback::findOrFail($id);
            
    
                
    
    
            if ($item->delete()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Feedback Comment deleted successfully.'
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
    
        return redirect()->route('get.feedbacks')->with($notification);
    
         
    }
}
