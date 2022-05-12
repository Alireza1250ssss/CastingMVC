<?php
namespace App\app\Controllers;

use App\app\Models\Branches;
use App\app\Models\Courses;
use App\core\BaseController;
use App\core\Request;
use App\core\View;

class CourseController extends BaseController{

    public $course_model;

    public function __construct()
    {
        parent::__construct();
        $this->course_model = new Courses();
    }

    public function index(){
        $course_model = new Courses();
        var_dump($course_model);
    }
    public function addCourse(){

      
        $prepared_data = $this->request->getBody();
        
        foreach($prepared_data as $key=>$value){
            if(in_array($key,$this->course_model->json_fields)){
                $json_data[$key]= $value;
            }
        }

        $prepared_data = array_filter($this->request->getBody(),function($key){
            return in_array($key,$this->course_model->attributes());
        },ARRAY_FILTER_USE_KEY);


        

        $json_data = json_encode($json_data);
        $prepared_data['meta_data'] = $json_data;
        

        if($this->course_model->create($prepared_data))
            die("created successfully");
        else
            die("failed");
    }

    public function getCourses(){
        $fetched_data = $this->course_model->select();
       
        $this->course_model->json_converter('meta_data',$fetched_data);
        echo "<pre>";
        print_r($fetched_data);
    }
}