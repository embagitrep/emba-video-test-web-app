<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\VideoStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Order;
use App\Services\Client\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UploadController extends Controller
{
    public function __construct(protected readonly CheckoutService $checkoutService) {}

    /**
     * Upload video from mobile app using temporary session token.
     * Request: multipart/form-data with fields: token, video (file)
     * Response: { success: 1, redirectUrl: string }
     */
    public function video(Request $request)
    {
		$reqId = (string) Str::uuid();
		$ctx = [
			'request_id' => $reqId,
			'ip' => $request->ip(),
			'user_agent' => (string) $request->header('User-Agent', ''),
			'content_type' => (string) $request->header('Content-Type', ''),
			'content_length' => (string) $request->header('Content-Length', ''),
			'has_file_video' => $request->hasFile('video'),
		];

		Log::info('API Upload: incoming request', $ctx);

		try {
			$request->validate([
				'token' => 'required|string',
			]);
			$token = (string) $request->input('token');
			$maskedToken = strlen($token) > 8 ? substr($token, 0, 4) . '...' . substr($token, -4) : $token;
			Log::info('API Upload: token validated', $ctx + ['token' => $maskedToken]);

			$sessionData = $this->checkoutService->getSessionData($token);
			if (! $sessionData) {
				Log::warning('API Upload: invalid or expired token', $ctx + ['token' => $maskedToken]);
				return response()->json(['success' => 0, 'message' => 'Invalid or expired token'], 400);
			}

			$sessionId = $sessionData->session_id;
			Log::info('API Upload: session resolved', $ctx + ['session_id' => $sessionId]);

			$model = app(\App\Services\Api\OrderService::class)->getBySession($sessionId);
			if (! $model) {
				Log::warning('API Upload: order not found for session', $ctx + ['session_id' => $sessionId]);
				return response()->json(['success' => 0, 'message' => 'Order not found'], 404);
			}

			$path = 'applications/' . $model->id;
			Log::info('API Upload: storage path prepared', $ctx + ['path' => $path, 'order_id' => $model->id]);

			$existing = Gallery::where('model_id', $model->id)
				->where('file_type', 'video')
				->where('model_type', Order::class)
				->first();
			if ($existing) {
				Log::info('API Upload: existing video found, deleting', $ctx + ['existing_id' => $existing->id, 'existing_path' => $existing->file_name]);
				Storage::delete($existing->file_name);
				$existing->delete();
			}

			$storedPath = null;
			if ($request->hasFile('video')) {
				$request->validate([
					'video' => 'required|file|mimes:webm,mp4,ogg|max:51200',
				]);
				$file = $request->file('video');
				$uploadMeta = [
					'client_original_name' => $file?->getClientOriginalName(),
					'client_mime' => $file?->getClientMimeType(),
					'client_ext' => $file?->getClientOriginalExtension(),
					'size' => $file?->getSize(),
				];
				if (! $file->isValid()) {
					Log::warning('API Upload: invalid uploaded file', $ctx + $uploadMeta);
					return response()->json(['success' => 0, 'message' => 'Invalid uploaded file'], 400);
				}
				// Store via Storage::put to avoid fopen("") issues on some environments
				if ((int) ($file?->getSize() ?? 0) <= 0) {
					Log::warning('API Upload: uploaded file size is zero', $ctx + $uploadMeta);
					return response()->json(['success' => 0, 'message' => 'Uploaded file is empty'], 400);
				}
				$extension = $file->getClientOriginalExtension() ?: ($file->extension() ?: 'mp4');
				$filename = bin2hex(random_bytes(12)) . '.' . $extension;
				$storedPath = $path . '/' . $filename;
				Storage::put($storedPath, $file->get());
				Log::info('API Upload: file stored from multipart', $ctx + $uploadMeta + ['stored_path' => $storedPath]);
			} else {
				$contentType = (string) $request->header('Content-Type', '');
				if (str_starts_with($contentType, 'video/')) {
					$extension = match ($contentType) {
						'video/mp4' => 'mp4',
						'video/webm' => 'webm',
						'video/ogg' => 'ogg',
						default => null,
					};
					if ($extension === null) {
						Log::warning('API Upload: unsupported content type', $ctx + ['content_type' => $contentType]);
						return response()->json(['success' => 0, 'message' => 'Unsupported video content type'], 415);
					}
					$content = $request->getContent();
					if ($content === '' || $content === false) {
						Log::warning('API Upload: empty request body', $ctx);
						return response()->json(['success' => 0, 'message' => 'Empty request body'], 400);
					}
					$filename = bin2hex(random_bytes(12)) . '.' . $extension;
					$storedPath = $path . '/' . $filename;
					Storage::put($storedPath, $content);
					Log::info('API Upload: file stored from raw body', $ctx + ['stored_path' => $storedPath, 'bytes' => strlen($content)]);
				}
			}

			if (! $storedPath) {
				Log::warning('API Upload: no video provided', $ctx);
				return response()->json(['success' => 0, 'message' => 'No video provided. Use form-data field "video" or send raw body with Content-Type: video/*'], 400);
			}

			$gallery = Gallery::create([
				'model_type' => Order::class,
				'model_id' => $model->id,
				'file_name' => $storedPath,
				'mime_type' => 'video',
				'file_type' => 'video',
			]);
			Log::info('API Upload: gallery record created', $ctx + ['gallery_id' => $gallery->id]);

			$model->status = VideoStatusEnum::RECORDED;
			$model->save();
			Log::info('API Upload: order status updated', $ctx + ['order_id' => $model->id, 'status' => (string) VideoStatusEnum::RECORDED->value]);

			$this->checkoutService->expireSession($sessionData);
			Log::info('API Upload: session expired', $ctx + ['session_id' => $sessionId]);

			$watchUrl = route('api.video.watch', ['order' => $model->id]);
			Log::info('API Upload: success response', $ctx + ['redirect_url' => $model->redirect_url, 'watch_url' => $watchUrl]);
			return response()->json([
				'success' => 1,
				'redirectUrl' => $model->redirect_url,
				'watchUrl' => $watchUrl,
			]);
		} catch (ValidationException $e) {
			Log::warning('API Upload: validation failed', $ctx + [
				'errors' => $e->errors(),
			]);
			return response()->json([
				'success' => 0,
				'message' => 'Validation failed',
				'errors' => $e->errors(),
			], 422);
		} catch (\Throwable $e) {
			Log::error('API Upload: unhandled exception', $ctx + [
				'exception' => get_class($e),
				'message' => $e->getMessage(),
				'file' => $e->getFile(),
				'line' => $e->getLine(),
			]);
			return response()->json(['success' => 0, 'message' => 'Server error'], 500);
		}
    }
}


