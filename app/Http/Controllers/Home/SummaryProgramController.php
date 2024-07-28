<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SummaryProgram;

class SummaryProgramController extends Controller
{
    //

    public function summary()
    {
        $allSummary = SummaryProgram::find(1);
        return view('admin.summary.add_summary',compact('allSummary'));
    }

    public function updateSummary(Request $request)
    {
        $request->validate([
            'summary_clients'=> ['integer'],
            'summary_projects'=> ['integer'],
            'summary_support'=> ['integer'],
            'summary_workers'=> ['integer'],
        ]);
        $summaryId = $request->id;

        SummaryProgram::findorfail($summaryId)->update([
            'summary_clients'=>$request->summary_clients,
            'summary_projects'=>$request->summary_projects,
            'summary_support'=>$request->summary_support,
            'summary_workers'=>$request->summary_workers,
        ]);
       
        $notification = [
            'message' => 'Summaries Updated Successfully',
            'alert-type' => 'success',
        ];
    return redirect()->back()->with($notification);

    }


    
}
