<?php

namespace App\Enums\Feature;

use App\Traits\UseValueAsLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum FeatureType: string implements HasColor, HasIcon, HasLabel
{
    use UseValueAsLabel;
    case FEATURE = 'Feature';
    case BUG = 'Bug';
    case IMPROVEMENT = 'Improvement';

    /**
     * Get the color for the enum case.
     */
    public function getColor(): array|string|null
    {
        return match ($this) {
            self::FEATURE => 'primary',
            self::BUG => 'danger',
            self::IMPROVEMENT => 'success',
        };
    }

    /**
     * Get the icon for the enum case.
     */
    public function getIcon(): string|\BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::FEATURE => 'heroicon-o-light-bulb',
            self::BUG => 'heroicon-o-bug-ant',
            self::IMPROVEMENT => 'heroicon-o-arrow-trending-up',
        };
    }
}
