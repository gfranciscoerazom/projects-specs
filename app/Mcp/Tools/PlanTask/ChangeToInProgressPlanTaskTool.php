<?php

namespace App\Mcp\Tools\PlanTask;

use App\Actions\PlanTask\ChangeToInProgressPlanTask;
use App\Models\PlanTask;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('A tool that changes a plan task status to in progress.')]
class ChangeToInProgressPlanTaskTool extends Tool
{
    public function handle(Request $request, ChangeToInProgressPlanTask $changeToInProgress): ResponseFactory
    {
        $validated = $request->validate(['id' => 'required|integer'], [
            'id.required' => 'The id field is required.',
            'id.integer' => 'The id field must be an integer.',
        ]);
        $planTask = PlanTask::findOrFail((int) $validated['id']);
        $changeToInProgress($planTask);

        return Response::structured(['id' => $planTask->id, 'task' => $planTask->task, 'status' => $planTask->status]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return ['id' => $schema->integer()->description('The ID of the plan task.')->required()];
    }

    /** @return array<string, Type> */
    public function outputSchema(JsonSchema $schema): array
    {
        return ['id' => $schema->integer()->required(), 'task' => $schema->string()->required(), 'status' => $schema->string()->required()];
    }
}
