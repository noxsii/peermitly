<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Enums\LicenseKeyStatus;
use App\Models\LicenseKey;
use App\Models\Product;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<LicenseKey>
 */
final class LicenseKeyBuilder extends Builder
{
    public function whereTeam(Team|int $team): self
    {
        return $this->where('team_id', $team instanceof Team ? $team->id : $team);
    }

    public function wherePending(): self
    {
        return $this->where('status', LicenseKeyStatus::PENDING->value);
    }

    public function whereActive(): self
    {
        return $this->where('status', LicenseKeyStatus::ACTIVE->value);
    }

    public function whereExpired(): self
    {
        return $this->where('status', LicenseKeyStatus::EXPIRED->value);
    }

    public function whereRevoked(): self
    {
        return $this->where('status', LicenseKeyStatus::REVOKED->value);
    }

    public function whereNormalizedKey(string $normalized): self
    {
        return $this->where('normalized_key', $normalized);
    }

    public function whereForProduct(Product|int $product): self
    {
        return $this->where('product_id', $product instanceof Product ? $product->id : $product);
    }
}
