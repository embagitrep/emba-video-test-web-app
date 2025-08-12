<?php

namespace App\Services\CP\Notification;

use App\DTO\BankNotificationDto;
use App\Notifications\Bank\ChatNotification as BankChatNotification;
use App\Services\CP\User\UserService;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    public function hasNotifications(): bool
    {
        $user = $this->userService->getLoggedUser();

        return $user->unreadNotifications()->exists();
    }

    public function getUnreadNotificationsCount(): int
    {
        $user = $this->userService->getLoggedUser();

        return $user->unreadNotifications()->count();
    }

    public function getUnreadNotifications()
    {
        $user = $this->userService->getLoggedUser();

        return $user->unreadNotifications()->paginate(10);
    }

    public function markAsRead($id): void
    {
        $user = $this->userService->getLoggedUser();
        $user->unreadNotifications->where('id', $id)->markAsRead();
    }

    public function markAllAsRead(): void
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
    }

    public function delete($id): void
    {
        $user = auth()->user();
        $user->notifications()->where('id', $id)->delete();
    }

    public function getUserNotifications($limit = 20)
    {
        $user = $this->userService->getLoggedUser();

        return $user->notifications()->paginate($limit);
    }

    public function notifyBank($recipients, string $type, BankNotificationDto $data): void
    {
        $data = $data->toArray();

        match ($type) {
            'chat' => Notification::send($recipients, new BankChatNotification($data)),
            'doc_uploaded' => Notification::send($recipients, new BankChatNotification($data)),
            default => throw new \InvalidArgumentException("Invalid notification type: $type"),
        };
    }
}
