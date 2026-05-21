<?php

declare(strict_types=1);

namespace App\Models;

use App\Data\LicenseKeys\LicenseKeyConfiguration;
use App\Enums\LicenseKeyGeneratorType;
use App\Models\Builders\LicenseKeyTypeBuilder;
use Database\Factories\LicenseKeyTypeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $uuid
 * @property int $team_id
 * @property string $name
 * @property string|null $description
 * @property LicenseKeyGeneratorType $generator_type
 * @property array<array-key, mixed> $configuration
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, LicenseKey> $licenseKeys
 * @property-read int|null $license_keys_count
 * @property-read Team $team
 *
 * @method static LicenseKeyTypeFactory factory($count = null, $state = [])
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType newModelQuery()
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType newQuery()
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType query()
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereActive()
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereConfiguration($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereCreatedAt($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereDescription($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereGeneratorType($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereId($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereIsActive($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereName($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereTeam((Team|int) $team)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereTeamId($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereUpdatedAt($value)
 * @method static LicenseKeyTypeBuilder<static>|LicenseKeyType whereUuid($value)
 *
 * @mixin Model
 */
#[Fillable('team_id', 'name', 'description', 'generator_type', 'configuration', 'is_active')]
final class LicenseKeyType extends Model
{
    use HasFactory, HasUuids;

    /**
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'id' => 'integer',
            'uuid' => 'string',
            'team_id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'generator_type' => LicenseKeyGeneratorType::class,
            'configuration' => 'array',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function newEloquentBuilder($query): LicenseKeyTypeBuilder
    {
        return new LicenseKeyTypeBuilder($query);
    }

    public function configurationDto(): LicenseKeyConfiguration
    {
        /** @var array<string, mixed> $configuration */
        $configuration = $this->getAttribute('configuration') ?? [];

        return LicenseKeyConfiguration::from($this->generator_type, $configuration);
    }

    /**
     * @return BelongsTo<Team, $this>
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return HasMany<LicenseKey, $this>
     */
    public function licenseKeys(): HasMany
    {
        return $this->hasMany(LicenseKey::class);
    }
}
