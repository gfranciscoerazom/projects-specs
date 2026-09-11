<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\AcceptanceCriteria\ListPendingAcceptanceCriteriaTool;
use App\Mcp\Tools\AcceptanceCriteria\MarkAsIsMetAcceptanceCriteriaTool;
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
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
