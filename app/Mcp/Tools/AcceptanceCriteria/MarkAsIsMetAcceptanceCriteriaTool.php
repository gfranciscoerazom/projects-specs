<?php

namespace App\Mcp\Tools\AcceptanceCriteria;

use App\Actions\AcceptanceCriteria\MarkAsIsMetAcceptanceCriteria;
use App\Models\AcceptanceCriteria;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('A tool that marks an acceptance criterion as met.')]
class MarkAsIsMetAcceptanceCriteriaTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request, MarkAsIsMetAcceptanceCriteria $markAsIsMet): ResponseFactory
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ], [
            'id.required' => 'The id field is required.',
            'id.integer' => 'The id field must be an integer.',
        ]);

        $criteria = AcceptanceCriteria::query()
            ->whereKey((int) $validated['id'])
            ->firstOrFail();

        $markAsIsMet($criteria);

        return Response::structured([
            'id' => $criteria->id,
            'name' => $criteria->name,
            'is_met' => $criteria->is_met,
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
            'id' => $schema
                ->integer()
                ->description('The ID of the acceptance criterion.')
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
            'id' => $schema->integer()->required(),
            'name' => $schema->string()->required(),
            'is_met' => $schema->boolean()->required(),
        ];
    }
}
