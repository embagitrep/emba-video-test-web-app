<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all()
    {
        $settings = Setting::paginate();

        //        dd(Setting::where('name', 'adminEmail')->first());
        return view('cp.setting.index', compact('settings'));
    }

    public function edit(Request $request, $id)
    {
        $setting = Setting::findOrfail($id);

        if ($request->isMethod('post')) {

            $setting->value = $request->value;
            $setting->update();
            Session::flash('success', 'Successfully updated');

            return back();
        }

        return view('cp.setting.edit', compact('setting'));
    }

    public function regenerateImages()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $images = Gallery::where('type', 'Product')->where('parent_id', $product->id)->get();
            foreach ($images as $image) {
                $imgN = Str::uuid().time();

                $imageName = $imgN.'.webp';
                $file = public_path('uploads/'.$image->image);

                //                $name = pathinfo($file, PATHINFO_FILENAME);

                $img = Image::make($file);

                $img->resize(508, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp')->save(public_path('uploads/'.$imageName));

                $img->resize(70, 85, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp')->save(public_path('thumb/'.$imgN.'.webp'));

                $image->image = $imageName;
                $image->save();
                //                dd($image->save());
            }
        }
    }
}
