<?php

spl_autoload_register(function($class) {

    // top level namespace
    $prefix = 'App\\';

    // folder containing all classes
    $base_dir = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;

    // length of top level namespace
    $len = strlen($prefix);

    // separate namespace levels into an array
    $namespace_arr = explode('\\', $class);

    // the last entry of the array is the class name
    $class_name = array_pop($namespace_arr);

    // convert namespace to path by making
    // all namespace levels lower case
    // imploding them with directory separators
    // and starting from index $prefix
    $path = $base_dir . substr(strtolower(implode(DIRECTORY_SEPARATOR, $namespace_arr)) . DIRECTORY_SEPARATOR, $len);

    // file is found with path & class name
    $file = $path . $class_name . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});