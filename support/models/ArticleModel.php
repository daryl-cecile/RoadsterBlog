<?php
/**
 * Article Model
 * The properties in this Class must match the name of the columns in your 'Articles' table in your database
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 01:21
 */

class ArticleModel extends Model
{
    public function IgnoreFieldsOnAdd()
    {
        // When adding to DB the values for these will be ignored
        return ["id","ts"];
    }

    public function IgnoreFieldsOnUpdate()
    {
        // When updating the DB these values will be ignored
        return ["id","ts"];
    }

    public $id = null;
    public $Title = "";
    public $Body = "";
    public $ts = null;
    public $user = null;
}