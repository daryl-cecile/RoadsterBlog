<?php
/**
 * Service Provider
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 01:17
 */

class NSServiceProvider
{
    // Repos
    public $ArticleRepository;
    public $UserRepository;

    // Managers
    public $ViewManager;

    // Data
    public $Config;

    function __construct()
    {
        $this->ArticleRepository = new ArticleRepository();
        $this->UserRepository = new UserRepository();

        $this->ViewManager = new NSViewManager();
    }

    function startService(){
        include_once $_SERVER['DOCUMENT_ROOT'] . "/routes.php";
    }
}