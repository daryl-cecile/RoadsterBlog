<?php
/**
 * Results to return as JSON to browser
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 00:49
 */

class NSResult
{
    public $Title = "";
    public $Message = "";
    public $HasErrors = false;

    public $Data = [];

    function __toString()
    {
        return json_encode($this,JSON_PRETTY_PRINT);
    }
}