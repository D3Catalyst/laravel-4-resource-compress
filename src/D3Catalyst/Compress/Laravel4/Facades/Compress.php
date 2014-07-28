<?php namespace D3catalyst\Compress\Laravel4\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class Compress extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() 
    { 
        return 'compress'; 
    }
 
}