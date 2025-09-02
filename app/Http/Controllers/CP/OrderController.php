<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();
        $query->with('merchant');
        $query->orderByDesc('id');

        $output = [];
        $output['merchants'] = selectOptionArrGeneratorByKey(Merchant::select('id', 'name')->orderBy('name')->pluck('name', 'id')->toArray());
        $output['selectedMerchant'] = null;

        $filters = $request->get('filters');

        // Sanitize incoming filters to avoid trailing/leading whitespace issues (e.g., %09 tabs)
        if (is_array($filters)) {
            $sanitizedFilters = [];
            foreach ($filters as $filterKey => $filterValue) {
                $sanitizedFilters[$filterKey] = is_string($filterValue) ? trim($filterValue) : $filterValue;
            }
            $request->merge(['filters' => $sanitizedFilters]);
            $filters = $sanitizedFilters;
        }

        if (!empty($filters['merchant_id'])) {
            $output['selectedMerchant'] = $filters['merchant_id'];

            $query->where('merchant_id', $output['selectedMerchant']);
        }

        // Apply app_id filter with exact match for full IDs, partial match otherwise
        if (!empty($filters['app_id'])) {
            $appIdFilter = $filters['app_id'];

            // Heuristic: treat long, hyphenated tokens as a full ID → exact match
            if (preg_match('/^[A-Za-z0-9\-]{20,}$/', $appIdFilter) === 1) {
                $query->where('app_id', $appIdFilter);
            } else {
                $query->where('app_id', 'like', "%{$appIdFilter}%");
            }
        }

        $dataProvider = new EloquentDataProvider($query);
        $output['dataProvider'] = $dataProvider;


        return view('cp.order.index', $output);
    }

    public function videos(Request $request, Merchant $merchant, $appId)
    {
        $orders = Order::with('gallery')->where('merchant_id', $merchant->id)->where('app_id', $appId)->get();
        $output = [];
        $output['orders'] = $orders;
        $output['appId'] = $appId;

        return view('cp.order.videos', $output);
    }

    public function videosPublic($appId)
    {
        // Prefer the most recent order that actually has a video in gallery
        $order = Order::with('gallery')
            ->where('app_id', $appId)
            ->whereHas('gallery', function($q){
                $q->where('file_type', 'video');
            })
            ->orderByDesc('created_at')
            ->first();
        $output = [];
        if (!$order) {
            abort(404);
        }
        $output['order'] = $order;
        $output['appId'] = $appId;

        return view('cp.order.videos-public', $output);
    }

    public function streamVideo(Request $request, $appId)
    {
        $order = Order::with('gallery')->where('app_id', $appId)->orderByDesc('created_at')->first();

        if (! $order) {
            abort(404);
        }

        $video = $order->gallery()->orderBy('created_at', 'desc')->first();


        if (!$video) {
            return false;
        }

        if (!Storage::exists($video->file_name)) {
            abort(404);
        }

        return response()->file(storage_path('app/' . $video->file_name), [
            'Content-Type' => 'video/mp4'
        ]);
    }

    public function headStreamVideoByAppId(Request $request, $appId)
    {
        $order = Order::with('gallery')
            ->where('app_id', $appId)
            ->whereHas('gallery', function($q){
                $q->where('file_type', 'video');
            })
            ->orderByDesc('created_at')
            ->first();

        if (!$order) {
            abort(404);
        }

        $video = $order->gallery()->orderBy('created_at', 'desc')->first();
        if (!$video || !Storage::exists($video->file_name)) {
            abort(404);
        }

        $size = Storage::size($video->file_name);

        return response(null, 200, [
            'Content-Type' => 'video/mp4',
            'Content-Length' => $size,
        ]);
    }
}

