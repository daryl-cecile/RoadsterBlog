<?php
/**
 * Base class repository
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 01:09
 */

Tools::DependsOn("/repository/IRepository.php");
Tools::DependsOn("/models/Model.php");
Tools::DependsOn("/models/ViewModel.php");

class Repository implements IRepository
{
    protected $db;

    function __construct()
    {
        global $ServiceProvider;
        $this->db = new NSDatabase("utf8mb4");
    }

    /**
     * @param $tableName
     * @param $model Model
     * @return bool
     */
    function _add($tableName,$model){
        $columns = []; // column values

        $ignoreAddList = $model->IgnoreFieldsOnAdd(); // columns to ignore

        // load the value of each property in this model into parameters
        foreach ($model as $key => $value) {
            if (property_exists($model,$key) && in_array($key,$ignoreAddList) === false) {
                $columns[]  = new NSParam($key,$value, is_numeric($value) ? 'i' : 's' );
            }
        }

        // make transaction and end
        return $this->db->BEGIN()->INSERT_INTO($tableName,$columns)->EXEC();
    }
    function add($m){}

    /**
     * @param $tableName
     * @param $model Model
     * @return bool
     */
    function _remove($tableName,$model){
        // get id from object
        $id = $model->id;

        return $this->db->BEGIN()->DELETE_FROM($tableName)->WHERE([
            new NSParam('id',$id,'i')
        ])->EXEC();
    }
    function remove($m){}

    /**
     * @param $tableName
     * @param $model Model
     * @return bool
     */
    function _update($tableName,$model){
        // column values to update
        $columns = [];

        // get current data
        $article = $this->_getById($tableName,$model->id);

        // check if data needs updating
        foreach ($model as $key => $value){
            if ($value !== $article[$key] && in_array($key, $model->IgnoreFieldsOnUpdate()) === false){
                $columns[] = new NSParam($key,$value, is_numeric($value) ? "i" : "s" );
            }
        }

        // perform update transaction
        return $this->db->BEGIN()->UPDATE($tableName)->SET($columns)->WHERE([
            new NSParam('id',$model->id,'i')
        ])->EXEC();

    }
    function update($m){}

    function get($id){}
    function _getById($tableName,$id){
        // get row by id and return
        $row = $this->db->BEGIN()->SELECT("*")->FROM($tableName)->WHERE([
            new NSParam('id',$id,'i')
        ])->GET_FIRST();

        return $row;
    }

    function _getAll($tableName){
        $rows = $this->db->BEGIN()->SELECT('*')->FROM($tableName)->GET_ALL();
        return $rows;
    }

}