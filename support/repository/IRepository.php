<?php
/**
 * Contract for repository
 * Classes implementing this interface must implement all of the properties
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 01:09
 */

interface IRepository{

    function add($m);
    function remove($m);
    function update($m);

    function get($id);

}