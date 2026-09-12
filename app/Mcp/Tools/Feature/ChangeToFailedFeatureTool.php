<?php

namespace App\Mcp\Tools\Feature;

use App\Actions\Feature\ChangeToFailedFeature;
use App\Models\Feature;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('A tool that changes a feature status to failed.')]
class ChangeToFailedFeatureTool extends Tool
{
    public function handle(Request $request, ChangeToFailedFeature $changeToFailed): ResponseFactory
    {
        $validated = $request->validate(['id' => 'required|integer'], [
            'id.required' => 'The id field is required.',
            'id.integer' => 'The id field must be an integer.',
        ]);
        $feature = Feature::findOrFail((int) $validated['id']);
        $changeToFailed($feature);

        return Response::structured(['id' => $feature->id, 'name' => $feature->name, 'status' => $feature->status]);
    }

    /** @return array<string, Type> */
    public function schema(JsonSchema $schema): array
    {
        return ['id' => $schema->integer()->description('The ID of the feature.')->required()];
    }

    /** @return array<string, Type> */
    public function outputSchema(JsonSchema $schema): array
    {
        return ['id' => $schema->integer()->required(), 'name' => $schema->string()->required(), 'status' => $schema->string()->required()];
    }
}
