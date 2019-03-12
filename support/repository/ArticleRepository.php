<?php
/**
 * Article repository
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 01:09
 */

Tools::DependsOn("/models/ArticleModel.php");

class ArticleRepository extends Repository
{

    /**
     * @param $m ArticleModel
     * @return bool
     */
    function add($m)
    {
        return $this->_add("Articles",$m);
    }

    /**
     * @param $m ArticleModel
     * @return bool
     */
    function remove($m)
    {
        return $this->_remove("Articles",$m);
    }

    /**
     * @param $m ArticleModel
     * @return bool
     */
    function update($m)
    {
        return $this->_update("Articles",$m);
    }

    /**
     * @param $id int
     * @return ArticleModel|null
     */
    function get($id)
    {

        // get row by id and return
        $row = $this->db->BEGIN()->SELECT("*")->FROM("Articles")->WHERE([
            new NSParam('id',$id,'i')
        ])->GET_FIRST();

        // if row doesn't exist, return nothing
        if ($row === false) return null;

        // populate new model
        $m = new ArticleModel();
        $m->loadValues($row);

        return $m;
    }
}