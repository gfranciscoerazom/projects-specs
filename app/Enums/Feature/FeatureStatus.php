<?php

namespace App\Enums\Feature;

use App\Traits\UseValueAsLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum FeatureStatus: string implements HasColor, HasIcon, HasLabel
{
    use UseValueAsLabel;

    case PENDING = 'Pending';
    case IN_PROGRESS = 'In Progress';
    case COMPLETED = 'Completed';
    case FAILED = 'Failed';

    /**
     * Get the color for the enum case.
     */
    public function getColor(): array|string|null
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::IN_PROGRESS => 'primary',
            self::COMPLETED => 'success',
            self::FAILED => 'danger',
        };
    }

    /**
     * Get the icon for the enum case.
     */
    public function getIcon(): string|\BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::IN_PROGRESS => 'heroicon-o-arrow-path',
            self::COMPLETED => 'heroicon-o-check-circle',
            self::FAILED => 'heroicon-o-x-circle',
        };
    }
}
