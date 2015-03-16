<?php
namespace Core;
use Router\Route as Route;
require_once('Core/Core.php');
Core::register();
$url = $_SERVER['REQUEST_URI'];
$r = new Route($url);