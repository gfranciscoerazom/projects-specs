<?php

namespace App\Mcp\Tools\Feature;

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
#[Description('A tool that provides the information about a specific feature.')]
class InfoFeatureTool extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $validated = $request->validate(['id' => 'required|integer'], [
            'id.required' => 'The id field is required.',
            'id.integer' => 'The id field must be an integer.',
        ]);

        $feature = Feature::with(['acceptanceCriterias', 'userStories', 'planTasks'])
            ->findOrFail((int) $validated['id']);

        return Response::structured([
            'id' => $feature->id,
            'name' => $feature->name,
            'description' => $feature->description,
            'plan' => $feature->plan,
            'status' => $feature->status,
            'priority' => $feature->priority,
            'type' => $feature->type,
            'sort' => $feature->sort,
            'acceptance_criterias' => $feature->acceptanceCriterias,
            'user_stories' => $feature->userStories,
            'plan_tasks' => $feature->planTasks,
        ]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return ['id' => $schema->integer()->description('The ID of the feature.')->required()];
    }

    /** @return array<string, Type> */
    public function outputSchema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->required(),
            'name' => $schema->string()->required(),
            'description' => $schema->string()->required(),
            'plan' => $schema->string()->required(),
            'status' => $schema->string()->required(),
            'priority' => $schema->string()->required(),
            'type' => $schema->string()->required(),
            'sort' => $schema->integer()->required(),
            'acceptance_criterias' => $schema->array()->required(),
            'user_stories' => $schema->array()->required(),
            'plan_tasks' => $schema->array()->required(),
        ];
    }
}
