<?php

namespace Sw\Arc2Bundle\Triples; 

/**
 * Representation of an URI (a class to make it easy to distinguish literals and URIs). 
 *
 * @author Thibaut
 */
class URI
{
    private $_uri; 
    
    public function __construct($uri)
    {
        $this->_uri = $uri; 
    }
    
    public function __toString()
    {
        return $this->get();
    }
    
    public function get()
    {
        return $this->_uri; 
    }
}