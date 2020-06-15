<?php

if( !function_exists('annotationBind') ) {
    function annotationBind( &$class, array $params, string $default ) 
    {
        foreach ($params as $key => $param) {
            if( is_string($key) && property_exists($class, $key) ) {
                $func = 'set'. ucfirst($key);
                if ($param == null) {
                    $class->$func();
                } else {
                    $class->$func($param);
                }
            } elseif( $key == 'value' ) {
                if ($param == null) {
                    $class->$default();
                } else {
                    $class->$default($param);
                }
            }
        }
    }
}

if( !function_exists('getCallingClass') ) {
    function getCallingClass() {

        //get the trace
        $trace = debug_backtrace();
    
        // Get the class that is asking for who awoke it
        $class = $trace[1]['class'];
    
        // +1 to i cos we have to account for calling this function
        for ( $i = 1; $i < count( $trace ); $i++ ) {
            if ( isset( $trace[$i] ) ) // is it set?
                 if ( $class != $trace[$i]['class'] ) // is it a different class
                     return $trace[$i]['class'];
        }
    }
}