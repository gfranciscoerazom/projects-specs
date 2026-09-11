<?php

namespace App\Mcp\Tools\AcceptanceCriteria;

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
#[Description('A tool that lists unmet acceptance criteria for a project feature.')]
class ListPendingAcceptanceCriteriaTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): ResponseFactory
    {
        $validated = $request->validate([
            'feature_id' => 'required|integer',
        ], [
            'feature_id.required' => 'The feature_id field is required.',
            'feature_id.integer' => 'The feature_id field must be an integer.',
        ]);

        $feature = Feature::findOrFail((int) $validated['feature_id']);

        return Response::structured([
            'acceptance_criterias' => $feature
                ->acceptanceCriterias()
                ->where('is_met', false)
                ->get(['id', 'name', 'description', 'is_met']),
        ]);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'feature_id' => $schema
                ->integer()
                ->description('The ID of the feature.')
                ->required(),
        ];
    }

    /**
     * Get the tool's output schema.
     *
     * @return array<string, Type>
     */
    public function outputSchema(JsonSchema $schema): array
    {
        return [
            'acceptance_criterias' => $schema
                ->array()
                ->items($schema->object([
                    'id' => $schema->integer()->required(),
                    'name' => $schema->string()->required(),
                    'description' => $schema->string()->required(),
                    'is_met' => $schema->boolean()->required(),
                ]))
                ->required(),
        ];
    }
}
