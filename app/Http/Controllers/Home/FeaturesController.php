<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Features;
use App\Models\HomeSlide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class FeaturesController extends Controller
{
    //
    public function allFeatures()
    {
        $allItems = Features::all();
        return view('admin.features.all_features', compact('allItems'));
    }

    public function featureItem()
    {
        return view('admin.features.add_features');
    }

    public function storeFeature(Request $request)
    {
        // validate the request data
        $request->validate([
            'feature_title' => ['required'],
            'feature_description' => ['required'],
            'feature_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ],[
            'feature_title.required' => 'Title is required',
            'feature_description.required' => 'Description is required',
            'feature_image.required' => 'Image is required',
        ]);

        $processImagePath = $this->processImage($request->file('feature_image'), $request->feature_id,'feature');
        Features::create([
            'feature_title' => $request->feature_title,
            'feature_description' => $request->feature_description,
            'feature_image' => $processImagePath,
        ]);

        $notification = [
            'message' => 'Feature Created Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('all.features')->with($notification);

    }

    private function processImage($uploadedFile,$title,$type)
    {
        $height = 600;
        $width = 800;
        
        $currentTimestamp = time();
        $extension = $uploadedFile->getClientOriginalExtension();
        $imageSlug = Str::slug($title);
        $imageName = $currentTimestamp . '.' . $extension;
        $uploadedFile->move('uploads/features',$imageName);

        $imgManager = new ImageManager(new Driver());
        $thumbImage = $imgManager->read('uploads/features/' . $imageName);
        $fileName = $imageSlug . '-' . $currentTimestamp . '-' . $type . '.' . $extension;
        $publicDir = 'uploads/features/' . $fileName;

        $thumbImage->height() > $thumbImage->width() ? ($width = null) : ($height = null);
        $thumbImage->resize($width,$height, function($constraint){
            $constraint->aspectRatio();
        });

        $thumbImage->save(public_path($publicDir));
        unlink(public_path('uploads/features/' . $imageName));


        return $publicDir;
    }

    public function editFeature($id)
    {
        $editFeature = Features::findorfail($id);
        return view('admin.features.edit_features', compact('editFeature'));
    }


    public function updateFeature(Request $request)
    {
        $featureId = $request->id;
        $feature = Features::findorfail($featureId);
        
        // validate the request data
        $request->validate([
            'feature_title' => ['required'],
            'feature_description' => ['required'],
            'feature_image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $featureImagePath = $feature->feature_image;
        if($request->hasFile('feature_image'))
        {
            if(Str::startsWith($feature->feature_image, 'uplaods/features/'))
            {
                unlink(public_path($feature->feature_image));
            }
            $featureImagePath = $this->processImage($request->file('feature_image'), $request->feature_id,'main');

        }

        Features::findorfail($featureId)->update([
            'feature_title' => $request->feature_title,
            'feature_description' => $request->feature_description,
            'feature_image' => $featureImagePath,
        ]);
        $notification = [
            'message' => 'Feature Created Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('all.features')->with($notification);
    }

    public function deleteFeature($id)
    {
        try{
            $item = Features::findorfail($id);

            if(Str::startsWith($item->feature_image, 'uploads/features/'))
            {
                $imagePath = public_path($item->feature_image);
                if(file_exists($imagePath))
                {
                    unlink($imagePath);
                }
            }
            if($item->delete())
            {
                return response() -> json([
                    'status' =>'success',
                    'message' => 'Feature deleted Successfully',
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete the item',
                ], 500);
            }

        } catch (\Exception $e)
        {
            Log::error('Error deleting items: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'an error occurred while deleting the item',
            ], 500);
        }
        return redirect('all.features')->route()->with($notification);

    }

    public function featuresPage()
    {
        $homeSlide = HomeSlide::find(1);
        $allFeatures = Features::inrandomorder()->get();
        return view('frontend.home_all.features', compact('allFeatures','homeSlide'));
    }

}
