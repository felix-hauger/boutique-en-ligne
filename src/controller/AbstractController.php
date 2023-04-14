<?php

namespace App\Controller;

abstract class AbstractController
{
    /**
     * @param string $class_name Fully qualified class name
     * @param string $method_name
     * @return array Contains names of method arguments
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

    /**
     * Convert html characters & all quotes to be not interpreted, remove spaces before & after string
     * @param string $string The string to filter
     * @return string The filtered string
     */
    public function filterSpecialCharacters($string): string
    {
        return htmlspecialchars(trim($string), ENT_QUOTES);
    }

    /**
     * Filter the arguments of the calling method to prevent XSS attacks
     *
     * @param string $class_name The name of the class containing the method
     * @param string $method_name The name of the method to filter
     * @param array $args the args to filter
     * @return array The filtered arguments
     */
    public function filterMethodArgs(string $class_name, string $method_name, array $args): array
    {
        // Get the method information using reflection
        $method = new \ReflectionMethod($class_name, $method_name);

        // Filter each argument using the filterSpecialCharacters method
        $filtered_args = array_map([$this, 'filterSpecialCharacters'], $args);

        // Combine the argument names and filtered arguments into an associative array
        $args_names = array_map(fn($param) => $param->name, $method->getParameters());

        $filtered_args = array_combine($args_names, $filtered_args);

        return $filtered_args;
    }
}