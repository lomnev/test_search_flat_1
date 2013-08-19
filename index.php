<?php

$configurationFile = 'configuration.ini';

require 'controllers/ApplicationController.php';
require 'controllers/PageController.php';
require 'extensions/phpQuery/phpQuery.php';
require 'models/Metro.php';
require 'models/Parser.php';
require 'models/SearchRequest.php';
require 'models/CurlEngine.php';

$app = new Application($configurationFile);
$app->run();

