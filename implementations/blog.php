<?php

class blog_implementation extends Implementation{
    
    public $model_name = "blog";
    public $collection_name = "video";
    
}

class blog_controller extends Controller{
    
    public static $name = "blog";
    public static $title = "Blog";

    public $implementation_name = "blog_implementation";
    
    function PrepareData($data) {
        $c = [];
        foreach($data as $item){
            $c[] = ["action" => "blog/$item->_id", "Title" => $item->title, "Tags" => $item->tags, "Date" => $item->date];
        }
        return $c;
    }
    
}

class blog_view extends View{
    
    public static $api_endpoint = "blog";
    
    public $implementation_name = "blog_implementation";
    
}
