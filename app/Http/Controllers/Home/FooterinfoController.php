<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterInfo;
class FooterinfoController extends Controller
{
    //

    public function footerInfo()
    {
        $footerInfo = FooterInfo::find(1);
        return view('admin.settings.footer.footer_info.index', compact('footerInfo'));
    }

    public function updateFooterInfo(Request $request)
    {
        $request->validate([
            'info_title'=> ['required'],
            'info_description'=> ['required'],
            
        ]);
        $infoId = $request->id;

        FooterInfo::findorfail($infoId)->update([
            'info_title'=>$request->info_title,
            'info_description'=>$request->info_description,
        
        ]);
       
        $notification = [
            'message' => 'Information Updated Successfully',
            'alert-type' => 'success',
        ];
    return redirect()->back()->with($notification);
    }
}
