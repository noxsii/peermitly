<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class NotificationController
{
    public function markRead(Request $request, string $notificationId): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $notification = $user->notifications()->whereKey($notificationId)->first();

        if ($notification !== null) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->unreadNotifications()->update(['read_at' => now()]);

        return back();
    }
}
