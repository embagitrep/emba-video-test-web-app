<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    public function strSlug(Request $request, $type, $id = null)
    {
        $title = $request->title;
        //        $title = preg_replace('/[^a-zA-Z0-9\-]/', '-', $title);
        $slug = Str::slug($title);
        $i = 1;
        while ($this->slugExists($type, $slug, $id)) {
            $slug = $slug.'-'.$i++;
        }

        return response()->json([
            'success' => true,
            'slug' => $slug,
        ]);
    }

    public function slugExists($type, $slug, $id = null)
    {
        $modelName = 'App\Models\\'.ucfirst($type);
        if (! $id) {
            $exists = $modelName::where('slug', $slug)->first();
        } else {
            $exists = $modelName::where('slug', $slug)->where('id', '!=', $id)->first();
        }
        if (isset($exists) && $exists) {
            return true;
        }

        return false;
    }

    public function activatePost($id, $type, $active = 0)
    {
        $modelName = 'App\Models\\'.ucfirst($type);
        $exists = $modelName::findOrFail($id);
        if ($exists) {
            $exists->active = $active;
            if ($exists->update()) {
                return response()->json([
                    'success' => true,
                    'active' => $active,
                    'id' => $id,
                    'msg' => 'Updated',
                ]);
            }
        }

    }

    public function frontPost($id, $type, $active = 0)
    {
        $modelName = 'App\Models\\'.ucfirst($type);
        $exists = $modelName::findOrFail($id);
        if ($exists) {
            $exists->front = $active;
            if ($exists->update()) {
                return response()->json([
                    'success' => true,
                    'front' => $active,
                    'id' => $id,
                    'msg' => 'Updated',
                ]);
            }
        }

    }

    public function getBrands($gender)
    {
        if ($gender) {
            $brands = Venue::where('gender', $gender)->get();
        } else {
            $brands = Venue::all();
        }

        $html = '<option value="">Choose..</option>';
        foreach ($brands as $brand) {
            $html .= "<option value='$brand->id'>$brand->name</option>";
        }

        return $html;
    }
}
