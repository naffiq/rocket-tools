<?php
// Updater class
require_once __DIR__ . '/UpdateCommand.php';

// Nginx commands and classes
require_once __DIR__ . '/nginx/GenerateCommand.php';
require_once __DIR__ . '/nginx/Generator.php';
require_once __DIR__ . '/nginx/LinkCommand.php';
require_once __DIR__ . '/nginx/UnlinkCommand.php';

// RocketTools configuration commands and classes
require_once __DIR__ . '/config/ConfigHelper.php';
require_once __DIR__ . '/config/ConfigUpdateCommand.php';
require_once __DIR__ . '/config/ConfigGetCommand.php';