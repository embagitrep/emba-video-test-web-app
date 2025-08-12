<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class UploadController extends Controller
{
    //    public function __construct(protected CDNService $CDNService)
    //    {
    //    }

    public function upload(Request $request, $type, $parent)
    {

        $photoableModel = "App\\Models\\$type";

        if (! class_exists($photoableModel)) {
            return response()->json('error', 400);
        }

        $photoableItem = $photoableModel::where('id', $parent)->first();

        $image = $request->file('file');
        $imgN = Str::uuid().time();
        $imageName = strtolower($type).DIRECTORY_SEPARATOR.$imgN.'_'.Str::slug(Str::lower($photoableItem->name)).'.webp';
        $file = $image;
        $mimeType = 'webp';
        $fileType = 'image';

        $img = ImageManager::gd()->read($file);
        $folderPath = public_path('uploads/'.strtolower($type));
        if (! file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $img->toWebp()->save(public_path('uploads/'.$imageName));

        //        $this->CDNService->store($imageName, $img->toWebp()->toString());

        $gallery = new Gallery([
            'file_name' => $imageName,
            'mime_type' => $mimeType,
            'file_type' => $fileType,
            'model_type' => $photoableModel,
            'model_id' => $parent,
        ]);

        $gallery->save();

        return response()->json(['success' => 1]);
    }

    public function getLastUploaded($type, $parent)
    {

        $photoableModel = "App\\Models\\$type";

        if (! class_exists($photoableModel)) {
            return response()->json('error', 400);
        }

        $photo = Gallery::where('model_type', $photoableModel)->where('model_id', $parent)->orderBy('created_at',
            'desc')->first();

        $filePath = public_path("uploads/$type/".$photo->file_name);
        //        $filePath = $photo->file_name;

        $ext = pathinfo($filePath, PATHINFO_EXTENSION);

        $img = '<div class="col-xs-6 col-sm-4 col-md-3 mt10 photo-block">
                        <div class="blog-item sortable" data-sortable="1">
                        <img src="'.$photo->file_name.'" class="img-responsive" style="max-height: 250px" />
                          <div class="blog-details">
                            <ul class="blog-meta">
                                <li><a class="delete-button delete btn btn-danger" href="'.route('deleteGallery',
            ['id' => $photo->id]).'">Delete</a></li>
                            </ul>
                          </div>
                          <div class="blog-content">
                          </div>
                        </div><!-- blog-item -->
                    </div>';

        $word = '<div class="col-xs-6 col-sm-4 col-md-3 mt10 photo-block">
                        <div class="blog-item sortable" data-sortable="1">
                        <a href="/uploads/'.$photo->image.'">Show</a>
                          <div class="blog-details">
                            <ul class="blog-meta">
                                <li><a class="delete-button delete btn btn-danger" href="'.route('deleteGallery',
            ['id' => $photo->id]).'">Delete</a></li>
                            </ul>
                          </div>
                          <div class="blog-content">
                          </div>
                        </div><!-- blog-item -->
                    </div>';

        $pdf = '<div class="col-xs-6 col-sm-4 col-md-3 mt10 photo-block">
                        <div class="blog-item sortable" data-sortable="1">
                        <a href="/uploads/'.$photo->image.'">Show</a>
                          <div class="blog-details">
                            <ul class="blog-meta">
                                <li><a class="delete-button delete btn btn-danger" href="'.route('deleteGallery',
            ['id' => $photo->id]).'">Delete</a></li>
                            </ul>
                          </div>
                          <div class="blog-content">
                          </div>
                        </div><!-- blog-item -->
                    </div>';
        $video = '<div class="col-xs-6 col-sm-4 col-md-3 mt10 photo-block">
                        <div class="blog-item sortable" data-sortable="1">
                         <video src="/uploads/'.$photo->image.'" class="img-responsive" style="max-height: 250px"></video>
                          <div class="blog-details">
                            <ul class="blog-meta">
                                <li><a class="delete-button delete btn btn-danger" href="'.route('deleteGallery',
            ['id' => $photo->id]).'">Delete</a></li>
                            </ul>
                          </div>
                          <div class="blog-content">
                          </div>
                        </div><!-- blog-item -->
                    </div>';

        if ($ext == 'pdf') {
            return $pdf;
        }

        if ($ext == 'doc' || $ext == 'docx') {
            return $word;
        }

        if ($ext == 'mp4' || $ext == '3gp') {
            return $video;
        }

        return $img;
    }

    public function deleteGallery($id)
    {
        $gall = Gallery::findOrFail($id);

        //        $cdnUrl = $this->CDNService->getCdnUrl();
        //        $filename = str_replace($cdnUrl, '', $gall->file_name);

        $filePath = public_path($gall->file_name);
        if ($gall->delete()) {
            @unlink($filePath);
            //            $this->CDNService->delete($filename);
        }

        return 'success';
    }

    public function sortUploaded(Request $request)
    {
        $photo = Gallery::findOrFail($request->id);
        $photo->sort = $request->sort;
        $photo->save();

        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
}
