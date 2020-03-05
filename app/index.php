<?php

require_once __DIR__ . '/bootstrap.php';

use App\Application;
use App\Http\Auth;
use App\Http\CSRFProtection;
use App\Http\Router;
use App\Http\Session;
use App\Http\HttpHandler;
use Symfony\Component\HttpFoundation\Request;


Application::set(Request::createFromGlobals());
Application::set(Router::createFromConfig());

Session::boot();
CSRFProtection::boot();
Auth::boot();

$response = HttpHandler::handle();
$response->send();

Session::terminate();


