<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\InfoProjectsTool;
use App\Mcp\Tools\ListPendingAcceptanceCriteriaTool;
use App\Mcp\Tools\ListProjectsTool;
use App\Mcp\Tools\MarkAsIsMetAcceptanceCriteriaTool;
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
