<?php
/**
 * Roadster Blog: Bootstrapping
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 00:31
 */

// Setup error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');


// Load config, tools, services and router
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/lib/Tools.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/lib/NSConfig.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/lib/NSRouter.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/lib/NSViewManager.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/lib/NSServiceProvider.php";


// Set up database support libs
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/lib/NSParam.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/lib/NSDatabase.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/models/Model.php";


// Loads NSResult to allow returning JSON values to browser
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/lib/NSResult.php";


// Bootstrap Repositories
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/repository/Repository.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/repository/ArticleRepository.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/support/repository/UserRepository.php";


// Create service provider
$ServiceProvider = new NSServiceProvider();

var_dump($ServiceProvider->Config);

exit();

// Start Service
$ServiceProvider->startService();