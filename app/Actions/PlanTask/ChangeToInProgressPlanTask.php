<?php

namespace App\Actions\PlanTask;

use App\Enums\PlanTask\PlanTaskStatus;
use App\Models\PlanTask;

class ChangeToInProgressPlanTask
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(PlanTask $planTask): void
    {
        $planTask->updateOrFail([
            'status' => PlanTaskStatus::IN_PROGRESS,
        ]);
    }
}
