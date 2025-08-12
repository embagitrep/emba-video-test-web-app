<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Services\CP\Notification\NotificationService;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service) {}

    public function delete($id)
    {
        $this->service->delete($id);

        return response()->json([
            'success' => 1,
        ]);
    }

    public function markAsRead($id)
    {
        $this->service->markAsRead($id);

        return response()->json([
            'success' => 1,
        ]);
    }

    public function markAllAsRead()
    {
        $this->service->markAllAsRead();

        return response()->json([
            'success' => 1,
        ]);
    }
}
