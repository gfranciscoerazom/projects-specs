<?php

use App\Mcp\Servers\ProjectsServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::oauthRoutes();

Mcp::web('/mcp/projects', ProjectsServer::class)->middleware('auth:api');
