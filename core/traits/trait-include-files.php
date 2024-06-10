<?php
namespace TFLD\core\Traits;

trait Include_Files {

	/*
     * The include_once statement core and evaluates the specified file during the execution of the script.
     *
     * @param  $path
     *
     * @return bool
     */
    private static function include_once( $path ) : bool {
        if( ! is_array($path) ) {
            $path = [$path];
        }

        if( '\\' === DIRECTORY_SEPARATOR ) {
            $path = array_map(function($include){
                return str_replace('/', DIRECTORY_SEPARATOR, $include);
            }, $path);
        }
        
        $i = 0;
        foreach($path as $include){
            if( file_exists($include) ) {
                include_once $include;
                ++$i;
            }
        }
        
        return ($i > 0);
    }

} // End trait
