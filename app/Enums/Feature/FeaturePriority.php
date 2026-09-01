<?php

namespace App\Enums\Feature;

use App\Traits\UseValueAsLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum FeaturePriority: string implements HasColor, HasIcon, HasLabel
{
    use UseValueAsLabel;

    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';

    /**
     * Get the color for the enum case.
     */
    public function getColor(): array|string|null
    {
        return match ($this) {
            self::LOW => 'gray',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger',
        };
    }

    /**
     * Get the icon for the enum case.
     */
    public function getIcon(): string|\BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::LOW => 'heroicon-o-arrow-down',
            self::MEDIUM => 'heroicon-o-arrow-right',
            self::HIGH => 'heroicon-o-arrow-up',
        };
    }
}
