<?php
namespace App\app\Models;
use App\core\Model;
class Courses extends Model{

    public $json_fields = ['start_time', 'end_time','cost'];
    protected $guarded = ['teacher_id'];

    public function attributes(){
        return [
            'title','teacher_id','capacity','meta_data'
        ];
    }

    public function getTable(){
        return "courses";
    }
}