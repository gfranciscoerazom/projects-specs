<?php

namespace App\Actions\AcceptanceCriteria;

use App\Models\AcceptanceCriteria;

class MarkAsIsMetAcceptanceCriteria
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(AcceptanceCriteria $criteria): void
    {
        $criteria->updateOrFail(['is_met' => true]);
    }
}
