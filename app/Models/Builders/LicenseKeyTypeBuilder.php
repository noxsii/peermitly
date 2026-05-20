<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Models\LicenseKeyType;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<LicenseKeyType>
 */
final class LicenseKeyTypeBuilder extends Builder
{
    public function whereTeam(Team|int $team): self
    {
        return $this->where('team_id', $team instanceof Team ? $team->id : $team);
    }

    public function whereActive(): self
    {
        return $this->where('is_active', true);
    }
}
