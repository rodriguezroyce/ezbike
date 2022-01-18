<?php

    function load_view($view){
        $view = require_once($view.".php");
        return $view;
    }
    function load_model($model){
        $model = require_once("../Model/{$model}.php");
        return $model;
    }

?>