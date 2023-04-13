<?php

namespace App\Controller;

abstract class AbstractController
{
    /**
     * @param string $class_name fully qualified class name
     * @param string $method_name
     * @return array containing names of method arguments
     */
    public function getMethodArgNames(string $class_name, string $method_name): array
    {
        // get infos from methods
        $method = new \ReflectionMethod($class_name, $method_name);

        $result = array();

        // store method parameters in array
        foreach ($method->getParameters() as $param) {
            $result[] = $param->name;   
        }

        // return array of method parameters
        return $result;
    }
}