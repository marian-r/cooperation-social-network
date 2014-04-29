<?php
/**
 * User: V. Jurenka
 * Date: 29.4.2014
 * Time: 15:52
 */
function json_encode_ex($var){
    if(PHP_VERSION >= 50400){
        return json_encode($var);
    }
    switch (gettype($var)) {
        case 'array':
            if (is_array($var) && count($var) && (array_keys($var) !== range(0, sizeof($var) - 1))) {
                return '{' .
                    join(',', array_map('nameValue_js',
                        array_keys($var),
                        array_values($var)))
                    . '}';
            }

            return '[' . join(',', array_map('json_encode_ex', $var)) . ']';
        case 'object':
            if ($var instanceof JsonSerializable){
                $vars = $var->jsonSerialize();
            }
            elseif ($var instanceof Traversable){
                $vars = array();
                foreach ($var as $k=>$v)
                    $vars[$k] = $v;
            }
            else{
                $vars = get_object_vars($var);
            }

            return '{' .
                join(',', array_map('nameValue_js',
                    array_keys($vars),
                    array_values($vars)))
                . '}';

        default:
            return json_encode($var);
    }
}

if (PHP_VERSION_ID < 50400) {
    function nameValue_js($name, $value)
    {
        return json_encode_ex(strval($name)) . ':' . json_encode_ex($value);
    }
    require_once('interface.php');
}
