<?php
/**
 * Data parameter for database
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 02:15
 */

class NSParam
{
    public $name = "";
    public $value = "";
    public $type = '';

    function __construct($name,$val,$type)
    {
        $this->name = $name;
        $this->value = $val;
        $this->type = $type;
    }
}