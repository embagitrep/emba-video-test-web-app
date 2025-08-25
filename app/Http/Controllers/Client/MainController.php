<?php

namespace App\Http\Controllers\Client;

use App\Enums\VideoStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Order;
use App\Services\Api\OrderService;
use App\Services\Client\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function __construct(
        protected readonly OrderService $orderService,
        protected readonly CheckoutService $checkoutService,
    ) {}

    public function index($sessionId)
    {
        $sessionData = $this->checkoutService->getSessionData($sessionId);

        if (! $sessionData) {
            abort(404);
        }

        $output = [];
        $output['sessionId'] = $sessionId;
        $sessionId = $sessionData->session_id;

        $output['model'] = $model = $this->orderService->getBySession($sessionId);
        $output['txtToRead'] = $model->description!=''?$model->description:getTranslation('Mən, {name} oğlu/qızı, könüllü şəkildə “Embafinans”a kredit müraciəti edirəm.',['name' => $model->name]);

        if (!$model){
            abort(404);
        }



        app()->setLocale($model->lang);

        return view('client.index.index', $output);
    }
    

    public function uploadVideo(Request $request, $sessionId)
    {


        $sessionData = $this->checkoutService->getSessionData($sessionId);

        if (! $sessionData) {
            return response()->json([
                'success' => 0,
            ],400);
        }
        $sessionId = $sessionData->session_id;
        $model = $this->orderService->getBySession($sessionId);


        $type = 'video';

        // Validate uploaded file presence and type
        $video = $request->file('video');
        $request->validate([
            'video' => 'required|file|mimes:webm,mp4,ogg|max:51200',
        ]);
        if (! $video || ! $video->isValid() || ($video->getSize() ?? 0) <= 0) {
            return response()->json([
                'success' => 0,
                'message' => 'Uploaded file is empty or invalid',
            ], 400);
        }


        $file = $video;
        $path = 'applications/' . $model->id;

        $existing = Gallery::where('model_id', $model->id)
            ->where('file_type', $type)
            ->where('model_type', Order::class)
            ->first();

        if ($existing) {
            Storage::delete($existing->file_name);
            $existing->delete();
        }


        // Avoid fopen("") issues: use Storage::put with explicit name
        $extension = $file->getClientOriginalExtension() ?: ($file->extension() ?: 'webm');
        $filename = bin2hex(random_bytes(12)) . '.' . $extension;
        $storedPath = $path . '/' . $filename;
        \Storage::put($storedPath, $file->get());


        Gallery::create([
            'model_type' => Order::class,
            'model_id' => $model->id,
            'file_name' => $storedPath,
            'mime_type' => 'video',
            'file_type' => $type,
        ]);

        $model->status = VideoStatusEnum::RECORDED;
        $model->save();

        $this->checkoutService->expireSession($sessionData);

        return response()->json([
            'success' => 1,
            'redirectUrl' => $model->redirect_url
            ]);
    }
}
