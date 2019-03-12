<?php
/**
 * Database Connection
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 11/03/2019
 * Time: 02:16
 */


class NSDatabase extends mysqli
{

    public $commandString = "";

    /** @var NSParam[] */
    public $values;

    private $initialCharset = null;

    function __construct($charset=null)
    {
        global $ServiceProvider;

        parent::__construct(
            $ServiceProvider->Config->database->host, // Host
            $ServiceProvider->Config->database->user, // Username
            $ServiceProvider->Config->database->pass, // Password
            $ServiceProvider->Config->database->name, // Database Name
            (int)$ServiceProvider->Config->database->port  // Connection Port
        );

        if ( mysqli_connect_errno() ){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $this->initialCharset = mysqli_character_set_name($this);

        if ($charset !== null){
            mysqli_set_charset($this, $charset);
        }

        $this->values = [];
    }

    function __destruct()
    {
        try{
            $this->close();
        }
        catch (Exception $e){}
    }

    function BEGIN(){
        $this->commandString = "";
        $this->values = [];
        return $this;
    }

    /**
     * @param string[] ...$columnNames
     * @return NSDatabase
     */
    function SELECT(...$columnNames){
        $this->commandString .= "SELECT " . implode(", ",$columnNames) . " ";
        return $this;
    }


    /**
     * @param string $tableName
     * @return NSDatabase
     */
    function UPDATE($tableName){
        $this->commandString .= "UPDATE $tableName ";
        return $this;
    }

    /**
     * @param string $tableName
     * @return NSDatabase
     */
    function DELETE_FROM($tableName){
        $this->commandString .= "DELETE FROM $tableName ";
        return $this;
    }

    /**
     * @param string $tableName
     * @param NSParam[] $params
     * @return NSDatabase
     */
    function INSERT_INTO($tableName,$params){
        $this->commandString .= "INSERT INTO $tableName (";

        $columnNames = [];

        foreach($params as $param){
            $columnNames[] = $param->name;
            $this->values[] = new NSParam($param->name,$param->value,$param->type);
        }
        $this->commandString .= implode(',',$columnNames) . ") VALUES (";

        foreach($params as $value) { $this->commandString .= "?,"; }
        $this->commandString = substr($this->commandString,0, strlen($this->commandString)-1);

        $this->commandString .= ")";

        return $this;
    }

    /**
     * @param string $tableName
     * @return NSDatabase
     */
    function FROM($tableName){
        $this->commandString .= "FROM $tableName ";
        return $this;
    }

    /**
     * @param NSParam[] $condition
     * @return NSDatabase
     */
    function SET($condition){
        $this->commandString .= "SET ";

        $conditionParts = [];
        foreach($condition as $value){
            $this->values[] = new NSParam($value->name,$value->value,$value->type);
            $conditionParts[] = $value->name . '=?';
        }
        $this->commandString .= implode(", ", $conditionParts) . " ";

        return $this;
    }

    /**
     * @param NSParam[] $condition
     * @param bool $performAnd
     * @return NSDatabase
     */
    function WHERE($condition,$performAnd=true){
        $this->commandString .= "WHERE ";

        $conditionParts = [];
        foreach($condition as $value){
            $this->values[] = new NSParam( $value->name,$value->value, $value->type );
            $conditionParts[] = $value->name . '=?';
        }
        $glue = ($performAnd===true?"AND":"OR");
        $this->commandString .= implode(" $glue ", $conditionParts) . " ";

        return $this;
    }

    function GET_ALL(){
        $stmt = $this->prepare($this->commandString);
        $params = $this->values;

        $success = true;
        if ( count($params) > 0 ){
            $types = "";
            $p = [];
            foreach($params as $param){
                $types .= $param->type;
                array_push($p,$param->value);
            }
            $success = $stmt->bind_param($types,...$p);
        }

        if ($success === false) return [];

        $success = $success && $stmt->execute();
        $success = $success && $stmt->store_result();

        if ($success === false) return [];

        $rows = array();

        while($results = $this->fetchAssocStatement($stmt)){
            $rows[] = $results;
        }

        return $rows;
    }

    function GET_FIRST(){
        // returns first row only
        $allrows = $this->GET_ALL();
        if ( count($allrows) > 0 ){
            return $allrows[0];
        }
        return false;
    }

    function EXEC(){
        $stmt = $this->prepare($this->commandString);

        if ($stmt === false) echo $this->error;

        $params = $this->values;
        $result = true;

        $types = "";
        $p = [];
        foreach($params as $param){
            $types .= $param->type;
            array_push($p,$param->value);
        }
        $result = $stmt->bind_param($types,...$p);

        $result = $result && $stmt->execute();
        return $result;
    }


    /**
     * @param mysqli_stmt $stmt
     * @return array|null
     */
    private function fetchAssocStatement($stmt)
    {
        if($stmt->num_rows>0)
        {
            $result = array();
            $md = $stmt->result_metadata();
            $params = array();
            while($field = $md->fetch_field()) {
                $params[] = &$result[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $params);
            if($stmt->fetch())
                return $result;
        }

        return null;
    }
}