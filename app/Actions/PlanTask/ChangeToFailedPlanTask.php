<?php

namespace App\Actions\PlanTask;

use App\Enums\PlanTask\PlanTaskStatus;
use App\Models\PlanTask;

class ChangeToFailedPlanTask
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(PlanTask $planTask): void
    {
        $planTask->updateOrFail([
            'status' => PlanTaskStatus::FAILED,
        ]);
    }
}
