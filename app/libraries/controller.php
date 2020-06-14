<?php
//main controller that will allow us to load other models and views

class controller
{
    public function model($model)
    {
        require_once '../app/models/'.$model.'.php';
        //instantiate model
        return new $model();
    }

    public function view($view, $data=[])
    {
        if(file_exists('../app/views/'.$view.'.php'))
        {
            require_once '../app/views/'.$view.'.php';
        }else{
            //stop the app
            die('View doesnt exist');
        }
    }
}