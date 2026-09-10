<?php

namespace App\Mcp\Tools;

use App\Models\Project;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
#[Description('A tool that provides the information about a specific project.')]
class InfoProjectsTool extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request, Project $project): ResponseFactory
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
        ]);

        $requestedProject = $project->where('name', $validated['name'])->firstOrFail();

        return Response::structured([
            'name' => $requestedProject->name,
            'description' => $requestedProject->description,
            'audience' => $requestedProject->audience,
            'conventions' => $requestedProject->conventions,
            'technologies' => $requestedProject->technologies()->get(['id', 'name', 'conventions']),
            'features' => $requestedProject
                ->features()
                ->with([
                    'acceptanceCriterias:id,feature_id,name,description,is_met',
                    'userStories:id,feature_id,name,story',
                    'planTasks:id,feature_id,task,description,status,sort',
                ])
                ->get([
                    'id',
                    'name',
                    'description',
                    'plan',
                    'status',
                    'priority',
                    'type',
                    'sort',
                ]),
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
            'name' => $schema
                ->string()
                ->description('The name of the project.')
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
            'name' => $schema
                ->string()
                ->description('The name of the project.')
                ->required(),
            'description' => $schema
                ->string()
                ->description('The description of the project.')
                ->required(),
            'audience' => $schema
                ->string()
                ->description('The audience of the project.')
                ->required(),
            'conventions' => $schema
                ->string()
                ->description('The conventions of the project.')
                ->required(),
            'features' => $schema
                ->array()
                ->items($schema->object([
                    'id' => $schema->integer()->required(),
                    'name' => $schema->string()->required(),
                    'description' => $schema->string()->required(),
                    'plan' => $schema->string()->required(),
                    'status' => $schema->string()->required(),
                    'priority' => $schema->string()->required(),
                    'type' => $schema->string()->required(),
                    'sort' => $schema->integer()->required(),
                    'acceptance_criterias' => $schema
                        ->array()
                        ->items($schema->object([
                            'id' => $schema->integer()->required(),
                            'name' => $schema->string()->required(),
                            'description' => $schema->string()->required(),
                            'is_met' => $schema->boolean()->required(),
                        ]))
                        ->required(),
                    'user_stories' => $schema
                        ->array()
                        ->items($schema->object([
                            'id' => $schema->integer()->required(),
                            'name' => $schema->string()->required(),
                            'story' => $schema->string()->required(),
                        ]))
                        ->required(),
                    'plan_tasks' => $schema
                        ->array()
                        ->items($schema->object([
                            'id' => $schema->integer()->required(),
                            'task' => $schema->string()->required(),
                            'description' => $schema->string()->required(),
                            'status' => $schema->string()->required(),
                            'sort' => $schema->integer()->required(),
                        ]))
                        ->required(),
                ]))
                ->required(),
        ];
    }
}
