<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\AcceptanceCriteria\ListPendingAcceptanceCriteriaTool;
use App\Mcp\Tools\AcceptanceCriteria\MarkAsIsMetAcceptanceCriteriaTool;
use App\Mcp\Tools\Feature\ChangeToCompletedFeatureTool;
use App\Mcp\Tools\Feature\ChangeToFailedFeatureTool;
use App\Mcp\Tools\Feature\ChangeToInProgressFeatureTool;
use App\Mcp\Tools\Feature\ChangeToPendingFeatureTool;
use App\Mcp\Tools\Feature\InfoFeatureTool;
use App\Mcp\Tools\PlanTask\ChangeToCompletedPlanTaskTool;
use App\Mcp\Tools\PlanTask\ChangeToFailedPlanTaskTool;
use App\Mcp\Tools\PlanTask\ChangeToInProgressPlanTaskTool;
use App\Mcp\Tools\PlanTask\ChangeToPendingPlanTaskTool;
use App\Mcp\Tools\PlanTask\InfoPlanTaskTool;
use App\Mcp\Tools\PlanTask\ListPendingPlanTasksTool;
use App\Mcp\Tools\Projects\InfoProjectsTool;
use App\Mcp\Tools\Projects\ListProjectsTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('Projects Server')]
#[Version('0.0.1')]
#[Instructions('Instructions describing how to use the server and its features.')]
class ProjectsServer extends Server
{
    protected array $tools = [
        InfoProjectsTool::class,
        ListProjectsTool::class,
        ListPendingAcceptanceCriteriaTool::class,
        MarkAsIsMetAcceptanceCriteriaTool::class,
        ChangeToCompletedFeatureTool::class,
        ChangeToFailedFeatureTool::class,
        ChangeToInProgressFeatureTool::class,
        ChangeToPendingFeatureTool::class,
        InfoFeatureTool::class,
        ChangeToCompletedPlanTaskTool::class,
        ChangeToFailedPlanTaskTool::class,
        ChangeToInProgressPlanTaskTool::class,
        ChangeToPendingPlanTaskTool::class,
        InfoPlanTaskTool::class,
        ListPendingPlanTasksTool::class,
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
