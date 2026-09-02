<?php

namespace App\Enums\Project;

use App\Traits\UseValueAsLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProjectStatus: string implements HasColor, HasIcon, HasLabel
{
    use UseValueAsLabel;

    case ACTIVE = 'Active';
    case PAUSED = 'Paused';
    case CANCELLED = 'Cancelled';
    case ARCHIVED = 'Archived';

    /**
     * Get the color for the enum case.
     */
    public function getColor(): array|string|null
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::PAUSED => 'warning',
            self::CANCELLED => 'danger',
            self::ARCHIVED => 'gray',
        };
    }

    /**
     * Get the icon for the enum case.
     */
    public function getIcon(): string|\BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::ACTIVE => 'heroicon-o-check-circle',
            self::PAUSED => 'heroicon-o-pause-circle',
            self::CANCELLED => 'heroicon-o-x-circle',
            self::ARCHIVED => 'heroicon-o-archive-box',
        };
    }
}
