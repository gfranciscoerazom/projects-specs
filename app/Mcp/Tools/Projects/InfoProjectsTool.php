<?php

namespace App\Mcp\Tools\Projects;

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
    public function handle(Request $request): ResponseFactory
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ], [
            'id.required' => 'The id field is required.',
            'id.integer' => 'The id field must be an integer.',
        ]);

        $project = Project::findOrFail((int) $validated['id']);

        return Response::structured([
            'id' => $project->id,
            'name' => $project->name,
            'description' => $project->description,
            'audience' => $project->audience,
            'conventions' => $project->conventions,
            'technologies' => $project->technologies()->get(['id', 'name', 'conventions']),
            'features' => $project
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
            'id' => $schema
                ->integer()
                ->description('The ID of the project.')
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
            'id' => $schema
                ->integer()
                ->description('The ID of the project.')
                ->required(),
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
