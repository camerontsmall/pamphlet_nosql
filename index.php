<?php

/* Initialise app */
require 'init.php';

//$auth = new authenticator();

if(!isset($_GET['a'])){
    header('location:./?a=home');
    die();
}

$task = $_GET['a'];
$task_parts = explode('/',$task);
$controller_name = $task_parts[0];

$ui_controller_class = Controller::loadControllerByName($controller_name);

if(class_exists($ui_controller_class)){

    $ui_controller = new $ui_controller_class($task);
    
}else{
    echo error("Error - requested class does not exist");
    die();
}

?>
<!doctype html>
<html>
    <head>
        <!-- Styling -->
        
        <link rel="stylesheet" href="bower_components/material-design-icons/iconfont/material-icons.css" />
        <!-- <link rel="stylesheet" href="bower_components/jquery-ui/themes/base/jquery-ui.min.css" />      -->  
        <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css" />        
        <!-- <link rel="stylesheet" href="bower_components/sceditor/minified/jquery.sceditor.default.min.css" /> -->
        
        <!-- Master stylesheet -->
        <link rel="stylesheet" href="css/main.css" />

        <style>
            .theme-color{
                background-color: <?= $config['theme_color'] ?>;
            }
            .theme-color-text{
                color: <?= $config['theme_color'] ?>;
            }
        </style>
        
        <!-- JS Includes -->
        <!-- Bower -->
        <script src="bower_components/jquery/dist/jquery.min.js" ></script>
        <script src="bower_components/jquery-ui/jquery-ui.min.js" ></script>
        <script src="bower_components/handlebars/handlebars.min.js" ></script>
        <script src="bower_components/json-editor/dist/jsoneditor.min.js" ></script>
        <script src="bower_components/select2/dist/js/select2.full.min.js" ></script>
 
        <script src="ckeditor/ckeditor.js" ></script>        
        
        <!-- Custom -->
        <script src="js/CustomForm.js" ></script>
        <script src="js/DynamicList.js" ></script>
        <script src="js/VideoPage.js" ></script>
        
    </head>
    <body>
        
        <nav class="desktop-nav sidebar">
            <div class="nav-header">
                <?= $config['site_title'] ?>
            </div>
            <ul class="nav-list theme-color-text">
                <?php
                
                $controller_list = Controller::listAll();
                foreach($controller_list as $item){
                    $active = ($item::$name == $controller_name)? "active" : "";
                    echo "<li class=\"$active\"><a href=\"./?a={$item::$name}\">{$item::$title}</a></li>";
                }
                
                ?>
            </ul>
        </nav>
        
        <nav class="mobile-nav sliding-nav">
            
        </nav>
        
        <div class="breadcrumbs theme-color" >
            <?php $ui_controller->PrintBreadcrumbs(); ?>
        </div>
        
        <main>
            <div class="container">
                <?php
                
                $ui_controller->UIMethod();
                
                ?>
            </div>
        </main>
        
        <script>
        //CKEDITOR.replaceAll();
        
        var j = 0;
        $("textarea[data-schemaformat='html']").each(function(){
            $(this).attr('id','textarea_' + j);
            j++;
            var editor = CKEDITOR.replace($(this).attr('id'));
            editor.on('change', function(event){
                //write ckeditor value to textarea value
                this.updateElement();
                //write value to dom - apparently not necessary
                //this.element.$.innerHTML = this.element.$.value;
                //create new event
                var event = new Event('change');
                //tell json editor the value has changed
                this.element.$.dispatchEvent(event);
            });
        });

/*
        $(document).ready(function(){
            for (var i in CKEDITOR.instances) {  
                console.log(i);
                CKEDITOR.instances[i].on('mouseup', function() { CKEDITOR.instances[i].updateElement() });  
            }
        }); */
        </script>
    </body>
</html>