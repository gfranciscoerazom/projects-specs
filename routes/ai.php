<?php

use App\Mcp\Servers\ProjectsServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/projects', ProjectsServer::class);
