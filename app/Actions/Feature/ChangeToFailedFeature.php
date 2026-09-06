<?php

namespace App\Actions\Feature;

use App\Enums\Feature\FeatureStatus;
use App\Models\Feature;

class ChangeToFailedFeature
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(Feature $feature): void
    {
        $feature->updateOrFail([
            'status' => FeatureStatus::FAILED,
        ]);
    }
}
