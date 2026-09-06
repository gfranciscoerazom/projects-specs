<?php

namespace App\Actions\PlanTask;

use App\Enums\PlanTask\PlanTaskStatus;
use App\Models\PlanTask;

class ChangeToCompletedPlanTask
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(PlanTask $planTask): void
    {
        $planTask->updateOrFail([
            'status' => PlanTaskStatus::COMPLETED,
        ]);
    }
}
