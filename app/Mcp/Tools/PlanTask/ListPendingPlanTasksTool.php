<?php

namespace App\Mcp\Tools\PlanTask;

use App\Enums\PlanTask\PlanTaskStatus;
use App\Models\Feature;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
#[Description('A tool that lists pending plan tasks for a project feature.')]
class ListPendingPlanTasksTool extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $validated = $request->validate(['feature_id' => 'required|integer'], [
            'feature_id.required' => 'The feature_id field is required.',
            'feature_id.integer' => 'The feature_id field must be an integer.',
        ]);

        $feature = Feature::findOrFail((int) $validated['feature_id']);

        return Response::structured([
            'plan_tasks' => $feature->planTasks()
                ->where('status', PlanTaskStatus::PENDING)
                ->orderBy('sort')
                ->get(['id', 'task', 'description', 'status', 'sort']),
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return ['feature_id' => $schema->integer()->description('The ID of the feature.')->required()];
    }

    /** @return array<string, Type> */
    public function outputSchema(JsonSchema $schema): array
    {
        return [
            'plan_tasks' => $schema->array()->items($schema->object([
                'id' => $schema->integer()->required(),
                'task' => $schema->string()->required(),
                'description' => $schema->string()->required(),
                'status' => $schema->string()->required(),
                'sort' => $schema->integer()->required(),
            ]))->required(),
        ];
    }
}
