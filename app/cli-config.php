<?php

require_once __DIR__ . '/bootstrap.php';

use App\Application;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

return ConsoleRunner::createHelperSet(Application::get('em'));