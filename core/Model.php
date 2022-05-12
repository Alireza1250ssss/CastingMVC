<?php

namespace App\core;

use App\core\DB\Connection\ConnectionInterface;
use App\core\DB\MySqlDatabase;
use stdClass;
use App\core\DB\DatabaseInterface;

abstract class  Model
{

    protected  $db;
    protected $query;
    protected $guarded=[];
    public function __construct()
    {
        $this->db = MySqlDatabase::do();
        $this->query = $this->db->table($this->getTable());
    }
    public static function do()
    { //!return my child class
        return new static;
    }
    public  abstract function getTable();
    public function create(array $fields)
    {
        return $this->query->insert($fields)->exec();
    }
    public function find($value, $col = 'id')
    {

        return $this->query->select()->where($col, $value)->fetch();
    }

    // SELECT array $cols from table then fetch or fetchAll
    public function select(array $cols = ['*'])
    {

        return $this->guard_safe($this->query->select($cols)->fetchAll());
    }

    public function json_converter($field, &$data)
    {

        foreach ($data as $single_record) {
            
            $json_decoded_data = json_decode($single_record->$field) ;
            $json_decoded_data = is_null($json_decoded_data) ? [] : $json_decoded_data;
            foreach ($json_decoded_data as $key => $value) {
                $single_record->$key = $value;
            }
        }
    }
    public function guard_safe($data){
        foreach($data as &$record){
            $record = (array) $record;
            $record = (object) array_filter($record,function($key){
                return !in_array($key,$this->guarded);
            },ARRAY_FILTER_USE_KEY);
        }
        return $data;
    }
}
