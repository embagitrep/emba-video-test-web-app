<?php

namespace App\Services\Client\Notification;

use App\DTO\BankNotificationDto;
use App\Notifications\Bank\ChatNotification as BankChatNotification;
use App\Notifications\Bank\NewLoanRequestNotification as BankNewLoanRequestNotification;
use App\Notifications\Bank\OfferAcceptedNotification as BankOfferAcceptedNotification;
use App\Services\Client\User\UserService;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    public function notifyUsers($event, $users, $data): void
    {
        $notification = new MeetNotification($data);
        Notification::send($users, $notification);
        $event::dispatch($data, $users);
    }

    public function hasNotifications(): bool
    {
        $user = $this->userService->getLoggedUser();

        return $user->unreadNotifications()->exists();
    }

    public function markAsRead($id): void
    {
        $user = $this->userService->getLoggedUser();
        $user->unreadNotifications->where('id', $id)->markAsRead();
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

    public function getUserUnreadNotifications($limit = 20)
    {
        $user = $this->userService->getLoggedUser();

        return $user->unreadNotifications()->paginate($limit);
    }

    public function notifyBank($recipients, string $type, BankNotificationDto $data): void
    {
        $data = $data->toArray();

        match ($type) {
            'chat' => Notification::send($recipients, new BankChatNotification($data)),
            'new_loan' => Notification::send($recipients, new BankNewLoanRequestNotification($data)),
            'offer_accepted' => Notification::send($recipients, new BankOfferAcceptedNotification($data)),
            default => throw new \InvalidArgumentException("Invalid notification type: $type"),
        };
    }
}
