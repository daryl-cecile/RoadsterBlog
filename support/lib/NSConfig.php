<?php

/**
 * Created by PhpStorm.
 * User: darylcecile
 * Date: 11/03/2019
 * Time: 00:41
 */
class NSConfig
{
    public $config;

    function __construct()
    {
        $this->config = simplexml_load_file(__DIR__ . "/../config.xml");
    }
}