<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

final class LicenseKeysBulkCreated extends Notification
{
    use Queueable;

    public function __construct(
        public readonly int $count,
        public readonly Product $product,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * @return array<string, mixed>
     */
    public function toDatabase(): array
    {
        return [
            'title' => 'License keys created',
            'message' => sprintf(
                '%d license keys for %s were generated in the background.',
                $this->count,
                $this->product->name,
            ),
            'product_uuid' => $this->product->uuid,
            'product_name' => $this->product->name,
            'count' => $this->count,
            'url' => '/license-keys',
        ];
    }
}
