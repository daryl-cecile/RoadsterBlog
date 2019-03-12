<?php

/**
 * Created by PhpStorm.
 * User: darylcecile
 * Date: 22/10/2018
 * Time: 00:19
 */
class Model
{
    public $id = "";

    function __toString()
    {
        return json_encode($this);
    }

    public function loadValues($values){
        foreach ($this as $key => $value) {
            if (property_exists($this,$key) && array_key_exists($key,$values)) $this->{$key} = $values[$key];
        }
        $this->{$this->GetIdFieldName()} = $values[$this->GetIdFieldName()];
    }

    public function IgnoreFieldsOnUpdate(){
        return [];
    }

    public function IgnoreFieldsOnAdd(){
        return [];
    }

    public function GetIdFieldName(){
        return "id";
    }

    public function GetId(){
        return $this->{$this->GetIdFieldName()};
    }
}